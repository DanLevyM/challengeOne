<template>
    <section v-if="seance" class="text-right">
        <div class="container col-md-6 mx-auto bg-dark text-light p-4"
            style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 1);">
            <div class="row">
                <h3 class="text-center pb-3" style="color: #f88c3f;">Réservez votre place !</h3>
                <div class="row text-center">
                    <div class="col-md-6">
                        <h3 class="h3">{{ seance.movie["title"] }}</h3>
                        <p>Salle {{ seance.movieroom_id["room_name"] }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>{{ seance.dateFormatted }}</h4>
                        <h4>{{ seance.startTimeFormatted }}</h4>
                        <p>Fin ({{ seance.endTimeFormatted }})</p>
                    </div>
                </div>
                <div v-if="sub">
                    <div class="row p-4">

                        <div v-if="sub.message === 'Offre Découverte'" class="d-flex flex-column">
                            <span class="text-decoration-line-through">
                                Prix : {{ seance.price }}€
                            </span>
                            <span class="text-danger fs-5">
                                {{ seance.price * 80 / 100 }}€
                            </span>
                            <span class="text-success">-20% grace à l'offre Découverte</span>
                        </div>
                        <div v-else-if="sub.message === 'Offre Drol'" class="d-flex flex-column">
                            <span class="text-decoration-line-through">
                                Prix : {{ seance.price }}€
                            </span>
                            <span class="text-danger fs-5">
                                {{ seance.price * 50 / 100 }}€
                            </span>
                            <span class="text-success">-50% grace à l'offre Drol</span>
                        </div>
                        <div v-else class="d-flex flex-column">
                            <span class="fs-5">
                                Prix : {{ seance.price }}€
                            </span>
                        </div>
                    </div>
                </div>


                <form @submit.prevent="handleSubmit">

                    <div class="form-group p-4">
                        <label style="color:white" for="email_field">Carte de crédit</label>
                        <div id="stripe-element-mount-point"></div>
                    </div>

                    <p v-if="error" class="alert alert-danger" role="alert">{{ error }}</p>

                    <div class="d-flex justify-content-center">
                        <button v-if="sub.message === 'Offre Découverte'" type="submit" class="btn text-light col-md-4"
                            style="background-color: #f88c3f; font-weight: bold;" :disabled="loading">
                            {{ loading ? "Loading..." : `Payer ${seance.price * 80 / 100}€` }}
                        </button>
                        <button v-else-if="sub.message === 'Offre Drol'" type="submit" class="btn text-light col-md-4"
                            style="background-color: #f88c3f; font-weight: bold;" :disabled="loading">
                            {{ loading ? "Loading..." : `Payer ${seance.price * 50 / 100}€` }}
                        </button>
                        <button v-else type="submit" class="btn text-light col-md-4"
                            style="background-color: #f88c3f; font-weight: bold;" :disabled="loading">
                            {{ loading ? "Loading..." : `Payer ${seance.price}€` }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import { ref, onBeforeMount } from "vue";
import { useRouter, useRoute } from "vue-router";
import jsCookie from "js-cookie";

const API_URL = import.meta.env.VITE_API_URL;
const jwtToken = localStorage.getItem("access_token");//jsCookie.get('jwt')
const style = {
    style: {
        base: {
            iconColor: "#fff",
            color: "#fff",
            fontWeight: "800",
            fontFamily: "Press Start 2P",
            fontSize: "22px"
        },
        invalid: {
            iconColor: "#FFC7EE",
            color: "#d9534f",
            "::placeholder": {
                color: "#d9534f"
            }
        }
    }
};

export default {
    setup() {
        const seance = ref({});
        const sub = ref({});
        const router = useRouter();
        const route = useRoute();
        let stripe = null;
        let loading = ref(true);
        let elements = null;
        const amount = ref(0);
        const error = ref(null);

        onBeforeMount(async () => {
            try {
                const res_seance = await fetch(`${API_URL}/seances/${route.params.id}`);

                if (res_seance.status === 404) {
                    router.replace({ name: 'not-found' });
                } else {
                    const data_seance = await res_seance.json();
                    seance.value = data_seance;

                    const res_sub = await fetch(`${API_URL}/subscriptions/active`, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer " + jwtToken
                        },
                    });

                    const data_sub = await res_sub.json();
                    sub.value = data_sub;

                    if (data_sub.code === 401) {
                        router.push({
                            path: '/login',
                            forceReload: true
                        })
                    }

                    const ELEMENT_TYPE = "card";
                    stripe = await loadStripe(import.meta.env.VITE_PUBLISHABLE_KEY);
                    elements = stripe.elements();
                    const element = elements.create(ELEMENT_TYPE, style);
                    element.mount("#stripe-element-mount-point");

                    loading.value = false;

                }

            } catch {
                error.value = "Une erreur s'est produite lors de la récupération des données de la séance."
            }

        });

        async function handleSubmit(event) {

            if (loading.value) return;

            const cardElement = elements.getElement("card");
            loading.value = true;

            try {
                const token = (await stripe.createToken(cardElement)).token.id;
                const id = route.params.id;
                alert(token)
                const response = await fetch(`${API_URL}/payment/${id}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + jwtToken
                    },
                    body: JSON.stringify({ stripeToken: token })
                });

                const payment_state = await response.json();
                if (payment_state.status === "success") {
                    loading.value = false;

                    router.push({
                        path: "/success",
                        forceReload: true

                    });
                } else if (response.status === 404 || response.status === 400) {
                    loading.value = false;
                    error.value = payment_state.message
                }
                else if (response.status === 302 || response.status === 401) {
                    router.push({
                        path: '/login'
                    })
                } else if (response.status === 201) {
                    router.push({
                        path: '/success'
                    })
                }

            } catch (error) {
                loading.value = false;
            }
        }

        return { loading, handleSubmit, amount, seance, sub, error };
    }
};
</script>

