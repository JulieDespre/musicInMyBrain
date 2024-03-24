<script>
import Search from "../components/Search.vue";
import ArtistSearch from "@/components/ArtistSearch.vue";
import MorceauSearch from "@/components/MorceauSearch.vue";
import MorceauResults from "@/components/MorceauResults.vue";

export default {
  name: "App",
  components: {
    ArtistSearch,
    MorceauSearch,
    Search,
    MorceauResults,
  },

  data() {
    return {
      searchTitleResults: [],
      searchArtistResults: [],
      offset: 0,
      query: "",
      searchBy: "",
      loading: true,
    };
  },
  methods: {
    resetOffset() {
      this.offset = 0;
    },

    updateOffset(newOffset) {
      this.offset = newOffset; // Mettre à jour l'offset avec la nouvelle valeur
    },

    /**
     * Effectue une recherche sur l'API MusicBrainz
     * @param {string} artistQuery - La chaîne de caractères à rechercher dans les artistes
     * @param {string} MorceauQuery - La chaîne de caractères à rechercher dans les titres
     */
    async apiSearch(artistQuery, MorceauQuery) {
      if (!artistQuery && !MorceauQuery) {
        // Si les deux champs de recherche sont vides, ne rien faire
        return;
      }

      /*if (artistQuery.trim() === "" || MorceauQuery.trim() === "") {
        this.error = "Veuillez saisir une valeur de recherche.";
        return;
      }*/

      this.loading = true;

      // URL de base de l'API MusicBrainz
      let baseUrl = "https://musicbrainz.org/ws/2/";

      let artistUrl = "";
      let morceauUrl = "";

      // Si on a une recherche par artiste, on construit l'URL correspondante
      if (artistQuery) {
        artistUrl = `${baseUrl}artist/?fmt=json&query=${artistQuery}&offset=${this.offset}`;
        console.log(artistUrl);
        this.searchBy = "artist";
      }
      // Si on a une recherche par titre, on construit l'URL correspondante
      if (MorceauQuery) {
        morceauUrl = `${baseUrl}recording/?fmt=json&query=${MorceauQuery}&offset=${this.offset}`;
        this.searchBy = "title";
      }

      try {
        const requests = [];

        if (artistUrl) {
          requests.push(
            fetch(artistUrl, {
              headers: {
                "User-Agent": "searcMusicVue/1.0 (desprejulie@gmail.com)",
              },
            })
          );
        }

        if (morceauUrl) {
          requests.push(
            fetch(morceauUrl, {
              headers: {
                "User-Agent": "searcMusicVue/1.0 (desprejulie@gmail.com)",
              },
            })
          );
        }

        const responses = await Promise.all(requests);

        let artistData = null;
        let MorceauData = null;

        //peut mettre && dans condition du if
        if (artistUrl) {
          console.log("artistUrl", artistUrl);
          artistData = await responses[0].json();
          console.log(artistData);
        }

        if (morceauUrl) {
          const index = artistUrl ? 1 : 0;
          MorceauData = await responses[index].json();
        }

        if (artistData) {
          this.searchArtistResults = artistData.artists;
        } else {
          this.searchArtistResults = [];
        }

        if (MorceauData) {
          console.log("MorceauData", MorceauData);
          this.searchTitleResults = MorceauData.recordings;
        } else {
          this.searchTitleResults = [];
        }
      } catch (error) {
        console.error("Erreur lors de la recherche:", error);
        this.searchTitleResults = [];
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<template>
  <div class="min-h-screen flex flex-col items-center mb-10">
    <Search @search="apiSearch" :resetOffset="resetOffset" />

    <div v-if="searchBy === 'title'">
      <MorceauSearch
        :results="searchTitleResults"
        :offset="offset"
        :loading="loading"
      />
    </div>

    <div v-if="searchBy === 'artist'">
      <ArtistSearch
        :results="searchArtistResults"
        :offset="offset"
        :loading="loading"
        @update:offset="updateOffset"
      />
    </div>
  </div>
</template>

<style></style>
