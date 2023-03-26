<template>
    <div>
        <section class="section section--details section--bg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="section-title">{{ movie.title }}</h1>
                    </div>
                    <div class="col-12">
                        <div class="card card--details">
                            <div class="row">
                                <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-3">
                                    <div class="card-cover">
                                        <img src="https://www.pathe.fr/media/movie/alex/HO00000177/poster/md/137/movie&amp;uuid=A3B5DFE6-E76F-4864-AE72-421961676CD3"
                                            alt={{movie.title}}>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                                    <div class="card-content">
                                        <ul class="card-meta">
                                            <li>Directeur:<span>{{ movie.director }}</span></li>
                                            <li>Sortie:<span>{{ movie.releaseDateFormatted }}</span></li>
                                            <li>Durée:<span>{{ movie.duration }} min</span></li>
                                        </ul>
                                        <div>
                                            {{ movie.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="content-head">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="content-title">Séances</h2>

                            <!-- Seance par date -->

                            <div>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
                                        <a class="nav-link" :class="{ active: activeTab === index }"
                                            @click="selectTab(index)">{{ tab }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div class="row" v-if="seances['hydra:totalItems'] > 0">
                                        <div v-for="(seance, index) in seances['hydra:member']" :key="index"
                                            :class="{ active: activeTab === index }" class="col-sm-3 pad">
                                            <button @click="showModals[index] = true"
                                                class="btn btn-block my-2 card-session">
                                                <div class="screening-start">{{ seance.startTimeFormatted }}</div>
                                                <div class="screening-end ">(fin {{ seance.endTimeFormatted }})</div>
                                                <!-- {{ seance.price }} -->
                                                <!-- {{ seance.id }} -->
                                            </button>

                                            <modal v-if="showModals[index]" @close="showModals[index] = false">
                                                <template v-slot:header>
                                                    <h2>{{ movie.title }}</h2>
                                                </template>
                                                <template v-slot:body>
                                                    <h3>{{ seance.startTimeFormatted }}</h3>
                                                    <h3>{{ seance.price }}€</h3>
                                                </template>
                                                <template v-slot:footer>
                                                    <a @click="emitDataEvent(seance.price)"
                                                        :href="'/payment/' + seance.id"
                                                        class="button-cta cta-button">Réserver</a>
                                                </template>
                                            </modal>
                                        </div>
                                    </div>
                                    <div v-else>
                                        Aucune séance pour le moment
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="comment-contents">
                                    <p>Comments:</p>
                                    <div v-if="comments">
                                        <div> v-for="(comment) in comments" :key="comment.id" class="col-sm-3">
                                            <div class="comment">
                                                <h3 class="comment-content">{{ comment.title }}</h3>
                                                <p class="comment-content">{{ comment.description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        Aucune commentaire pour le moment
                                    </div>
                                </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { ref, reactive, onBeforeMount, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import modal from "../../components/Modal.vue"
import TabMenu from "../../components/TabMenu.vue"
import Stripe from '../stripe/Stripe.vue';

const API_URL = import.meta.env.VITE_API_URL;

export default {

    components: {
        modal,
        Stripe,
    },
    setup() {


        const jours = ["dim", "lun", "mar", "mer", "jeu", "ven", "sam"];
        const mois = [
            "janv",
            "févr",
            "mars",
            "avril",
            "mai",
            "juin",
            "juil",
            "août",
            "sept",
            "oct",
            "nov",
            "déc",
        ];

        let today = new Date();
        const activeTab = ref(0);
        const tabs = [];
        const contents = [];

        const movie = ref({});
        const seances = ref({});
        const comments = reactive([]);
        const comments_url = ref({});
        const route = useRoute();
        var showModals = reactive([])

        for (let i = 0; i < 7; i++) {
            let day = new Date(today.getTime() + i * 24 * 60 * 60 * 1000);
            let jourSemaine = jours[day.getDay()];
            let jourMois = day.getDate();
            let moisAnnee = mois[day.getMonth()];

            tabs.push(`${jourSemaine} ${jourMois} ${moisAnnee}`);
            contents.push(`Contenu pour ${jourSemaine} ${jourMois} ${moisAnnee}`);
        }

        function formatDate(dateString) {
            // Tableau pour mapper les mois en français à leurs numéros respectifs
            const monthMap = {
                'janv': '01',
                'févr': '02',
                'mars': '03',
                'avril': '04',
                'mai': '05',
                'juin': '06',
                'juil': '07',
                'août': '08',
                'sept': '09',
                'oct': '10',
                'nov': '11',
                'déc': '12'
            };

            // Expression régulière pour extraire le jour et le mois
            const dateRegex = /(\d+)\s+(\w+)/;

            // Extraire le jour et le mois de la chaîne de caractères
            const [, day, monthName] = dateString.match(dateRegex);

            // Trouver le numéro du mois en utilisant le tableau de mappage
            const month = monthMap[monthName];

            // Formater la date dans le format YYYY-MM-DD
            const formattedDate = `${new Date().getFullYear()}-${month}-${day.padStart(2, '0')}`;

            return formattedDate;
        }


        async function selectTab(index) {
            activeTab.value = index;

            // Récupérer la date correspondant à l'onglet sélectionné
            const date = formatDate(tabs[index]);

            // Construire l'URL de l'API correspondante
            const apiUrl = `${API_URL}/seances?date=${date}&movie=${route.params.id}`;

            const res_seances = await fetch(apiUrl);

            const data_seances = await res_seances.json();

            seances.value = data_seances;
            console.log(seances.value)
            return seances;

        }


        onBeforeMount(async () => {
            try {
                const res_movie = await fetch(`${API_URL}/movies/${route.params.id}`);
                const data_movie = await res_movie.json();
                movie.value = data_movie;

                showModals = Array(movie.seance.length).fill(false)
                seances_urls.value = movie.value.seance;

                // get comments
                comments_url.value = movie.value.comments;
                console.log(comments_url.value);
                for (const comment of comments_url.value) {
                    await fetch(`${API_URL}${comment}`)
                        .then(response => response.json())
                        .then(data => {
                            comments.push(data);
                        })
                }

            } catch (error) {
                console.log(error);
            }

        });


        return {
            movie,
            showModals,
            comments,
            comments_url,
            tabs: tabs,
            contents: contents,
            activeTab,
            selectTab,
            formatDate,
            seances
        }
    }
};
</script>

<style lang="scss">
.section--details {
    background: url(../../assets/details.jpg) center center / cover no-repeat;
}

.section-title {
    font-weight: 400;
    font-size: 30px;
    line-height: 130%;
    margin-bottom: 20px;
}

.card {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    width: 100%;
    position: relative;
    margin-bottom: 20px;
    background-color: transparent;
    border: none;
}

.card-cover {
    display: flex;
    flex-direction: row;
    align-items: center;
    position: relative;
    border-radius: 6px;
    overflow: hidden;
}

.card-content {
    position: relative;
    display: block;
    margin-top: 10px;
    width: 100%;
}

.card-meta {
    display: block;
    font-size: 16px;
    line-height: 26px;
    color: #fff;
    padding-left: 0;
}

.card-meta li {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: start;
    flex-wrap: wrap;
    width: 100%;
}

.card-meta span {
    margin-left: 10px;
    color: #f9ab00;
    opacity: 0.8;
}

// Section decouverte
.content-head {
    background-color: #1a191f;
    margin-bottom: 20px;
    padding: 20px 0;
    position: relative;
    border-bottom: 1px solid #222028;
}

.content {
    padding: 0 0 30px;
}

.content-title {
    font-weight: 400;
    font-size: 30px;
    line-height: 100%;
    margin-bottom: 20px;
}

.card-session {
    background-color: #ff7f00;
    //#f9ab00;
    opacity: 0.8;
    display: flex;
    height: 100%;
    border-radius: 8px;
    overflow: hidden;
    flex-direction: column;
    transition: box-shadow 0.3s ease;
    border: none;
    padding: 0;
    width: 100%;
    align-items: stretch;
    text-align: center;
    color: white;
}

.btn:hover {
    background-color: #ff9900;
    // color: black;
}

.screening-start {
    font-size: 30px;
    line-height: 34px;
    font-weight: 500;
}

.screening-end {
    font-size: 16px;
    opacity: 0.8;
}

.pad {
    margin-bottom: 15px;
}

.nav-tabs .nav-link.active {
    color: black !important;
}
</style>

