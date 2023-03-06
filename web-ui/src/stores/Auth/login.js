import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { useAuth } from "./auth";

export const useLogin = defineStore("login", () => {
  const auth = useAuth();
  const errors = reactive({});
  const loading = ref(false);

  const form = reactive({
    email: "",
    password: "",
    remember: false,
  });

  function resetForm() {
    form.email = "";
    form.password = "";
    form.remember = false;
  }

  async function handleSubmit() {
    if (loading.value) return;

    loading.value = true;
    errors.value = {};

    return window.axios
      .post("login", form)
      .then((res) => {
        auth.login(res.data.access_token);
      })
      .catch((err) => {
        console.log(err)
        if (err.response.status === 422) {
          errors.value = err.response.data.errors;
        }
      })
      .finally(() => {
        form.password = "";
        loading.value = false;
      });
  }

  return { form, errors, loading, resetForm, handleSubmit };
});
