import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";

// const route = useRouter();
export const useMuscle = defineStore("muscle", () => {
  const toast = useToast();
  const muscles = ref([]);
  const editId = ref(null);

  const form = reactive({
    name: "",
    image: null,
    icon: null,
    description: "",
  });

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const resetForm = () => {
    form.name = "";
    form.image = null;
    form.icon = null;
    form.description = "";
    editId.value = null;
  };

  const fillForm = (data) => {
    form.name = data.name;
    form.image = data.image;
    form.icon = data.icon;
    form.description = data.description;
    editId.value = data.id;
  };

  const getMuscles = () => {
    return window.axios
      .get("muscles")
      .then((res) => {
        muscles.value = res.data.data;
      })
      .catch((err) => {});
  };

  const createMuscle = () => {
    return window.axios
      .post("muscles", form)
      .then((res) => {
        getMuscles();
        showToast("success", res.message);
      })
      .catch((err) => {
        showToast("error", err.message);
      })
      .finally(resetForm);
  };

  const editMuscle = () => {
    return window.axios
      .put(`muscles/${editId.value}`, form)
      .then(() => {
        getMuscles();
        showToast("success", res.message);
      })
      .catch((err) => {
        showToast("error", err.message);
      })
      .finally(resetForm);
  };

  function deleteMuscle(id) {
    return window.axios
      .delete(`muscles/${id}`)
      .then((res) => {
        getMuscles();
        showToast("success", res.message);
      })
      .catch((err) => {
        showToast("error", err.message);
      });
  }

  return {
    form,
    resetForm,
    fillForm,
    muscles,
    getMuscles,
    createMuscle,
    editMuscle,
    deleteMuscle,
  };
});
