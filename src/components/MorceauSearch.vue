<script>
import MorceauResults from "@/components/MorceauResults.vue";

export default {
  name: "MorceauSearch",
  components: { MorceauResults },
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
  <div class="music-results max-w-lg mx-auto py-8">
    <template v-if="results.length">
      <h1 class="text-neutral-300 font-bold">
        Les résultats de votre recherche sont :
      </h1>
      <ArtistResult :response="results" :offset="offset" />
    </template>
    <template v-else>
      <p class="text-lg text-carbon-700">
        Aucun morceau ne correspond à votre recherche dans notre base de
        données.
      </p>
    </template>
  </div>
</template>
