import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useForm } from "vee-validate";
import * as Yup from "yup";

export const useMuscle = defineStore("muscle", () => {
  const toast = useToast();
  const muscles = ref([]);
  const editItem = ref({});

  const validationSchema = Yup.object({
    name: Yup.string().required(),
    image: Yup.object().required(),
  });

  const initialValues = {
    name: "",
    image: null,
    icon: null,
    description: "",
  };

  const form = useForm({
    initialValues,
    validationSchema,
  });

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const getMuscles = () => {
    return window.axios
      .get("muscles")
      .then((res) => {
        muscles.value = res.data;
      })
      .catch((err) => {});
  };

  const createMuscle = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      await window.axios
        .post("muscles", values)
        .then((res) => {
          getMuscles();
          showToast("success", res.message);
        })
        .catch((err) => {
          setErrors(err.response.data);
          showToast("error", err.message);
        });
    }
  );

  const editMuscle = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      await window.axios
        .put(`muscles/${editItem.value.id}`, values)
        .then((res) => {
          getMuscles();
          showToast("success", res.message);
        })
        .catch((err) => {
          setErrors(err.response.data);
          showToast("error", err.message);
        });
    }
  );

  function deleteMuscle(id) {
    return window.axios
      .delete(`muscles/${id}`)
      .then((res) => {
        getMuscles();
        showToast("success", res.message);
      })
      .catch((err) => {
        setErrors(err.response.data);
        showToast("error", err.message);
      });
  }

  return {
    form,
    editItem,
    muscles,
    getMuscles,
    createMuscle,
    editMuscle,
    deleteMuscle,
  };
});
