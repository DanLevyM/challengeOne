<script>
import { ref, reactive, onBeforeMount} from 'vue';


const API_URL = import.meta.env.VITE_API_URL;
export default {
    components: {
    },
    setup () {
      const userData = localStorage.getItem('access_token');
      console.log("here");
      console.log(userData);

// Vérification si les données existent dans le localStorage

    
        const data = reactive([]);
        const user = ref({});
        const reviews_urls = ref({});
        const reviews = ref({});
        const users = ref({});
     
        async function createNewReview(title, description, verif) {
          const formData = {};
          formData.title = title;
          formData.description = description;
          //TODO remplacer /users/1 par les données de l'user loggé
          formData.userId = "/users/1";
          formData.userVerif = "/users/"+verif;
          const response = await fetch(`${API_URL}/reviews`, {
            method: 'POST',
            headers: {
              'Content-type': 'application/json; charset=UTF-8' 
            },
            body: JSON.stringify(formData)
          });
         
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
                
                for (let element of reviews.value){
                  //TODO remplacer /users/1 par les données de l'user loggé
                  if(element.userId == "/users/1"){
                    data.push(element);
                  }
                }
                
                let i = 0;
                for (let userNames of data){
                  console.log(data[i].userVerif)
                  const res_userNames = await fetch(`${API_URL}${userNames["User_verif"]}`);
                  const data_userNames = await res_userNames.json();
                  let userName = data_userNames.firstname + " " + data_userNames.lastname; 
                  data[i].userVerif = userName;
                  i++;
                }
              
                /*const res_reviews = await fetch(`${API_URL}/reviews`);
                const data_reviews = await res_reviews.json();
                reviews.value = data_reviews;
                reviews.value = reviews["value"]["hydra:member"];
                for (let element of reviews.value){
                  if(element.userId == "/users/2"){
                    data.value = element
                    console.log(element);
                  }
                }
                console.log(data);*/
                //2 tests differents en bas est de base en com dans le push
                /*const res_user = await fetch(`${API_URL}/users/1`);
                    const data_user = await res_user.json();
                    console.log( data_user);
                    user.value = data_user;
                    reviews_urls.value = user.value.reviews;
                    
                    console.log(reviews_urls);
                    for (const review of reviews_urls.value) {
                        await fetch(`${API_URL}${review}`)
                            .then(response => response.json())
                            .then(data => {
                                reviews.push(data);
                        }) }*/
            } catch (error) {
                console.log(error);
            }
        
        });
        
      
        return {
            reviews,
            data,
            createNewReview,
            users  
        }
    }      
         

};

</script>


<template>
  <div class="bodyclass">
    <table class="mainTable">
      <thead>
        <tr class="fit">
          <th scope="col"><div class="thText">ID</div></th>
          <th scope="col"><div class="thText">TITRE</div></th>
          <th scope="col"><div class="thText">DESCRIPTION</div></th>
          <th scope="col"><div class="thText">VALIDATEUR</div></th>
        </tr>
      </thead>
      <tbody class="w-auto">
        <tr v-for="review in data" :key="review.id" class="fit">
          <td><div class="tableText">{{ review.id }}</div></td>
          <td><div class="tableText">{{ review.title }}</div></td>
          <td><div class="tableText">{{ review.description }}</div></td>
          <td><div class="tableText">{{ review.userVerif }}</div></td>
        </tr>
        <tr>
          <td>
            <form @submit.prevent="createNewReview(title, description, verif)">
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
                <option v-for="user in users" :value="user.id" :key="user.id">{{ user.firstname }} {{ user.lastname }}</option>
              </select>
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