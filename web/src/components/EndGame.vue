<script>

import {GET_SCORES} from "@/apiLiens.js";
import Cookies from "js-cookie";
import {VueSpinner} from 'vue3-spinners';


export default {
  components: {
    VueSpinner
  },
  data() {
    return {
      score: null,
      nomSerie: null,
      idSerie: null,
      difficulty: null,
      idGame: null,
      nomUser: null,
      userEmail: null,
      //gestion erreur
      error: false,
      initialisation: this.init()


    }
  },
  methods: {

    /**
     * Methode qui fetch le score du joueur
     */
    fetchGetScore() {
      fetch(GET_SCORES + this.getGameId(), {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + Cookies.get('accessToken')
        },
      })
          .then(response => response.json())
          .then(data => {
            this.score = data.score;
            this.nomSerie = data.serie_nom;
            this.idSerie = data.serie_id;
            this.difficulty = data.difficulte;
            this.idGame = data.id;
            this.nomUser = data.user_username;
            this.userEmail = data.user_email;
          })
          .catch((error) => {
            this.error = true;
            console.error('Error:', error);
          })
          .finally(() => {
            this.initialisation = true;
          });

    },

    /**
     *Methode qui permet de récupérer l'id de la partie grace à l'url
     */
    getGameId() {
      let url = window.location.href;
      return url.substring(url.lastIndexOf('/') + 1);
    },

    /**
     * Methode qui permet d'initialiser la page
     */
    init() {
      this.initialisation = false;
      this.fetchGetScore();
    },
  },


}

</script>

<template>

  <section v-if="!this.initialisation"
           class="h-screen w-screen flex justify-center items-center bg-gradient-to-br from-blue-800 via-gray-700 to-lime-900 ">
    <div class="flex flex-col justify-center items-center ">
      <VueSpinner class="" size="100" color="Grey"/>
      <label class="text-4xl text-center font-bold text-white pt-3">Chargement de la partie</label>
    </div>

  </section>

  <section v-if="this.initialisation && !this.error" class=" h-screen py-8">

    <div class="border border-gray-400 rounded-lg mx-auto max-w-lg bg-gray-100 p-8">
      <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Fin de la partie</h1>
        <p class="text-xl">Joueur: {{ nomUser }}</p>
        <p class="text-xl">Score: {{ score }}</p>
        <p class="text-xl">Série: {{ nomSerie }}</p>
        <p class="text-xl">Difficulté: {{ difficulty }}</p>
      </div>
      <div class="mt-8 text-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="this.$router.push('/selectgame')">Rejouer
        </button>
      </div>
    </div>

  </section>

  <section v-if="this.error && this.initialisation" class="h-screen w-full py-8 flex flex-col items-center">
    <div
        class="h-3/4 w-1/2 min-w-80 border border-gray-400 rounded-lg mx-28 bg-gray-50 flex flex-col items-center justify-between">

      <h1 class="text-4xl font-bold text-center pt-8">Erreur lors de la récupération des données</h1>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-8"
              @click="this.$router.push('/')">Retour à l'accueil
      </button>

    </div>
  </section>


</template>

<style scoped>

</style>