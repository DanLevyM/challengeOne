<script>
import { ref, onBeforeMount } from 'vue';


    const API_URL = import.meta.env.VITE_API_URL;
    export default {
        components: {
        },
        setup () {
            const products = ref({});
            onBeforeMount(async () => {
                try {
                    const res_products = await fetch(`${API_URL}/products`);
                    const data_products = await res_products.json();
                    products.value = data_products;
                    products.value = products["value"]["hydra:member"];
                } catch (error) {
                    console.log(error);
                }
            
            });
            
            return {
                products
            }
        }                
        
        
    
    };
</script>


<template>


  <div>
    <section style="background-color: #eee;">
      <div class="container py-5">
        <div class="row">
          <div class="col-md-12 col-lg-4 mb-4 mb-lg-4" v-for="product in products" >
            <div class="card">
              <img src="../../assets/img/default.png" 
                class="card-img-top" alt="default" />
              <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                  <h5 class="mb-0">{{ product.name }}</h5>
                  <h5 class="text-dark mb-0"> {{ product.price }} &euro;</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>


<style lang="css">
  section {
    margin-bottom: 2em;
  }

  .buttonAction {
    background: none;
    border: none;
    padding: 0;
    cursor: cursor;
    outline: none;
    margin-right: 2em;
  }
 
  .buttonAdd {
    color: #fff;
    border-radius: 5px;
    font-family: 'Lato', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    display: inline-block;
    box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
    7px 7px 20px 0px rgba(0,0,0,.1),
    4px 4px 5px 0px rgba(0,0,0,.1);
    outline: none;
    background: linear-gradient(0deg, rgba(255,151,0,1) 0%, rgba(251,75,2,1) 100%);
    width: 130px;
    height: 40px;
    line-height: 42px;
    padding: 0;
    border: none;
    text-align: center;
  }
</style>