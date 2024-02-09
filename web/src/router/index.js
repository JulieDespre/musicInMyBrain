import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import MapTest from '@/components/MapTest.vue'
import ConnexionView from "@/views/ConnexionView.vue";
import InscriptionView from "@/views/InscriptionView.vue";
import Page404 from '@/views/Page_404.vue'
import GameModeView from '@/views/GameModeView.vue';
import RestartGameView from '@/views/RestartGameView.vue'
import Guess from "@/components/Guess.vue";
import SelectGameMenu from "@/components/SelectGameMenu.vue";
import monCompteView from "@/views/monCompteView.vue";
import EndGame from "@/components/EndGame.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/connexion',
      name: 'connexion',
      component: ConnexionView
    },
    {
      path: '/inscription',
      name: 'inscription',
      component: InscriptionView
    },
    {
      path: '/map',
      name: 'map',
      component: MapTest
    },
    {
      path: '/gamemode',
      name: 'map',
      component: GameModeView
    },
    {
      path: '/restartgame',
      name: 'restartgame',
      component: RestartGameView
    },
    {
      path: '/selectgame',
      name: 'selectgame',
      component: SelectGameMenu
    },

    {
      path: '/play/:difficulte/:id',
      name: 'play',
      component: Guess

    },
    {
      path: '/play/:id_game',
      name: 'replay',
      component: Guess
    },
    {
      path: '/endgame/:id_game',
      name: 'endgame',
      component: EndGame
    },

    {
      path: '/monCompte',
      name: 'monCompte',
      component: monCompteView
    },

    {
      path: '/:pathMatch(.*)',
      name: 'page404',
      component: Page404
    }
  ]
})

export default router
