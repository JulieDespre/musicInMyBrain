<script setup>


defineProps({})
</script>

<template>
  <div ref="connectedUserDiv" class="w-fit drop-shadow-[0_8px_4px_rgba(34,0,4,6)] mx-10 justify-between rounded-xl flex flex-row overflow-hidden  my-4 ">
    <div class="playGeoQuizz w-full mr-10 rounded-xl flex flex-col overflow-hidden border-2 border-gray-100  my-8 drop-shadow-[0_8px_4px_rgba(34,0,4,6)]">

      <!-- Contenu à gauche (image et texte) -->
      <div class="flex flex-col h-full bg-stone-400 text-zinc-900">
        <!-- Image -->
        <h2  class="text-center py-5 xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl font-extrabold  "> Règles du jeu </h2>
        <p class="p-4">Le jeu consiste à placer localiser des lieux de villes sur une carte.
          Les lieux sont représentés par des photos et l'on doit placer sur une carte un marqueur correspondant à l'endroit où l'on pense qu ele lieu se trouve dans la ville choisie </p>

      </div>
    </div>

    <div class="playGeoQuizz w-full h-full rounded-xl flex flex-col overflow-hidden border-2 border-gray-100 my-8 drop-shadow-[0_8px_4px_rgba(34,0,4,6)]">

      <!-- Contenu à gauche (image et texte) -->
      <div class="flex flex-col bg-stone-400 text-zinc-900">
        <!-- Image -->
        <img class="h-1/2" src="@/components/icons/fondAcc.jpg" alt="imageAcc">

        <!-- Texte en dessous de l'image -->
        <p class="text-center py-5 xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl font-extrabold">Tester vos connaissances !</p>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
