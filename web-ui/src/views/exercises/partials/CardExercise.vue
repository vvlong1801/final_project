<script setup>
import { defineProps } from "vue";
const props = defineProps(["exercise"]);
</script>
<template>
  <Card class="w-full !rounded-xl">
    <template #header>
      <img class="rounded-xl" alt="user header" :src="exercise.image.url" />
    </template>
    <template #content>
      <div class="flex flex-col gap-2">
        <div class="flex gap-2 justify-between">
          <p class="text-lg">{{ exercise.name }}</p>
          <Badge value="easy" severity="success"></Badge>
        </div>
        <div class="flex gap-2 justify-between items-center">
          <div class="flex space-x-2 items-center">
            <i class="w-4 h-4 pi" :class="exercise.type.icon" />
            <span>{{ exercise.type.label }}</span>
          </div>
          <div class="flex">
            <img
              :src="mus.image.url"
              v-for="mus in exercise.muscles"
              class="w-4 h-4"
            />
          </div>
        </div>
      </div>
    </template>
    <template #footer>
      <div class="w-full space-x-4 text-right">
        <Button
          icon="pi pi-trash"
          class="p-button-outlined p-button-sm p-button-danger !rounded-lg"
        />
        <Button
          icon="pi pi-eye"
          class="p-button-outlined p-button-sm !rounded-lg"
          @click="
            $router.push({
              name: 'group_exercises.edit',
              params: { id: exercise.id },
            })
          "
        />
      </div>
    </template>
  </Card>
</template>
