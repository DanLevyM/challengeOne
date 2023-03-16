<template>
  <div>
    <div class="carousel-container">
      <h2 class="h3 mr-2">À l'affiche au cinéma</h2>
      <div class="inner-carousel">
        <div class="track">

          <div class="card-container" v-for="movie in movies" :key="movie.id">
            <router-link :to="'/movie/' + movie.id">
              <div class="card card1"></div>
              <p class="card-title">{{ movie.title }}</p>
            </router-link>
          </div>

        </div>
        <div class="nav">
          <button class="prev"><font-awesome-icon icon="fa-solid fa-chevron-left" /></button>
          <button class="next"><font-awesome-icon icon="fa-solid fa-chevron-right" /></button>
        </div>
      </div>
    </div>

    <div class="carousel-container">
      <h2 class="h3 mr-2">Prochaines sorties au cinéma</h2>
      <div class="inner-carousel">
        <div class="track">

          <div class="card-container" v-for="movie in movies" :key="movie.id">
            <router-link :to="'/movie/' + movie.id">
              <div class="card card1"></div>
              <p class="card-title">{{ movie.title }}</p>
            </router-link>
          </div>

        </div>
        <div class="nav">
          <button class="prev"><font-awesome-icon icon="fa-solid fa-chevron-left" /></button>
          <button class="next"><font-awesome-icon icon="fa-solid fa-chevron-right" /></button>
        </div>
      </div>
    </div>
  </div>
</template>
    
<script>
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL
export default {
  setup() {
    const movies = ref({});
    onBeforeMount(async () => {
      const response = await axios.get(`${API_URL}/movies?page=1`);
      movies.value = await JSON.parse(JSON.stringify(response.data["hydra:member"]));

    });

    return {
      movies
    }
  },
  mounted() {

    const prev = document.querySelector(".prev");
    const next = document.querySelector(".next");
    const carousel = document.querySelector(".carousel-container");

    const track = document.querySelector(".track");
    let width = carousel.offsetWidth;
    let index = 0;
    window.addEventListener("resize", function () {
      width = carousel.offsetWidth;
    });
    next.addEventListener("click", function (e) {
      e.preventDefault();
      index = index + 1;
      prev.classList.add("show");
      track.style.transform = "translateX(" + index * -width + "px)";
      if (track.offsetWidth - index * width < index * width) {
        next.classList.add("hide");
      }
    });
    prev.addEventListener("click", function () {
      index = index - 1;
      next.classList.remove("hide");
      if (index === 0) {
        prev.classList.remove("show");
      }
      track.style.transform = "translateX(" + index * -width + "px)";
    })
  }

}


</script>
    
<style>
.carousel-container {
  width: 1250px;
  margin: 50px auto;
  position: relative;
}

@media (max-width: 768px) {
  .carousel-container {
    width: 95%;
  }
}

.inner-carousel {
  width: 100%;
  height: 400px;
  overflow: hidden;
}

.track {
  display: inline-flex;
  height: 100%;
  transition: transform 0.2s ease-in-out;
}

.card-container {
  width: 275px;
  height: 400px;
  flex-shrink: 0;
  padding-right: 10px;
}

.card-container:hover {
  transform: scale(1.01);
}


.card-container:hover p {
  color: white;
}

@media (max-width: 768px) {
  .card-container {
    width: 184px;
  }
}

.card {
  width: 100%;
  height: 90%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-position: center bottom;
  background-repeat: no-repeat;
  border-radius: 5px;
}

.card1 {
  background-image: url("https://cdn.pixabay.com/photo/2018/08/21/23/29/fog-3622519_960_720.jpg");
  transition: transform 0.5s ease;
}

.nav button {
  position: absolute;
  top: 50%;
  transform: translatey(-50%);
  width: 60px;
  height: 60px;
  border-radius: 50%;
  outline: none;
  border: 1px solid #000;
  cursor: pointer;
}

.nav .prev {
  left: 5px;
  display: none;
}

.nav .prev.show {
  display: block;
}

.nav .next {
  right: 5px;
}

.nav .next.hide {
  display: none;
}

.card-title {
  font-size: 14px;
  max-height: 36px;
  overflow: hidden;
  color: #70726e;
}
</style>