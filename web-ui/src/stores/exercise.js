import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useRouter } from "vue-router";
import { useForm } from "vee-validate";
import * as Yup from "yup";
import { TYPE_LEVEL, EVALUATE_METHOD, getOption } from "@/utils/option";
import * as ExerciseAPI from "@/services/exercise";

export const useExercise = defineStore("exercise", () => {
  const router = useRouter();
  const exercises = ref([]);
  const pagination = ref({});
  const filtered = ref([]);
  const selectedExercises = ref([]);
  const toast = useToast();
  const editItem = ref({});
  const groupTags = ref([]);

  const validationSchema = Yup.object({
    name: Yup.string().required(),
    level: Yup.object().required(),
    evaluate_method: Yup.string().required(),
    group_tags: Yup.array(),
    muscles: Yup.array().required(),
    image: Yup.object().required(),
    gif: Yup.object().required(),
  });

  const initialValues = {
    name: "",
    level: TYPE_LEVEL.easy,
    type: null,
    evaluate_method: EVALUATE_METHOD.repitition,
    group_tags: null,
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
        item.type = getOption(EVALUATE_METHOD, item.type);
        item.level = getOption(TYPE_LEVEL, item.level);
        return item;
      });
      return result;
    } else {
      res.type = getOption(EVALUATE_METHOD, res.type);
      res.level = getOption(TYPE_LEVEL, res.level);
      return res;
    }
  };

  const getExercises = async () => {
    try {
      const res = await ExerciseAPI.onGetExercises();
      exercises.value = convertResToData(res?.data);
    } catch (err) {
      console.log(err);
    }
  };

  const getGroupTags = async () => {
    try {
      const res = await ExerciseAPI.onGetGroupTags();
      groupTags.value = res.data;
      console.log(groupTags.value);
    } catch (err) {
      console.log(err);
    }
  };

  const getExerciseById = async (id) => {
    try {
      const res = await ExerciseAPI.onGetExerciseById(id);
      editItem.value = convertResToData(res?.data);
    } catch (error) {
      showToast("error", err.response.data.message);
    }
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
          setErrors(err.response.data);
          showToast("error", err.response.data.message);
        });
    }
  );

  const deleteExercise = async (id) => {
    try {
      const res = await ExerciseAPI.onDeleteExercise(id);
      showToast("success", res?.message);
      getExercises();
    } catch (error) {
      showToast("error", error.response.data.message);
    } finally {
      resetSelected();
    }
  };

  return {
    exercises,
    groupTags,
    pagination,
    selectedExercises,
    form,
    resetSelected,
    filtered,
    getExercises,
    getGroupTags,
    getExerciseById,
    editItem,
    createExercise,
    editExercise,
    deleteExercise,
  };
});
