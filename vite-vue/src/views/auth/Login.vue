<template>
    <div class="col-lg-4 col-xs-12 m-auto mt-5">
        <main class="form-signin w-100 border p-4 rounded shadow">
            <form v-on:submit.prevent="handleLoginForm">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <div class="form-floating">
                    <input
                        type="email"
                        v-model="email"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                    />
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input
                        type="password"
                        v-model="password"
                        class="form-control"
                        id="floatingPassword"
                        placeholder="Password"
                    />
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me" /> Remember
                        me
                    </label>
                </div>
                <div class="w-50 m-auto mb-2 text-secondary">
                    <router-link to="/register"
                        >Not registered yet ?</router-link
                    >
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">
                    Sign in
                </button>
            </form>
        </main>
    </div>
</template>

<script lang="ts">
import { useUserStore } from "../../stores/UserStore.js";

const { login } = useUserStore();



export default {
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async handleLoginForm() {
            const hasLoggedIn = await login({
                email: this.email,
                password: this.password,
            });
            if (hasLoggedIn) {
                this.$router.push("/");
            }
        },
    },
    mounted() {
        console.log("Login mounted");
    },
};
</script>

<style>
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
