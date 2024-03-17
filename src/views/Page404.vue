<script>
export default {
  props: {
    msg: String,
  },
};
</script>

<template>
  <div class="greetings">
    <div class="ml-52">
      <div class="glitch" data-text="404 ... Oups! ">404 ... Oups!</div>
      <div class="glitch" data-text="Nous ne trouvons pas la page recherchée. ">
        Nous ne trouvons pas la page recherchée.
      </div>
    </div>
    <img src="@/components/icons/page404.jpg" alt="Page404" class="logo" />
    <router-link to="/">Retour vers l'accueil</router-link>
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
  font-size: 60px;
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
  left: 0;
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
