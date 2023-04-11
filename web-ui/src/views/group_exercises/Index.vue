<script setup>
import BaseView from "../BaseView.vue";
</script>
<template>
  <base-view title="Group Exercises">
    <div class="card flex flex-col gap-8 min-h-screen">
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
      <div class="grid grid-cols-4 grid-flow-row gap-8">
        <Card class="w-full !rounded-xl">
          <template #header>
            <img
              class="rounded-xl"
              alt="user header"
              src="@/assets/images/panel.jpg"
            />
          </template>
          <template #title> Cardio </template>
          <template #subtitle> Card subtitle </template>
          <template #content> </template>
          <template #footer>
            <div class="w-full text-right">
              <Button
                label="view"
                class="p-button-outlined p-button-sm !rounded-xl"
              />
            </div>
          </template>
        </Card>
      </div>
    </div>
  </base-view>
</template>
