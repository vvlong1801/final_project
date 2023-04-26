<script setup>
// const props = defineProps()
</script>
<template>
  <div
    class="flex-col space-y-2 shadow-default rounded border border-gray-300 p-2"
  >
    <div class="w-full rounded h-fit flex items-center">
      <img
        src="@/assets/images/panel.jpg"
        alt="xxx"
        class="w-12 h-12 rounded"
      />
      <div class="w-full px-2">
        <p class="text-base font-semibold">exercise name</p>
        <div>
          <span class="mr-2">set: 5</span>
          <span>rep: 10</span>
        </div>
      </div>
    </div>
    <div class="w-full rounded h-fit flex items-center">
      <img
        src="@/assets/images/panel.jpg"
        alt="xxx"
        class="w-12 h-12 rounded"
      />
      <div class="w-full px-2">
        <p class="text-base font-semibold">exercise name</p>
        <div>
          <span class="mr-2">set: 5</span>
          <span>rep: 10</span>
        </div>
      </div>
    </div>
    <div class="w-full rounded h-fit flex items-center">
      <img
        src="@/assets/images/panel.jpg"
        alt="xxx"
        class="w-12 h-12 rounded"
      />
      <div class="w-full px-2">
        <p class="text-base font-semibold">exercise name</p>
        <div>
          <span class="mr-2">set: 5</span>
          <span>rep: 10</span>
        </div>
      </div>
    </div>
    <div
      class="h-10 w-full bg-slate-100 border border-slate-300 rounded flex justify-center items-center"
    >
      <i class="pi pi-plus font-semibold text-sm"></i>
    </div>
  </div>
</template>
<style scoped>
.shadow-default {
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px,
    rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}
</style>
