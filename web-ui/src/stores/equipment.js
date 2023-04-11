import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useForm } from "vee-validate";
import * as Yup from "yup";

export const useEquipment = defineStore("equipment", () => {
  const toast = useToast();
  const equipments = ref([]);
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

  const createEquipment = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      await window.axios
        .post("equipments", values)
        .then((res) => {
          getEquipments();
          showToast("success", res.message);
        })
        .catch((err) => {
          setErrors(err.response.data);
          showToast("error", err.response.data.message);
        });
    }
  );

  const editEquipment = form.handleSubmit(
    async (values, { setErrors, resetForm }) => {
      await window.axios
        .put(`equipments/${editItem.value.id}`, values)
        .then((res) => {
          getEquipments();
          showToast("success", res.message);
        })
        .catch((err) => {
          setErrors(err.response.data);
          showToast("error", err.response.data.message);
        });
    }
  );

  function deleteEquipment(id) {
    return window.axios
      .delete(`equipments/${id}`)
      .then((res) => {
        getEquipments();
        showToast("success", res.message);
      })
      .catch((err) => {
        setErrors(err.response.data);
        showToast("error", err.response.data.message);
      });
  }

  return {
    form,
    equipments,
    editItem,
    editEquipment,
    createEquipment,
    getEquipments,
    deleteEquipment,
  };
});
