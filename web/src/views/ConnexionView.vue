<script>
import Cookies from 'js-cookie';
import {SERIES, SERIES_IMAGE, SIGNIN} from "@/apiLiens.js";
import togglePassword from '@/components/togglePasseword.vue';


export default {
  components: {
    togglePassword
  },

  data() {
    return {
      isConnected: false,
      showError: false,
      showPassword: false,
      email: '',
      password: '',
      isMail: true,
      isFill: true,
      emailTouched: false
    };
  },
  methods: {
    /**
     * Permet de se connecter à l'application fetch l'api d'autehntification
     * @returns {void} - return true si connecté et false sinon
     */
    async login() {
      const email = this.email;
      const password = this.password;

      if (email.trim() === '' || password.trim() === '') {
        console.error('Veuillez entrer votre email et votre mot de passe');
        this.isFill = false;
        return;
      }

      try {
        const response = await fetch(SIGNIN, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Basic ' + btoa(`${email}:${password}`),
          },
        });
        const responseData = await response.json();
        if (response.status !== 200) {
          this.showError = true;
        } else {

          if (responseData && responseData.message === "401 Authentification failed") {
            console.error('Échec de la connexion');
            this.isConnected = false;
            this.showError = true;
          } else {
            // Récupérer l'expiration du cookie de la réponse si elle est disponible
            const expiresIn = (((responseData.expiration) / 3600) / 24);//expire au bout de 12h
            //const expiresIn = (((60)/3600)/24); //expire au bout de 2 min

            const accessToken = responseData.access_token;
            if (!accessToken) {
              console.error('Erreur lors de la récupération de l\'access token');
              this.showError = true;
              return;
            }
            Cookies.set('accessToken', accessToken, {expires: expiresIn});

            this.isConnected = true;
            this.showError = false;
            this.resetFields();
            window.location.reload()
          }

        }
      } catch (error) {
        console.error('Erreur lors de la connexion:', error);
      }
    },

    /**
     * Permet de réinitialiser les champs email et password
     * @returns {void}
     */
    resetFields() {
      this.email = '';
      this.password = '';
    },

    /**
     * Permet de basculer entre l'affichage du mot de passe en clair et masqué
     * @returns {void} - return true si le passeport est valide, false sinon
     */
    togglePassword() {
      this.showPassword = !this.showPassword;
    },

    /**
     * Permet de vérifier si l'email est valide
     * @param {string} email - email à vérifier
     * @returns {boolean} - return true si l'email est valide, false sinon
     */
    verifEmail(email) {
      if (this.emailTouched && email.trim() !== '') {
        const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return emailRegex.test(email);
      }
      return true;
    },

  },

}
</script>

<template>
  <div
      class="bg-gray-700 flex flex-col justify-center p-8 drop-shadow-[0_8px_4px_rgba(34,0,4,6)] rounded-xl m-auto mb-8 mt-8">
      <div v-if="showError" class="flex flex-col items-center p-2 rounded-2xl mb-2">
        <p class="text-[# #c92222]text-xl font-bold ">La connexion a échoué, le nom d'utilisateur</p>
        <p class="text-red-700 text-xl font-bold ">ou le mot de passe sont erronés</p>
      </div>
    <div>
      <p class="text-white mb-1">Votre e-mail</p>
      <input v-model="email" class="w-full mb-2.5 p-1 rounded-lg border-4" type="text" placeholder="prenom.nom@mail.com"
             @input="emailTouched = true">
    </div>
    <div>
      <p class="text-white mb-1">Mot de passe</p>
      <div>
        <input v-if="!showPassword" ref="passwordInput" v-model="password" class="w-full mb-2.5 p-1 rounded-lg border-4" type="password" placeholder="djul58sjuolpo" @keyup.enter="login">
        <input v-else ref="passwordInput" v-model="password" class="w-full mb-2.5 p-1 rounded-lg border-4" type="text" placeholder="djul58sjuolpo" @keyup.enter="login">
        <div>
          <togglePassword :showPassword="showPassword" @toggle="togglePassword" />
        </div>
        <p v-if="!verifEmail(email)" class="text-red-700 font-bold mb-2">Email invalide</p>
      </div>
    </div>
    <RouterLink to="/">
    <button :disabled="!verifEmail(email) || password === ''" @click="login"
            class="text-white text-2xl font-bold mt-4 py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 disabled:opacity-50 disabled:bg-gray-400 disabled:hover:bg-gray-400 disabled:cursor-not-allowed">
      Je me connecte
    </button>
    </RouterLink>
    <RouterLink to="/inscription">
      <button
          class="bg-stone-400 text-zinc-600 hover:bg-blue-500 hover:text-zinc-900  py-2 px-4 rounded-xl mt-10 ml-14">
        Je n'ai pas de compte
      </button>
    </RouterLink>
  </div>
  <div v-if="showError" class="flex flex-col items-center p-2 rounded-2xl mb-2">
    <p class="text-[# #c92222]text-xl font-bold ">La connexion a échoué, le nom d'utilisateur</p>
    <p class="text-red-700 text-xl font-bold ">ou le mot de passe sont erronés</p>
  </div>
  <div v-else-if="isConnected" class="flex flex-col items-center p-8 rounded-2xl m-auto">
    <p class="text-green-600 text-xl font-bold ">Connexion réussie</p>
  </div>
  <div v-else-if="!isConnected && !isFill" class="flex flex-col items-center p-8 rounded-2xl m-auto">
    <p class="text-gray-400 text-xl font-bold ">Veuillez rentrer un email et un mot de passe</p>
  </div>
</template>
