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
  },
};
</script>

<template>
  <div class="music-results max-w-lg mx-auto py-8">
    <template v-if="results.length">
      <h1>Les résultats correspondant au morceau recherché :</h1>
      <ul>
        <li v-for="(recording, index) in results" :key="index" class="mb-4">
          <MorceauResults
            :title="recording.title"
            :artists="recording['artist-credit']"
          />
        </li>
      </ul>
    </template>
    <template v-else>
      <p class="text-lg text-gray-700">
        Aucun morceau ne correspond à votre recherche dans notre base de
        données.
      </p>
    </template>
  </div>
</template>
