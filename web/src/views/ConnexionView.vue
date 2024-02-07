<script>

export default {
  data() {
    return {
      isConnected: true,
      showError: false,
      showPassword: false,
      email: '',
      password: '',
    };
  },
  methods:{
    /**
     * fontion pour afficher ou masquer le mot de passe
     * @returns {void} - Affiche ou masque le mot de passe
     */
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
      const passwordInput = this.$refs.passwordInput;
      passwordInput.type = this.showPassword ? 'text' : 'password';
    },

    /**
     * Fonction pour s'authentifier, fetch l'api pour vérifier si l'utilisateur est bien inscrit
     * @returns {void} - Authentifie l'utilisateur
     */
    async login() {
      // Récupérer les valeurs des champs d'entrée
      const email = this.$refs.emailInput.value;
      const password = this.$refs.passwordInput.value;

      // const credentials = btoa(`${email}:${password}`);

      // Envoyer les données d'identification au serveur pour authentification
      try {
        const response = await fetch('http://docketu.iutnc.univ-lorraine.fr:35200/signin', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Basic ' + btoa(email + ':' + password)

          },
        });

        // Vérifier la réponse du serveur
        if (response.message === 401) {
          const data = await response.json();
          console.log('Réponse du serveur:', data);
          // Authentification réussie
          console.log('Connexion réussie');
          this.isConnected = true;
          this.showError = false;

        } else {
          // Authentification échouée
          console.error('Échec de la connexion');
          console.log("Authentification a échoué, le nom utilisateur ou le mot de passe sont erronés");
          this.isConnected = false;
          this.showError = true;

        }
      } catch (error) {
        console.error('Erreur lors de la connexion:', error);
      }
    },
    /**
     * Réinitialiser les champs d'entrée avant de quitter le composant
     * @returns {void} - Réinitialise les champs d'entrée
     */
    resetFields() {
      this.email = '';
      this.password = '';
    }

  },
}

</script>


<template>
  <div class="bg-gray-700 flex flex-col justify-center p-8 rounded-2xl m-auto">
    <div>
      <p class="text-white">Votre e-mail :</p>
      <input ref="emailInput" class="w-60 mb-2.5 p-1 rounded-lg" type="text" placeholder="Votre e-mail ...">
    </div>
    <div>
      <p class="text-white">Mot de passe :</p>
      <input ref="passwordInput" class="w-60 mb-2.5 p-1 rounded-lg" type="password" placeholder="Votre mot de passe ..." @keyup.enter="login">
      <button @click="togglePasswordVisibility" class="flex items-start ml-52 focus:outline-none">
        <img v-if="!showPassword" src="@/components/icons/invisible.png" alt="Masquer mot de passe" class="h-5 w-5 bg-transparent">
        <img v-else src="@/components/icons/visible.png" alt="Afficher mot de passe" class="h-5 w-5 bg-transparent">
      </button>
    </div>
      <button @click="login" class="text-white text-2xl font-bold mt-4 py-2 px-4 rounded-xl bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80">
         Je me connecte
      </button>
    </div>
  <div v-if="!isConnected" class="flex flex-col items-center p-8 rounded-2xl m-auto">
    <p class="text-red-500 text-xl font-bold ">La connexion a échoué, le nom d'utilisateur</p>
    <p class="text-red-500 text-xl font-bold ">ou le mot de passe sont erronés</p>
  </div>
</template>