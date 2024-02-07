<script setup>
import {RouterLink, RouterView} from 'vue-router'
</script>

<template>
  <header class="border-r-2 w-2/12 text-white bg-blue-900 h-screen ">
    <nav class="flex flex-col items-center">
      <div class="hover:bg-white hover:text-blue-900 p-2">
        <RouterLink to="/">
          <button class="h-full w-full">Home</button>
        </RouterLink>
      </div>
      <div class="hover:bg-white hover:text-blue-900 p-2">
        <RouterLink to="/map">
          <button class="h-full w-full">Map</button>
        </RouterLink>
      </div>
      <div class="hover:bg-white hover:text-blue-900 p-2">
        <RouterLink to="/inscription">
          <button class="h-full w-full">Inscription</button>
        </RouterLink>
      </div>
      <div class="hover:bg-white hover:text-blue-900 p-2">
        <RouterLink to="/connexion">
          <button class="h-full w-full">Connexion</button>
        </RouterLink>
      </div>
    </nav>
  </header>

  <RouterView/>
</template>
