import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import { useRouter } from "vue-router";
export const useExercise = defineStore("exercise", () => {
  const router = useRouter();
  const exercises = ref([]);
  const pagination = ref({});
  const filtered = ref([]);
  const selectedExercises = ref([]);
  const toast = useToast();
  const findedExercise = ref({});

  const form = reactive({
    name: "",
    level: "",
    type: "",
    equipment: null,
    muscles: [],
    description: "",
    gif: null,
    video: null,
    image: null,
  });

  const fillForm = (data) => {
    form.name = data.name;
    form.level = data.level;
    form.type = data.type;
    form.equipment = data.equipment;
    form.muscles = data.muscles;
    form.description = data.description;
    form.gif = data.gif;
    form.video = data.video;
    form.image = data.image;
  };

  const resetSelected = () => (selectedExercises.value = []);
  const resetFindedExercise = () => (findedExercise.value = null);
  const resetForm = () => {
    form.name = "";
    form.level = "";
    form.type = "";
    form.equipment = null;
    form.muscles = [];
    form.description = "";
    form.gif = null;
    form.video = null;
    form.image = null;
  };

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const getExercises = () => {
    return window.axios
      .get("exercises")
      .then((res) => {
        exercises.value = res.data;
      })
      .catch((err) => {});
  };

  const getExercisesWithPagination = (pageNum = 1) => {
    return window.axios
      .get(`exercises/12?page=${pageNum}`)
      .then((res) => {
        exercises.value = res.data.data;
        pagination.value = res.data.pagination;
      })
      .catch((err) => {});
  };

  const getExerciseById = (id) => {
    return window.axios
      .get(`exercises/find/${id}`)
      .then((res) => {
        findedExercise.value = res.data;
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const createExercise = () => {
    form.muscles = form.muscles.map((item) => item.id);
    form.equipment = form.equipment.id;

    window.axios
      .post("exercises", form)
      .then((res) => {
        showToast("success", res.message);
        router.push({ name: "exercises.index" });
        resetSelected();
        resetForm();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const editExercise = (id) => {
    form.muscles = form.muscles.map((item) => item.id);
    form.equipment = form.equipment.id;

    window.axios
      .put(`exercises/${id}`, form)
      .then((res) => {
        showToast("success", res.message);
        router.push({ name: "exercises.index" });
        resetFindedExercise();
        resetForm();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };
  const deleteExercise = () => {
    const ids = selectedExercises.value.map((ex) => ex.id);
    window.axios
      .post("exercises/delete", { ids })
      .then((res) => {
        showToast("success", res.message);
        getExercises();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      })
      .finally(resetSelected);
  };

  return {
    exercises,
    pagination,
    selectedExercises,
    form,
    fillForm,
    resetForm,
    resetSelected,
    filtered,
    getExercises,
    getExercisesWithPagination,
    getExerciseById,
    findedExercise,
    createExercise,
    editExercise,
    deleteExercise,
  };
});
