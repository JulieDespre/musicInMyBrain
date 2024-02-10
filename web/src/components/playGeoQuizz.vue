<script setup>
import { ref } from 'vue';

const showRules = ref(false);

//pour changer la valeur de showRules et donc afficher ou non les règles du jeu
/**
 * Permet de basculer entre l'affichage des règles du jeu et le jeu lui-même
 * @returns {void} - return true si le passeport est valide, false sinon
 */
const toggleRules = () => {
  showRules.value = !showRules.value;
}

defineProps({})
</script>

<template>

  <div ref="connectedUserDiv" class=" mx-20 justify-between rounded-xl flex flex-row overflow-hidden mt-5 ">
    <img src="@/components/icons/info.png" alt="Logo Regles" @click="toggleRules" class="min-h-10 min-w-10 h-12 w-12 cursor-pointer">
  </div>

  <div class="flex justify-center items-center">

    <div class="align-middle drop-shadow-[0_8px_4px_rgba(34,0,4,6)] justify-between rounded-xl flex flex-row overflow-hidden my-4">

      <div v-if="showRules" class="playGeoQuizz max-h-[600px]  max-w-[600px]  m-auto rounded-xl flex flex-col overflow-hidden border-2 border-gray-100 my-8 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] flip-transition flip-front ">
        <!-- Contenu des règles du jeu -->
        <div class="flex flex-col bg-stone-400 text-zinc-900 text-center pb-5 pt-5">
          <!-- Texte des règles du jeu -->

          <div class="flex flex-col py-5 ">
          <h1 class="text-center xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl text-blue-400 font-extrabold drop-shadow-[0_2px_4px_rgba(36,29,0,65)]"> Bienvenu sur GéoQuizz !</h1>
          <h1 class="text-center  xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl font-extrabold"> Le jeu qui test des connaissances sur différentes villes</h1>
          </div>
          <h1 class="text-left pt-2 ml-5 xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl font-extrabold w-full bg"> Règles du jeu : </h1>

          <h3 class="p-4">Le jeu se déroule autour de la localisation de divers lieux emblématiques au sein de différentes villes, le tout sur une carte virtuelle.
            Chaque lieu est accompagné d'une photo, le défi est alors pour le joueur de placer avec le plus de précision possible un marqueur sur la carte, indiquant l'endroit où il estime que ce lieu spécifique se trouve dans la ville sélectionnée. Cela demande à la fois une connaissance géographique et une capacité à interpréter les indices visuels pour réussir à identifier correctement l'emplacement de chaque lieu sur la carte.</h3>
        </div>

      </div>

      <div v-else class="playGeoQuizz w-fit max-h-[600px]  max-w-[600px]  rounded-xl flex flex-col overflow-hidden border-2 border-gray-100 my-8 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] flip-transition  ">
        <!-- Contenu du jeu -->
        <div class="flex flex-col bg-stone-400 text-zinc-900">
          <!-- Image -->
          <img class="h-fit" src="@/components/icons/fondAcc.jpg" alt="imageAcc">
          <!-- Texte en dessous de l'image -->
          <p class="text-center py-5 xl:text-4xl lg:text-3xl md:text-2xl sm:text-xl font-extrabold">Tester vos connaissances !</p>
        </div>
      </div>

    </div>

  </div>
</template>



<style scoped>
.flip-transition {
  transition: transform 0.5s ease;
}

.flip-front {
  transform: rotateY(0deg);
}

.flip-back {
  transform: rotateY(180deg);
}
</style>
