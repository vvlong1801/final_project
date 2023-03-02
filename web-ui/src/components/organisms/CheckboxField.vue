<script setup>
const props = defineProps(["label", "modelValue"]);
</script>
<template>
  <div class="flex items-center">
    <label
      :for="props.name"
      class="text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
    >
      <input
        :id="props.name"
        type="checkbox"
        :value="props.modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      />
      <span class="ml-2">{{ props.label }}</span>
    </label>
  </div>
</template>
