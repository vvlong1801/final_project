<script setup>
import FileUpload from "primevue/fileupload";
import Steps from "primevue/steps";

import { useToast } from "primevue/usetoast";
import { useChallenge } from "@/stores/challenge";
import { ref } from "vue";
import { useRouter, RouterView } from "vue-router";

const toast = useToast();
const store = useChallenge();
const router = useRouter();

const steps = ref([
  {
    label: "Basic Information",
    to: "/challenges/create",
  },
  {
    label: "Exercise Picker",
    to: "/challenges/create/exercise_picker",
  },
  {
    label: "Confirmation",
    to: "/challenges/create/confirmation",
  },
]);

const nextPage = (pageIndex) => {
  router.push(steps.value[pageIndex + 1].to);
};
const prevPage = (pageIndex) => {
  router.push(steps.value[pageIndex - 1].to);
};

const complete = () => {
  toast.add({
    severity: "success",
    summary: "Order submitted",
    detail:
      "Dear, " +
      formObject.value.firstname +
      " " +
      formObject.value.lastname +
      " your order completed.",
  });
};
</script>
<template>
  <div>
    <Toast />

    <div class="card mb-6">
      <Steps :model="steps" aria-label="Form Steps" :readonly="false" />
    </div>

    <router-view
      @prev-page="(pageIndex) => prevPage(pageIndex)"
      @next-page="(pageIndex) => nextPage(pageIndex)"
      @submit="$emit('onSubmit')"
    >
    </router-view>
  </div>
</template>
