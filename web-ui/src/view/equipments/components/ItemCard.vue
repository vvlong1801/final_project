<script setup>
import { ref } from "vue";
const showTitle = ref(false);
</script>
<template>
  <div
    class="bg-orange-300 pt-[100%] card shadow-xl shadow-orange-500/20 relative cursor-pointer"
  >
    <figure class="absolute top-0 left-0 p-2" @mouseover="showTitle = true">
      <img src="@/assets/images/equi-ta.png" alt="Shoes" />
    </figure>
    <div
      class="absolute z-10 top-0 left-0 bg-white opacity-80 w-full h-full rounded-2xl flex justify-center items-center"
      v-if="showTitle"
      @mouseleave="showTitle = false"
    >
      <div class="text-black font-semibold">title</div>
    </div>
  </div>
</template>
