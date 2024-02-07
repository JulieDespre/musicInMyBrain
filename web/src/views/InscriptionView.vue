<script>
export default {
  data() {
    return {
      email: null,
      pwd: null,
      pwdverif: null,
      inscriptionDone: false,
    }
  },
  methods: {
    /**
     * Méthode qui vérifie le format de l'email saisi par l'utilisateur
     * @param email email saisi par l'utilisateur
     * @return {boolean} vrai si email correspond au format tout en étant non null, faux sinon
     */
    verifEmail(email) {
      if (email !== null) {
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);
      }
    },

    /**
     * Méthode qui vérifie la cohérence entre les deux mots de passes saisis par l'utilisateur
     * @param pwd1 mot de passe saisi par l'utilisateur
     * @param pwd2 vérification du premier mot de passe
     * @return {boolean} vrai si les deux mots de passe correspondent et sont non null, faux sinon
     */
    verifMdp(pwd1, pwd2) {
      if ((pwd1 !== null) && (pwd2 !== null)) {
        return pwd1 === pwd2;
      }
    },

    /**
     * Méthode qui permet à l'utilisateur de finaliser son inscription qui son email a été vérifié et que ses mots de passe sont cohérents
     */
    finirInscription() {
      if (this.verifEmail(this.email) && this.verifMdp(this.pwd, this.pwdverif)) {
        this.inscriptionDone = true;
      }
    },
  }
}
</script>

<template>
  <div v-if="!inscriptionDone" class="bg-gray-700 flex flex-col justify-center p-8 rounded-2xl m-auto">
    <div>
      <p class="text-white">Votre e-mail :</p>
      <input v-model="email" class="w-60 mb-2.5 p-1 border-4" type="text"
             :class="{'border-red-700': verifEmail(this.email) === false}" placeholder="Votre e-mail ...">
      <p v-if="verifEmail(this.email) === false" class="text-red-700 font-bold mb-2">Email invalide</p>
    </div>
    <div>
      <p class="text-white">Mot de passe :</p>
      <input v-model="pwd" class="w-60 mb-2.5 p-1 border-4" type="password"
             :class="{'border-red-700': verifMdp(this.pwd, this.pwdverif) === false}"
             placeholder="Votre mot de passe ...">
    </div>
    <div>
      <p class="text-white">Confirmation du mot de passe :</p>
      <input v-model="pwdverif" class="w-60 mb-2.5 p-1 border-4" type="password"
             :class="{'border-red-700': verifMdp(this.pwd, this.pwdverif) === false}"
             placeholder="Votre mot de passe ...">
      <p v-if="verifMdp(this.pwd, this.pwdverif) === false" class="text-red-700 font-bold">Mots de passe
        incompatibles</p>
    </div>
    <button @click="finirInscription" class="bg-blue-400 text-white hover:opacity-70 font-bold py-2 px-4 rounded">Je
      m'inscris
    </button>
  </div>

  <div v-else class="bg-gray-700 flex flex-col justify-center p-8 rounded-2xl m-auto">
    <p class="text-white">Merci de votre inscription !</p>
  </div>

</template>