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
                                <div
                                    class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-3"
                                >
                                    <div class="card-cover">
                                        <img
                                            src="https://www.pathe.fr/media/movie/alex/HO00000177/poster/md/137/movie&amp;uuid=A3B5DFE6-E76F-4864-AE72-421961676CD3"
                                            alt="{{movie.title}}"
                                        />
                                    </div>
                                </div>

                                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                                    <div class="card-content">
                                        <ul class="card-meta">
                                            <li>
                                                Directeur:<span>{{
                                                    movie.director
                                                }}</span>
                                            </li>
                                            <li>
                                                Sortie:<span>{{
                                                    movie.releaseDateFormatted
                                                }}</span>
                                            </li>
                                            <li>
                                                Durée:<span
                                                    >{{
                                                        movie.duration
                                                    }}
                                                    min</span
                                                >
                                            </li>
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
                                    <li
                                        class="nav-item"
                                        v-for="(tab, index) in tabs"
                                        :key="index"
                                    >
                                        <a
                                            style="cursor: pointer"
                                            class="nav-link"
                                            :class="{
                                                active: activeTab === index,
                                            }"
                                            @click="selectTab(index)"
                                            >{{ tab }}</a
                                        >
                                    </li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div
                                        class="row"
                                        v-if="seances['hydra:totalItems'] > 0"
                                    >
                                        <div
                                            v-for="(seance, index) in seances[
                                                'hydra:member'
                                            ]"
                                            :key="index"
                                            :class="{
                                                active: activeTab === index,
                                            }"
                                            class="col-sm-3 pad"
                                        >
                                            <button
                                                @click="
                                                    showModals[index] = true
                                                "
                                                class="btn btn-block my-2 card-session"
                                            >
                                                <div class="screening-start">
                                                    {{
                                                        seance.startTimeFormatted
                                                    }}
                                                </div>
                                                <div class="screening-end">
                                                    (fin
                                                    {{
                                                        seance.endTimeFormatted
                                                    }})
                                                </div>
                                            </button>

                                            <modal
                                                v-if="showModals[index]"
                                                @close="
                                                    showModals[index] = false
                                                "
                                            >
                                                <template v-slot:header>
                                                    <h2>{{ movie.title }}</h2>
                                                </template>
                                                <template v-slot:body>
                                                    <h3>
                                                        {{
                                                            seance.startTimeFormatted
                                                        }}
                                                    </h3>
                                                    <h3>{{ seance.price }}€</h3>
                                                </template>
                                                <template v-slot:footer>
                                                    <a
                                                        @click="
                                                            emitDataEvent(
                                                                seance.price
                                                            )
                                                        "
                                                        :href="
                                                            '/payment/' +
                                                            seance.id
                                                        "
                                                        class="button-cta cta-button"
                                                        >Réserver</a
                                                    >
                                                </template>
                                            </modal>
                                        </div>
                                    </div>
                                    <div v-else>
                                        Aucune séance pour le moment
                                    </div>
                                </div>
                            </div>

                            <div class="comment-contents">
                                <h2 class="content-title">Commentaires</h2>

                                <!-- INPUT COMMENT -->
                                <form v-on:submit.prevent="handleAddComment">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            v-model="commentTitle"
                                            class="form-control"
                                            id="titleCommentInput"
                                        />
                                        <label for="floatingInput">Titre</label>
                                    </div>
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            v-model="commentDescription"
                                            class="form-control"
                                            id="descCommentInput"
                                        />
                                        <label for="floatingPassword"
                                            >Description</label
                                        >
                                    </div>
                                    <button
                                        class="w-100 btn btn-lg"
                                        type="submit"
                                        id="button-send-comment"
                                    >
                                        Envoyer
                                    </button>
                                </form>
                                <!-- REVIEW --> 
                                <div v-if="review.length > 0">
                                    <p>{{review[0].title}}</p>
                                    <p>{{review[0].description}}</p>
                                    
                                </div>
                                <div v-else>
                                    Aucune critique n'a été rédigée pour le moment
                                    <p>{{review.descritpion}}{{review[0].description}}gygyu</p>
                                </div>
                                <!-- LIST COMMENTS -->
                                <div
                                    v-if="
                                        movie.comments &&
                                        movie.comments.length > 0
                                    "
                                >
                                    <div
                                        v-for="comment in movie.comments"
                                        :key="comment.id"
                                    >
                                        <div class="comment">
                                            <div>
                                                <h3 class="comment-content">
                                                    {{ comment.title }}
                                                </h3>
                                                <p class="comment-content">
                                                    {{ comment.description }}
                                                </p>
                                            </div>
                                            <i
                                                class="bi bi-flag-fill"
                                                @click="signalComment(comment)"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    Aucun commentaire pour le moment
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div v-if="showMessage" class="message">{{ message }}</div>
</template>

