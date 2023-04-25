import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useRouter } from "vue-router";
import { useForm } from "vee-validate";
import * as Yup from "yup";
import { levelTypes, exerciseTypes, getOption } from "@/utils/option";

export const useExercise = defineStore("exercise", () => {
  const router = useRouter();
  const exercises = ref([]);
  const pagination = ref({});
  const filtered = ref([]);
  const selectedExercises = ref([]);
  const toast = useToast();
  const editItem = ref({});

  const validationSchema = Yup.object({
    name: Yup.string().required(),
    level: Yup.object().required(),
    // type: Yup.object().required(),
    evaluate_method: Yup.string().required(),
    muscles: Yup.array().required(),
    image: Yup.object().required(),
    gif: Yup.object().required(),
  });

  const initialValues = {
    name: "",
    level: null,
    type: null,
    evaluate_method: null,
    group_exercise: null,
    equipment: null,
    description: "",
    muscles: null,
    gif: null,
    video: null,
    image: null,
  };

  const form = useForm({
    initialValues,
    validationSchema,
  });

  const resetSelected = () => (selectedExercises.value = []);
  const resetEditItem = () => (editItem.value = {});

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const convertResToData = (res) => {
    if (res instanceof Array) {
      const result = res.map((item) => {
        item.type = getOption(exerciseTypes, item.type);
        item.level = getOption(levelTypes, item.level);
        return item;
      });
      return result;
    } else {
      res.type = getOption(exerciseTypes, res.type);
      res.level = getOption(levelTypes, res.level);
      return res;
    }
  };

  const getExercises = () => {
    return window.axios
      .get("exercises")
      .then((res) => {
        exercises.value = convertResToData(res.data);
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

  const getExerciseById = async (id) => {
    await window.axios
      .get(`exercises/find/${id}`)
      .then((res) => {
        editItem.value = convertResToData(res.data);
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const createExercise = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      values.muscles = values.muscles.map((item) => item.id);
      values.equipment = values.equipment.id;
      values.type = values.type.value;
      values.level = values.level.value;

      await window.axios
        .post("exercises", values)
        .then((res) => {
          showToast("success", res.message);
          router.push({ name: "exercises.index" });
          resetForm();
        })
        .catch((err) => {
          console.log(err);
          // setErrors(err.response.data);
          // showToast("error", err.response.data.message);
        });
    }
  );

  const editExercise = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      values.muscles = values.muscles.map((item) => item.id);
      values.equipment = values.equipment.id;
      values.type = values.type.value;
      values.level = values.level.value;

      await window.axios
        .put(`exercises/${values.id}`, values)
        .then((res) => {
          showToast("success", res.message);
          router.push({ name: "exercises.index" });
          resetEditItem();
          resetForm();
        })
        .catch((err) => {
          console.log(err);
          setErrors(err.response.data);
          showToast("error", err.response.data.message);
        });
    }
  );

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
    resetSelected,
    filtered,
    getExercises,
    getExercisesWithPagination,
    getExerciseById,
    editItem,
    createExercise,
    editExercise,
    deleteExercise,
  };
});
