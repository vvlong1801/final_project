<script setup>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import BaseView from "../BaseView.vue";
import Tag from "primevue/tag";
import CardExercise from "./partials/CardExercise.vue";

import { FilterMatchMode } from "primevue/api";
import { onMounted, ref } from "vue";
import { useExercise } from "@/stores/exercise";
import { useConfirm } from "primevue/useconfirm";

const store = useExercise();
const confirm = useConfirm();
const dt = ref(null);
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
onMounted(() => {
  store.getExercises();
});

const exportCSV = (event) => {};

const confirmDelete = (item) => {
  if (item?.id) {
    store.resetSelected();
    store.selectedExercises.push(item);
  }
  confirm.require({
    message: "Do you want to delete this exercise?",
    header: "Delete Confirmation",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      store.deleteExercise();
    },
    reject: () => {
      store.resetSelected();
    },
  });
};
</script>
<template>
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
            @click="(e) => confirmDelete()"
          />
        </template>
      </Toolbar>
      <div class="grid grid-cols-3 gap-6">
        <card-exercise></card-exercise>
        <card-exercise></card-exercise>
        <card-exercise></card-exercise>
        <card-exercise></card-exercise>
      </div>
      <Toast />
      <ConfirmDialog></ConfirmDialog>
    </div>
  </base-view>
</template>
