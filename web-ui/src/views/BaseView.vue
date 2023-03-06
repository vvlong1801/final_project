<script setup>
import { defineProps } from "vue";
const props = defineProps({
  title: {
    type: String,
    required: false,
  },
});
</script>
<template>
  <div class="flex flex-col gap-6 absolute top-0 left-0 w-full">
    <div class="page-header">
      <h4 v-if="props.title" class="text-2xl font-semibold">
        {{ props.title }}
      </h4>
    </div>

    <div class="page-content">
      <slot></slot>
    </div>
  </div>
</template>
