<script setup>
import { onMounted } from "vue";
import { RouterLink } from "vue-router";
import { useExercise } from "@/store/exercise.js";
import BaseView from "../BaseView.vue";
import ExerciseCard from "./components/ExerciseCard.vue";
const store = useExercise();
onMounted(store.getExercises);
</script>
<template>
  <base-view title="Exercise">
    <div class="grid grid-cols-6 gap-6">
      <router-link to="/exercises/new">
        <div
          class="card shadow-xl h-48 flex items-center justify-center bg-white cursor-pointer"
        >
          <font-awesome-icon
            icon="fa-solid fa-plus"
            class="text-3xl font-bold"
          />
        </div>
      </router-link>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
      <exercise-card></exercise-card>
    </div>
  </base-view>
</template>
