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

        const products = reactive([]);
        const showModals = ref(false);

        async function editProduct(id, name, price) {
          const formData = {}
          formData.id = id
          formData.name = name;
          formData.price = price;
          console.log(formData)
          const response = await fetch(`${API_URL}/products/${id}`, {
            method: 'PATCH',
            headers: {
              'Content-type': 'application/merge-patch+json' 
            },
            body: JSON.stringify(formData)
          });
          showModals.value = false;
        }

        async function createNewProduct(name, price) {
          if (name == "" || price == "") {
                alert("Veuillez remplir tous les champs");
                return;
            }
          const formData = {}
          formData.name = name;
          formData.price = price;
          console.log(typeof(formData))
          console.log(JSON.stringify({formData}))
          try {
              await fetch(`${API_URL}/products`, {
              method: 'POST',
              headers: {
                'Content-type': 'application/json; charset=UTF-8' 
              },
              body: JSON.stringify(formData)
            });
          
              const res_products = await fetch(`${API_URL}/products`);
              const data_products = await res_products.json();
              products.value = data_products;
            
              products.value = data_products["hydra:member"];
           
              products.push(data_products["hydra:member"].slice(-1)[0]);
            
          }  catch (error) {
                console.error(error);
          }
          
        }
        
        async function deleteProduct(id){
          try {
          await fetch(`${API_URL}/products/` + id, {
            method: 'DELETE',
          });
          console.log("delete fait")
          const res_products = await fetch(`${API_URL}/products`);
              const data_products = await res_products.json();
              products.value = data_products;
              console.log("dataproducts")
              console.log(data_products)
              products.value = data_products["hydra:member"];
              console.log("products")
              for (let i=0; i<products.length; i++){
                console.log("hello here")
                console.log(products[i])
                console.log(products[i].id)
                if (products[i].id === id){
                  products.splice(i, 1);
                }
              }
              console.log("products2")
              console.log(products)
       
        } catch (error) {
            console.error(error);
        }
      }

        onBeforeMount(async () => {
            try {
                const res_products = await fetch(`${API_URL}/products`);
                const data_products = await res_products.json();
                products.value = data_products;
                console.log(data_products)
                products.value = data_products["hydra:member"];
                console.log(products)
                for (let product of data_products["hydra:member"]){
                  products.push(product)
                }
            } catch (error) {
                console.log(error);
            }
        
        });
        
      
        return {
            products,
            deleteProduct,
            createNewProduct,
            showModals,
            editProduct
        }
    }      
         

};

</script>


<template>

    <table class="table table-dark col-md-12 col-lg-4 mb-4 mb-lg-4">
      <thead>
        <tr>
          <th scope="col"><div class="thText">LIBELLE</div></th>
          <th scope="col"><div class="thText">PRIX</div></th>
          <th scope="col"><div class="thText">ACTION</div></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td><div >{{ product.name }}</div></td>
          <td><div class="tableText">{{ product.price }}</div></td>
          <td><div class="tableText"><button class="buttonAction delete"><i class="bi bi-trash text-danger" @click.prevent="deleteProduct(product.id)"></i></button>
              <button class="buttonAction edit"><i class="bi bi-pencil-square text-warning" @click="showModals = product.id"></i></button></div></td>
              <modal v-show="showModals == product.id" @close="showModals = false">
                <template v-slot:header>
                  <h6 class="modalTitle">{{product.id}}</h6>
                </template>
                <template v-slot:body>
                  <form @submit.prevent="editProduct(product.id, product.name, product.price)">
                    <div class="form-group">
                      <label class="formLabel" for="Nom">Nom</label> 
                      <input type="text" class="formInput" v-model="product.name">
                    </div>
                    <div class="form-group">
                      <label class="formLabel">Prix</label> 
                      <input type="number" class="formInput" v-model="product.price" >
                    </div>
                    <div class="containerFlex">
                      <button type="submit" id="save">Enregistrer</button>
                      <button id="dismiss" @click.prevent="showModals = false">Annuler</button>
                    </div>
                  </form>
                </template>
                <template v-slot:footer>
                  <p></p>
                </template>
              </modal>
        </tr>
      </tbody>
    </table>
    <form @submit.prevent="createNewProduct(name, price)">
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="text" v-model="name" placeholder="Libelle">
      </span>
      <span class="col-12 col-sm-6 col-lg-3">
        <input class="formInput" type="number" v-model="price" placeholder="Prix">
      </span>
      <button class="buttonAdd">AJOUTER</button>    
    </form>

</template>


<style lang="css">
.formLabel {
  color: white;
}
</style>