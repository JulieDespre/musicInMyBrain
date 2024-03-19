<template>
  <main>
    <div>
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
        <span class="mx-2 text-gray-200 font-bold"
          >Chargement des détails en cours...</span
        >
      </div>
      <div v-else>
        <div class="bg-gray-200 p-6 rounded-lg ml-20 mr-20 mt-10 mb-10">
          <div>
            <h2 class="font-bold">{{ recording.title }}</h2>
          </div>
          <div>
            <h2 class="">
              Durée du morceau : {{ recording.formattedDuration }} min
            </h2>
            <h2 v-show="!recording.length">Durée non renseignée</h2>
          </div>
          <!-- Ajout des autres éléments de contenu -->
        </div>
      </div>
    </div>
    <router-link
      :to="'/search'"
      class="bg-gray-200 p-2 rounded-lg ml-20 mr-20 mt-10 mb-10"
      >Nouvelle Recherche</router-link
    >
  </main>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      recording: {},
    };
  },
  mounted() {
    fetch(`https://musicbrainz.org/ws/2/recording/${this.id}?fmt=json`)
      .then((response) => response.json())
      .then((data) => {
        const info = data;
        this.recording = {
          id: info.id,
          title: info.title,
          artistName: this.getArtistName(info),
          formattedDuration: this.formatDuration(info.length),
          firstReleaseDate: info["first-release-date"],
          format: this.getFormat(info),
          country: this.getCountry(info),
          disambiguation: info.disambiguation,
          video: info.video,
        };
        this.loading = false;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    id() {
      return this.$route.params.id;
    },
    /**
     * Récupère le nom de l'artiste à partir des informations de l'enregistrement.
     * @param {Object} info - Informations de l'enregistrement
     * @returns {string|null} - Nom de l'artiste
     */
    getArtistName(info) {
      return info["artist-credit"] ? info["artist-credit"][0].name : null;
    },

    /**
     * Formate la durée de l'enregistrement.
     * @returns {Function} - Fonction de formatage de la durée
     */
    formatDuration() {
      return (duration) => {
        const minutes = Math.floor(duration / 60000);
        const seconds = Math.floor((duration % 60000) / 1000);
        return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
      };
    },

    /**
     * Récupère le format de l'enregistrement.
     * @param {Object} info - Informations de l'enregistrement
     * @returns {string|null} - Format de l'enregistrement
     */
    getFormat() {
      return info.releases &&
        info.releases.length > 0 &&
        info.releases[0].media &&
        info.releases[0].media.length > 0
        ? info.releases[0].media[0].format
        : null;
    },

    /**
     * Récupère le pays de l'enregistrement.
     * @param {Object} info - Informations de l'enregistrement
     * @returns {string|null} - Pays de l'enregistrement
     */
    getCountry(info) {
      return info.releases && info.releases.length > 0
        ? info.releases[0]["country"]
        : null;
    },
    /**
     * Formatte la date au format jour, mois et année.
     * @param {string} date - Date à formater
     * @returns {string} - Date formatée
     */
    formatDate(date) {
      const options = { day: "2-digit", month: "long", year: "numeric" };
      return new Date(date).toLocaleDateString("fr-FR", options);
    },
  },
};
</script>

<style>
.loading {
  --speed-of-animation: 0.9s;
  --gap: 6px;
  --first-color: #6962ad;
  --second-color: #6c39a6;
  --third-color: #83c0c1;
  --fourth-color: #95e7c6;
  --fifth-color: #6962ad;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100px;
  gap: 6px;
  height: 100px;
  margin-bottom: 20px;
}

.loading span {
  width: 4px;
  height: 50px;
  background: var(--first-color);
  animation: scale var(--speed-of-animation) ease-in-out infinite;
}

.loading span:nth-child(2) {
  background: var(--second-color);
  animation-delay: -0.8s;
}

.loading span:nth-child(3) {
  background: var(--third-color);
  animation-delay: -0.7s;
}

.loading span:nth-child(4) {
  background: var(--fourth-color);
  animation-delay: -0.6s;
}

.loading span:nth-child(5) {
  background: var(--fifth-color);
  animation-delay: -0.5s;
}

@keyframes scale {
  0%,
  40%,
  100% {
    transform: scaleY(0.05);
  }

  20% {
    transform: scaleY(1);
  }
}
</style>
