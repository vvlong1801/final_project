<script setup>
import { onMounted, ref, computed } from "vue";
import { useExercise } from "@/stores/exercise";
import { useChallenge } from "@/stores/challenge";

const pageIndex = 1;
const exerciseStore = useExercise();
const challengeStore = useChallenge();
const selectedExercises = ref([]);
const selectingExercise = ref(0);

onMounted(exerciseStore.getExercisesWithPagination);

const source = computed(() => {
  let source = exerciseStore.exercises.filter(
    (exe) => !challengeStore.form.exercises.some((e) => e.id === exe.id)
  );
  selectedExercises.value = [];
  return source;
});

const onSelectExercise = (id) => {
  selectedExercises.value.push(id);
};

const onMove = () => {
  let selected = exerciseStore.exercises.filter((exe) =>
    selectedExercises.value.includes(exe.id)
  );
  challengeStore.form.exercises = [
    ...challengeStore.form.exercises,
    ...selected,
  ];
};

const onRemove = (exe) => {
  challengeStore.form.exercises = challengeStore.form.exercises.filter(
    (e) => e.id !== exe.id
  );
};

const onPaginate = (event) => {
  exerciseStore.getExercisesWithPagination(event.page + 1);
};
</script>
<template>
  <div class="card flex flex-col gap-6">
    <Toolbar>
      <template #start>
        <Button label="Add" icon="pi pi-plus" class="mr-2" />
      </template>

      <template #end>
        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText placeholder="Search..." />
        </span>
      </template>
    </Toolbar>
    <div class="flex">
      <div class="flex flex-col w-1/2">
        <div class="grid grid-cols-3 gap-6">
          <div
            class="relative"
            v-for="(exe, index) in challengeStore.form.exercises"
            :key="index"
          >
            <Image :alt="exe.name" :src="exe.gif.url" />
            <div class="absolute top-2 left-2">{{ exe.name }}</div>
            <Button
              icon="pi pi-times"
              class="!w-4 !h-4 !absolute !top-2 !right-2"
              @click="onRemove(exe)"
            />
          </div>
        </div>
        <!-- <Paginator
          v-model:first="exerciseStore.form.exercises"
          template="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        /> -->
      </div>
      <Divider layout="vertical">
        <Button icon="pi pi-angle-double-left" @click="onMove" />
      </Divider>
      <div class="flex flex-col w-1/2">
        <div class="grid grid-cols-3 gap-6">
          <div class="relative" v-for="(exe, index) in source" :key="index">
            <Image
              :alt="exe.name"
              :src="exe.gif.url"
              @mouseover="() => (selectingExercise = exe.id)"
            />
            <div class="absolute top-2 left-2">{{ exe.name }}</div>
            <div
              v-if="
                selectingExercise === exe.id ||
                selectedExercises.includes(exe.id)
              "
              class="absolute top-0 left-0 w-full h-full bg-white opacity-80 cursor-pointer"
              @mouseleave="() => (selectingExercise = 0)"
              @click="onSelectExercise(exe.id)"
            >
              <Badge
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                v-if="selectedExercises.includes(exe.id)"
                :value="selectedExercises.indexOf(exe.id) + 1"
              />
            </div>
          </div>
        </div>
        <Paginator
          :rows="exerciseStore.pagination.meta?.per_page"
          :totalRecords="exerciseStore.pagination.meta?.total"
          template="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
          @page="onPaginate"
        />
      </div>
    </div>

    <div class="flex justify-between">
      <Button
        icon="pi pi-angle-left"
        label="Back"
        @click="$emit('prevPage', pageIndex)"
      />
      <Button
        icon="pi pi-angle-right"
        label="Next"
        @click="$emit('nextPage', pageIndex)"
        iconPos="right"
      />
    </div>
  </div>
</template>
