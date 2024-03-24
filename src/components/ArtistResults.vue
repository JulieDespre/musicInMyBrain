<script>
export default {
  name: "ArtistResult",
  props: {
    response: Object,
    offset: Number, // La réponse de la requête
  },
  methods: {
    /**
     * Récupérer la nationalité d'un artiste
     * @param {Object} artist - L'objet représentant l'artiste
     * @returns {string} - La nationalité de l'artiste
     *
     */
    getNationality(artist) {
      if (artist.area && artist.area.name) {
        console.log("area artistes" + artist.area);
        return artist.area.name;
      } else if (artist.begin_area && artist.begin_area.name) {
        return artist.begin_area.name;
      } else {
        return "Pays inconnue";
      }
    },

    /**
     * Récupérer les genres de musique d'un artiste
     *  @param {Object} artist - L'objet représentant l'artiste
     * @returns {string} - Les genres de musique de l'artiste
     *
     */
    getGenres(artist) {
      if (artist.tags && artist.tags.length > 0) {
        // Récupérer uniquement les trois premiers tags
        const firstThreeTags = artist.tags.slice(0, 3);

        // Mapper les noms des tags
        const tagNames = firstThreeTags.map((tag) => {
          // Séparer le tag en mots
          const words = tag.name.split(" ");

          // Récupérer les deux premiers mots
          const firstTwoWords = words.slice(0, 2);

          // Joindre les deux premiers mots avec un espace
          return firstTwoWords.join(" ");
        });

        // Joindre les noms des tags avec une virgule
        return tagNames.join(", ");
      } else {
        return "Inconnu";
      }
    },

    /**
     * Afficher les détails de l'artiste
     *
     */
    showArtistDetails(artist) {
      if (artist && artist.id) {
        this.$router.push({
          name: "artiste", // Utiliser le nom de la route défini dans le fichier de configuration du routage
          params: { id: artist.id },
        });
      } else {
        console.error(
          "L'artiste est indéfini ou ne possède pas de propriété id."
        );
      }
    },
  },
};
</script>

<template>
  <div
    class="artist-result max-w-lg mx-auto w-full flew flex-wrap md:flex-row sm:flex-col justify-center lg:flex-row py-2"
    v-if="response"
  >
    <h2 class="text-xl">Artistes trouvé(e)s dans la base de données :</h2>
    <div
      class="flex flex-wrap lg:flex-row sm:flex-col items-center justify-center"
    >
      <ul
        class="pl-4 flew flex-wrap md:flex-row sm:flex-col justify-center lg:flex-row py-2"
      >
        <li
          v-for="artist in response.slice(offset, offset + 5)"
          :key="artist.id"
          class="bg-gray-200 rounded-lg p-4 mb-4"
        >
          <div>
            <p class="font-semibold">Nom: {{ artist.name }}</p>
            <ul class="list-disc pl-4">
              <li>Genre de musique: {{ getGenres(artist) }}</li>
              <li>Pays: {{ getNationality(artist) }}</li>
            </ul>
            <button
              class="bg-neutral-500 text-white px-4 py-2 rounded-md mt-2 ml-auto"
              @click="showArtistDetails(artist)"
            >
              Plus d'informations
            </button>
          </div>
        </li>
      </ul>
    </div>
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
