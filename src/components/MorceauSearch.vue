<script>
import MorceauResults from "@/components/MorceauResults.vue"; // Importer le composant correctement

export default {
  name: "MorceauSearch",
  components: {
    MorceauResults,
  },
  props: {
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
  <div class="morceau-search">
    <template v-if="results.length">
      <h1 class="text-neutral-300 font-bold">
        Les résultats de votre recherche sont :
      </h1>
      <!-- Afficher le nombre de résultats -->

      <MorceauResults :response="results" :offset="offset" />
      <!-- Utiliser morceauResults au lieu de morceauResult -->
    </template>
    <template v-else>
      <p class="text-lg text-carbon-700">
        Aucun morceau ne correspond à votre recherche dans notre base de
        données.
      </p>
    </template>
  </div>
</template>

<style scoped>
/* Vos styles CSS */
</style>
