<script setup>
import BaseView from "../BaseView.vue";
import FormExercise from "./Form.vue";
import { useRoute } from "vue-router";
import { onMounted } from "vue";
import { useExercise } from "@/stores/exercise";
const route = useRoute();
const store = useExercise();
onMounted(async () => {
  await store.getExerciseById(route.params.id);
  store.fillForm(store.findedExercise);
});
</script>
<template>
  <base-view title="Edit Exercises">
    <form-exercise
      type="edit"
      @handle-submit="store.editExercise(route.params.id)"
    />
  </base-view>
</template>
