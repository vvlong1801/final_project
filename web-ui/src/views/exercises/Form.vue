<script setup>
import { defineProps, onMounted } from "vue";
import { useExercise } from "@/stores/exercise.js";
import { useGroupExercise } from "@/stores/group_exercise.js";
import { useMuscle } from "@/stores/muscle.js";
import { useEquipment } from "@/stores/equipment.js";
import FileUpload from "primevue/fileupload";
import { useToast } from "primevue/usetoast";
import { exerciseTypes, levelTypes } from "@/utils/option";

const props = defineProps({
  type: {
    required: false,
    default: "create",
  },
});
const { form } = useExercise();
const groupExerciseStore = useGroupExercise();
const muscleStore = useMuscle();
const equipmentStore = useEquipment();
const toast = useToast();

onMounted(async () => {
  muscleStore.getMuscles();
  equipmentStore.getEquipments();
  groupExerciseStore.getGroupExercisesToOptions();
});

const onUpload = async (event, type) => {
  const file = event.files[0];

  const formData = new FormData();
  formData.append("file", file);
  formData.append("collection", "exercises");
  formData.append("type", type);

  try {
    const res = await window.axios.post("upload", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    form[type] = res.data.data || res.data;

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
  <div class="flex flex-col gap-6">
    <Toast />
    <div class="card p-8 flex gap-8 w-full">
      <div class="grid grid-cols-4 grid-flow-row auto-rows-max gap-8 w-2/5">
        <div class="p-float-label col-span-2 col-start-1">
          <InputText id="name" v-model="form.name" class="w-full" />
          <label for="name">Name</label>
        </div>
        <div class="p-float-label col-span-2 col-start-3">
          <Dropdown
            v-model="form.groupExercise"
            :options="groupExerciseStore.toOptions"
            optionLabel="name"
            class="w-full"
            inputId="group_exercise"
          />
          <label for="group" class="truncate max-w-full pr-8"
            >Select group</label
          >
        </div>
        <div class="p-float-label !col-span-2 !col-start-1">
          <Dropdown
            v-model="form.level"
            :options="levelTypes"
            class="w-full"
            inputId="level"
          />
          <label for="level" class="truncate max-w-full pr-8"
            >Select level</label
          >
        </div>
        <div class="p-float-label !col-span-2 !col-start-3">
          <Dropdown
            v-model="form.type"
            :options="exerciseTypes"
            class="w-full"
            inputId="type"
          />
          <label for="type" class="truncate max-w-full pr-8">Select type</label>
        </div>
        <div class="p-float-label !col-span-2 !col-start-1">
          <MultiSelect
            class="w-full"
            :options="muscleStore.muscles"
            optionLabel="name"
            v-model="form.muscles"
            display="chip"
          >
            <template #option="slotProps">
              <div class="flex justify-between w-full items-center">
                <p class="capitalize">{{ slotProps.option.name }}</p>
                <img
                  :alt="slotProps.option.name"
                  :src="slotProps.option.image.url"
                  class="mr-2 w-8"
                />
              </div>
            </template>
            <template #footer>
              <div class="py-2 px-3">
                <b>{{ form.muscles ? form.muscles.length : 0 }}</b>
                item{{
                  (form.muscles ? form.muscles.length : 0) > 1 ? "s" : ""
                }}
                selected.
              </div>
            </template>
          </MultiSelect>
          <label for="muscles" class="truncate max-w-full pr-8"
            >Select muscles</label
          >
        </div>
        <div class="p-float-label !col-span-2 !col-start-3">
          <Dropdown
            class="w-full"
            :options="equipmentStore.equipments"
            optionLabel="name"
            v-model="form.equipment"
          >
            <template #option="slotProps">
              <div class="flex items-center justify-between">
                <p class="capitalize">{{ slotProps.option.name }}</p>
                <img
                  :alt="slotProps.option.name"
                  :src="slotProps.option.image.url"
                  class="mr-2 w-8"
                />
              </div>
            </template>
          </Dropdown>
          <label for="equipment" class="truncate max-w-full pr-8"
            >Select equipment</label
          >
        </div>
        <div class="p-float-label !col-span-4 !col-start-1">
          <Textarea
            v-model="form.description"
            class="w-full"
            id="description"
            rows="5"
          />
          <label for="description">Enter description</label>
        </div>
      </div>
      <div class="flex flex-col w-3/5 gap-8">
        <div class="p-inputgroup">
          <span class="p-inputgroup-addon">
            <i class="pi pi-youtube"></i>
          </span>
          <div class="p-float-label">
            <InputText
              class="w-full"
              id="video"
              placeholder="enter video url"
              v-model="form.video"
            />
            <label for="video">Video</label>
          </div>
        </div>
        <div class="flex gap-6 w-full">
          <div class="w-1/2 flex-auto">
            <FileUpload
              name="gif"
              accept="image/*"
              :maxFileSize="1000000"
              @uploader="onUpload($event, 'gif')"
              auto
              custom-upload
              class="w-1/2 flex-auto"
            >
              <template
                #header="{
                  chooseCallback,
                  uploadCallback,
                  clearCallback,
                  files,
                }"
              >
                <div class="flex space-x-4 items-center justify-center">
                  <Button @click="chooseCallback" icon="pi pi-cloud-upload" />
                  <span v-if="form.gif">{{ form.gif?.filename }}</span>
                </div>
              </template>
              <template #content>
                <Image
                  v-if="form.gif"
                  :src="form.gif?.url"
                  :alt="form.gif?.name"
                  class="w-full flex justify-center items-center"
                />
                <div v-else>
                  <p>Drag and drop files to here to upload.</p>
                </div>
              </template>
            </FileUpload>
          </div>
          <div class="flex-auto w-1/2">
            <FileUpload
              name="image"
              accept="image/*"
              :maxFileSize="1000000"
              @uploader="onUpload($event, 'image')"
              auto
              custom-upload
              class="!w-1/2 !flex-auto"
            >
              <template
                #header="{
                  chooseCallback,
                  uploadCallback,
                  clearCallback,
                  files,
                }"
              >
                <div class="flex space-x-4 items-center justify-center">
                  <Button @click="chooseCallback" icon="pi pi-cloud-upload" />
                  <span v-if="form.gif">{{ form.image?.filename }}</span>
                </div>
              </template>
              <template #content>
                <Image
                  v-if="form.image"
                  :src="form.image?.url"
                  :alt="form.image?.name"
                  class="w-full flex justify-center items-center"
                />
                <div v-else>
                  <p>Drag and drop files to here to upload.</p>
                </div>
              </template>
            </FileUpload>
          </div>
        </div>
      </div>
    </div>
    <Button
      :label="props.type == 'edit' ? 'Update' : 'Create'"
      class="!rounded-lg drop-shadow-lg"
      @click="$emit('handleSubmit')"
    />
  </div>
</template>
