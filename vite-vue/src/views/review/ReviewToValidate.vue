<script>
import { ref, reactive, onBeforeMount} from 'vue';
import { useUserStore } from "../../stores/UserStore";


const API_URL = import.meta.env.VITE_API_URL;
export default {
    components: {
    }, 
    setup () {
        const userData = localStorage.getItem('access_token');

        const datas = reactive([]);
        const reviews = ref({});
        const reviews_array = reactive([]);
        const admins = ref({});
        let id_connected;
        const data_reviews_logged_value = ref({});
        
        async function toValidate(id) {
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
          for (let i=0; i<datas.length; i++){
            if (datas[i].id === id){
                datas.splice(i, 1);
            }
          }
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
        
        });
        
      
        return {
            reviews,
            datas,
            admins,
            reviews_array,
            toValidate
        }
    }      
         

};

</script>


<template>
  <div class="bodyclass">
    <table class="mainTable">
      <thead>
        <tr class="fit">
          <th scope="col"><div class="thText">TITRE</div></th>
          <th scope="col"><div class="thText">DESCRIPTION</div></th>
          <th scope="col"><div class="thText">AUTEUR</div></th>
          <th scope="col"><div class="thText">FILM</div></th>
          <th scope="col"><div class="thText">ACTION</div></th>
          <th scope="col"><div class="thText">FILM ID</div></th>
        </tr>
      </thead>
      <tbody class="w-auto">
        <tr v-for="review of datas" :key="review.id" class="fit">
          <td><div class="tableText">{{ review.title }}</div></td>
          <td><div class="tableText">{{ review.description }}</div></td>
          <td><div class="tableText">{{ review.userAdmin }}</div></td>
          <td><div class="tableText">{{ review.movie }}</div></td>
          <td><div class="tableText">{{ review }}</div></td>
          <td>
            <div class="tableText"><button class="price__btn" @click="toValidate(review.id)">Valider</button></div>
          </td>
        </tr>
      </tbody>
    </table>
    
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