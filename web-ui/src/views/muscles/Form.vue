<script setup>
import { defineProps } from "vue";
import { useMuscle } from "@/stores/muscle.js";
import FileUpload from "primevue/fileupload";
import { useToast } from "primevue/usetoast";

const { form, createMuscle, editMuscle } = useMuscle();
const toast = useToast();
const props = defineProps({
  visible: {
    type: Boolean,
    default: false,
  },
  formType: {
    type: String,
    default: "create",
    validator(value) {
      return ["create", "edit"].includes(value);
    },
  },
});

const emits = defineEmits(["update:visible"]);

const onSubmit = () => {
  if (props.formType.toLowerCase() == "create") {
    createMuscle();
  } else editMuscle();
  emits("update:visible", false);
};

const onUpload = async (event) => {
  const file = event.files[0];

  const formData = new FormData();
  formData.append("file", file);
  formData.append("collection", "muscles");
  formData.append("type", "image");

  try {
    const res = await window.axios.post("upload", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    form.image = res.data.data || res.data;

    toast.add({
      severity: "success",
      summary: "Success",
      detail: "File Uploaded",
      life: 3000,
    });
  } catch (error) {
    toast.add({
      severity: "error",
      summary: "Error Upload",
      detail: error,
      life: 3000,
    });
  }
};
</script>
<template>
  <Dialog
    :header="`${props.formType} Muscle`.toUpperCase()"
    v-model:visible="props.visible"
    @update:visible="$emit('update:visible', false)"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
    :modal="true"
  >
    <div class="grid grid-cols-4 gap-6 py-6">
      <label for="name" class="col-span-2">
        <div>Name</div>
        <InputText
          class="w-full"
          type="text"
          label="name"
          id="name"
          v-model="form.name"
        />
      </label>

      <div class="col-span-1">
        <h5>Image</h5>
        <FileUpload
          name="image"
          mode="basic"
          :customUpload="true"
          :auto="true"
          @uploader="onUpload"
          :upload-icon="form.image ? '' : 'pi pi-fw pi-upload'"
          :choose-label="form.image?.filename"
          class="w-40"
        >
        </FileUpload>
      </div>
      <div class="col-span-1">
        <h5>Icon</h5>
        <FileUpload
          name="icon"
          mode="basic"
          :customUpload="true"
          :auto="true"
          @uploader="onUpload"
          :upload-icon="form.icon ? '' : 'pi pi-fw pi-upload'"
          :choose-label="form.icon?.filename"
          class="w-40"
        />
      </div>
      <div class="col-span-4">
        <label for="address1">
          <span>Description</span>
          <Textarea
            v-model="form.description"
            class="textarea-restyle"
            rows="5"
            id="description"
          />
        </label>
      </div>
    </div>
    <template #footer>
      <Button
        label="Cancel"
        icon="pi pi-times"
        @click="$emit('update:visible', false)"
        class="p-button-text"
      />
      <Button label="Save" icon="pi pi-check" @click="onSubmit" />
    </template>
  </Dialog>
</template>
