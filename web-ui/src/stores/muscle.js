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
    image: "",
    icon: "",
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
    form.image = "";
    form.icon = "";
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

  function getMuscles() {
    return window.axios
      .get("muscles")
      .then((res) => {
        muscles.value = res.data.data;
      })
      .catch((err) => {});
  }

  const createMuscle = () => {
    return window.axios
      .post("muscles", form)
      .then((res) => {
        getMuscles();
        showToast("success", "Muscle Created");
      })
      .catch((err) => {})
      .finally(resetForm);
  };

  const editMuscle = () => {
    return window.axios
      .put(`muscles/${editId.value}`, form)
      .then(() => {
        getMuscles();
        showToast("success", "Muscle Updated");
      })
      .catch((err) => {})
      .finally(resetForm);
  };

  function deleteMuscle(id) {
    return window.axios
      .delete(`muscles/${id}`)
      .then((res) => {
        getMuscles();
        showToast("success", "Muscle Deleted");
      })
      .catch((err) => {});
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
