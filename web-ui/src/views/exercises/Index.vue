<script setup>
import BaseView from "../BaseView.vue";
import CardExercise from "./partials/CardExercise.vue";

import { onMounted, ref } from "vue";
import { useExercise } from "@/stores/exercise";
import { useConfirm } from "primevue/useconfirm";

const store = useExercise();
const confirm = useConfirm();

onMounted(() => {
  store.getExercises();
});

const confirmDelete = (id) => {
  confirm.require({
    message: "Do you want to delete this exercise?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => store.deleteExercise(id),
  });
};

const confirmBulkDelete = (item) => {
  if (item?.id) {
    store.resetSelected();
    store.selectedExercises.push(item);
  }
  confirm.require({
    message: "Do you want to delete selected exercise?",
    header: "Delete Confirmation",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      store.deleteExercise();
    },
    // reject: () => {
    //   store.resetSelected();
    // },
  });
};
</script>
<template>
  <Toast />
  <ConfirmDialog></ConfirmDialog>
  <base-view title="Exercises">
    <div class="card flex flex-col space-y-6 min-h-full">
      <Toolbar>
        <template #start>
          <Button
            label="New"
            type="button"
            icon="pi pi-plus"
            class="!mr-2"
            @click="$router.push({ name: 'exercises.create' })"
          />
          <Button
            label="Delete"
            icon="pi pi-trash"
            class="!bg-red-600 !border-none"
            @click="(e) => confirmBulkDelete()"
          />
        </template>
      </Toolbar>
      <div class="grid grid-cols-3 gap-6">
        <card-exercise
          v-for="exe in store.exercises"
          :exercise="exe"
          @click-delete="confirmDelete"
        />
      </div>
    </div>
  </base-view>
</template>
