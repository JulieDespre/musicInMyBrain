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
  },
};
</script>

<template>
  <div class="artist-results">
    <template v-if="results.length">
      <h1>Les résultats de votre recherche :</h1>
      <!-- Afficher le nombre de résultats -->
      <p>{{ results.count }} résultats trouvés :</p>
      <ArtistResult :response="results" />
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
