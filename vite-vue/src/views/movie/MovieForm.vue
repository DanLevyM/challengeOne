<script>
import { ref, onBeforeMount, reactive} from 'vue';
import { useRoute } from 'vue-router';
import modal from "../../components/Modal.vue"


const API_URL = import.meta.env.VITE_API_URL;
export default {
    components: {
      modal
    },
    setup () {

        const movies = ref({});
        const showModals = ref(false);

        async function editMovie(id, name, price) {
          const formData = {}
          formData.id = id
          formData.name = name;
          formData.price = price;
          console.log(formData)
          const response = await fetch(`${API_URL}/movies/${id}`, {
            method: 'PATCH',
            headers: {
              'Content-type': 'application/merge-patch+json' 
            },
            body: JSON.stringify(formData)
          });
          console.log(response.json())
          return await response.json();
        }

        async function createNewMovie(title, director, release_date, description, imgFile, duration) {
          const formData = {}
          formData.title = title;
          formData.director = director;
          formData.release_date = release_date;
          formData.description = description;
          formData.imgFile = imgFile;
          formData.duration = duration;

          const response = await fetch(`${API_URL}/movies`, {
            method: 'POST',
            headers: {
              'Content-type': 'application/json; charset=UTF-8' 
            },
            body: JSON.stringify(formData)
          });
          return await response.json();
        }
        
        function deleteMovie(id){
          fetch(`${API_URL}/movies/` + id, {
            method: 'DELETE',
          })
       
        }

        onBeforeMount(async () => {
            try {
                const res_movies = await fetch(`${API_URL}/movies`);
                const data_movies = await res_movies.json();
                movies.value = data_movies;
                movies.value = movies["value"]["hydra:member"];
            } catch (error) {
                console.log(error);
            }
        
        });
        
      
        return {
            movies,
            deleteMovie,
            createNewMovie,
            showModals,
            editMovie
        }
    }      
         

};

</script>


<template>
  <div class="bodyclass">
    <table class="mainTable">
      <thead>
        <tr>
          <th scope="col"><div class="thText">ID</div></th>
          <th scope="col"><div class="thText">NAME</div></th>
          <th scope="col"><div class="thText">PRICE</div></th>
          <th scope="col"><div class="thText">ACTION</div></th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr v-for="product in products" :key="product.id">
          <td><div class="tableText">{{ product.id }}</div></td>
          <td><div class="tableText">{{ product.name }}</div></td>
          <td><div class="tableText">{{ product.price }}</div></td>
          <td><div class="tableText"><button class="buttonAction delete"><i class="bi bi-trash text-danger" @click.prevent="deleteProduct(product.id)"></i></button>
              <button class="buttonAction edit"><i class="bi bi-pencil-square text-warning" @click="showModals = product.id"></i></button></div></td>
              <modal v-show="showModals == product.id" @close="showModals = false">
                <template v-slot:header>
                  <h6 class="modalTitle">{{product.id}}</h6>
                </template>
                <template v-slot:body>
                  <form @submit.prevent="editProduct(product.id, editName, editPrice)">
                    <div class="form-group">
                      <label for="Nom">Nom</label> 
                      <input type="text" class="formInput" v-model="editName" :placeholder="product.name">
                    </div>
                    <div class="form-group">
                      <label>Prix</label> 
                      <input type="number" class="formInput" v-model="editPrice" :placeholder="product.price">
                    </div>
                    <div class="containerFlex">
                      <button id="save">Enregistrer</button>
                      <button id="dismiss" @click.prevent="showModals = false">Annuler</button>
                    </div>
                  </form>
                </template>
                <template v-slot:footer>
                  <p></p>
                </template>
              </modal>
        </tr> -->
        <tr>
          <td>
            <form @submit.prevent="createNewMovie(title, director, release_date, description, imgFile, duration)">
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="text" v-model="title" placeholder="title">
              </span>
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="text" v-model="director" placeholder="director">
              </span>
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="date" v-model="release_date" placeholder="release_date">
              </span>
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="text" v-model="description" placeholder="description">
              </span>
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="date" v-model="duration" placeholder="duration">
              </span>
              <span class="col-12 col-sm-6 col-lg-3">
                <input class="formInput" type="file" v-on="imgFile" placeholder="Image">
              </span>
              <button class="buttonAdd">AJOUTER</button>    
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    
  </div>
</template>


<style lang="css">

</style>