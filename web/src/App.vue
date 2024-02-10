<script>
import {computed, reactive, watch} from 'vue';
import {useRoute, RouterView, RouterLink} from 'vue-router';
import PlayGeoQuizz from "@/components/playGeoQuizz.vue";
import Cookies from "js-cookie";
import Connexion from "@/views/ConnexionView.vue";

export default {
  Connexion,
  components: {PlayGeoQuizz},
  data() {
    return {
      isHomeRoute: true,
      isConnected: false,
    }
  },


  /**
   * Vérifie si la route actuelle est la page d'accueil ou non
   * @returns {{isHomeRoute: ComputedRef<boolean>}} - true si la route actuelle est la page d'accueil, false sinon
   */
  setup() {
    const route = useRoute();
    const isHomeRoute = computed(() => route.path === '/');

    const state = reactive({
      isConnected: false,
    });

    /**
     * Vérifie si l'utilisateur est connecté ou non
     * @returns {void} - return true si connecté et false sinon
     */
    const checkAuthStatus = () => {
      const token = Cookies.get('accessToken');
      // Si le token existe, l'utilisateur est connecté, sinon il ne l'est pas
      if (token !== undefined) {
        console.log("connexion true 2")
        state.isConnected = true;
      } else {
        console.log("connexion false 2")
        state.isConnected = false;
      }
    };


    const logout = () => {
      Cookies.remove('accessToken');
      console.log("connexion false 2")
      state.isConnected = false;
      //rajouter user.pseudo = '' pour le déconnecter

    };

    // Watcher pour détecter les changements de isConnected
    watch(() => state.isConnected, (newValue, oldValue) => {
      console.log('Changement de statut de connexion:', newValue);
      // Mettre à jour l'affichage du header ou d'autres composants en fonction du nouvel état de connexion
    });

    // Vérifier l'état d'authentification lors du chargement initial du composant
    checkAuthStatus();

    return {isHomeRoute, state, checkAuthStatus, logout};
  },

};
</script>

<template>
  <header class="bg-zinc-900">
    <div class="header flex flex-wrap p-1 m-2 lg:flex-row lg:justify-between max-lg:flex-col max-lg:items-center">
      <div class="headerLogoText flex flex-row flex-wrap max-lg:mb-8 max-lg:mr-20">
        <!-- Logo à gauche -->

        <router-link to="/" class="logo">
          <img class="w-28" src="@/components/icons/globe.png" alt="logo">
        </router-link>

        <!-- Textes à gauche -->
        <div class="flex-col ml-4 w-20">
          <div>
            <h1 class="text-7xl font-extrabold drop-shadow-[0_8px_4px_rgba(34,0,4,6)] text-blue-500">
              Geo
            </h1>
          </div>
          <div>
            <h1 class="text-5xl font-extrabold text-gray-400">
              Quizz
            </h1>
          </div>
        </div>
      </div>
      <div class="flex flex-row items-center">
        <div
            class="max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">
          <RouterLink to="/">
            <button class="h-full w-full ">Home</button>
          </RouterLink>
        </div>
        <div
            class=" max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">
          <RouterLink to="/gamemode">
            <button class="h-full w-full">Jouer</button>
          </RouterLink>
        </div>

        <div class="notConnected flex flex-row items-center sm:flex-row">
          <!-- Boutons de connexion et inscription -->
          <div v-if="!state.isConnected">
            <RouterLink to="/inscription">
              <button class="max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">Inscription</button>
            </RouterLink>
            <RouterLink to="/connexion">
              <button class="max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">Connexion</button>
              <Connexion :is-connected="state.isConnected" />
              <Connexion :is-connected="state.isConnected" @login-success="handleLoginSuccess" />
            </RouterLink>
          </div>

          <!-- Bouton de déconnexion -->
          <div v-else class="connected flex flex-row items-center">
            <button class="max-sm:text-sm sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105" @click="logout">Déconnexion</button>
            <RouterLink to="/monCompte">
              <img class="max-sm:h-10 max-sm:mr-1.5 max-sm:w-10 h-12 w-12 min-w-10 hover:transition duration-300 ease-in-out transform hover:scale-110" src="@/components/icons/user.png" alt="logoUser">
            </RouterLink>

          </div>
        </div>
        <div class="connected flex flex-row items-center">
        </div>
      </div>
    </div>
  </header>

  <playGeoQuizz v-if="isHomeRoute"/>
  <div class="flex justify-center items-center mb-2" v-if="isHomeRoute">
    <!-- Bouton à droite -->
    <RouterLink to="/selectgame">
      <button class="text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105 mb-14 ">
        Choisir le Quiz !
      </button>
    </RouterLink>
  </div>
  <RouterView/>

  <footer class="bg-zinc-900 text-zinc-500 text-center p-4 flex flex-row justify-between frelative bottom-0 w-full">
    <p>GeoQuizz - 2024</p>
    <p>Copyright IUT-Charlemagne</p>
  </footer>
</template>
