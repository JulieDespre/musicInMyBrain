<script>
export default {
  props: {
    title: String,
    artists: Array,
  }
}
</script>

<template>
  <div class="max-w-lg mx-auto">

    <h2 class="text-xl">{{ title }}</h2>
    <ul class="list-disc pl-4">
      <li v-for="(artist, index) in artists" :key="index" class="text-s text-gray-500">{{ artist.name }}</li>
    </ul>
  </div>
</template>

<style scoped>

</style>