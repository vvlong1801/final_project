<script setup>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import BaseView from "../BaseView.vue";
import Tag from "primevue/tag";
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
        <template #end>
          <Button
            label="Export"
            icon="pi pi-upload"
            class="!bg-purple-600 !border-none"
            @click="exportCSV($event)"
          />
        </template>
      </Toolbar>
      <DataTable
        :value="store.exercises"
        v-model:selection="store.selectedExercises"
        v-model:filters="filters"
        dataKey="id"
        paginator
        :rows="5"
        :rowsPerPageOptions="[5, 10, 20, 50]"
        ref="dt"
        sortField="name"
        removableSort
        :sortOrder="-1"
        @page="onPage($event)"
      >
        <template #header>
          <div class="flex flex-wrap gap-2 items-center justify-between">
            <h4 class="m-0">Manage Exercises</h4>
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                v-model="filters['global'].value"
                placeholder="Search..."
              />
            </span>
          </div>
        </template>
        <Column
          selectionMode="multiple"
          class="w-8"
          :exportable="false"
        ></Column>
        <Column field="name" header="Name" sortable></Column>
        <Column field="groupExercise.name" header="Group" sortable></Column>
        <Column field="level" header="Level" sortable>
          <template #body="slotProps">
            <Tag
              :value="slotProps.data.level.label"
              :severity="slotProps.data.level.severity"
            />
          </template>
        </Column>
        <Column field="type" header="Type" sortable>
          <template #body="slotProps">
            <div class="flex">
              <i class="!text-xl mr-2 pi" :class="slotProps.data.type.icon"></i>
              <p>{{ slotProps.data.type.label }}</p>
            </div>
          </template>
        </Column>
        <Column
          field="muscles"
          header="Muscles"
          sortable
          body-class="flex gap-2"
        >
          <template #body="slotProps">
            <Image
              v-for="(muscle, index) in slotProps.data.muscles"
              :src="muscle.image.url"
              class="!mr-2 !rounded !outline-none"
            />
          </template>
        </Column>
        <Column
          :exportable="false"
          style="min-width: 8rem"
          body-class="!text-end"
        >
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              class="!mr-2 !rounded !outline-none"
              @click="
                $router.push({
                  name: 'exercises.edit',
                  params: { id: slotProps.data.id },
                })
              "
            />
            <Button
              icon="pi pi-trash"
              class="!bg-red-600 !rounded !border-none"
              @click="confirmDelete(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
      <Toast />
      <ConfirmDialog></ConfirmDialog>
    </div>
  </base-view>
</template>
