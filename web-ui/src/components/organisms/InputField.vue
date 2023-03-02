<script setup>
// import ValidationError from "../atoms/ValidationError.vue";

const props = defineProps([
  "label",
  "modelValue",
  "errors",
  "required",
  "type",
]);
</script>
<template>
  <div class="w-full">
    <label
      :for="props.name"
      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize"
    >
      <span>{{ props.label }}</span>
      <sup
        class="font-medium text-red-700 dark:text-danger-400 ml-1"
        v-if="required"
        >*</sup
      >
    </label>
    <input
      :type="props.type ?? 'text'"
      :id="props.name"
      :value="props.modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    />
    <validation-error
      :errors="props.errors"
      :field="props.name"
      class="text-sm"
    ></validation-error>
  </div>
</template>
