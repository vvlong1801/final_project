<script setup>
import { defineProps, defineEmits } from "vue";
import { useEquipment } from "@/stores/equipment.js";
import Form from "./Form.vue";
const props = defineProps({
  visible: {
    type: Boolean,
    default: false,
  },
});
const emit = defineEmits(["update:visible"]);
const { editEquipment, form } = useEquipment();
const onsubmit = async () => {
  await editEquipment();
  if (form.meta.valid && form.submitCount) {
    emit("update:visible", false);
    form.resetForm();
  }
};
</script>

<template>
  <Dialog
    header="Edit Equipment"
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
