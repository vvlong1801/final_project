import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { useAuth } from "./auth";
import { useForm } from "vee-validate";
import * as Yup from "yup";

export const useLogin = defineStore("login", () => {
  const auth = useAuth();

  const validationSchema = Yup.object({
    email: Yup.string().email().required(),
    password: Yup.string().min(6).required(),
    remember: Yup.boolean(),
  });

  const initialValues = {
    email: "",
    password: "",
    remember: false,
  };

  const form = useForm({
    initialValues,
    validationSchema,
  });

  const login = form.handleSubmit(async (values, { setErrors, resetForm }) => {
    console.log("login");
    await window.axios
      .post("login", values)
      .then((res) => {
        auth.login(res.access_token);
      })
      .catch((err) => {
        console.log(err);
        if (err.response.status === 422) {
          setErrors(err.response.data.errors);
        }
      });
    resetForm();
  });

  return { form, login };
});
