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
        const title = ref();
        const director = ref();
        const description = reactive([]);
        const duration = ref();
        const releaseDate = ref();
        const img = ref();
        let id_connected;
        const administrator = reactive([]);
        const movies = reactive([]);

     
        async function createNewMovie() {
          
          console.log("title:", this.title, this.description, this.director, this.title)
          const r = await fetch(`${API_URL}/movies`, {
            method: "POST",
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              
                title: this.title,
                director: this.director,
                description: this.description,
                duration: new Number(this.duration),
                releaseDate: this.releaseDate
            }
            )
          })

          console.log(r)
          return

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

          if(img = "" || img == null) {
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
            data,
            createNewMovie,
            administrator,
            movies,
            title,
            description,
            director,
            duration,
            releaseDate
        }
    }      
         
};

</script>

<template>
  <h1 class="title">Ajouter un film</h1>
  <div class="bodyclass">
    <table class="mainTable">
    </table>
    <form @submit.prevent="createNewMovie()">
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="title" placeholder="Titre">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="description" placeholder="Description">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="director" placeholder="Réalisateur">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="number" v-model="duration" placeholder="Durée du film">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="date" v-model="releaseDate" placeholder="Date de sortie">
      </span>
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