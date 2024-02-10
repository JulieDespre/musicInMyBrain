import './assets/main.css'

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import Toaster from "@meforma/vue-toaster";

const app = createApp(App);

app.use(router);
app.use(Toaster);

const vue = app.mount('#app');



export const ws = new WebSocket('ws://docketu.iutnc.univ-lorraine.fr:35201');

ws.onmessage = function(event) {
    if (event.data instanceof Blob) {
        event.data.text().then(function(text) {
            // Utiliser app.config.globalProperties.$toast.success() pour afficher la notification toast
            app.config.globalProperties.$toast.success(text);
        });
    } else {
        console.log("Message reçu :", event.data);
    }
};





