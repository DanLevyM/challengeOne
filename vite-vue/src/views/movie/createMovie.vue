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

     
        async function createNewMovie(title, director, description, duration, releaseDate, img) {
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

          if(img = "") {
            img = "https://www.cinehorizons.net/sites/default/files/default_images/affiches/default-movie.png";
          }
            
          const formData = {};
          formData.title = title;
          formData.description = description;
          formData.director = director;
          formData.img = img;
          formData.duration = duration;
          formData.releaseDate = releaseDate;
          formData.userAdmin = "/users/"+id_connected;
          formData.userAdminCheck = "/users/"+verif;
          formData.movie_id = movieId;
          formData.validate = false;
          const response = await fetch(`${API_URL}/movies`, {
            method: 'POST',
            headers: {
              'Content-type': 'application/json; charset=UTF-8' 
            },
            body: JSON.stringify(formData)
          });
         console.log(response.json);
          return await response.json();
        }


        return {
            reviews,
            data,
            createNewMovie,
            users,
            administrator,
            movies,
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