import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Page404 from "@/views/Page404.vue";
import SearchView from "@/views/SearchView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/search',
      name: 'search',
      component: SearchView
    },
    {
      path: '/artiste/:id',
      name: 'artiste',
      component: () => import('../views/SearchView.vue')
    },
    {
      path: '/morceau/:id',
      name: 'morceau',
      component: () => import('../views/SearchView.vue')
    },
    {
      path: "/:pathMatch(.*)",
      name: "Page404",
      component: Page404,
    },
  ]

})

export default router
