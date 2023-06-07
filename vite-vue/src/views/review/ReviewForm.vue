<script>
import { ref, reactive, onBeforeMount, onMounted} from 'vue';


const API_URL = import.meta.env.VITE_API_URL;
export default {
    components: {
    },
    setup () {
      const userData = localStorage.getItem('access_token');

// Vérification si les données existent dans le localStorage

        const data = reactive([]);
        const user = ref({});
        const reviews_urls = ref({});
        const reviews = ref({});
        const reviews_array = reactive([]);
        const users = ref({});
        let id_connected;
        const administrator = reactive([]);
        const movies = reactive([]);

     
        async function createNewReview(title, description, verif, movieId) {
          let payload = (userData).split('.')[1];
          let tokenTest = window.atob(payload);
          const values = JSON.parse(tokenTest);
                
          //get the id of the logged user 
          const all_user = await fetch(`${API_URL}/users`);
          const data_allUser = await all_user.json();
                
          for (let element of data_allUser["hydra:member"]) {
            if(element.email === values.email) {
              id_connected = element.id;
            }
          }
            
          const formData = {};
          formData.title = title;
          formData.description = description;
          formData.userAdmin = "/users/"+id_connected;
          formData.userAdminCheck = "/users/"+verif;
          formData.movie_id = movieId;
          formData.validate = false;
          const response = await fetch(`${API_URL}/reviews`, {
            method: 'POST',
            headers: {
              'Content-type': 'application/json; charset=UTF-8' 
            },
            body: JSON.stringify(formData)
          });
         console.log(response.json);
          return await response.json();
        }
        
        onBeforeMount(async () => {
          console.log(localStorage.getItem("access_token"));
            try {
                //TODO faire en sorte que la liste des users soient seulement des admins
                const res_users = await fetch(`${API_URL}/users`);
                const data_users = await res_users.json();
                users.value = data_users;
                users.value = users["value"]["hydra:member"];
                const res_reviews = await fetch(`${API_URL}/reviews`);
                const data_reviews = await res_reviews.json();
                reviews.value = data_reviews;
                reviews.value = reviews["value"]["hydra:member"];
                

                let payload = (userData).split('.')[1];
                let tokenTest = window.atob(payload);
                const values = JSON.parse(tokenTest);
                //get the id of the logged user 
                const all_user = await fetch(`${API_URL}/users`);
                const data_allUser = await all_user.json();
                for (let element of data_allUser["hydra:member"]) {
                  if(element.email === values.email) {
                    id_connected = element.id;
                  }
                }
            
                //enlever le user connecté de la liste des admin 
                for (let admin of users.value) {
                  if (admin.roles.includes('ROLE_ADMIN')){
                    administrator.push(admin);
                  } 
                }
                administrator.splice(administrator.indexOf(id_connected), 1); 

                //afficher que les reviews que l'utilisateur loggé a créé
                for (let element of reviews.value){
                  if(element.userId == `/users/${id_connected}`){
                    data.push(element);
                  }
                }
                
                const res_user = await fetch(`${API_URL}/reviews?user_admin=/users/${id_connected}`);
                const data_user = await res_user.json();
                user.value = data_user;
               
                user.value = user["value"]["hydra:member"];
                 
                //reviews_urls.value = user.value.reviews;
                
                /*for (const review of reviews_urls.value) {
                  await fetch(`${API_URL}${review}`)
                  .then(response => response.json())
                  .then(data => {
                    reviews_array.push(data);
                    }) }*/
                  //afficher les reviews qu'il doit valider je crois 
                let i = 0;
                for (let userNames of user.value){
                   
                  const res_userNames = await fetch(`${API_URL}${userNames["User_verif"]}`);
                  const data_userNames = await res_userNames.json();
                        
                  let userName = data_userNames.firstname + " " + data_userNames.lastname; 
                  data[i].userVerif = userName;
                  i++;
                  }
                const res_movies = await fetch(`${API_URL}/movies`);
                const data_movies = await res_movies.json();
                movies.value = data_movies;
             
                        
                        movies.value = movies["value"]["hydra:member"];

                  
                        for(let i=0; i>movies.value.length; i++){
                          if(movies.value.review_id.length === 0){
                            //movies.value.slice(-1)[0];
                         
                          }
                        }
                        //TODO faire la verif des films dans la liste deroulantes qu'ils n'aient pas deja une review
            } catch (error) {
                console.log(error);
            }

           
        
        });


        return {
            reviews,
            data,
            createNewReview,
            users,
            administrator,
            reviews_array,
            movies,
            verif: '',
            movieId: ''
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
          <th scope="col"><div class="thText">VALIDATEUR</div></th>
        </tr>
      </thead>
      <tbody class="w-auto">
        <tr v-for="review of reviews_array" :key="review.id" class="fit">
          <td><div class="tableText">{{ review.title }}</div></td>
          <td><div class="tableText">{{ review.description }}</div></td>
          <td><div class="tableText">{{ review.user_admin_check }}</div></td>
        </tr>
      </tbody>
    </table>
    <form @submit.prevent="createNewReview(title, description, verif, movieId)">
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="title" placeholder="Titre">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="description" placeholder="Ecrire ici">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <label class="formInput" for="admins-select">Choisir le modérateur:</label>
      </span>
      <select v-model="verif">
        <option value="" disabled>--Choisir parmi la liste--</option>
        <option v-for="user in administrator" :value="user.id" :key="user.id">{{ user.firstname }} {{ user.lastname }}</option>
      </select>
      <span class="col-12 col-sm-6 col-lg-3">
        <label class="formInput" for="admins-select">Choisir le film:</label>
      </span>
      <select v-model="movieId">
        <option value="" disabled>--Choisir parmi la liste--</option>
        <option v-for="movie in movies" :value="movie.id" :key="movie.id">{{ movie.title }}</option>
      </select>
      <button class="buttonAdd">AJOUTER</button>    
    </form>
  </div>
</template>


<style lang="css">
form {
  padding: 30px;
  margin-bottom: 30px;
}
</style>