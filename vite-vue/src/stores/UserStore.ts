import { defineStore } from "pinia";
import jsCookie from "js-cookie";

interface State {
  user: User | null;
  isLoggedIn: boolean;
}

interface User {
  name: string;
  isAuthenticate: boolean;
}
const API_URL = import.meta.env.VITE_API_URL;
const isLoggedIn = localStorage.getItem("access_token") ? true : false;
console.log("IsLoggedIn:", isLoggedIn);

export const useUserStore = defineStore("UserStore", {
  state: (): State => ({ user: {} as User, isLoggedIn }),

  getters: {},

  actions: {
    async login(credentials: {
      email: string;
      password: string;
    }): Promise<boolean | void> {
      console.log(credentials);

      try {
        const response = await fetch(`${API_URL}/authentication_token`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(credentials),
        });
        const data = await response.json();
        console.log("data received:", data);

        if (response.status !== 200 || !response.ok) {
          throw new Error(data.message);
        }

        // TODO: check if user is needed
        this.user = {
          name: credentials.email,
          isAuthenticate: true,
        };
        this.isLoggedIn = true;
        console.log("user:", this.user);
        jsCookie.set('jwt', data.token, { expires: 1 })
        localStorage.setItem("access_token", data.token);
        return true;
      } catch (error) {
        console.error(error);
      }
    },

    async register(credentials: {
      email: string;
      plainPassword: string;
      firstname: string;
      lastname: string;
    }) {
      try {
        console.log("req", credentials);

        const response = await fetch(`${API_URL}users`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(credentials),
        });
        const data = await response.json();
        console.log(data);
        if (response.status !== 201 || !response.ok) {
          throw new Error(data.message);
        }
        return true;
      } catch (error) {
        console.error(error);
      }
    },

    async logout() {
      // const response = await fetch("http://localhost:3003/api/logout", {
      //   method: "DELETE",
      // });
      // console.log("logout", response);

      this.user = null;
      this.isLoggedIn = false;
      localStorage.removeItem("access_token");
    },

    isLogged() {
      return localStorage.getItem("access_token") ? true : false;
    },

    async id() {
      const API_URL = import.meta.env.VITE_API_URL;
      const userData = localStorage.getItem("access_token");
      let id_connected;
      if (userData) {
        let payload = userData.split(".")[1];
        let tokenTest = window.atob(payload);
        const values = JSON.parse(tokenTest);
        //get the id of the logged user
        const all_user = await fetch(`${API_URL}/users`);
        const data_allUser = await all_user.json();

        for (let element of data_allUser["hydra:member"]) {
          if (element.email === values.email) {
            id_connected = element.id;
          }
        }
        return id_connected;
      }
    },

    isAdmin() {
      const token = localStorage.getItem("access_token");
      if (token) {
        const payload = token?.split(".")[1];
        const tokenTest = window.atob(payload!);
        const values = JSON.parse(tokenTest);

        for (let element of values.roles) {
          if (element === "ROLE_ADMIN") {
            return true;
          }
        }
      }
      return false;
    },
  },
});
