import { defineStore } from "pinia";
import { ref } from "vue";

export const useExercise = defineStore("exercise", () => {
  const exercises = ref([]);
  const currentPage = ref(1);
  const dataPagination = ref(null);

  function setCurrentPage(page) {
    console.log(page)
    currentPage.value = page;
    getExercises();
  }

  function getExercises() {
    return window.axios
      .get(`exercises?page=${currentPage.value}`)
      .then((res) => {
        exercises.value = res.data.data;
        dataPagination.value = res.data.meta;
        console.log(res)
      })
      .catch((err) => {})
      .finally(() => {});
  }

  return { exercises, setCurrentPage, getExercises, dataPagination };
});
