<script setup>
import Session from "./Session.vue";
import { defineProps } from "vue";
const props = defineProps({
  index: Number,
  countSessions: {
    type: Number,
    default: 7,
  },
});
</script>
<template>
  <div class="flex space-x-2 justify-end h-fit">
    <div class="bg-red-400 w-8 min-h-full relative">
      <p
        class="w-28 text-center origin-center absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 -rotate-90"
      >
        {{ `week ${index}` }}
      </p>
    </div>
    <Session
      class="flex-1 min-h-[7rem]"
      v-for="n in 7"
      :class="{ '!bg-slate-400': n > countSessions }"
      :index="n * index"
    ></Session>
  </div>
</template>
