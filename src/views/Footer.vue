<template>
  <footer
    class="fixed bottom-0 left-0 right-0 footer mt-2 py-2 bg-zinc-700 text-neutral-500"
  >
    <div class="container justify-between flex flex-grow">
      <!-- Affichage des informations sur la provenance des données -->
      <p>Les données sont fournies par MusicBrainz. Tous droits réservés.</p>
      <p>IUT-charlemagne 2024</p>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer", // Nom du composant
};
</script>

<!-- Styles spécifiques au footer -->
<style scoped>
.footer {
  height: 10vh;
}

/* Media Query pour changer la taille de la police */
@media screen and (max-width: 380px) {
  .footer p {
    font-size: small;
  }
}
</style>
