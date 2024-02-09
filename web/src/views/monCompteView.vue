<script>
// Importez la bibliothèque js-cookie pour récupérer le token JWT du cookie
import Cookies from 'js-cookie';
import {VALIDATE_USER, HISTORY} from "@/apiLiens.js";

export default {
  data() {
    return {
      user: {
        pseudo: '', // Initialisez le pseudo de l'utilisateur à une chaîne vide
      },
      history: [],

      //nb partie jouées
      nbPartie: 0,
      //Les 3 meilleurs scores de l'utilisateur
      premierMeilleurScore: {
        serie_nom: '',
        score: 0,
        difficulte: 0,

      },
      secondMeilleurScore: {
        serie_nom: '',
        score: 0,
        difficulte: 0,
      },
      troisiemeMeilleurScore: {
        serie_nom: '',
        score: 0,
        difficulte: 0,
      },

      userNotConnected: false,
    };
  },
  created() {
    // Appel de la fonction pour récupérer les informations de l'utilisateur lors du chargement du composant
    this.fetchUserData();
    this.fetchUserScores();
  },
  methods: {
    async fetchUserData() {
      const token = Cookies.get('accessToken'); // Récupérez le token du cookie

      // Vérifiez si le token est défini
      if (!token) {
        // L'utilisateur n'est pas connecté, donc le pseudo reste vide
        this.userNotConnected = true;
        return;
      }
      try {
        const response = await fetch(VALIDATE_USER, {
          headers: {
            Authorization: `Bearer ${token}`, // Ajoutez le token comme en-tête d'autorisation
          },
        });

        if (!response.ok) {
          throw new Error('Erreur lors de la récupération des informations de l\'utilisateur');
        }
        // Récupérez le pseudo de l'utilisateur depuis la réponse de l'API
        const userData = await response.json();
        this.userNotConnected = false;
        this.user.pseudo = userData.username;
      } catch (error) {
        console.error('Erreur:', error.message);
      }
    },
    async fetchUserScores() {
      const token = Cookies.get('accessToken');
      if (!token) {
        this.userNotConnected = true;
        return;
      }
      try {
        const response = await fetch(HISTORY, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        if (!response.ok) {
          throw new Error('Erreur lors de la récupération des scores de l\'utilisateur');
        }
        const userScoreData = await response.json();
        this.userNotConnected = false;
        this.nbPartie = userScoreData.length;
        let history = [];

        for (let i = 0; i < userScoreData.length; i++) {
          this.calculMeilleurScore(userScoreData[i]);
          history.push({
            nomSerie: userScoreData[i].serie_nom,
            score: userScoreData[i].score,
            difficulte: userScoreData[i].difficulte,
          })
        }
        this.history = history;
      } catch (error) {
        console.error('Erreur:', error.message);
      }


    },

    /**
     * Méthode qui permet de gérer les meilleurs scores de l'utilisateur
     * @param {object} partie - Les informations de la partie jouée
     */
    calculMeilleurScore(partie) {
      if (partie.score > this.premierMeilleurScore.score) {
        this.troisiemeMeilleurScore = this.secondMeilleurScore;
        this.secondMeilleurScore = this.premierMeilleurScore;
        this.premierMeilleurScore = partie;
      } else if (partie.score > this.secondMeilleurScore.score) {
        this.troisiemeMeilleurScore = this.secondMeilleurScore;
        this.secondMeilleurScore = partie;
      } else if (partie.score > this.troisiemeMeilleurScore.score) {
        this.troisiemeMeilleurScore = partie;
      }
    },


  },

}


</script>

<template>
  <div>
    <section class=" min-h-screen pt-6">
      <div ref="connectedUserDiv" v-if="!userNotConnected"
           class="drop-shadow-[0_8px_4px_rgba(34,0,4,6)] w-1/2 rounded-xl flex flex-col overflow-hidden border-2 border-gray-100 mx-auto my-4 bg-stone-400 text-zinc-900">
        <div class="flex flex-row items-center m-2 justify-evenly ml-auto mr-auto">
          <p class="text-4xl font-bold m-1 mr-2">Compte de :</p>
          <p class="text-4xl font-bold">{{ user.pseudo }}</p>
        </div>
      </div>
      <div v-else ref="disconnectedUserDiv" class="flex flex-col justify-center mt-4 items-center">
        <div class="justify-center">
          <p class="p-2 text-center font-bold w-1/2 rounded-xl overflow-hidden border-2 border-gray-100 mx-auto my-10 bg-stone-400 text-zinc-900">
            Vous avez été déconnecté. Veuillez vous reconnecter pour accéder à votre compte.</p>
        </div>
        <router-link to="/connexion">
          <button
              class="text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">
            Se connecter
          </button>
        </router-link>
      </div>

      <div class="flex justify-center mt-8">
        <div class="flex flex-col items-center w-1/3 mr-4 ">
          <img class="w-1/3 mb-1" src="@/components/icons/serie.png" alt="seriePlayed">
          <div
              class="p-2 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] w-full rounded-xl flex flex-col overflow-hidden mx-auto mt-4 bg-stone-400 text-zinc-900">
            <h3 class="text-2xl font-bold ">Parties jouées</h3>
            <div class="flex flex-row  p-2">
              <p class="text-right font-bold text-neutral-500 text-base mr-2">Nombre de parties :</p>
              <p class="text-right text-xl font-bold"> {{ nbPartie }}</p>
            </div>
          </div>
          <div
              class="flex flex-col p-2 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] w-full rounded-xl overflow-hidden mx-auto my-4 bg-stone-400 text-zinc-900">
            <div class="flex justify-between" v-for="partie in history" :key="partie.nomSerie">
              <p class="text-left w-1/3 font-bold text-gray-800 text-base">{{ partie.nomSerie }}</p>
              <p class="text-center w-1/3 font-bold text-gray-800 text-base"> Difficulté :{{ partie.difficulte }}</p>
              <p class="text-right w-1/3 text-xl font-bold">Score : {{ partie.score }}</p>
            </div>
          </div>
        </div>

        <div class="flex flex-col items-center w-1/3 ml-4">
          <img class="w-1/3 mb-5" src="@/components/icons/score.png" alt="seriePlayed">
          <div
              class="p-2 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] w-full rounded-xl flex flex-col overflow-hidden mx-auto  bg-stone-400 text-zinc-900">
            <h3 class="text-2xl font-bold">Meilleurs Scores : </h3>

          </div>
          <div
              class="flex flex-col p-2 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] w-full rounded-xl overflow-hidden mx-auto my-4 bg-stone-400 text-zinc-900">
            <!-- Contenu supplémentaire ici -->
            <div class="flex flex-col justify-between" >
              <div class="flex justify-between ">
                <p class="text-center font-bold text-yellow-600 text-base">#1</p>
                <p class="text-center font-bold text-yellow-600 text-base"> {{ premierMeilleurScore.serie_nom }}</p>
                <p class="text-center font-bold text-yellow-600 text-base">Score : {{ premierMeilleurScore.score }}</p>
                <p class="text-center font-bold text-yellow-600 text-base">Difficulté : {{ premierMeilleurScore.difficulte }}</p>
              </div>
              <div class="flex justify-between">
                <p class="text-center font-bold text-neutral-600 text-base">#2</p>
                <p class="text-center font-bold text-neutral-600 text-base  "> {{ secondMeilleurScore.serie_nom }}</p>
                <p class="text-center font-bold text-neutral-600 text-base">Score : {{ secondMeilleurScore.score }}</p>
                <p class="text-center font-bold text-neutral-600 text-base">Difficulté : {{ secondMeilleurScore.difficulte }}</p>
              </div>
              <div class="flex justify-between">
                <p class=" text-yellow-700 text-center font-bold text-base">#3</p>
                <p class="text-center font-bold text-yellow-700 text-base  "> {{ troisiemeMeilleurScore.serie_nom }}</p>
                <p class="text-center font-bold text-yellow-700 text-base">Score : {{ troisiemeMeilleurScore.score }}</p>
                <p class="text-center font-bold text-yellow-700 text-base">Difficulté : {{ troisiemeMeilleurScore.difficulte }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>


    </section>
  </div>
</template>