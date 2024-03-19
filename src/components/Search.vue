<script>
export default {
  props: {
    resetOffset: Function,
    trackResults: Array,
  },
  data() {
    return {
      artistQuery: "",
      MorceauQuery: "",
    };
  },
  methods: {
    reset() {
      this.$emit("search", this.artistQuery, this.MorceauQuery);
    },
    search() {
      this.resetOffset();
      this.$emit("search", this.artistQuery, this.MorceauQuery);
    },
  },
};
</script>

<template>
  <div
    class="search-bar flex lg:flex-row max-sm:flex-col items-center justify-center mt-8"
  >
    <img src="@/components/icons/vinyle.png" alt="image vinyle" class="w-80" />

    <div
      class="search-bar flex flex-col items-center justify-center mt-8 mb-14 mx-10"
    >
      <div class="form-control mr-2 mb-2 sm:mb-0 sm:mr-2">
        <div class="flex flex-col">
          <input
            @keyup.enter="search"
            type="text"
            required=""
            v-model="MorceauQuery"
            class="py-2 px-1 rounded-lg border-gray-300"
          />
          <label>
            <span style="transition-delay: 0ms">M</span>
            <span style="transition-delay: 50ms">o</span>
            <span style="transition-delay: 100ms">r</span>
            <span style="transition-delay: 150ms">c</span>
            <span style="transition-delay: 200ms">e</span>
            <span style="transition-delay: 250ms">a</span>
            <span style="transition-delay: 300ms">u</span>
          </label>
        </div>
      </div>

      <p class="text-2xl text-gray-400">OU</p>

      <div class="form-control mr-2 mb-2 sm:mb-0 sm:mr-2">
        <input
          @keyup.enter="search"
          type="text"
          required=""
          v-model="artistQuery"
          class="py-2 px-4 rounded-lg border-gray-300"
        />
        <label>
          <span style="transition-delay: 0ms">A</span>
          <span style="transition-delay: 50ms">r</span>
          <span style="transition-delay: 100ms">t</span>
          <span style="transition-delay: 150ms">i</span>
          <span style="transition-delay: 200ms">s</span>
          <span style="transition-delay: 250ms">t</span>
          <span style="transition-delay: 300ms">e</span>
        </label>
      </div>

      <button
        @click="search"
        @keyup.enter="search"
        class="pushable marker:py-2 px-4 bg-neutral-500 text-white rounded-lg focus:outline-none hover:bg-neutral-200 hover:text-neutral-800"
      >
        <span class="shadow"></span>
        <span class="edge"></span>
        <span class="front"> Rechercher </span>
      </button>

      <div class="relative mb-2 sm:mb-0">
        <div class="absolute inset-y-0 right-0 flex items-center pr-3"></div>
      </div>
    </div>
  </div>
</template>
<style scoped>
img {
  margin-left: auto;
  margin-right: auto;
}
.form-control {
  position: relative;
  margin: 20px 0 40px;
  width: 190px;
}

.form-control input {
  background-color: transparent;
  border: 0;
  border-bottom: 2px #fff solid;
  display: block;
  width: 100%;
  padding: 15px 0;
  font-size: 18px;
  color: #fff;
}

.form-control input:focus,
.form-control input:valid {
  outline: 0;
  border-bottom-color: lightblue;
}

.form-control label {
  position: absolute;
  top: 15px;
  left: 0;
  pointer-events: none;
}

.form-control label span {
  display: inline-block;
  font-size: 18px;
  min-width: 5px;
  color: #fff;
  transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.form-control input:focus + label span,
.form-control input:valid + label span {
  color: lightblue;
  transform: translateY(-30px);
}
.pushable {
  position: relative;
  background: transparent;
  padding: 0px;
  border: none;
  cursor: pointer;
  outline-offset: 4px;
  outline-color: deeppink;
  transition: filter 250ms;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

.shadow {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: hsl(226, 25%, 69%);
  border-radius: 8px;
  filter: blur(2px);
  will-change: transform;
  transform: translateY(2px);
  transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
}

.edge {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  border-radius: 8px;
  background: linear-gradient(
    to right,
    hsl(248, 39%, 39%) 0%,
    hsl(248, 39%, 49%) 8%,
    hsl(248, 39%, 39%) 92%,
    hsl(248, 39%, 29%) 100%
  );
}

.front {
  display: block;
  position: relative;
  border-radius: 8px;
  background: hsl(248, 53%, 58%);
  padding: 16px 32px;
  color: white;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-size: 1rem;
  transform: translateY(-4px);
  transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
}

.pushable:hover {
  filter: brightness(110%);
}

.pushable:hover .front {
  transform: translateY(-6px);
  transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
}

.pushable:active .front {
  transform: translateY(-2px);
  transition: transform 34ms;
}

.pushable:hover .shadow {
  transform: translateY(4px);
  transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
}

.pushable:active .shadow {
  transform: translateY(1px);
  transition: transform 34ms;
}

.pushable:focus:not(:focus-visible) {
  outline: none;
}
</style>
