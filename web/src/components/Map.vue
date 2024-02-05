<script >
import  'leaflet/dist/leaflet.css';
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';
export default {
  components: {
    LMap,
    LTileLayer,
    LMarker
  },
  data() {
    return {
      osmURL: 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      //centre de la carte identifié par des coordonnées : [latitude, longitude]
      center: [48.69, 6.18],
      //niveau de zoom initial
      zoom: 13,
      //niveau de zoom maximal et minimal
      maxZoom: 18,
      minZoom: 1,
      //tableau d'objets identifiés par un id et contenant les coordonnées des marqueur
      markers:{
      }

    }

  },

}
</script>

<template>
  <div class="mapbox">
    <h1>Test Map</h1>
    <l-map
        ref="map"
        class="map"
        v-model:zoom="zoom"
        v-model:center="center"
        :max-zoom="maxZoom"
        :min-zoom="minZoom"
        :zoom-control="false"
        :use-global-leaflet="false"
    >

      <l-tile-layer :url="osmURL"></l-tile-layer>

      <!--boucle sur le tableau markers pour afficher les marqueurs-->
      <l-marker
          v-for="(marker, index) in markers"
          :key="index"
          :lat-lng="marker.coordinates"/>
    </l-map>
  </div>
</template>

<style scoped>
.mapbox {
  position: relative;
  margin: auto;
  width: 700px;
  height: 500px;
}
.map {
  position: absolute;
}

h1 {
  font-weight: 500;
  font-size: 2.6rem;
}

</style>
