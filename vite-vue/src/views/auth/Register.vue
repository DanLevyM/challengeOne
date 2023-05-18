<template>
    <div class="col-lg-4 col-xs-12 m-auto mt-5">
        <main class="form-signin w-100 p-4" style="background-color:#1a191f">
            <form v-on:submit.prevent="handleRegisterForm">
                <h1 class="h3 mb-3 fw-normal text-center">S'enregistrer</h1>

                <div class="form-floating">
                    <input
                        type="email"
                        v-model="email"
                        class="formInput"
                        id="floatingInput"
                        placeholder="Email"
                    />
                </div>

                <div class="form-floating">
                    <input
                        type="password"
                        v-model="password"
                        class="formInput"
                        id="floatingPassword"
                        placeholder="Password"
                    />
                </div>

                <div class="form-floating">
                    <input
                        type="text"
                        v-model="firstname"
                        class="formInput"
                        id="floatingInput"
                        placeholder="Prenom"
                    />
                </div>

                <div class="form-floating">
                    <input
                        type="text"
                        v-model="lastname"
                        class="formInput"
                        id="floatingInput"
                        placeholder="Nom"
                    />
                </div>

                <div class="checkbox mb-3">
                    <label style="color: #f9ab00;">
                        <input type="checkbox" value="remember-me" /> Se souvenir de 
                        moi
                    </label>
                </div>
                <div class="w-50 m-auto mb-2 text-warning text-center">
                    <router-link to="/login"
                        >Déjà un compte ?</router-link
                    >
                </div>
                <button class="w-100 btn-lg buttonAdd" type="submit">
                    Créer un compte
                </button>
            </form>
        </main>
    </div>
</template>

<script lang="ts">
import { useUserStore } from "../../stores/UserStore.js";

const { register } = useUserStore();

export default {
    name: "Register",
    data() {
        return {
            email: "",
            password: "",
            firstname: "",
            lastname: "",
        };
    },
    methods: {
        async handleRegisterForm() {
            const hasRegister = await register({
                email: this.email,
                plainPassword: this.password,
                firstname: this.firstname,
                lastname: this.lastname,
            });
            if (hasRegister) {
                this.$router.push("/login");
            }
        },
    },
    mounted() {
        console.log("Register mounted");
    },
};
</script>

<style>
::placeholder {
    color: white;
    opacity: 1; 
}

label {
    color: black;
}

.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}

.b-example-divider {
    height: 3rem;
    background-color: rgba(0, 0, 0, 0.1);
    border: solid rgba(0, 0, 0, 0.15);
    border-width: 1px 0;
    box-shadow: inset 0 0.5em 1.5em rgba(0, 0, 0, 0.1),
        inset 0 0.125em 0.5em rgba(0, 0, 0, 0.15);
}

.b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
}

.bi {
    vertical-align: -0.125em;
    fill: currentColor;
}

.nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
}

.nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
</style>
