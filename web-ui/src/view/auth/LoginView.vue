<script setup>
import { onBeforeUnmount } from "vue";
import { useLogin } from "@/store/Auth/login";

import IconSpinner from "@/components/atoms/IconSpinner.vue";
import InputField from "../../components/organisms/InputField.vue";
import CheckboxField from "../../components/organisms/CheckboxField.vue";

const store = useLogin();

onBeforeUnmount(() => {
  store.resetForm();
});
</script>
<template>
  <div
    class="w-96 p-8 space-y-4 bg-white/50 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-2xl relative dark:bg-gray-900/50 dark:border-gray-700"
  >
    <div class="flex justify-center w-full"></div>
    <h2 class="text-2xl font-bold tracking-tight text-center">Login</h2>
    <form @submit.prevent="store.handleSubmit" class="grid grid-cols-1 gap-6">
      <div class="space-y-2">
        <input-field
          label="email"
          :modelValue="store.form.email"
          @update:modelValue="(newValue) => (store.form.email = newValue)"
          :required="true"
          :errors="store.errors"
        ></input-field>
      </div>
      <div class="space-y-2">
        <input-field
          label="password"
          :modelValue="store.form.password"
          @update:modelValue="(newValue) => (store.form.password = newValue)"
          type="password"
          :required="true"
          :errors="store.errors"
        ></input-field>
      </div>
      <div class="space-y-2">
        <checkbox-field
          label="remember me"
          :modelValue="store.form.remember"
          @update:modelValue="(newValue) => (store.form.remember = newValue)"
        />
      </div>
      <button
        type="submit"
        class="flex justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
      >
        <icon-spinner v-show="store.loading" class="mr-2" />
        <span>Sign in</span>
      </button>
    </form>
  </div>
</template>
