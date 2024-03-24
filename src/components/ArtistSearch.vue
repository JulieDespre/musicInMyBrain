<script>
// Importer la composante ArtistResult
import ArtistResult from "@/components/ArtistResults.vue";

export default {
  name: "ArtistSearch",
  components: {
    ArtistResult,
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
  methods: {
    // Affiche la page précédente des résultats de la recherche
    previousPage() {
      if (this.offset >= 5) {
        this.$emit("update:offset", this.offset - 5); // Émettre un événement pour mettre à jour offset
      }
    },

    // Affiche la page suivante des résultats de la recherche
    nextPage() {
      if (this.results.length >= 25) {
        this.$emit("update:offset", this.offset + 5); // Émettre un événement pour mettre à jour offset
      }
    },
  },
  computed: {
    canGoNext() {
      return this.results.length > 5 && this.offset < 20;
    },
  },
};
</script>

<template>
  <div class="artist-results">
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
        <ArtistResult :response="results" :offset="offset" />
      </template>
      <template v-else>
        <p class="text-lg text-carbon-700">
          Aucun artiste ne correspond à votre recherche dans notre base de
          données.
        </p>
      </template>
    </template>
    <div class="mb-5">
      <button
        @click="previousPage"
        :disabled="offset === 0"
        class="btn-nav py-2 px-2 rounded-lg mr-4"
        :class="{ 'opacity-50 cursor-not-allowed': offset === 0 }"
      >
        Précédent
      </button>
      <button
        @click="nextPage"
        :disabled="!canGoNext"
        class="btn-nav py-2 px-4 rounded-lg"
        :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
      >
        Suivant
      </button>
    </div>
  </div>
</template>

<style scoped>
.btn-nav {
  background-color: #83c0c1;
  color: #6962ad;
  transition: all 0.3s;
}
.btn-nav:hover {
  background-color: #6962ad;
  color: #83c0c1;
}
</style>
