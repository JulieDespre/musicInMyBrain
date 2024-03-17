<script>
export default {
  name: "ArtistResult",
  props: {
    response: Object, // La réponse de la requête
  },
  methods: {
    getNationality(artist) {
      console.log("responce artistes" + this.response.artists);
      if (artist.area && artist.area.name) {
        console.log("area artistes" + artist.area);
        return artist.area.name;
      } else if (artist.begin_area && artist.begin_area.name) {
        return artist.begin_area.name;
      } else {
        return "Nationalité inconnue";
      }
    },
    getGenres(artist) {
      if (artist.tags && artist.tags.length > 0) {
        return artist.tags.map((tag) => tag.name).join(", ");
      } else {
        return "Genre inconnu";
      }
    },
  },
};
</script>

<template>
  <div class="artist-result max-w-lg mx-auto" v-if="true">
    <h2 class="text-xl">Artistes</h2>
    <ul class="list-disc pl-4">
      {{
        response[0].name
      }}
      <li v-for="artist in response" :key="artist.id">
        <div>Nom: {{ artist.name }}</div>
        <div>Nationalité: {{ getNationality(artist) }}</div>
        <div>Genre de musique: {{ getGenres(artist) }}</div>
      </li>
    </ul>
  </div>
  <div v-else>
    <p>Aucun résultat trouvé.</p>
  </div>
</template>

<style scoped>
.artist-result {
  margin-bottom: 10px;
}
</style>
