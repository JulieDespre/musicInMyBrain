<script>
export default {
  props: {
    response: {
      type: Array,
      default: () => [],
    },
    offset: {
      type: Number,
      default: 0,
    },
  },
  methods: {
    /**
     * Récupérer le nom de l'artiste
     * @param {Object} morceau - L'objet représentant le morceau
     * @returns {string} - Le nom de l'artiste
     */
    getArtistName(morceau) {
      if (morceau["artist-credit"] && morceau["artist-credit"].length > 0) {
        return morceau["artist-credit"][0].name;
      } else {
        return "Inconnu";
      }
    },
    /**
     * Convertir la durée en minutes
     * @param {number} seconds - La durée en secondes
     * @returns {string} - La durée en minutes (format hh:mm)
     */
    formatDuration(milliseconds) {
      const seconds = Math.floor(milliseconds / 1000);
      const minutes = Math.floor(seconds / 60);
      const remainderSeconds = seconds % 60;
      return `${minutes}:${
        remainderSeconds < 10 ? "0" : ""
      }${remainderSeconds}`;
    },
  },
};
</script>

<template>
  <div
    class="morceau-result max-w-lg mx-auto w-full flex flex-wrap md:flex-row sm:flex-col justify-center lg:flex-row py-2"
    v-if="response && response.length > 0"
  >
    <h2>Résultats de la recherche par morceaux :</h2>
    <div
      class="flex flex-wrap lg:flex-row sm:flex-col items-center justify-center"
    >
      <ul
        class="pl-4 flex flex-wrap md:flex-row sm:flex-col justify-center lg:flex-row py-2"
      >
        <li v-for="n in 5" :key="n" class="bg-gray-200 rounded-lg p-4 mb-4">
          <!-- Contenu de chaque morceau -->
          <div>
            <p class="font-semibold">
              Nom: {{ response[n - 1 + offset].title }}
            </p>
            <ul class="list-disc pl-4">
              <li>
                Durée du morceau:
                {{ formatDuration(response[n - 1 + offset].length) }} min
              </li>
              <li>Artiste : {{ getArtistName(response[n - 1 + offset]) }}</li>
            </ul>

            <button
              class="bg-neutral-500 text-white px-4 py-2 rounded-md mt-2 ml-auto"
            >
              <router-link :to="'/morceau/' + response[n - 1 + offset].id"
                >Plus d'informations</router-link
              >
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <div v-else>
    <p>Aucun résultat trouvé.</p>
  </div>
</template>

<style scoped>
/* Vos styles CSS */
</style>
