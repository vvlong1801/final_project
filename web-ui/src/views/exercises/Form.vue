<script setup>
import { defineProps, onMounted, ref } from "vue";
import { useExercise } from "@/stores/exercise.js";
import { useMuscle } from "@/stores/muscle.js";
import { useEquipment } from "@/stores/equipment.js";
import FileUpload from "primevue/fileupload";
import SelectButton from "primevue/selectbutton";
import AutoComplete from "primevue/autocomplete";

import { EVALUATE_METHOD, TYPE_LEVEL } from "@/utils/option";
import { useFile } from "@/composables/file.js";

const props = defineProps({
  type: {
    required: false,
    default: "create",
  },
});

const { form, groupTags, getGroupTags } = useExercise();
const muscleStore = useMuscle();
const equipmentStore = useEquipment();

const typeDescOpts = ["free", "step"];
const typeDesc = ref("free");

onMounted(async () => {
  await muscleStore.getMuscles();
  await equipmentStore.getEquipments();
  await getGroupTags();
});

const fileService = useFile();

const onUpload = async (event, type) => {
  await fileService.upload(event, "exercises", type);
  form.values[type] = fileService.file.value;
};

// const searchGroupTag = (event) => {
//   form.values.group_tags;
// };
const checkValidate = (type) => form.errors[type] && form.submitCount;
</script>
<template>
  <div class="flex flex-col gap-6">
    <Toast />
    <div class="card p-8 flex gap-8 w-full">
      <div class="grid grid-cols-2 auto-rows-max gap-6 w-1/2">
        <div class="flex flex-col">
          <div class="p-float-label">
            <InputText
              id="name"
              v-model="form.values.name"
              class="w-full"
              inputId="name"
            />
            <label for="name">Name</label>
          </div>
          <small class="p-error" id="text-error" v-if="checkValidate('name')">
            {{ form.errors.name || "&nbsp;" }}
          </small>
        </div>
        <div class="flex flex-col">
          <SelectButton
            v-model="form.values.level"
            :options="TYPE_LEVEL"
            optionLabel="label"
            aria-labelledby="multiple"
            class="grid grid-cols-3"
          />
          <small class="p-error" id="text-error" v-if="checkValidate('level')">
            {{ form.errors.level || "&nbsp;" }}
          </small>
        </div>

        <div class="flex flex-col col-span-2">
          <SelectButton
            v-model="form.values.evaluate_method"
            :options="EVALUATE_METHOD"
            optionLabel="label"
            aria-labelledby="multiple"
            class="w-full"
          >
            <template #option="slotProps">
              <div class="flex items-center justify-between">
                <i class="mr-2" :class="`pi ${slotProps.option.icon}`" />
                <p class="capitalize">{{ slotProps.option.label }}</p>
              </div>
            </template>
          </SelectButton>
          <small class="p-error" id="text-error" v-if="checkValidate('level')">
            {{ form.errors.type || "&nbsp;" }}
          </small>
        </div>
        <div class="p-float-label col-span-2">
          <AutoComplete
            v-model="form.values.group_tags"
            multiple
            :suggestions="groupTags"
            optionLabel="name"
            inputClass="!w-full"
            inputId="group"
          />
          <label for="group" class="truncate max-w-full pr-8">
            Select group
          </label>
        </div>
        <div class="flex-col">
          <div class="p-float-label">
            <MultiSelect
              class="w-full"
              :options="muscleStore.muscles"
              :loading="muscleStore.muscles === null"
              optionLabel="name"
              v-model="form.values.muscles"
              display="chip"
              loading
              inputId="muscles"
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
            <label for="muscles" class="truncate max-w-full pr-8">
              Select muscles
            </label>
          </div>
          <small
            class="p-error"
            id="text-error"
            v-if="checkValidate('muscles')"
          >
            {{ form.errors.muscles || "&nbsp;" }}
          </small>
        </div>

        <div class="p-float-label">
          <Dropdown
            class="w-full"
            :options="equipmentStore.equipments"
            optionLabel="name"
            v-model="form.values.equipment"
            :loading="equipmentStore.equipments === null"
            inputId="equipment"
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
          <label for="equipment" class="truncate max-w-full pr-8">
            Select equipment
          </label>
        </div>
        <div class="col-span-2">
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
              #header="{ chooseCallback, uploadCallback, clearCallback, files }"
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
          <small class="p-error" id="text-error" v-if="checkValidate('gif')">{{
            form.errors.gif || "&nbsp;"
          }}</small>
        </div>
        <div class="col-span-2">
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
              #header="{ chooseCallback, uploadCallback, clearCallback, files }"
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
        <div class="p-inputgroup col-span-2">
          <span class="p-inputgroup-addon">
            <i class="pi pi-link"></i>
          </span>
          <div class="p-float-label">
            <InputText
              class="w-full"
              placeholder="enter video url"
              v-model="form.values.video"
              inputId="video"
            />
            <label for="video">Video</label>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-1/2 gap-6">
        <SelectButton
          v-model="typeDesc"
          :options="typeDescOpts"
          aria-labelledby="basic"
          class="grid grid-cols-2"
        />
        <span class="p-float-label" v-if="typeDesc == 'free'">
          <Textarea
            v-model="form.values.description"
            rows="10"
            class="w-full"
            inputId="description"
          />
          <label for="description">Description</label>
        </span>
      </div>
    </div>
    <div class="flex justify-between">
      <Button
        label="Back"
        class="!rounded-lg drop-shadow-lg"
        @click="$emit('handleSubmit')"
      />
      <Button
        :label="props.type == 'edit' ? 'Update' : 'Create'"
        class="!rounded-lg drop-shadow-lg"
        @click="$emit('handleSubmit')"
      />
    </div>
  </div>
</template>
