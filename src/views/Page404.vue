<script>
export default {
  props: {
    msg: String,
  },
};
</script>

<template>
  <div class="greetings h-full mb-10">
    <div class="text-center">
      <div class="text-7xl font-bold text-gray-400 mt-4 mb-4">
        404 ... Oups!
      </div>
      <img
        src="@/components/icons/page404.png"
        alt="Page404"
        class="logo rounded-lg w-96 h-96"
      />
      <div class="glitch-container">
        <div
          class="glitch"
          data-text="Nous ne trouvons pas la page recherchée. "
        >
          Nous ne trouvons pas la page recherchée.
        </div>
      </div>
    </div>
    <button class="retourAcc px-4 py-2 rounded-lg text-red mb-8">
      <router-link to="/">Retour vers l'accueil</router-link>
    </button>
  </div>
</template>

<style scoped>
h1 {
  font-weight: 500;
  font-size: 2.6rem;
  text-align: center;
}

.logo {
  display: block;
  margin: 0 auto;
}

@media (min-width: 1024px) {
  h1 {
    text-align: left;
  }
}
.glitch {
  position: relative;
  font-size: 40px;
  font-weight: bold;
  color: #ffffff;
  letter-spacing: 3px;
  z-index: 1;
}

.glitch:before,
.glitch:after {
  display: block;
  content: attr(data-text);
  position: absolute;
  top: 0;
  left: 0px;
  opacity: 0.8;
}

.glitch:before {
  animation: glitch-it 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
  color: #00ffff;
  z-index: -1;
}

.glitch:after {
  animation: glitch-it 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) reverse both
    infinite;
  color: #ff00ff;
  z-index: -2;
}

.retourAcc {
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

.glitch-container {
  width: 400px;
  height: 200px;
  margin: 0 auto;
}

@keyframes glitch-it {
  0% {
    transform: translate(0);
  }
  20% {
    transform: translate(-2px, 2px);
  }
  40% {
    transform: translate(-2px, -2px);
  }
  60% {
    transform: translate(2px, 2px);
  }
  80% {
    transform: translate(2px, -2px);
  }
  to {
    transform: translate(0);
  }
}
</style>
