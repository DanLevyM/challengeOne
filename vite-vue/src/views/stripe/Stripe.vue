<template>
    
    <section class="showcase">
        
    <div class="nes-container with-title">
        <h3>Réservez votre place !</h3>
        <div class="img">
        <img
            src="https://stripe-camo.global.ssl.fastly.net/6d097cce2c90965a3c955721cead3e8e0a9f8050f4122b2b3c50762fbffb326a/68747470733a2f2f66696c65732e7374726970652e636f6d2f6c696e6b732f4d44423864584e6c636c38775155526f654464315454683556566c4a53327846544642554e48786d624639305a584e3058316c7963464a58546e52726556424863336b35626c5648596b5a554e45706a656730305a7a5a565335315a"
            alt=""
            srcset=""
        />
        </div>
    </div>
    </section>

    <div class="nes-container with-title is-centered">
        <form @submit.prevent="handleSubmit">
            <fieldset :class="{ dis: loading }" class="fields">
            <div class="nes-field"></div>
            <div class="nes-field">
                <label for="name_field">Nom</label>
                <input
                placeholder="Jane Doe"
                type="text"
                name="name"
                id="name_field"
                class="nes-input"
                />
            </div>
            <div class="nes-field">
                <label for="email_field">Email</label>
                <input
                    placeholder="jane.doe@example.com "
                    type="email"
                    name="email"
                    id="email_field"
                    class="nes-input"
                />
            </div>
            <div class="nes-field">
                <label for="email_field">Carte de crédit</label>
                <div id="stripe-element-mount-point" class="nes-input" />
            </div>
            </fieldset>
            <div class="nes-field">
                <button
                    type="submit"
                    class="nes-btn is-primary"
                    :class="{ dis: loading }"
                >
                    {{ loading ? "Loading..." : `Payer ` }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, ref, onBeforeMount } from "vue";
import { useRouter, useRoute } from "vue-router";
// import bus from '../../event-bus.js';
const API_URL = import.meta.env.VITE_API_URL;

const style = {
    style: {
        base: {
            iconColor: "#000",
            color: "#000",
            fontWeight: "800",
            fontFamily: "Press Start 2P",
            fontSize: "22px",
            fontSmoothing: "antialiased",
            ":-webkit-autofill": {
            color: "#fce883"
            },
            "::placeholder": {
            color: "green"
            }
        },
        invalid: {
            iconColor: "#FFC7EE",
            color: "red"
        }
    }
};

export default {
    setup() {
        const router = useRouter();
        const route = useRoute();
        let stripe = null;
        let loading = ref(true);
        let elements = null;
        const amount = ref(0);
        
        onBeforeMount(async () => {
            const ELEMENT_TYPE = "card";
            stripe = await loadStripe(import.meta.env.VITE_PUBLISHABLE_KEY);
            elements = stripe.elements();
            const element = elements.create(ELEMENT_TYPE, style);
            element.mount("#stripe-element-mount-point");
            
            // const token = (await stripe.value?.createToken(cardElement.value)) //.token.id;
            
            loading.value = false;
            // bus.$on('data-event', handleDataEvent)
            
        });

        async function handleSubmit(event) {

            if (loading.value) return;

            const cardElement = elements.getElement("card");
            loading.value = true;
            
            const { name, email } = Object.fromEntries(
                new FormData(event.target)
            );
            
            const billingDetails = {
                name,
                email
            };
            

            // const token = await stripe.value?.createToken(cardElement.value);
            
            try {
                // const token = (await stripe.value?.createToken(cardElement.value)).token.id;
                const token = (await stripe.createToken(cardElement)).token.id;
                console.log(token)
                // const stripeToken = (await stripe.value?.createToken(cardElement.value)).token.id;
                const id = route.params.id
                // console.log(stripeToken)
                const response = await fetch(`${API_URL}/payment/${id}`, {
                    method: "POST",
                    headers: {
                    "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ token: token })
                });
            
                const  payment_state  = await response.json();
                console.log(payment_state)
                if (payment_state.status === "success") {
                    loading.value = false;

                    router.push({
                        path: "/success",
                        forceReload: true
                
                    });
                } else {
                    router.push({
                        path: "/error",
                        forceReload :true
                    })
                }   
                /* const paymentMethodReq = await stripe.createPaymentMethod({
                    type: "card",
                    card: cardElement,
                    billing_details: billingDetails
                });
                console.log("error?createPaymentMethod", paymentMethodReq);

                const { error } = await stripe.confirmCardPayment(secret.client_secret, {
                    payment_method: paymentMethodReq.paymentMethod.id
                });  */

                } catch (error) {
                    console.log("error", error);
                    loading.value = false;
            }
        }

        return { loading, handleSubmit, amount };
    },
    methods: {
        handleDataEvent (seance) {
            console.log("hola")
            amount.value = seance
        }
    }
};
</script>


<style scoped>
.checkout {
border: 1px solid black;
padding: 3px;
}
.fields {
display: flex;
flex-wrap: wrap;
flex-direction: column;
gap: 30px;
}
.img {
display: flex;
justify-content: center;
}
.showcase {
margin-bottom: 20px;
}
.mt {
margin-top: 20px;
}
.dis {
opacity: 0.5;
cursor: default;
pointer-events: none;
}
button {
margin-top: 30px;
}
</style>
