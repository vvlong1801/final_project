<script setup>
import { defineProps, onMounted } from "vue";
import { useExercise } from "@/stores/exercise.js";
import { useGroupExercise } from "@/stores/group_exercise.js";
import { useMuscle } from "@/stores/muscle.js";
import { useEquipment } from "@/stores/equipment.js";
import FileUpload from "primevue/fileupload";

import { exerciseTypes, levelTypes } from "@/utils/option";
import { useFile } from "@/composables/file.js";

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

onMounted(async () => {
  await muscleStore.getMuscles();
  await equipmentStore.getEquipments();
  await groupExerciseStore.getGroupExercisesToOptions();
});

const fileService = useFile();

const onUpload = async (event, type) => {
  await fileService.upload(event, "exercises", type);
  form.values[type] = fileService.file.value;
};
const checkValidate = (type) => form.errors[type] && form.submitCount;
</script>
<template>
  <div class="flex flex-col gap-6">
    <Toast />
    <div class="card p-8 flex gap-8 w-full">
      <div class="grid grid-cols-4 grid-flow-row auto-rows-max gap-8 w-2/5">
        <div class="flex flex-col col-span-2 col-start-1">
          <div class="p-float-label">
            <InputText id="name" v-model="form.values.name" class="w-full" />
            <label for="name">Name</label>
          </div>
          <small class="p-error" id="text-error" v-if="checkValidate('name')">{{
            form.errors.name || "&nbsp;"
          }}</small>
        </div>
        <div class="col-span-2 col-start-3">
          <div class="p-float-label">
            <Dropdown
              v-model="form.values.groupExercise"
              :options="groupExerciseStore.toOptions"
              optionLabel="name"
              class="w-full"
              inputId="group_exercise"
            />
            <label for="group" class="truncate max-w-full pr-8"
              >Select group</label
            >
          </div>
        </div>
        <div class="col-span-2 col-start-1">
          <div class="p-float-label">
            <Dropdown
              v-model="form.values.level"
              :options="levelTypes"
              optionLabel="label"
              class="w-full"
              inputId="level"
            />
            <label for="level" class="truncate max-w-full pr-8"
              >Select level</label
            >
          </div>
          <small
            class="p-error"
            id="text-error"
            v-if="checkValidate('level')"
            >{{ form.errors.level || "&nbsp;" }}</small
          >
        </div>
        <div class="col-span-2 col-start-3">
          <div class="p-float-label">
            <Dropdown
              v-model="form.values.type"
              :options="exerciseTypes"
              class="w-full"
              optionLabel="label"
              inputId="type"
            >
              <template #option="slotProps">
                <div class="flex items-center justify-between">
                  <p class="capitalize">{{ slotProps.option.label }}</p>
                  <i class="mr-2 w-8" :class="`pi ${slotProps.option.icon}`" />
                </div>
              </template>
            </Dropdown>
            <label for="type" class="truncate max-w-full pr-8"
              >Select type</label
            >
          </div>
          <small class="p-error" id="text-error" v-if="checkValidate('type')">{{
            form.errors.type || "&nbsp;"
          }}</small>
        </div>
        <div class="col-span-2 col-start-1">
          <div class="p-float-label">
            <MultiSelect
              class="w-full"
              :options="muscleStore.muscles"
              optionLabel="name"
              v-model="form.values.muscles"
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
                  <b>{{
                    form.values.muscles ? form.values.muscles.length : 0
                  }}</b>
                  item{{
                    (form.values.muscles ? form.values.muscles.length : 0) > 1
                      ? "s"
                      : ""
                  }}
                  selected.
                </div>
              </template>
            </MultiSelect>
            <label for="muscles" class="truncate max-w-full pr-8"
              >Select muscles</label
            >
          </div>
          <small
            class="p-error"
            id="text-error"
            v-if="checkValidate('muscles')"
            >{{ form.errors.muscles || "&nbsp;" }}</small
          >
        </div>
        <div class="col-span-2 col-start-3">
          <div class="p-float-label">
            <Dropdown
              class="w-full"
              :options="equipmentStore.equipments"
              optionLabel="name"
              v-model="form.values.equipment"
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
        </div>
        <div class="col-span-4 col-start-1">
          <div class="p-float-label">
            <Textarea
              v-model="form.values.description"
              class="w-full"
              id="description"
              rows="5"
            />
            <label for="description">Enter description</label>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-3/5 gap-8">
        <div class="p-inputgroup">
          <span class="p-inputgroup-addon">
            <i class="pi pi-link"></i>
          </span>
          <div class="p-float-label">
            <InputText
              class="w-full"
              id="video"
              placeholder="enter video url"
              v-model="form.values.video"
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
                <div class="flex space-x-4 items-center justify-between w-full">
                  <Button @click="chooseCallback" icon="pi pi-cloud-upload" />
                  <Badge
                    :value="form.values.gif?.filename ?? 'gif'"
                    class="p-2"
                  />
                </div>
              </template>
              <template #content>
                <Image
                  v-if="form.values.gif"
                  :src="form.values.gif?.url"
                  :alt="form.values.gif?.name"
                  class="w-full flex justify-center items-center"
                />
                <div v-else>
                  <p>Drag and drop files to here to upload.</p>
                </div>
              </template>
            </FileUpload>
            <small
              class="p-error"
              id="text-error"
              v-if="checkValidate('gif')"
              >{{ form.errors.gif || "&nbsp;" }}</small
            >
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
                <div class="flex space-x-4 items-center justify-between w-full">
                  <Button @click="chooseCallback" icon="pi pi-cloud-upload" />
                  <Badge
                    :value="form.values.image?.filename ?? 'image'"
                    class="p-2"
                  />
                </div>
              </template>
              <template #content>
                <Image
                  v-if="form.values.image"
                  :src="form.values.image?.url"
                  :alt="form.values.image?.name"
                  class="w-full flex justify-center items-center"
                />
                <div v-else>
                  <p>Drag and drop files to here to upload.</p>
                </div>
              </template>
            </FileUpload>
            <small
              class="p-error"
              id="text-error"
              v-if="checkValidate('image')"
              >{{ form.errors.image || "&nbsp;" }}</small
            >
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
