<script>
import 'leaflet/dist/leaflet.css';
import {LMap, LTileLayer, LMarker} from '@vue-leaflet/vue-leaflet';
import {getDistance} from "geolib";

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
  },
  data() {
    return {
      image: "",
      timerCount: 60,
      timerEnable: true,
      validate: false,
      osmURL: 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      center: [48.69, 6.18],
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
      numeroTour: 1,
      donneesSent: false,


      //id_série récupérer grâce à l'url
      idSerie: this.getIdSerie(),



      //Jeu de données de test en attendant de récupérer les données de l'API
      serie_id: 28,
      imageTest: "https://www.francebleu.fr/s3/cruiser-production/2021/09/b2c29454-b2be-4658-abb5-5e7695597631/1200x680_1000x563_photo_une_pool_demange_marchi_gettyimages-124066777.jpg",
      //Lieu à deviner
      LieuReponse: "Place Stanislas, Nancy, France",
      //marker de la réponse
      reponseMarker: [48.693522435993316, 6.183261126061553]
    }
  },
  watch: {

    timerEnable(value) {
      if (value) {
        setTimeout(() => {
          this.timerCount--;
        }, 1000);
      }
    },

    timerCount: {
      handler(value) {
        if (value > 0 && this.timerEnable) {
          setTimeout(() => {
            this.timerCount--;
          }, 1000);
        } else if (value === 0) {
          this.valider();
        }

      },
      immediate: true
    }

  },
  methods: {


      /**
       * Méthode qui permet de récupérer l'id de la série dans l'url
       * @returns {string} - l'id de la série ou "aleatoire" si serie choisie aléatoirement
       */
      getIdSerie() {
        let url = window.location.href;
        let id = url.substring(url.lastIndexOf('/') + 1);
        console.log(id);
        return id;
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
        this.donneesScores = {
          serie_id: this.serie_id,
          temps: 60 - this.timerCount,
          distance: this.distance,
          tours: this.numeroTour
        };
        this.envoyerScores();
      },

    /**
     * Méthode qui permet d'envoyer les données de scores à l'API au format JSON
     * @returns {void}
     */
    envoyerScores() {
      fetch('routeApiIci', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.donneesScores)
      })
          .then(response => response.json())
          .then(data => {
          })
          .catch((error) => {
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
      this.timerCount = 60;
      this.timerEnable = true;
      this.validate = false;
      this.userMarkerCoords = null;
      this.userFinalGuess = null;
      this.distance = null;
      this.numeroTour++;
      //Remet la carte dans la config intiale
      //valeurs temporaires
      this.center = [48.69, 6.18];
      this.donneesSent = false;


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
  }
}

</script>

<template>
  <section
      class="h-screen w-screen flex justify-center items-center bg-gradient-to-br from-blue-800 via-gray-700 to-lime-900 ">
    <div class="flex flex-wrap">
      <div class="w-full h-full md:w-3/5 border border-gray-400 rounded-lg flex flex-col justify-between mb-2">
        <img :src="imageTest" alt="imageTest">
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
          <div class="bg-blue-600 text-white rounded-b-lg py-4 ">
            <label class="m-8 text-xl w-1/2 font-mono ">Temps Restant : <span class="font-semibold">{{
                timerCount
              }}</span></label>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full "
                    @click="valider" v-if="!validate">Valider
            </button>
            <label class="m-8  text-xl font-semibold py-2 " v-if="validate && !donneesSent">Chargement</label>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full "
                    @click="nextStep" v-if="donneesSent">Suivant
            </button>
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