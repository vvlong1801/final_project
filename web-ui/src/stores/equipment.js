import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";

// const route = useRouter();
export const useEquipment = defineStore("equipment", () => {
  const toast = useToast();
  const equipments = ref([]);
  const editId = ref(null);
  const errors = ref(null);

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

  const fillForm = (data) => {
    form.name = data.name;
    form.image = data.image;
    form.icon = data.icon;
    form.description = data.description;
    editId.value = data.id;
  };

  const resetForm = () => {
    form.name = "";
    form.image = "";
    form.icon = "";
    form.description = "";
    editId.value = null;
  };
  function getEquipments() {
    return window.axios
      .get("equipments")
      .then((res) => {
        equipments.value = res.data;
      })
      .catch((err) => {
        showToast("error", err.message);
      });
  }

  const createEquipment = () => {

    return window.axios
      .post("equipments", form)
      .then((res) => {
        getEquipments();
        showToast("success", res.message);
      })
      .catch((err) => {
        errors.value = err.response.data;
        showToast("error", err.response.data.message);
      })
      .finally(resetForm);
  };

  const editEquipment = () => {
    return window.axios
      .put(`equipments/${editId.value}`, form)
      .then((res) => {
        getEquipments();
        showToast("success", res.message);
      })
      .catch((err) => {
        errors.value = err.response.data;
        showToast("error", err.response.data.message);
      })
      .finally(resetForm);
  };

  function deleteEquipment(id) {
    return window.axios
      .delete(`equipments/${id}`)
      .then((res) => {
        getEquipments();
        showToast("success", res.message);
      })
      .catch((err) => {
        errors.value = err.response.data;
        showToast("error", err.response.data.message);
      });
  }

  return {
    form,
    errors,
    fillForm,
    resetForm,
    editEquipment,
    createEquipment,
    equipments,
    getEquipments,
    deleteEquipment,
  };
});
