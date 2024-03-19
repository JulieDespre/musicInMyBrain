<script>
export default {
  data() {
    return {
      loading: true,
      loadingAlbums: true, // Ajout de la propriété loadingAlbums
      artist: {},
      artistId: this.$route.params.id,
    };
  },
  mounted() {
    fetch(`https://musicbrainz.org/ws/2/artist/${this.artistId}?fmt=json`)
      .then((response) => response.json())
      .then((data) => {
        this.artist = data;
        //permet d'afficher un loading
        this.loading = false; // Changement de loading à false
        // Récupération des albums de l'artiste
        this.getArtistAlbums(this.artistId);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    /*
     * Récupère les albums de l'artiste
     * @param {string} artistId - Identifiant de l'artiste
     * @returns les albums de l'artiste
     */
    async getArtistAlbums(artistId) {
      try {
        const response = await fetch(
          `https://musicbrainz.org/ws/2/release?artist=${artistId}&fmt=json&inc=recordings`
        );
        const data = await response.json();
        if (data.releases && data.releases.length > 0) {
          for (const release of data.releases) {
            release.albumArt = await this.getAlbumArt(release.id);
            // Ajoutez les informations sur les pistes à chaque album
            release.tracksCount = release.media.reduce((acc, media) => {
              return acc + media["track-count"];
            }, 0);
          }
          this.artist.releases = data.releases;
        } else {
          console.log("Aucun album trouvé pour cet artiste.");
        }
        this.loadingAlbums = false;
      } catch (error) {
        console.error("Erreur lors de la récupération des albums :", error);
      }
    },

    /*
     * Récupère la pochette de l'album
     * @param {string} albumId - Identifiant de l'album
     * @returns la pochette de l'album
     */
    async getAlbumArt(albumId) {
      try {
        const response = await fetch(
          `https://coverartarchive.org/release/${albumId}`
        );
        const data = await response.json();
        if (data.images && data.images.length > 0) {
          this.loading = false;
          return data.images[0].image;
        } else {
          // Si la pochette n'est pas disponible, retourner une image lambda
          return "https://via.placeholder.com/150";
        }
      } catch (error) {
        console.error("Erreur lors de la récupération de la pochette :", error);
        // En cas d'erreur, retourner une image lambda
        return "https://via.placeholder.com/150";
      }
    },

    /**
     * Permet de revenir à la page précédente
     */
    goBack() {
      this.$router.go(-1);
    },

    /**
     * Calcule la durée de carrière de l'artiste
     * @param {string} beginDate - Date de début de carrière
     * @param {string} endDate - Date de fin de carrière
     * @returns la durée de carrière
     */
    calculateCareerDuration(beginDate, endDate) {
      const begin = new Date(beginDate);
      const end = endDate ? new Date(endDate) : new Date();
      const duration = end.getFullYear() - begin.getFullYear();
      return duration;
    },

    /**
     * Convertit la durée d'un morceau en minutes
     * @param {number} duration - Durée du morceau en millisecondes
     * @returns la durée du morceau en minutes
     */
    convertToMinutes(duration) {
      // Convertir la durée de millisecondes à minutes
      const minutes = Math.floor(duration / 60000);
      // Retourner le résultat
      return minutes;
    },
  },
};
</script>

<template>
  <main>
    <div>
      <!-- Afficher l'indicateur de chargement si loading est vrai -->
      <div
        v-if="loading || loadingAlbums"
        class="flex justify-center items-center h-3/4 mt-40"
      >
        <div class="loading align-middle">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <!-- Afficher les albums si loading est faux -->
      <div v-else>
        <!-- Contenu des albums -->
        <div class="bg-gray-200 p-6 rounded-lg ml-20 mr-20 mt-10 mb-10">
          <div>
            <h2 class="font-bold">
              Nom de l'artiste recherché : {{ artist.name }}
            </h2>
          </div>
          <div>
            <h2>Pays : {{ artist.area?.name || "Pays non renseigné" }}</h2>
          </div>
          <div>
            <h2>
              Groupe ou chanteur :
              {{ artist.type === "Group" ? "Groupe" : "Chanteur(euse)" }}
            </h2>
          </div>
          <div>
            <h2>
              Date de création :
              {{
                artist["life-span"]?.begin || "Date de création non renseignée"
              }}
            </h2>
          </div>
          <div>
            <h2>
              Date de fin :
              {{
                artist["life-span"]?.end ||
                "Date de fin non renseignée, l'artiste n'a pas mis fin à sa carrière"
              }}
            </h2>
          </div>
          <div>
            <h2>
              Durée de carrière :
              {{
                calculateCareerDuration(
                  artist["life-span"]?.begin,
                  artist["life-span"]?.end || new Date().toISOString()
                )
              }}
              ans
            </h2>
          </div>
          <div>
            <h2>
              Informations complémentaires :
              {{ artist.disambiguation || "Non renseigné" }}
            </h2>
          </div>
          <div v-if="loading">
            <p>Loading...</p>
          </div>
          <!-- Liste des albums -->
          <div v-else-if="artist.releases && artist.releases.length > 0">
            <h2 class="mt-6 mb-3 font-bold text-lg">Albums de l'artiste :</h2>
            <div v-for="album in artist.releases" :key="album.id" class="mb-4">
              <div class="flex items-center">
                <!-- Pochette de l'album -->
                <img
                  :src="album.albumArt"
                  alt="Pochette de l'album"
                  class="w-20 h-20 mr-4"
                />

                <!-- Informations sur l'album -->
                <div>
                  <h3 class="font-semibold">{{ album.title }}</h3>
                  <p>
                    Date de sortie : {{ album.date || "Date non disponible" }}
                  </p>
                  <!-- Vérification si album.tracks est défini -->

                  <p v-if="album.tracksCount !== undefined">
                    Nombre de pistes : {{ album.tracksCount }}
                  </p>

                  <!-- Liste des morceaux de l'album -->
                  <ul v-if="album.media && album.media.length > 0">
                    <li v-for="media in album.media" :key="media.id">
                      <ul>
                        <li v-for="track in media.tracks" :key="track.id">
                          <p class="ml-5">
                            <strong>{{
                              track.title || "Titre non disponible"
                            }}</strong>
                            Durée : {{ convertToMinutes(track.length) }} minutes
                          </p>
                          <!-- Convertir la longueur du morceau en minutes -->
                        </li>
                      </ul>
                    </li>
                  </ul>

                  <p v-else>Nombre de pistes non disponible</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Fin de la liste des albums -->
          <div v-else-if="artist.album.length === 0">
            <p>Aucun album trouvé pour cet artiste.</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

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
