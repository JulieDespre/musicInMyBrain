<script>
export default {

}
</script>

<template>
  <img class="w-28 mb-8 mt-4" src="@/components/icons/globe.png" alt="logo">
  <button class="w-full bg-blue-500 text-white text-2xl font-bold py-2 px-4 rounded-xl hover:bg-blue-800 m-1">
    <RouterLink to="/">Home</RouterLink>
  </button>
  <button class="w-full bg-blue-500 text-white text-2xl font-bold py-2 px-4 rounded-xl hover:bg-blue-800 m-1">
    <RouterLink to="/map">Map</RouterLink>
  </button>
  <button class="w-full bg-blue-500 text-white text-2xl font-bold py-2 px-4 rounded-xl hover:bg-blue-800 m-1">
    <RouterLink to="/inscription">Inscription</RouterLink>
  </button>
  <button class="w-full bg-blue-500 text-white text-2xl font-bold py-2 rounded-xl hover:bg-blue-800 m-1">
    <RouterLink to="/connexion">Connexion</RouterLink>
  </button>
</template>