<script setup>
import { onBeforeUnmount } from "vue";
import { useLogin } from "@/store/Auth/login";
import ValidationError from "@/components/ValidationError.vue";
import IconSpinner from "@/components/IconSpinner.vue";

const store = useLogin();

onBeforeUnmount(() => {
  store.resetForm();
});
</script>
<template>
  <div
    class="p-8 space-y-4 bg-white/50 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-2xl relative dark:bg-gray-900/50 dark:border-gray-700"
  >
    <div class="flex justify-center w-full"></div>
    <h2 class="text-2xl font-bold tracking-tight text-center">Login</h2>
    <form @submit.prevent="store.handleSubmit" class="grid grid-cols-1 gap-6">
      <div class="space-y-2">
        <label
          for="email"
          class="inline-flex items-center space-x-3 rtl:space-x-reverse"
        >
          <span
            class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300"
          >
            Email address
          </span>
          <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
        </label>
        <input
          type="text"
          class="input input-bordered input-primary w-full max-w-xs"
          name="email"
          v-model="store.form.email"
        />
        <validation-error :errors="store.errors" field="email" />
      </div>
      <div class="space-y-2">
        <label
          for="password"
          class="inline-flex items-center space-x-3 rtl:space-x-reverse"
        >
          <span
            class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300"
          >
            Password
          </span>
          <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
        </label>
        <input
          type="password"
          class="input input-bordered input-primary w-full max-w-xs"
          name="password"
          v-model="store.form.password"
        />
        <validation-error :errors="store.errors" field="password" />
      </div>
      <div class="space-y-2">
        <div
          class="flex items-center justify-between space-x-2 rtl:space-x-reverse"
        >
          <label
            for="remember"
            class="inline-flex items-center space-x-3 rtl:space-x-reverse"
          >
            <input
              type="checkbox"
              checked="checked"
              class="checkbox checkbox-primary checkbox-sm"
            />
            <span
              class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300"
            >
              Remember me
            </span>
          </label>
        </div>
      </div>
      <button class="btn btn-primary w-full h-8" type="submit">
        <icon-spinner v-show="store.loading" />
        <span>Sign in</span>
      </button>
    </form>
  </div>
</template>
