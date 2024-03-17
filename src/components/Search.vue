<script>
export default {
  props: {
    resetOffset: Function,
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
    class="search-bar flex lg:flex-row sm:flex-col items-center justify-center mt-8"
  >
    <img src="@/components/icons/vinyle.png" alt="image vinyle" class="w-80" />

    <div
      class="search-bar flex flex-col sm:flex-row items-center justify-center mt-8"
    >
      <div class="form-control mr-2 mb-2 sm:mb-0 sm:mr-2">
        <input
          type="text"
          required=""
          v-model="MorceauQuery"
          class="py-2 px-4 rounded-lg border-gray-300"
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

    <div class="form-control mr-2 mb-2 sm:mb-0 sm:mr-2">
      <input
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
      @keydown.enter="search"
      class="py-2 px-4 bg-red-500 text-white rounded-lg focus:outline-none hover:bg-blue-700"
    >
      Rechercher
    </button>
    <div class="relative mb-2 sm:mb-0">
      <div class="absolute inset-y-0 right-0 flex items-center pr-3"></div>
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
</style>
