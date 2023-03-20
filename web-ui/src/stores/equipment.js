import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";

// const route = useRouter();
export const useEquipment = defineStore("equipment", () => {
  const toast = useToast();
  const editId = ref(null);
  const equipments = ref([]);
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
  };

  const createEquipment = () => {
    return window.axios
      .post("equipments", form)
      .then((res) => {
        getEquipments();
        showToast("success", "Equipment Created");
      })
      .catch((err) => {})
      .finally(resetForm);
  };

  function getEquipments() {
    return window.axios
      .get("equipments")
      .then((res) => {
        equipments.value = res.data.data;
      })
      .catch((err) => {});
  }

  const editEquipment = () => {
    return window.axios
      .put(`equipments/${editId.value}`, form)
      .then(() => {
        getEquipments();
        showToast("success", "Equipment Updated");
      })
      .catch((err) => {})
      .finally(resetForm);
  };

  function deleteEquipment(id) {
    return window.axios
      .delete(`equipments/${id}`)
      .then((res) => {
        getEquipments();
        showToast("success", "Equipment Deleted");
      })
      .catch((err) => {});
  }

  return {
    form,
    fillForm,
    resetForm,
    editEquipment,
    createEquipment,
    equipments,
    getEquipments,
    deleteEquipment,
  };
});
