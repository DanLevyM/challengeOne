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
const isLoggedIn = jsCookie.get('jwt') ? true : false;

export const useUserStore = defineStore("UserStore", {
  state: (): State => ({ user: {} as User, isLoggedIn }),

  getters: {},

  actions: {
    async login(credentials: {
      email: string;
      password: string;
    }): Promise<boolean | void> {

      try {
        const response = await fetch(`${API_URL}/authentication_token`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(credentials),
        });
        const data = await response.json();

        if (response.status !== 200 || !response.ok) {
          throw new Error(data.message);
        }

        // TODO: check if user is needed
        this.user = {
          name: credentials.email,
          isAuthenticate: true,
        };
        this.isLoggedIn = true;
        jsCookie.set('jwt', data.token, { expires: 1 })
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

        const response = await fetch(`${API_URL}/users`, {
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
      this.user = null;
      this.isLoggedIn = false;
      jsCookie.remove('jwt');
    },

    async id() {
      const API_URL = import.meta.env.VITE_API_URL;
      const userData = jsCookie.get("jwt");
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
      const token = jsCookie.get("jwt");
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
