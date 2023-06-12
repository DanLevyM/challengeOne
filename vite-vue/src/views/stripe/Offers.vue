<template>
    <section class="section section--border">
        <div class="container-fluid">
            <div class="row justify-content-center d-flex">
                <div class="col-12 col-xl-10">
                    <h2 class="section__title section__title--mb"><b>DrolCinema</b> – Le meilleur endroit pour les films
                    </h2>

                    <p class="section__text">Plongez dans une expérience cinématographique inoubliable avec notre offre
                        spéciale ! Profitez de notre offre découverte pour bénéficier de 20% de réduction sur les
                        séances et de 15% de réduction sur les collations. Vous avez également la possibilité de
                        réserver jusqu'à une semaine avant la séance pour planifier votre sortie au cinéma à la
                        perfection.

                        Si vous cherchez une option plus flexible, optez pour notre offre Drol ! Avec des séances
                        illimitées et une réduction de 15% sur les collations, vous pourrez profiter de nos films autant
                        que vous le souhaitez. De plus, vous pouvez réserver jusqu'à une semaine avant la séance, pour
                        une expérience sans stress.</p>

                    <p class="section__text">Ne manquez pas ces offres spéciales ! Réservez dès maintenant pour profiter
                        de notre offre découverte ou optez pour notre offre Drol pour une expérience cinématographique
                        sans limites.</p>
                </div>
            </div>

            <div class="row justify-content-center d-flex">

                <div class="col-12 col-md-12 col-lg-4 order-md-1 order-lg-2">
                    <div class="price">
                        <div class="price__item price__item--first"><span>Offre Découverte</span> <span>7€ <sub>/
                                    mois</sub></span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 1 mois</span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 20% de réduction
                                sur les séances</span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 15% de réduction
                                sur la nourriture</span></div>
                        <div class="price__item price__item--none"><font-awesome-icon
                                icon="fa-solid fa-check" /><span>Possibilité de réserver jusqu’à 1 semaine avant la
                                séance</span>
                        </div>
                        <button @click="showModal = true" class="price__btn">Choisir cette Offre</button>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 order-md-3">
                    <div class="price price--premium">
                        <div class="price__item price__item--first"><span>Offre Drol</span> <span>20€
                                <sub>/mois</sub></span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 1 an</span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 50% de réduction
                                sur les séances</span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 15% de réduction
                                sur la nourriture</span></div>
                        <div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> Possibilité de
                                réserver jusqu’à 1 semaine avant la séance</span></div>
                        <button @click="showModal = true" class="price__btn">Choisir cette Offre</button>
                    </div>
                </div>

                <modal v-if="showModal" @close="showModal = false">
                    <template v-slot:header>
                        <h3>Souscrivez à notre offre de cinéma</h3>
                    </template>
                    <template v-slot:body>
                        <p>
                            Profitez d'un accès préférentiels à une vaste sélection de films et de séries !
                        </p>
                        <ul>
                            <li>Des milliers de titres disponibles à la demande</li>
                            <li>Diffusion en streaming haute qualité</li>
                            <li>Accès sur tous vos appareils : téléviseur, ordinateur, téléphone et tablette</li>
                            <li>Créez des listes de lecture personnalisées</li>
                            <li>Recommandations basées sur vos préférences</li>
                        </ul>
                    </template>
                    <template v-slot:footer>
                        <router-link :to="'/payment/'" class="btn-cta btn--full btn--center">Souscrire</router-link>
                    </template>
                </modal>

            </div>
        </div>

        <div class="bg--dark-blue">
            <div class="component--cards-offers">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-10 offset-md-1 text-center">
                            <h2 class="card--title title--big-caps color--white">Formules gourmandes</h2>
                        </div>

                        <div
                            class="col-12 col-md-4 col-lg-3 offset-md-2 offset-lg-3 d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="img-wrapper">
                                <img alt="Formules gourmandes" src="../../assets/img/les-formules-gourmandes.png">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="text-justify">
                                <p class="color--white p--medium">Découvrez nos formules gourmandes et nos remises pour les
                                    membres du Club UGC.</p>
                                <router-link class="offer-btn" to="/products"><span>JE DÉCOUVRE</span></router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import modal from "../../components/Modal.vue";
import { ref } from "vue";

export default {
    setup() {
        var showModal = ref(false);
        return {
            showModal
        }
    },
    components: {
        modal
    }
}
</script>

<style scoped>
section#cards-offers #ugc-blue,
section#cards-offers #partners-cards {
    padding: 33px 0 50px;
}

.bg--dark-blue {
    margin-top: 50px;
    background-color: #222028;
}

.offer-btn {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    height: 46px;
    width: 100%;
    border-radius: 6px;
    background-color: transparent;
    font-size: 14px;
    color: #fff;
    text-transform: uppercase;
    border: 2px solid #f77e29;
    margin-top: 20px;
}

.component--cards-offers .img-wrapper {
    margin-right: 6%;
}
</style>
