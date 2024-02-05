import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import MapView from '@/views/MapView.vue'
import ConnexionView from "@/views/ConnexionView.vue";
import InscriptionView from "@/views/InscriptionView.vue";
import Map from '@/components/Map.vue'
import Page404 from '@/views/Page_404.vue'

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
      component: Map
    },
    {
      path: '/:pathMatch(.*)',
      name: 'page404',
      component: Page404
    }
  ]
})

export default router
