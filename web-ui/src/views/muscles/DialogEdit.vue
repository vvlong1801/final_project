<script setup>
import { defineProps, defineEmits } from "vue";
import { useMuscle } from "@/stores/muscle.js";
import Form from "./Form.vue";
const props = defineProps({
  visible: {
    type: Boolean,
    default: false,
  },
});
const emit = defineEmits(["update:visible"]);
const { editMuscle, form } = useMuscle();
const onsubmit = async () => {
  await editMuscle();
  if (form.meta.valid && form.submitCount) {
    emit("update:visible", false);
    form.resetForm();
  }
};
</script>

<template>
  <Dialog
    :header="'Edit Muscle'.toUpperCase()"
    v-model:visible="props.visible"
    @update:visible="$emit('update:visible', false)"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
    :modal="true"
  >
    <Form editForm />
    <template #footer>
      <Button
        label="Cancel"
        icon="pi pi-times"
        @click="$emit('update:visible', false)"
        class="p-button-text" />
      <Button label="Save" icon="pi pi-check" @click="onsubmit"
    /></template>
  </Dialog>
</template>
