import { defineStore } from "pinia";
import { ref } from "vue";

export const useExercise = defineStore("exercise", () => {
  const exercises = ref([]);
  function getExercises() {
    return window.axios
      .get("exercises")
      .then((res) => {
        exercises.value = res.data.data;
        console.log(exercises.value);
      })
      .catch((err) => {})
      .finally(() => {});
  }

  return { exercises, getExercises };
});
