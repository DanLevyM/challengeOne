<template>
    <div>
        <picture class="cover-img">
            <source media="(-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi)"
                srcset="https://www.pathe.fr/media/movie/9102738/backdrop/lg/80/1280x720_le-roi-lion-238823_5df0b8e1496ad.jpg">
            <img alt="" loading="lazy"
                src="https://www.pathe.fr/media/movie/9102738/backdrop/lg/80/1280x720_le-roi-lion-238823_5df0b8e1496ad.jpg">
        </picture>
        <div class="container hero-film">
            <img width="100" class="hero-film__poster"
                src="https://www.pathe.fr/media/movie/alex/HO00000177/poster/md/137/movie&amp;uuid=A3B5DFE6-E76F-4864-AE72-421961676CD3"
                alt="Le Roi Lion">
            <div class="hero-film-content">
                <h1 class="mb-md-1">Le Roi Lion</h1>
                <div class="hero-film__subtitle mb-2 f-inline f-ai-center f-wrap">
                    <span class="label label--dark mr-2">Animation </span>
                    <span class="label label--dark mr-2"> Aventure </span>
                    <span class="label label--dark mr-2"> Famille </span>
                    <span class="label label--dark mr-2">1h58</span>
                </div>

                <div>
                    <p class="ft-tertiary ft-500 c-white-70"> Sortie : {{ movie.release_date }} </p>

                    <div>
                        <p class="ft-tertiary c-white-70"> De <strong>{{ movie.director }}</strong> avec
                            <strong>Jean Reno, Rayane Bensetti, Sabrina Ouazani</strong>
                        </p>
                        <p class="hero-film__desc ft-default c-white-70"> {{ movie.description }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import { ref, reactive, onBeforeMount, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import modal from "../../components/Modal.vue"
import Stripe from '../stripe/Stripe.vue';

const API_URL = import.meta.env.VITE_API_URL;
function getHoursAndMinutes(dateString) {
    let date = new Date(dateString);

    let hours = date.getHours();
    let minutes = date.getMinutes();

    let formattedTime = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}`;
    return formattedTime;
}

function getFullDate(date_string) {
    let dateString = date_string;
    let date = new Date(dateString);

    let dayOfWeek = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    let day = dayOfWeek[date.getUTCDay()];

    let months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
    let month = months[date.getUTCMonth()];

    let dayOfMonth = date.getUTCDate();

    let formattedDate = `${day} ${dayOfMonth} ${month}`;

    return formattedDate;

}
export default {

    components: {
        modal,
        Stripe
    },
    setup() {

        const movie = ref({});
        const seances_urls = ref({});
        const seances = reactive([]);
        const comments = reactive([]);
        const comments_url = ref({});
        const route = useRoute();
        const showModals = reactive(Array(seances.length).fill(false))
        onBeforeMount(async () => {
            try {
                const res_movie = await fetch(`${API_URL}/movies/${route.params.id}`);
                const data_movie = await res_movie.json();
                movie.value = data_movie;
                movie.value.release_date = new Date(movie.value.release_date).toLocaleDateString()
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

                for (const s of seances_urls.value) {
                    await fetch(`${API_URL}${s}`)
                        .then(response => response.json())
                        .then(data => {
                            data.start_time = getHoursAndMinutes(data.start_time)
                            seances.push(data);
                        })
                }

            } catch (error) {
                console.log(error);
            }

        });


        return {
            movie,
            seances_urls,
            seances,
            showModals,
            comments,
            comments_url
        }
    },
    /*  methods: {
            emitDataEvent(seance) {
                bus.$emit('data-event', seance)
        } */
    //}                



};
</script>

<style lang="scss">
.cover-img {
    position: absolute;
    top: 0;
    right: 0;
    // display: flex;
    background-image: url('https://www.pathe.fr/media/movie/9102738/backdrop/lg/80/1280x720_le-roi-lion-238823_5df0b8e1496ad.jpg');
    background-size: cover;
    background-position: center center;
    max-width: 1080px;
    margin: 0 auto;
    height: 100vh;
    /* ajuster la hauteur selon vos besoins */
}

.hero-film-content {
    width: 40%;
}

.cover-img {
    z-index: -1;
    width: 60%
}

.cover-img::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, var(--black) 0%, transparent 44%);
    z-index: 1;
}

.comment-contents {
    border-color: grey;
    border: solid;
    border-radius: 10px;
    padding: 1em;
    margin: 1em;
}

.comment {
    border-radius: 10px;
    padding: 1em;
    margin: 1em;
    width: 100%;
}

.comment-content {
    width: 100;
}
</style>
