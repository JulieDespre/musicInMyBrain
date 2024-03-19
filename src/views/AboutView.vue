<script setup></script>

<template>
  <main
    class="container mx-auto py-8 px-6 bg-neutral-400 rounded-lg shadow-lg ml-auto mr-auto mt-20 mb-10"
  >
    <h1 class="text-4xl font-bold mb-4 text-center">
      Music Brain est un application web qui permet de rechercher des morceaux
    </h1>

    <p class="text-lg text-gray-700 pl-10 pr-10 mb-2 text-center">
      Pour rechercher des informations sur les morceaux et les artistes l'API
      utilisé est MusicBrainz.
      <p><span class="font-bold ml-10 mb-20"
        >https://musicbrainz.org/ws/2/release?artist=${artistId}&fmt=json&inc=recordings</span
      >
    </p>
    </p>
    <p class="text-lg text-gray-700 pl-10 pr-10 mb-2 text-center">
      Pour les couvertures d'albums, l'API utilisé est Cover Art Archive.
     <p><span class="font-bold ml-20"
        >https://coverartarchive.org/release/${albumId}</span
      >
    </p>
    </p>
    <h1 class="text-xl font-bold mb-4 text-center"></h1>
  </main>
</template>

<style scoped></style>
