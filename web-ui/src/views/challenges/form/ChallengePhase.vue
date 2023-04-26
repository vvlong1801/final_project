<script setup>
import InputNumber from "primevue/inputnumber";
import Panel from "primevue/panel";
import Schedule from "../partials/Schedule.vue";
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
  <div class="flex-col space-y-6">
    <div class="card flex-col gap-6">
      <Toolbar>
        <template #start>
          <div class="flex justify-between">
            <div class="p-inputgroup !w-1/3">
              <span class="p-inputgroup-addon">
                <p>Name Phase</p>
              </span>
              <InputText v-model="value2" inputId="name-phase" />
            </div>
            <div class="p-inputgroup !w-1/4">
              <span class="p-inputgroup-addon">
                <p>Active Day</p>
              </span>
              <InputNumber
                v-model="value2"
                inputId="minmax-buttons"
                mode="decimal"
                suffix=" days"
                showButtons
                :min="3"
                :max="100"
              />
            </div>
            <div class="p-inputgroup !w-1/4">
              <span class="p-inputgroup-addon">
                <p>Rest Day</p>
              </span>
              <InputNumber
                v-model="value2"
                inputId="minmax-buttons"
                mode="decimal"
                suffix=" days"
                showButtons
                :min="3"
                :max="100"
              />
            </div>
          </div>
        </template>
        <template #end>
          <Button icon="pi pi-plus" aria-label="Submit" />
        </template>
      </Toolbar>
    </div>

    <div class="card">
      <div class="flex-col space-y-2">
        <div
          class="h-16 bg-slate-100 w-full p-4 rounded border border-slate-300 flex items-center mb-6"
        >
          <span class="text-gray-700">{{ phaseName }}</span>
        </div>
        <Schedule :activeDays="27" :restDays="5"></Schedule>
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