<script>
import { ref, reactive, onBeforeMount, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import modal from "../../components/Modal.vue";
import TabMenu from "../../components/TabMenu.vue";
import Stripe from "../stripe/Stripe.vue";
import { useUserStore } from "../../stores/UserStore";
const showMessage = ref(false);
const message = ref("");
const API_URL = import.meta.env.VITE_API_URL;

export default {
    data() {
        return {
            comments: null,
        };
    },
    created() {},
    methods: {},
    components: {
        modal,
        Stripe,
    },
    setup() {
        const user = useUserStore();

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
        const review = ref({});
        const seances = ref({});
        const comments = reactive([]);
        const comments_url = ref({});
        const route = useRoute();
        var showModals = reactive([]);
        const commentTitle = ref("");
        const commentDescription = ref("");

        for (let i = 0; i < 7; i++) {
            let day = new Date(today.getTime() + i * 24 * 60 * 60 * 1000);
            let jourSemaine = jours[day.getDay()];
            let jourMois = day.getDate();
            let moisAnnee = mois[day.getMonth()];

            tabs.push(`${jourSemaine} ${jourMois} ${moisAnnee}`);
            contents.push(
                `Contenu pour ${jourSemaine} ${jourMois} ${moisAnnee}`
            );
        }

        function formatDate(dateString) {
            // Tableau pour mapper les mois en français à leurs numéros respectifs
            const monthMap = {
                janv: "01",
                févr: "02",
                mars: "03",
                avril: "04",
                mai: "05",
                juin: "06",
                juil: "07",
                août: "08",
                sept: "09",
                oct: "10",
                nov: "11",
                déc: "12",
            };

            // Expression régulière pour extraire le jour et le mois
            const dateRegex = /(\d+)\s+(\w+)/;

            // Extraire le jour et le mois de la chaîne de caractères
            const [, day, monthName] = dateString.match(dateRegex);

            // Trouver le numéro du mois en utilisant le tableau de mappage
            const month = monthMap[monthName];

            // Formater la date dans le format YYYY-MM-DD
            const formattedDate = `${new Date().getFullYear()}-${month}-${day.padStart(
                2,
                "0"
            )}`;

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
            // console.log(seances.value)
            return seances;
        }

        selectTab(0); // Appel de la fonction pour le premier onglet

        onBeforeMount(async () => {
            try {
                const res_movie = await fetch(
                    `${API_URL}/movies/${route.params.id}`
                );
                const data_movie = await res_movie.json();
                movie.value = data_movie;
                console.log(movie.value);
 //get review
                const res_review = await fetch(`${API_URL}/reviews?validate=true&movie_id=${route.params.id}`);
                const data_review = await res_review.json();
                review.value = data_review;
                review.value = review['value']['hydra:member'];
                console.log("review")
                console.log(review)
            } catch (error) {
                console.log(error);
            }

              
                showModals = Array(movie.seance.length).fill(false);
                seances_urls.value = movie.value.seance;
            
                
                

                // get comments
                comments_url.value = movie.value.comments;
                for (const comment of comments_url.value) {
                    await fetch(`${API_URL}${comment}`)
                        .then((response) => response.json())
                        .then((data) => {
                            comments.push(data);
                        });
                }

               
        });

        async function handleAddComment() {
            if (this.commentTitle == "" || this.commentDescription == "") {
                alert("Veuillez remplir tous les champs");
                return;
            }
            const movieId = route.params.id;
            const userId = await user.id();

            try {
                await fetch(`${API_URL}/comments`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        title: this.commentTitle,
                        description: this.commentDescription,
                        movieId: `/movies/${movieId}`,
                        userId: `/users/${userId}`,
                        // moderation: '/moderations/2',
                        date: new Date(),
                        counter: 0,
                    }),
                });

                const res_movie = await fetch(`${API_URL}/movies/${movieId}`);
                const data_movie = await res_movie.json();
                movie.value = data_movie;

                // get comments
                comments_url.value = movie.value.comments;
                for (const comment of comments_url.value) {
                    await fetch(`${API_URL}${comment["@id"]}`)
                        .then((response) => response.json())
                        .then((data) => {
                            comments.push(data);
                        });
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function signalComment(comment) {
            const userId = await user.id();
            const commentId = comment["@id"];

            console.log("commentId = ", commentId);
            // Check if comment is already signaled
            const res = await fetch(`${API_URL}/moderations`);
            const commentsInDb = await res.json();

            try {
                const isCommentAlreadySignaled = commentsInDb[
                    "hydra:member"
                ].find((el) => el.commentaireId === commentId);

                if (isCommentAlreadySignaled) {
                    const moderationresp = await fetch(
                        `${API_URL}/moderations/${isCommentAlreadySignaled.id}`
                    );
                    const moderationdata = await moderationresp.json();
                    const numberOfSignal = moderationdata.counterUserBan;

                    await fetch(`${API_URL}/moderations/${moderationdata.id}`, {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/merge-patch+json",
                        },
                        body: JSON.stringify({
                            counterUserBan: numberOfSignal + 1,
                            userId: `/users/${userId}`,
                            commentaireId: commentId,
                        }),
                    });
                } else {
                    await fetch(`${API_URL}/moderations`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            counterUserBan: 0,
                            userId: `/users/${userId}`,
                            commentaireId: commentId,
                        }),
                    });
                }
                showMessage.value = true;
                message.value = "Commentaire signalé !";
                setTimeout(() => {
                    showMessage.value = false;
                }, 3000);
            } catch (error) {
                console.error(error);
            }
        }

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
            seances,
            handleAddComment,
            commentTitle,
            commentDescription,
            user,
            signalComment,
            showMessage,
            message,
            review,
        };
    },
};
</script>

<style lang="scss">
label {
    color: black;
}

#button-send-comment {
    background-color: #ff7f00;
    color: white;
}

#button-send-comment:hover {
    background-color: #f9ab00;
    color: white;
}

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

i {
    color: red;
    cursor: pointer;
}

.comment {
    display: flex;
    align-items: center;
    justify-content: space-between;

    border: 1px white solid;
    margin: 0.5em;
    padding: 0.5em 1.5em;

    border-radius: 5px;
}

form {
    width: 70%;
    margin: 0 auto;
    padding: 1em 0;
}

form > div {
    margin-bottom: 0.5em;
}

.message {
    position: absolute;
    right: 20px;
    bottom: 20px;
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
}
</style>
