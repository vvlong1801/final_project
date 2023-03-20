<script setup>
import { useLogin } from "@/stores/Auth/login.js";
const store = useLogin();
</script>
<template>
  <div class="z-10 min-w-fit">
    <div class="z-10 bg-white py-16 px-16 border rounded-lg">
      <div class="mb-4">
        <div class="text-xl font-bold mb-2">Log in</div>
        <span class="text-[#757575] font-medium"
          >Please enter your details</span
        >
      </div>
      <div class="flex flex-col space-y-4">
        <span class="p-input-icon-left w-full">
          <i class="pi pi-envelope" />
          <input
            class="p-inputtext p-component w-full md:w-[400px] !rounded-lg"
            id="email"
            type="text"
            v-model="store.form.email"
            placeholder="Email"
          />
        </span>
        <span class="p-input-icon-left w-full">
          <i class="pi pi-lock" />
          <input
            class="p-inputtext p-component w-full md:w-[400px] !rounded-lg"
            id="password"
            type="password"
            v-model="store.form.password"
            placeholder="Password"
          />
        </span>
        <div class="mb-4 flex flex-wrap gap-3">
          <div>
            <div class="p-checkbox p-component mr-2">
              <div class="p-hidden-accessible">
                <input
                  type="checkbox"
                  name="remember"
                  v-model="store.form.remember"
                />
              </div>
              <div class="p-checkbox-box">
                <span class="p-checkbox-icon"></span>
              </div>
            </div>
            <label for="checkbox" class="text-900 font-medium mr-8">
              Remember Me
            </label>
          </div>
          <a
            class="text-[#757575] hover:text-primary cursor-pointer ml-auto transition-colors transition-duration-300"
            >Reset password</a
          >
        </div>
        <Button
          type="submit"
          label="Login"
          class="!bg-primary-500 !border-none !rounded-lg"
          @click="store.handleSubmit"
        />
      </div>
    </div>
  </div>
</template>
