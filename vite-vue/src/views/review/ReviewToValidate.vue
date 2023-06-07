<script>
import { ref, reactive, onBeforeMount} from 'vue';
import { useUserStore } from "../../stores/UserStore";


const API_URL = import.meta.env.VITE_API_URL;
export default {
    components: {
    }, 
    setup () {
        const userData = localStorage.getItem('access_token');
        const elementor = ["1", "2", "3", "4", "5", "6"];
        const picked = ref('');
        const datas = reactive([]);
        const dataf = ref({});
        const datafa = reactive([]);
        const reviews = ref({});
        const reviews_array = reactive([]);
        const admins = ref({});
        let id_connected;
        const data_reviews_logged_value = ref({});
        
        async function toValidate(id) {

          const selectedReview = datas.find(review => review.id === id);
          if (!selectedReview) {
            return; // Arrêter la fonction si la critique sélectionnée n'est pas trouvée
          }

          // Mettre à jour l'état des critiques dans la base de données
          const updatePromises = [];

          // Mettre la critique sélectionnée en true
          const updateSelectedReview = fetch(`${API_URL}/reviews/${id}`, {
            method: 'PATCH',
            headers: {
              'Content-type': 'application/merge-patch+json' 
            },
            body: JSON.stringify({ validate: true })
          });
          updatePromises.push(updateSelectedReview);

          // Mettre à false l'ancienne critique validée (si elle existe)
          const previouslyValidatedReview = datas.find(review => review.validate === true && review.id !== id);
          if (previouslyValidatedReview) {
            const updatePreviouslyValidatedReview = fetch(`${API_URL}/reviews/${previouslyValidatedReview.id}`, {
                method: 'PATCH',
                headers: {
                  'Content-type': 'application/merge-patch+json' 
                },
                body: JSON.stringify({ validate: false })
            });
            updatePromises.push(updatePreviouslyValidatedReview);
          }

          // Attendre la fin de toutes les requêtes de mise à jour
          await Promise.all(updatePromises);
          picked.value = id;
            
          /*
          const formData = {};
          formData.id = id;
          formData.validate = true;
          const response = await fetch(`${API_URL}/reviews/${id}`, {
            method: 'PATCH',
            headers: {
              'Content-type': 'application/merge-patch+json' 
            },
            body: JSON.stringify(formData)
          });
          console.log(formData)
          for (let i=0; i<datas.length; i++){
            if (datas[i].id === id){
                datas.splice(i, 1);
            }
          }*/
        }

        onBeforeMount(async () => {
            try {
              //get id logged user
              let payload = (userData).split('.')[1];
              let tokenTest = window.atob(payload);
              const values = JSON.parse(tokenTest);
              const api_url = `${API_URL}/users?email=${values.email}`;
              const res_user_logged = await fetch(api_url);
              const data_user_logged = await res_user_logged.json();
              
              id_connected = data_user_logged["hydra:member"];

              const res_users_admin = await fetch(`${API_URL}/users`);
              const data_users_admin = await res_users_admin.json();
              admins.value = data_users_admin;
              admins.value = admins["value"]["hydra:member"];

              const res_reviews = await fetch(`${API_URL}/reviews`);
              const data_reviews = await res_reviews.json();
              reviews.value = data_reviews;
              reviews.value = reviews["value"]["hydra:member"];
      
              const res_reviews_logged = await fetch(`${API_URL}/reviews?user_admin_check=/users/${id_connected[0].id}`);
              const data_reviews_logged = await res_reviews_logged.json();
              data_reviews_logged_value.value = data_reviews_logged
        
              for (let element of data_reviews_logged_value["value"]["hydra:member"]){
                const res_userNames = await fetch(`${API_URL}${element["userAdmin"]}`);
                const data_userNames = await res_userNames.json();
                let userName = data_userNames.firstname + " " + data_userNames.lastname; 
                element.userAdmin = userName;
                const res_movies = await fetch(`${API_URL}${element["movie"]}`);
                const data_movies = await res_movies.json();
                element.movie = data_movies.title;
                element.movie_id = data_movies.id;
                datas.push(element);   
              }
            } catch (error) {
                console.log(error);
            }
            for(let ele of datas){
         
              dataf.movie_id = ele.movie_id;
         
              dataf.title = ele.title;
              dataf.description = ele.description;
              datafa.push({element: dataf});
            }
        });
        
      
        return {
            reviews,
            datas,
            admins,
            reviews_array,
            toValidate,
            dataf,
            datafa,
            pickedCritiques: {},
            elementor,
            picked,
        }
    },      
         
    computed: {
    critiquesGroupedByFilm() {
      return this.datas.reduce((groupedCritiques, critique) => {
        const idFilm = critique.movie_id;
       
        if (groupedCritiques[idFilm]) {
          groupedCritiques[idFilm].push(critique);
  
        } else {
          groupedCritiques[idFilm] = [critique];
     
        }
        return groupedCritiques;
      }, {});
    },
  },



};

</script>


<template>
  <div class="bodyclass">
    <div style="color:white;" >
      <div class="rounded" v-for="(critiqueGroup, idFilm) in critiquesGroupedByFilm" :key="idFilm" style="margin: 5% 20% 5% 20%; padding-top: 2%; background-color:#111111">
      <h2 style="text-align:center;">Titre du film : {{ critiqueGroup[0].movie }}</h2>
      <div style="margin: 5% 20% 5% 20%; padding-bottom: 2%;" >
        <div class="rounded" style="color:white; border: 2px solid #1d1b22; background-color: #222028; margin: 2% 2% 4% 2%" v-for="critique in critiqueGroup" :key="critique.id">
            <input class="form-check-input" style="margin-left: 2%" v-if="critique.validate == true" type="radio" :id="critique.id" :value="critique.description" v-model="picked" checked/>
            <input class="form-check-input" style="margin-left: 2%" v-else type="radio" :id="critique.id" :value="critique.id" v-model="picked"/>
            {{ critique.title }}
            <div>
              <label :for="critique.description" style="margin: 6% 2% 2% 7%">{{ critique.description}}</label>
            </div>
        </div>
        <button class="buttonAdd w-10 m-auto mb-2" @click="toValidate(picked)">Enregistrer</button>
      </div>
    </div>
    </div>
  </div>
</template>


<style lang="css">
.price__btn {
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
	height: 30px;
	width: 100%;
	border-radius: 6px;
	background-color: transparent;
	font-size: 12px;
	color: #fff;
	text-transform: uppercase;
	border: 2px solid #f9ab00;
  margin: auto;
  padding: auto;
}

</style>