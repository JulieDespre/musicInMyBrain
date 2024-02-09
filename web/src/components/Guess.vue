<script>
import 'leaflet/dist/leaflet.css';
import {LMap, LTileLayer, LMarker} from '@vue-leaflet/vue-leaflet';
import {getDistance} from "geolib";
import Cookies from "js-cookie";
import {CREATE_GAME, RECREATE_GAME, SCORE_PLAY} from "@/apiLiens.js";
import {VueSpinner} from 'vue3-spinners';

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    VueSpinner
  },
  data() {
    return {
      timerCount: 60,
      timerEnable: false,
      validate: false,
      osmURL: 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      center: null,
      //centre de la carte initial
      initCenter: null,
      //niveau de zoom initial
      zoom: 13,
      //niveau de zoom maximal et minimal
      maxZoom: 18,
      minZoom: 1,

      //coordonnées du marqueur placé par l'utilisateur
      userMarkerCoords: null,
      //coordonnées du Guess final
      userFinalGuess: null,
      //distance entre le marqueur de l'utilisateur et le marqueur de la réponse
      distance: null,

      //message en fonction de la distance
      distanceMessage: "",

      //objet pour le calcul des scores
      donneesScores: null,
      numeroTour: 0,
      donneesSent: false,


      serie_id: null,
      difficulty: null,
      replayGame_id: null,
      //serie_id récupérer grâce à l'url


      game_id: null,
      token: null,
      localisations: [],
      initialisation: this.init(),
      reponseMarker: null,
      LieuReponse: null,
      image: "",
      nomSeries: null,

      //booléen pour afficher la fin de la partie
      finDePartie: false,

    }
  },


  methods: {
    /**
     * Méthode qui permet d'initialiser le jeu
     * @returns {boolean} - true si l'initialisation s'est bien passée, false sinon
     */
    init() {
      this.initialisation = false;
      this.fetchGame();
    },

    /**
     * Méthode qui permet gérer l'url afin de donner les bonnes valeures aux variables
     */
    getValuUrl() {
      let url = window.location.href;
      let indexPlay = url.indexOf("/play");
      if (indexPlay !== -1) {
        let subUrl = url.substring(indexPlay);
        let count = subUrl.split("/").length - 1;
        if (count === 3) {
          this.getIdSerie();
          this.getDifficulty();
        } else if (count === 2) {
          this.replayGame_id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        } else {
         //redirection vers l'acc car
          this.$router.push('/');
        }

      } else {
        //redirection vers l'acc
        this.$router.push('/');


      }

    },


    /**
     * Méthode qui permet de récupérer l'id de la série dans l'url
     *
     */
    getIdSerie() {
      let url = window.location.href;
      let id = url.substring(url.lastIndexOf('/') + 1);
      this.serie_id = parseInt(id);
    },

    /**
     * Méthode qui permet de récupérer la difficulté de la série dans l'url
     *
     */
    getDifficulty() {
      let url = window.location.href;
      let segments = url.split('/'); // Divise l'URL en segments en utilisant '/'
      let diff = segments[segments.length - 2]; // La difficulté est l'avant-dernier segment de l'URL
      this.difficulty = diff;
      if (this.difficulty === "easy") {
        this.difficulty = 1;
      } else if (this.difficulty === "medium") {
        this.difficulty = 2;
      } else if (this.difficulty === "hard") {
        this.difficulty = 3;
      }
    },

    /**
     * Méthode qui permet de fetch l'api afin d'avoir le jeu de données nécessaire pour le jeu
     */
    fetchGame() {
      this.getValuUrl();
      let url = null;
      let bodyRequest = null;
      if (this.replayGame_id === null || this.replayGame_id === undefined) {
        url = CREATE_GAME;
        bodyRequest = JSON.stringify({
          "serie_id": this.serie_id,
          "difficulte": this.difficulty
        });
      } else {
        url = RECREATE_GAME + this.replayGame_id
        bodyRequest = JSON.stringify({});
      }

      if (this.checkAuthStatus()) {
        //FETCH API : POST avec un bearer token (this.token) et "serie_id" (this.serie_id) dans le body
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + Cookies.get('accessToken')
          },
          body: bodyRequest
        })
            .then(response => response.json())
            .then(data => {
              this.game_id = data.game_id;
              this.localisations = data.localisations;
              this.initCenter = [data.startmap[1], data.startmap[0]];
              this.center = this.initCenter;
              this.reponseMarker = [this.localisations[0].coordinate[1], this.localisations[0].coordinate[0]];
              this.LieuReponse = this.localisations[0].nom;
              this.image = this.localisations[0].url;
              this.initialisation = true;
              this.timerEnable = true;
              this.nomSeries = data.serie_nom;


            })
            .catch((error) => {
              //si erreur lors de la récupération des données de jeu redirige vers la page de jeu
              this.$router.push('/selectgame');
            });
      }
    },

    /**
     * Méthode qui permet de récupérer le cookie de l'utilisateur connecté et de renvoyer sur une page de connexion si
     * l'utilisateur n'est pas connecté / token expiré
     * @returns {boolean} - true si l'utilisateur est connecté, false sinon
     */
    checkAuthStatus() {
      const token = Cookies.get('accessToken');
      if (token === undefined || token === null) {
        this.$router.push('/connexion');
        return false;
      } else {
        this.token = token
        return true;
      }
    },


    /**
     * Méthode qui stop le chronomètre et permet de valider la position choisie par l'utilisateur
     * @returns {void}
     */
    valider() {
      this.timerEnable = false;
      this.validate = true;
      this.userFinalGuess = this.userMarkerCoords;
      this.calculerDistance();
      this.replaceMapView();
      this.donneesScores = {
        "game_id": this.game_id,
        "distance": this.distance,
        "temps": 60 - this.timerCount,
      };
      this.envoyerScores();
    },

    /**
     * Méthode qui permet d'envoyer les données de scores à l'API au format JSON
     * @returns {void}
     */
    envoyerScores() {

      fetch(SCORE_PLAY, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + Cookies.get('accessToken')
        },
        body: JSON.stringify({
              "game_id": this.donneesScores.game_id,
              "distance": this.donneesScores.distance,
              "temps": this.donneesScores.temps
            }
        )
      })
          .then(response => response.json())
          .then(data => {
          })
          .catch((error) => {
            //A modif peut etre plus tard
            console.error('Error:', error);
          })
          .finally(() => this.donneesSent = true);

    },


    /**
     * Méthode qui permet de calculer la distance en metre entre le point de l'utilisateur et le point de la réponse
     * avec la librairie geolib
     *
     */
    calculerDistance() {
      if (this.userFinalGuess !== null) {
        this.distance = getDistance(
            {latitude: this.userFinalGuess[0], longitude: this.userFinalGuess[1]},
            {latitude: this.reponseMarker[0], longitude: this.reponseMarker[1]}
        );
        this.distanceMessage = this.distance + " m";
      } else {
        this.distanceMessage = "Vous n'avez pas pointé de lieu sur la carte";
        this.distance = -1;
      }
    },

    /**
     * Méthode qui permet de passer à l'étape suivante
     * @returns {void}
     */
    nextStep() {
      if (this.numeroTour < this.localisations.length - 1) {
        this.timerCount = 60;
        this.timerEnable = true;
        this.validate = false;
        this.userMarkerCoords = null;
        this.userFinalGuess = null;
        this.distance = null;

        //Remet la carte dans la config intiale
        this.center = this.initCenter;
        this.zoom = 13;
        this.donneesSent = false;
        //préparation des données pour la prochaine étape
        this.numeroTour++;
        this.reponseMarker = [this.localisations[this.numeroTour].coordinate[1], this.localisations[this.numeroTour].coordinate[0]];
        this.LieuReponse = this.localisations[this.numeroTour].nom;
        this.image = this.localisations[this.numeroTour].url;
      } else {
        this.finDePartie = true;
        //route vers la page de fin de partie
        this.$router.push('/endgame/' + this.game_id);
      }


    },

    /**
     * Methode qui permet de replacer la map.
     * @returns {void}
     */
    replaceMapView() {
      this.zoom = 13;
      this.center = this.initCenter;

    },


    /**
     * Méthode qui place le marqueur sur la carte à l'endroit où l'utilisateur a cliqué
     * @param event
     * @returns {void}
     */
    placeMarker(event) {
      if (this.validate) return;
      this.userMarkerCoords = [event.latlng.lat, event.latlng.lng];
    }
  },
  mounted() {
    setInterval(() => {
      if (this.timerEnable && this.timerCount > 0) {
        this.timerCount -= 1;
      }
      if (this.timerCount === 0 && this.validate === false) {
        this.timerEnable = false;
        this.valider();
      }
    }, 1000);
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


  <section v-else
           class="h-screen w-screen justify-center items-center bg-gradient-to-br from-blue-800 via-gray-700 to-lime-900 ">
    <div class="flex justify-center pt-3">
      <Label class="text-4xl font-bold font-mono text-gray-50">{{ nomSeries }} - TOUR NUMERO {{
          this.numeroTour
        }}. </Label>
    </div>

    <div
        class="h-screen w-screen flex justify-center items-center">
      <div class="flex flex-wrap  px-2">
        <div class="w-full h-full md:w-3/5 border border-gray-400 rounded-lg flex flex-col justify-between mb-2">
          <img class="rounded-lg" :src="image" alt="image du lieu">
          <div v-if="validate" class=" w-full rounded-b-lg h-max bg-blue-600 py-8 flex flex-col justify-center text-xl">
            <label class="text-white ml-2 ">
              Réponse : <label class="font-bold">{{ LieuReponse }}</label>
            </label>
            <label class="text-white ml-2 ">
              Distance : <label class="font-bold">{{ distanceMessage }}</label>
            </label>
          </div>
        </div>
        <div class="w-full md:w-2/5 flex justify-center items-center">
          <div class="w-full max-w-md">
            <div class="mapbox border border-gray-400 rounded-lg shadow-lg">
              <l-map
                  ref="map"
                  class="map"
                  v-model:zoom="zoom"
                  v-model:center="center"
                  :max-zoom="maxZoom"
                  :min-zoom="minZoom"
                  :zoom-control="false"
                  :use-global-leaflet="false"
                  @click="placeMarker($event)"
              >
                <l-tile-layer :url="osmURL"></l-tile-layer>

                <!--marqueur placé par l'utilisateur-->
                <l-marker v-if="userMarkerCoords" :lat-lng="userMarkerCoords"/>

                <!--marqueur de la réponse-->
                <l-marker v-if="validate" :lat-lng="reponseMarker"/>


              </l-map>
            </div>
            <div class="bg-blue-600 text-white rounded-b-lg py-4 relative">
              <label class="m-8 text-xl w-1/2 font-mono">Temps Restant : <span class="font-semibold">{{
                  timerCount
                }}</span></label>
              <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full"
                      @click="valider" v-if="!validate">Valider
              </button>
              <VueSpinner v-if="validate && !donneesSent" size="20" color="Black"
                          class="absolute top-1/2 right-0 transform translate-y-1/2 mr-4"/>
              <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full"
                      @click="nextStep" v-if="donneesSent">Suivant
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>


<style scoped>
.mapbox {
  position: relative;
  width: auto;
  height: calc(100vh / 2.5);
  min-width: 200px;
  min-height: 200px;

}

.map {
  position: absolute;
}
</style>