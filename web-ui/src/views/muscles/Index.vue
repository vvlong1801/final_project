<script setup>
import BaseView from "../BaseView.vue";
import FormMuscle from "./Form.vue";

import { ref, onMounted, computed, watch } from "vue";
import { useMuscle } from "@/stores/muscle";

const searchKey = ref("");
const visibleModal = ref(false);
const showAction = ref(null);
const modalType = ref("create");

const store = useMuscle();

onMounted(store.getMuscles);
watch(visibleModal, (newValue, oldValue) => {
  if (!newValue) {
    store.resetForm();
  }
});
const searchList = computed(() => {
  return searchKey.value.length
    ? store.muscles.filter((muscle) => muscle.name.includes(searchKey.value))
    : store.muscles;
});

const openCreateModal = () => {
  modalType.value = "create";
  visibleModal.value = true;
};

const openEditModal = (muscle) => {
  modalType.value = "edit";
  store.fillForm(muscle);
  visibleModal.value = true;
};
</script>
<template>
  <base-view title="Muscles">
    <div class="card flex flex-col space-y-6 min-h-full">
      <Toolbar>
        <template #start>
          <Button
            icon="pi pi-plus"
            class="p-button-rounded p-button-primary !bg-primary-500 !border-none"
            @click="openCreateModal"
          />
          <Toast />
          <form-muscle v-model:visible="visibleModal" :form-type="modalType" />
        </template>
        <template #end>
          <span class="p-input-icon-left">
            <i class="pi pi-search" />
            <InputText type="text" v-model="searchKey" placeholder="Search" />
          </span>
        </template>
      </Toolbar>

      <div class="p-4 grid grid-flow-row grid-cols-12 gap-4">
        <div
          class="space-y-1 text-center"
          v-for="(muscle, index) in searchList"
          :key="index"
        >
          <div
            class="relative border rounded-lg drop-shadow-md block cursor-pointer p-2"
            @mouseover="() => (showAction = index)"
            @mouseleave="() => (showAction = null)"
          >
            <Transition name="fade">
              <div v-if="showAction == index">
                <div
                  class="absolute top-0 left-0 w-full h-full flex space-x-4 justify-center items-center"
                >
                  <i
                    class="pi pi-pencil z-50 text-white cursor-pointer"
                    @click="openEditModal(muscle)"
                  ></i>
                  <i
                    class="pi pi-trash z-50 text-white cursor-pointer"
                    @click="store.deleteMuscle(muscle.id)"
                  ></i>
                </div>
                <div
                  class="absolute w-full h-full masker top-0 left-0 rounded-lg"
                ></div>
              </div>
            </Transition>
            <Image :src="muscle.image.url" imageClass="w-full" />
          </div>
          <p class="truncate px-2">{{ muscle.name }}</p>
        </div>
      </div>
    </div>
  </base-view>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
