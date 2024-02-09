<script>
export default {
  data() {
    return {
      initialisation: this.init(),
      games: [],
      gameDifficulty: [
        {
          id: 1,
          libelle: "Facile"
        },
        {
          id: 2,
          libelle: "Médium"
        },
        {
          id: 3,
          libelle: "Difficile"
        }
      ]
    }
  },
  methods: {
    /**
     * Méthode qui charge et permet de rejouer les anciennes parties
     */
    fetchOldGames() {
      fetch('http://docketu.iutnc.univ-lorraine.fr:35200/games')
          .then(response => response.json())
          .then(data => {
            this.games = data;
          })
          .catch(error => {
            throw error;
          })

    },
    init() {
      this.fetchOldGames();
      this.initialisation = true;
    }
  }
}
</script>

<template>
  <div class="mb-16">
    <h2 class="my-8 text-center text-blue-500 text-3xl font-bold">Redémarrer une partie</h2>
    <div v-for="game in games" class="p-4 m-1 bg-gray-700 flex flex-row justify-between items-center">
      <div>
        <p class="text-white"><strong>Série n°{{ game.serie_id }}</strong>, Difficulté {{ game.difficulte }} par <u>{{ game.user_email }}</u></p>
        <RouterLink :to="/play/ + game.id">
          <button class="mt-4 max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">Rejouer</button>
        </RouterLink>
      </div>
      <div>
        <p class="text-3xl text-blue-200"><strong>{{ game.score }}</strong></p>
      </div>
    </div>
  </div>
</template>