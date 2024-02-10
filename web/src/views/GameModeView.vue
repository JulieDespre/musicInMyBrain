<script>
export default {
  data() {
    return {}
  }
}
</script>

<template>
  <div class="h-screen flex flex-row justify-evenly items-center mx-auto ">/
    <router-link to="/selectgame" tag="button" class="mr-10">
      <button class="max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-gray-400 via-gray-500 to-gray-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-gray-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">Nouvelle partie</button>
    </router-link>
    <router-link to="/restartgame" tag="button" class="">
      <button class="max-sm:text-xs max-sm:mr-1.5 sm:text-base text-white text-2xl font-bold py-2 px-4 rounded-xl bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 mr-3 hover:transition duration-300 ease-in-out transform hover:scale-105">Rejouer</button>
    </router-link>
  </div>

</template>
