<script setup>
import { defineProps } from "vue";

const props = defineProps(["exercise"]);
</script>
<template>
  <div class="card h-28 p-4 flex gap-4">
    <img
      src="@/assets/images/panel.jpg"
      alt="abc"
      class="w-20 h-20 object-cover rounded-md"
    />
    <div class="content w-full py-1 flex flex-col justify-between">
      <div class="flex justify-between items-center">
        <p class="font-bold text-lg">{{ exercise.name }}</p>
        <div class="space-x-2">
          <i
            class="pi pi-pencil cursor-pointer"
            @click="
              $router.push({
                name: 'exercises.show',
                params: {
                  id: 1,
                },
              })
            "
          ></i>
          <i
            class="pi pi-trash cursor-pointer"
            @click="$emit('clickDelete', exercise.id)"
          ></i>
        </div>
      </div>
      <div class="flex justify-between items-center">
        <Tag
          :severity="exercise.level.severity"
          :value="exercise.level.label"
        />
        <p class="font-normal text-sm text-gray-500">
          {{ exercise.created_by }}
        </p>
      </div>
    </div>
  </div>
</template>
