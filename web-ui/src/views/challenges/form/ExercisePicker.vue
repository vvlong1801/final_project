<script setup>
import { onMounted } from "vue";
import { useExercise } from "@/stores/exercise";

const pageIndex = 1;
const exerciseStore = useExercise();

onMounted(exerciseStore.getExercises);
</script>
<template>
  <div class="card flex flex-col gap-6">
    <Toolbar>
      <template #start>
        <Button label="Add" icon="pi pi-plus" class="mr-2" />
      </template>

      <template #end>
        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText placeholder="Search..." />
        </span>
      </template>
    </Toolbar>

    <div class="grid grid-cols-4 gap-6 z-0">
      <div
        class="relative"
        v-for="(exe, index) in exerciseStore.exercises"
        :key="index"
      >
        <Image :alt="exe.name" :src="exe.gif.url" />
        <div class="absolute top-2 left-2">{{ exe.name }}</div>
        <Button
          class="!absolute !bottom-2 !right-2 !w-6 !h-6 p-button-small"
          icon="pi pi-plus"
        />
      </div>
    </div>

    <div class="flex justify-between">
      <Button
        icon="pi pi-angle-left"
        label="Back"
        @click="$emit('prevPage', pageIndex)"
      />
      <Button
        icon="pi pi-angle-right"
        label="Next"
        @click="$emit('nextPage', pageIndex)"
        iconPos="right"
      />
    </div>
  </div>
</template>
