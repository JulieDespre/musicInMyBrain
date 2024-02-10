<script>
import {SERIES, SERIES_IMAGE} from "@/apiLiens.js";

export default {
  name: 'SelectGameMenu',
  data() {
    return {
      initialisation: this.init(),
      series: [],
      difficulteSerie: [],
      difficulteRandom: "medium",
      imageUrl: "",
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
                  img: this.returnImgSrc(serie.photo),
                });
                this.difficulteSerie.push({
                  id: serie.id,
                  difficulty: "medium",
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
     * methode qui permet de retourner l'url de l'image à partir de son ID
     * @param idImg
     * @returns string - url de l'image
     */
    returnImgSrc(idImg) {
      try {
        console.log(SERIES + idImg);
        return SERIES_IMAGE + idImg;

      } catch (e) {

      }
    },

    /**
     * Méthode qui initialise le composant
     * @return {boolean}
     */
    init() {
      this.fetchSeries();
      return true;
    },

    /**
     * Méthode qui permet de récupérer un choix aléatoire
     * @returns {number}
     */
    aleatoire() {
      return (Math.floor(Math.random() * this.series.length)) + 1;
    },

  }

}

</script>

<template>
  <section class="h-full w-full min-h-screen">
    <h2 class="my-8 text-center text-blue-500 text-3xl font-bold">Commencer une partie</h2>
    <div v-if="this.series.length > 0 " class="flex flex-wrap justify-center">
      <!-- Carte "Random" pour avoir un choix aléatoire -->
      <div class="max-w-xs mx-4 mb-4 w-[350px]">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          <div class="bg-gray-300 flex justify-center items-center">
            <img class=" h-48 object-cover object-center" src="@/components/icons/Aleatoire.png"
                 alt="Image de la série">
          </div>
          <div class="p-4 flex flex-row justify-between items-center">
            <div>
              <h3 class="text-gray-900 font-semibold text-lg">Aléatoire</h3>
              <router-link :to="/play/ + this.difficulteRandom + '/' + this.aleatoire()">
                <button
                    class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                  Choisir
                </button>
              </router-link>
            </div>
            <select
                class="h-12 w-28 bg-gray-200 border-2 border-gray-700 text-gray-700 font-bold align-middle text-center"
                v-model="difficulteRandom" name="difficulty">
              <option value="easy" class="bg-green-500 text-white text-bold">Facile</option>
              <option value="medium" class="bg-orange-500 text-white text-bold align-middle">Médium</option>
              <option value="hard" class="bg-red-500 text-white text-bold">Difficile</option>
            </select>

          </div>
        </div>
      </div>

      <!-- Cartes pour chaque jeu -->
      <div v-for="(item, index) in series" :key="item.id" class="max-w-xs mx-4 mb-4 w-[350px]" v-if="index % 5 !== 0">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          <img class="w-full h-48 object-cover object-center" :src="item.img"
               alt="Image de la série">
          <div class="p-4 flex flex-row justify-between items-center">
            <div>
              <h3 class="text-gray-900 font-semibold text-lg">{{ item.nom }}</h3>
              <router-link :to="/play/ + this.difficulteSerie[index].difficulty + '/' + item.id">
                <button
                    class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                  Choisir
                </button>
              </router-link>
            </div>
            <select
                class="h-12 w-28 bg-gray-200 border-2 border-gray-700 text-gray-700 font-bold align-middle text-center"
                v-model="difficulteSerie[index].difficulty" name="difficulty">
              <option value="easy" class="bg-green-500 text-white text-bold">Facile</option>
              <option value="medium" class="bg-orange-500 text-white text-bold align-middle">Médium</option>
              <option value="hard" class="bg-red-500 text-white text-bold">Difficile</option>
            </select>
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