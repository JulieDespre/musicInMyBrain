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
      loading: false,
    };
  },
  methods: {
    resetOffset() {
      this.offset = 0;
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

    // Affiche la page précédente des résultats de la recherche
    previousPage() {
      if (this.offset >= 5) {
        this.offset -= 5;
      }
    },
    // Affiche la page suivante des résultats de la recherche
    nextPage() {
      // Vérifie si le nombre de résultats affichés est égal à la limite
      if (this.searchBy === "title" && this.searchTitleResults.length >= 25) {
        this.offset += 5; // Incrémente l'offset
      } else if (
        this.searchBy === "artist" &&
        this.searchArtistResults.length >= 25
      ) {
        this.offset += 5; // Incrémente l'offset
      }
    },
  },
  computed: {
    canGoNext() {
      if (this.searchBy === "title") {
        return this.searchTitleResults.length > 5 && this.offset < 20;
      } else if (this.searchBy === "artist") {
        return this.searchArtistResults.length > 5 && this.offset < 20;
      } else {
        return false;
      }
    },
  },
};
</script>

<template>
  <div class="min-h-screen flex flex-col items-center mb-10">
    <Search @search="apiSearch" :resetOffset="resetOffset" />

    <div v-if="searchBy === 'title'">
      <MorceauSearch :results="searchTitleResults" :offset="offset" />
    </div>

    <div v-if="searchBy === 'artist'">
      <ArtistSearch :results="searchArtistResults" :offset="offset" />
    </div>

    <div class="mb-5">
      <button
        @click="previousPage"
        :disabled="offset === 0"
        class="btn-nav py-2 px-2 bg-blue-500 text-white rounded-lg mr-4"
        :class="{ 'opacity-50 cursor-not-allowed': offset === 0 }"
      >
        Précédent
      </button>
      <button
        @click="nextPage"
        :disabled="!canGoNext"
        class="btn-nav py-2 px-4 bg-blue-500 text-white rounded-lg"
        :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
      >
        Suivant
      </button>
    </div>
  </div>
</template>

<style>
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
