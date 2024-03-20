<script>
import { RouterLink, RouterView } from "vue-router";
import HelloWorld from "./components/HelloWorld.vue";
import Footer from "@/views/Footer.vue";
import Search from "@/components/Search.vue";
import MorceauSearch from "@/components/MorceauSearch.vue";
import ArtistSearch from "@/components/ArtistSearch.vue";

export default {
  components: {
    HelloWorld,
    RouterLink,
    RouterView,
    Footer,
    Search,
    MorceauSearch, // Déclarez le composant MorceauSearch
    ArtistSearch,
  },

  data() {
    return {
      resetOffset: Function,
      trackResults: [],
      searchQuery: "", // Définissez la propriété searchQuery
      searchType: "tracks", // Définissez la propriété searchType avec une valeur par défaut
      searchBy: "title", //
    };
  },
};
</script>

<template>
  <header class="mt-10 flex max-sm:flex-col max-lg:flex-row pr-5">
    <img
      alt="Vue logo"
      class="logo"
      src="@/assets/logo.png"
      width="125"
      height="125"
    />

    <div class="wrapper">
      <HelloWorld
        msg="Bienvenue sur Music in my Brain"
        class="text-neutral-300"
      />

      <nav class="navbar ml-8">
        <div class="nav-links justify-center max-sm:mx-auto">
          <router-link class="nav-link" to="/">
            <button
              class="btn btn-nav px-4 py-2 rounded-lg max-sm:text-sm max-xs:text-xs"
            >
              Accueil
            </button>
          </router-link>
          <router-link class="nav-link" to="/search">
            <button class="btn btn-nav px-4 py-2 rounded-lg max-sm:text-sm">
              Recherche
            </button>
          </router-link>
          <router-link class="nav-link" to="/about">
            <button class="btn btn-nav px-4 py-2 rounded-lg max-sm:text-sm">
              A propos
            </button>
          </router-link>
        </div>
      </nav>
    </div>
  </header>

  <RouterView />
  <Footer />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 100px) and (max-width: 350px) {
  .nav-links {
    justify-content: center; /* Centrer les boutons */
  }
}

@media (min-width: 420px) {
  .btn {
    font-size: 0.875rem; /* Taille du texte réduite pour les petits écrans */
  }
}

@media (min-width: 810px) {
  .btn {
    font-size: 1rem; /* Taille du texte normale pour les écrans moyens */
  }
  header {
    justify-content: center;
  }

  .logo {
    width: 150px;
    margin: 0 1rem 0 0; /* Réduire la marge à droite de l'image */
  }

  header .wrapper {
    margin-top: 1rem; /* Réduire l'espace en haut du wrapper */
  }
}

@media (min-width: 1440px) {
  .btn {
    font-size: 1.125rem; /* Taille du texte légèrement augmentée pour les grands écrans */
  }
  header {
    justify-content: center;
  }

  .logo {
    width: 150px;
    margin: 0 1rem 0 0; /* Réduire la marge à droite de l'image */
  }

  header .wrapper {
    margin-top: 1rem; /* Réduire l'espace en haut du wrapper */
  }
}

/* Supprimez les sélecteurs CSS actuels */

.btn {
  display: block;
  margin: 0 auto;
  margin-top: 20px;
  background-color: #6962ad;
  color: #83c0c1;
  font-size: 1.5rem;
  font-weight: bold;
  transition: 0.3s;
  cursor: pointer;
  border: none;
  outline: none;
}

.btn:hover {
  background-color: #d4d4d4; /* Couleur de fond gris clair au survol */
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-links {
  display: flex;
}

.navbar-brand,
.nav-link {
  margin-right: 1rem;
}

@media screen and (max-width: 502px) {
  .btn {
    font-size: 20px; /* Taille de la police pour les écrans jusqu'à 502px de large */
  }
  footer {
    font-size: 12px;
  }
}
</style>
