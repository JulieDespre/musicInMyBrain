import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Page404 from "@/views/Page404.vue";
import SearchView from "@/views/SearchView.vue";
import ArtistResultsView from "@/views/ArtistResultsView.vue";
import MorceauResultsViews from "@/views/MorceauResultsViews.vue";
import AboutView from "@/views/AboutView.vue";
import Footer from "@/views/Footer.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/footer",
      name: "footer",
      component: Footer,
    },
    {
      path: "/search",
      name: "search",
      component: SearchView,
    },
    {
      path: "/artiste/:id",
      name: "artiste",
      component: ArtistResultsView,
    },
    {
      path: "/morceau/:id",
      name: "morceau",
      component: MorceauResultsViews,
    },
    {
      path: "/about",
      name: "about",
      component: AboutView,
    },
    {
      path: "/:pathMatch(.*)",
      name: "Page404",
      component: Page404,
    },
  ],
});

export default router;
