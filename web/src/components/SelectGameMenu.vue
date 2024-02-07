<script >
import {SERIES, SERIES_IMAGE} from "@/apiLiens.js";

export default {
  name: 'SelectGameMenu',
  data() {
    return {
      initialisation:  this.init(),

      series: [],
      chargement: false,
      erreur: false,


    }
  },
  methods: {
    /**
     * Méthode qui permet de récupérer les données des séries depuis l'API
     * @returns {void}
     */
    fetchSeries() {
      this.chargement = true;
      let seriesFetch = [];
      fetch(SERIES)
          .then(response => {
            if (!response.ok) {
              throw new Error('Erreur de chargement des données');
              this.erreur = true;
            }
            // Parse la réponse JSON
            return response.json();
          })
          .then(data => {
            // Vérifie si la clé "data" existe dans la réponse JSON
            if (data && data.data) {
              // Itère sur les données pour créer un objet pour chaque série
              data.data.forEach(serie => {
                seriesFetch.push({
                  id: serie.id,
                  nom: serie.nom,
                  img: "https://via.placeholder.com/350x200" // this.fetchImage(serie.photo)
                });
              });

            } else {
              throw new Error('Les données reçues ne sont pas au format attendu.');
            }
          })
          .catch(error => {
            console.error('Erreur lors du chargement des séries:', error);
            this.erreur = true;
          })
          .finally(() => {
            // Assigne les données récupérées à la variable series
            this.series = seriesFetch;
            this.chargement = false;
          });
    },

    /**
     * methode qui permet de fetch une image à partir de l'API à partir de l'id de l'image
     * @param idImg
     * @returns string - url de l'image
     */
    fetchImage(idImg) {
let url = "";
      fetch(SERIES_IMAGE + idImg)
          .then(response => {
            if (!response.ok) {
              throw new Error('Erreur de chargement des données');
            }
            // Parse la réponse JSON
            return response.json();
          })
          .then(data => {
            // Vérifie si la clé "data" existe dans la réponse JSON
            if (data && data.data) {
              // Itère sur les données pour créer un objet pour chaque série
              url = data.data.url;
            } else {
              throw new Error('Les données reçues ne sont pas au format attendu.');
            }
          })
          .catch(error => {
            console.error('Erreur lors du chargement des séries:', error);
          })
          .finally(() => {
            return url;
          });

    },



    /**
     * Méthode qui initialise le composant
     * @return {boolean}
     */
  init() {
    this.fetchSeries();
    return true;
  }
  }

}

</script>

<template>
  <section class="h-full w-full min-h-screen pt-6">
    <div v-if="this.series.length > 0 "  class="flex flex-wrap justify-center">
    <!-- Carte "Random" pour avoir un choix aléatoire -->
    <div  class="max-w-xs mx-4 mb-4">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <img class="w-full h-48 object-cover object-center" src="https://via.placeholder.com/350x200" alt="Image de la série">
        <div class="p-4">
          <h3 class="text-gray-900 font-semibold text-lg">Aléatoire</h3>
          <router-link to="/play/aleatoire">
          <button class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Choisir</button>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Cartes pour chaque jeu -->
    <div  v-for="(item, index) in series" :key="item.id" class="max-w-xs mx-4 mb-4" v-if="index % 5 !== 0">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <img class="w-full h-48 object-cover object-center" :src="item.img" alt="Image de la série">
        <div class="p-4">
          <h3 class="text-gray-900 font-semibold text-lg">{{ item.nom }}</h3>
          <router-link :to="/play/ + item.id" >
          <button class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Choisir</button>
          </router-link>
        </div>
      </div>
    </div>
    </div>

    <div v-if="!this.chargement && this.series.length === 0 && !this.erreur">
      <label class="">
        Aucune série n'est présente pour le moment !
      </label>
    </div>

    <div class="flex justify-center  px-4 py-20 w-full"
     v-if="!this.chargement && this.erreur">
      <label class=" text-red-500 font-bold text-2xl ">
        Erreur lors du chargement des données !
      </label>
    </div>

  </section>
</template>

<style scoped>

</style>