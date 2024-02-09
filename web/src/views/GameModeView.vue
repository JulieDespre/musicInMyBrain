<script>
export default {
  data() {
    return {}
  }
}
</script>

<template>
  <div class="h-screen flex flex-row justify-around">
    <router-link to="/selectgame" tag="button">
      <button class="bg-blue-300 border-8 border-blue-700 hover:border-blue-900 p-20 mt-20 text-blue-700 rounded-xl hover:text-blue-900 font-bold text-xl">Commencer une nouvelle partie</button>
    </router-link>
    <router-link to="/restartgame" tag="button">
      <button class="bg-blue-300 border-8 border-blue-700 hover:border-blue-900 p-20 mt-20 text-blue-700 rounded-xl hover:text-blue-900 font-bold text-xl">Redémarrer une partie</button>
    </router-link>
  </div>
</template>