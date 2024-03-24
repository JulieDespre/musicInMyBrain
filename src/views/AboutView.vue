<script setup></script>

<template>
  <main
    class="container mx-auto py-8 px-6 bg-neutral-400 rounded-lg shadow-lg mt-20 mb-10"
  >
    <h1 class="text-4xl font-bold mb-6">Music Brain: Recherche de Morceaux</h1>

    <section class="mb-8">
      <h2 class="text-2xl font-bold mb-4">API MusicBrainz</h2>
      <p class="text-lg text-gray-700 leading-relaxed">
        MusicBrain est une API utilisée pour rechercher des informations sur les
        morceaux et les artistes. Vous pouvez accéder à l'API MusicBrainz en
        utilisant le lien suivant :
      </p>
      <p>
        <a
          href="https://musicbrainz.org/ws/2/release?artist=${artistId}&fmt=json&inc=recordings"
          class="text-neutral-800 font-bold ml-10 mt-2 inline-block"
          target="_blank"
          rel="noopener noreferrer"
        >
          https://musicbrainz.org/ws/2/release?artist=${artistId}&fmt=json&inc=recordings
        </a>
      </p>
    </section>

    <section>
      <h2 class="text-2xl font-bold mb-4">API Cover Art Archive</h2>
      <p class="text-lg text-gray-700 leading-relaxed">
        Cover Art Archive est une API utilisée pour obtenir les couvertures
        d'albums. Vous pouvez accéder à l'API Cover Art Archive en utilisant le
        lien suivant :
      </p>
      <p>
        <a
          href="https://coverartarchive.org/release/${albumId}"
          class="text-neutral-800 font-bold ml-10 mt-2 inline-block"
          target="_blank"
          rel="noopener noreferrer"
        >
          https://coverartarchive.org/release/${albumId}
        </a>
      </p>
    </section>
  </main>
</template>

<style scoped>
/* Vous pouvez ajouter des styles personnalisés si nécessaire */
</style>

<style scoped></style>
