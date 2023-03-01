<script setup>
import BaseView from "../BaseView.vue";
import ItemCard from "./components/ItemCard.vue";
</script>
<template>
  <base-view title="Equipment">
    <div class="grid grid-cols-12 gap-4">
      <div
        class="pt-[100%] card bg-slate-400 drop-shadow-xl relative justify-center align-middle"
      >
        <div
          class="absolute top-0 left-0 w-full h-full flex justify-center items-center"
        >
          <font-awesome-icon icon="fa-solid fa-plus fa-lg" class="text-4xl" />
        </div>
      </div>
      <item-card></item-card>
    </div>
  </base-view>
</template>
