<script>
// Importer la composante ArtistResult
import ArtistResult from "@/components/ArtistResults.vue";

export default {
  name: "ArtistSearch",
  components: {
    ArtistResult,
  },
  props: {
    // Corriger le nom de la prop pour correspondre à celui utilisé dans le template
    results: {
      type: Array,
      default: () => [],
    },
    offset: {
      type: Number,
      default: 0,
    },
  },
};
</script>

<template>
  <div class="artist-results">
    <template v-if="results.length">
      <h1 class="text-neutral-300 font-bold">
        Les résultats de votre recherche sont :
      </h1>
      <!-- Afficher le nombre de résultats -->

      <ArtistResult :response="results" :offset="offset" />
    </template>
    <template v-else>
      <p class="text-lg text-carbon-700">
        Aucun artiste ne correspond à votre recherche dans notre base de
        données.
      </p>
    </template>
  </div>
</template>

<style scoped>
/* Ajouter des styles si nécessaire */
</style>
