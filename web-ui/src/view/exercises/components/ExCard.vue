<script setup>
const props = defineProps(["name", "level", "muscles"]);
</script>
<template>
  <div
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
  >
    <a href="#">
      <img
        class="rounded-t-lg"
        src="@/assets/images/test-exe.png"
        alt="image"
      />
    </a>
    <div class="grid grid-cols-3 gap-2 p-4">
      <div class="grid grid-rows-3 col-span-2 auto-rows-fr">
        <div class="grid grid-cols-4 items-center justify-center gap-1">
          <img
            src="@/assets/images/chest.png"
            class="w-10 object-contain"
            alt="muscle"
          />
          <img
            src="@/assets/images/chest.png"
            class="w-10 object-contain"
            alt="muscle"
          />
        </div>
        <div></div>
        <div class="text-md font-semibold truncate">{{ props.name }}</div>
      </div>
      <div class="grid grid-rows-3 items-center justify-right">
        <div>
          <div
            class="bg-blue-100 text-blue-800 text-xs text-center font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
          >
            {{ props.level }}
          </div>
        </div>
        <div></div>
      </div>
    </div>
  </div>
</template>
