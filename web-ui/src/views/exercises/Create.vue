<script setup>
import BaseView from "../BaseView.vue";
import FormExercise from "./Form.vue";
import { onMounted } from "vue";
import { useExercise } from "@/stores/exercise";
const { form, createExercise } = useExercise();
onMounted(form.resetForm);
</script>
<template>
  <base-view title="Create Exercises">
    <form-exercise @handle-submit="createExercise" />
  </base-view>
</template>
