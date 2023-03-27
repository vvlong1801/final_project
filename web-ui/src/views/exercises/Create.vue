<script setup>
import BaseView from "../BaseView.vue";
import FormExercise from "./Form.vue";
import { useExercise } from "@/stores/exercise";
import { onMounted } from "vue";
const { createExercise, resetForm } = useExercise();
onMounted(resetForm);
</script>
<template>
  <base-view title="Create Exercises">
    <form-exercise @handle-submit="createExercise" />
  </base-view>
</template>
