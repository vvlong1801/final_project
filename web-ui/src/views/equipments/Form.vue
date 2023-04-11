<script setup>
import { onMounted } from "vue";
import { useEquipment } from "@/stores/equipment.js";
import { useFile } from "@/composables/file.js";
import FileUpload from "primevue/fileupload";

const { form, editItem } = useEquipment();
const fileService = useFile();
const props = defineProps({
  editForm: Boolean,
});

onMounted(() => {
  form.resetForm();
  if (props.editForm) {
    form.setValues(editItem);
  }
});

const onUpload = async (event, type) => {
  await fileService.upload(event, "equipments", type);
  form.values[type] = fileService.file.value;
};
</script>
<template>
  <div class="grid grid-cols-4 gap-6 py-6">
    <div class="col-span-2">
      <div class="p-float-label">
        <InputText
          class="w-full"
          :class="{ 'p-invalid': form.errors.name }"
          type="text"
          label="name"
          id="name"
          v-model="form.values.name"
        />
        <label for="name">Enter name</label>
      </div>
      <small class="p-error" id="text-error">{{
        form.errors.name || "&nbsp;"
      }}</small>
    </div>
    <div class="col-span-1">
      <FileUpload
        name="image"
        mode="basic"
        :customUpload="true"
        :auto="true"
        @uploader="onUpload($event, 'image')"
        :upload-icon="form.values.image ? '' : 'pi pi-fw pi-upload'"
        :choose-label="form.values.image?.filename ?? 'Image'"
        class="w-40"
      >
      </FileUpload>
      <small class="p-error" id="text-error">{{
        form.errors.image || "&nbsp;"
      }}</small>
    </div>
    <div class="col-span-1">
      <FileUpload
        name="icon"
        mode="basic"
        :customUpload="true"
        :auto="true"
        @uploader="onUpload($event, 'icon')"
        :upload-icon="form.values.icon ? '' : 'pi pi-fw pi-upload'"
        :choose-label="form.values.icon?.filename ?? 'Icon'"
        class="w-40"
      />
    </div>
    <div class="col-span-4 p-float-label">
      <Textarea
        v-model="form.values.description"
        class="w-full"
        rows="5"
        id="description"
      />
      <label for="description">Description</label>
    </div>
  </div>
</template>
