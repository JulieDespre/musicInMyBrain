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
    loading: {
      type: Boolean,
      default: true, // Défaut à true pour indiquer le chargement initial
    },
  },
  data() {
    return {
      isLoading: this.loading, // Initialiser isLoading avec la valeur de loading
    };
  },
  watch: {
    // Surveiller les changements de la propriété loading
    loading(newVal) {
      this.isLoading = newVal; // Mettre à jour isLoading lorsque loading change
    },
  },
};
</script>

<template>
  <div class="morceau-search">
    <template v-if="isLoading">
      <div
        v-if="loading"
        class="flex flex-col justify-center items-center h-3/4 mt-20 mb-16"
      >
        <div class="loading align-middle">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <span class="mx-2 text-gray-200 font-bold">Chargement en cours...</span>
      </div>
    </template>
    <template v-else>
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
    </template>
  </div>
</template>

<style scoped>
/* Vos styles CSS */
</style>
