<script>
export default {
  data() {
    return {
      loading: true,
      artist: {},
    };
  },
  mounted() {
    // Récupération des données de l'artiste
    fetch(`https://musicbrainz.org/ws/2/artist/${this.id}?fmt=json`)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        this.artist = data;
        //permet d'afficher un loading
        this.loading = false;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    /**
     * Récupère l'identifiant de l'artiste dans l'URL
     * @returns la route avec le paramètre de l'id
     */
    id() {
      return this.$route.params.id;
    },
  },
};
</script>

<template>
  <main>
    <div>
      <div v-if="!loading">
        <div>
          <h2>{{ artist.name }}</h2>
        </div>
        <div>
          <h2>{{ artist.country }}</h2>
          <h2 v-show="!artist.country">Pays non renseigné</h2>
        </div>
        <div>
          <h2>{{ artist.type }}</h2>
          <h2 v-show="!artist.type">Type d'artiste non renseigné</h2>
        </div>
        <div>
          <h2>{{ artist.disambiguation }}</h2>
          <h2 v-show="!artist.disambiguation">Type de musique non renseigné</h2>
        </div>
      </div>
      <div v-else>
        <p>Loading...</p>
      </div>
      <RouterLink :to="'/'">Rechercher</RouterLink>
    </div>
  </main>
</template>
