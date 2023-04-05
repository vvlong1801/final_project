import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import { useRouter } from "vue-router";
export const useGroupExercise = defineStore("groupExercise", () => {
  const router = useRouter();
  const groupExercises = ref([]);
  const toOptions = ref([]);
  const toast = useToast();

  const form = reactive({
    name: "",
    exercises: [],
    description: "",
  });

  const fillForm = (data) => {
    form.name = data.name;
    form.exercises = data.exercises;
    form.description = data.description;
  };

  const resetForm = () => {
    form.name = "";
    form.exercises = [];
    form.description = "";
  };

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const getGroupExercises = () => {
    return window.axios
      .get("group_exercises")
      .then((res) => {
        exercises.value = res.data;
      })
      .catch((err) => {});
  };

  const getGroupExercisesToOptions = () => {
    return window.axios
      .get("group_exercises", { params: { option: true } })
      .then((res) => {
        toOptions.value = res.data;
      })
      .catch((err) => {});
  };

  return {
    groupExercises,
    toOptions,
    form,
    fillForm,
    resetForm,
    getGroupExercises,
    getGroupExercisesToOptions,
  };
});
