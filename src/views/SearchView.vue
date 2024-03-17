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

      // URL de base de l'API MusicBrainz
      let baseUrl = "https://musicbrainz.org/ws/2/";

      let artistUrl = "";
      let morceauUrl = "";

      // Si on a une recherche par artiste, on construit l'URL correspondante
      if (artistQuery) {
        artistUrl = `${baseUrl}artist/?fmt=json&query=${artistQuery}&limit=10&offset=${this.offset}`;
        console.log(artistUrl);
        this.searchBy = "artist";
      }
      // Si on a une recherche par titre, on construit l'URL correspondante
      if (MorceauQuery) {
        morceauUrl = `${baseUrl}recording/?fmt=json&query=${MorceauQuery}&limit=10&offset=${this.offset}`;
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
          this.searchTitleResults = MorceauData.recordings;
        } else {
          this.searchTitleResults = [];
        }
      } catch (error) {
        console.error("Erreur lors de la recherche:", error);
        this.searchTitleResults = [];
      }
    },

    // Méthode pour aller à la page précédente
    async previousPage() {
      if (this.offset >= 10) {
        this.offset -= 10;
        await this.apiSearch(this.query, this.searchBy);
      } else {
        // Gérer le cas où l'offset devient négatif
        this.offset = 0;
        await this.apiSearch(this.query, this.searchBy);
      }
    },

    // Méthode pour aller à la page suivante
    async nextPage() {
      this.offset += 10;
      await this.apiSearch(this.query, this.searchBy);
    },
  },
};
</script>

<template>
  <div class="min-h-screen flex flex-col items-center">
    <Search @search="apiSearch" :resetOffset="resetOffset" />

    <div v-if="searchBy === 'morceau'">
      <MorceauSearch :results="searchTitleResults" />
    </div>

    <div v-if="searchBy === 'artist'">
      <ArtistSearch :results="searchArtistResults" />
    </div>

    <div>
      <button
        @click="previousPage"
        :disabled="offset === 0"
        class="py-2 px-4 bg-blue-500 text-white rounded-lg mr-4"
        :class="{ 'opacity-50 cursor-not-allowed': offset === 0 }"
      >
        Précédent
      </button>
      <button
        @click="nextPage"
        :disabled="
          (searchBy === 'title' && searchTitleResults.length < 10) ||
          (searchBy === 'artist' && searchArtistResults.length < 10)
        "
        class="py-2 px-4 bg-blue-500 text-white rounded-lg"
        :class="{
          'opacity-50 cursor-not-allowed':
            (searchBy === 'title' && searchTitleResults.length < 10) ||
            (searchBy === 'artist' && searchArtistResults.length < 10),
        }"
      >
        Suivant
      </button>
    </div>
  </div>
</template>
