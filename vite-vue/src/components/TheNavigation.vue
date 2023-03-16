<script lang="ts" setup>
import { useUserStore } from "../stores/UserStore.js";
import { useRouter } from "vue-router";

const router = useRouter();
const user = useUserStore();

async function handleLogout() {
    await user.logout();
    router.push({ name: "login" });
}
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="../../public/drolcinema.png" alt="DrolCinema">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav navbar-left me-auto mb-2 mb-lg-0">
                    <li class="nav-item" :class="{ 'router-link-active': $route.path === '/' }">
                        <router-link class="nav-link" to="/">Films</router-link>
                    </li>
                    <li class="nav-item" :class="{ 'router-link-active': $route.path === '/about' }">
                        <router-link class="nav-link" to="/offres">Offres</router-link>
                    </li>
                    <li class="nav-item" :class="{ 'router-link-active': $route.path === '/reservation' }">
                        <router-link class="nav-link" to="/produits">Produits</router-link>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item"><a class="nav-link" href="/register" style="font-weight: bold">S'inscrire</a></li>
                    <li class="nav-item"><span class="nav-link">|</span></li>
                    <li class="nav-item"><a class="nav-link" href="/login" style="font-weight: bold">Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
</template>


<style>
.router-link-active {
    color: white;
    font-weight: bold;
}

.navbar {
    background-color: transparent !important;
}

.nav-link {
    color: white;
    transition: color 0.2s ease-in-out;
}

.nav-link:hover {
    color: rgba(255, 255, 255, 0.8) !important;
}

.navbar-nav a:not(.active) {
    color: #d3c4b8;
}

.navbar-nav .nav-link:focus,
.navbar-nav .nav-link:active {
    color: #fff;
    /* Couleur du texte */
    background-color: transparent;
    /* Couleur de fond */
    outline: none;
}

.navbar-left li {
    margin-right: 32px;
}
</style>
