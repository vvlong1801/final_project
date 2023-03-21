<script setup>
import { defineProps, onMounted } from "vue";
import { useExercise } from "@/stores/exercise.js";
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
const storeMuscle = useMuscle();
const storeEquipment = useEquipment();
const toast = useToast();

onMounted(() => {
  storeMuscle.getMuscles();
  storeEquipment.getEquipments();
});

const onUpload = async (event, type) => {
  const file = event.files[0];
  console.log(type);
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
  <div class="flex gap-6">
    <Toast />
    <div class="card grid grid-cols-10 gap-6 w-full">
      <label for="name" class="col-span-4 col-start-1">
        <div>Name</div>
        <InputText
          class="w-full"
          type="text"
          label="name"
          id="name"
          v-model="form.name"
        />
      </label>
      <label for="level" class="col-span-2 col-start-1">
        <div>Level</div>
        <Dropdown
          class="w-full"
          type="text"
          label="level"
          id="level"
          placeholder="select level"
          :options="levelTypes"
          v-model="form.level"
        />
      </label>
      <label for="type" class="col-span-2 col-start-3">
        <div>Type</div>
        <Dropdown
          class="w-full"
          type="text"
          label="type"
          id="type"
          :options="exerciseTypes"
          v-model="form.type"
          placeholder="select type"
        />
      </label>
      <label for="muscles" class="col-span-2 col-start-1">
        <div>Muscle</div>
        <MultiSelect
          class="w-full"
          label="type"
          id="type"
          :options="storeMuscle.muscles"
          optionLabel="name"
          v-model="form.muscles"
          display="chip"
          placeholder="select muscle"
        >
          <template #option="slotProps">
            <div class="flex items-center">
              <img
                :alt="slotProps.option.name"
                :src="slotProps.option.image.url"
                class="mr-2 w-8"
              />
              <div>{{ slotProps.option.name }}</div>
            </div>
          </template>
          <template #footer>
            <div class="py-2 px-3">
              <b>{{ form.muscles ? form.muscles.length : 0 }}</b>
              item{{ (form.muscles ? form.muscles.length : 0) > 1 ? "s" : "" }}
              selected.
            </div>
          </template>
        </MultiSelect>
      </label>
      <label for="equipment" class="col-span-2 col-start-3">
        <div>Equipment</div>
        <Dropdown
          class="w-full"
          label="type"
          id="type"
          :options="storeEquipment.equipments"
          optionLabel="name"
          dataKey="id"
          v-model="form.equipment"
          placeholder="select equipment"
        >
          <template #option="slotProps">
            <div class="flex items-center">
              <img
                :alt="slotProps.option.name"
                :src="slotProps.option.image.url"
                class="mr-2 w-8"
              />
              <div>{{ slotProps.option.name }}</div>
            </div>
          </template>
        </Dropdown>
      </label>
      <label for="video" class="col-start-1 col-span-4">
        <div>Video</div>
        <span class="p-input-icon-left w-full items-center">
          <i class="pi pi-youtube" />
          <InputText
            class="w-full"
            label="video"
            id="video"
            placeholder="enter video url"
            v-model="form.video"
          />
        </span>
      </label>

      <label for="gif" class="col-span-3 col-start-5 row-start-1 row-span-3">
        <div>Gif</div>
        <FileUpload
          name="gif"
          accept="image/*"
          :maxFileSize="1000000"
          @uploader="onUpload($event, 'gif')"
          auto
          custom-upload
        >
          <template
            #header="{ chooseCallback, uploadCallback, clearCallback, files }"
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
      </label>
      <label for="image" class="col-span-3 col-start-8 row-start-1 row-span-3">
        <div>Image</div>
        <FileUpload
          name="image"
          accept="image/*"
          :maxFileSize="1000000"
          @uploader="onUpload($event, 'image')"
          auto
          custom-upload
        >
          <template
            #header="{ chooseCallback, uploadCallback, clearCallback, files }"
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
      </label>
      <label for="desc" class="col-span-6 col-start-5 row-span-3">
        <div>Description</div>
        <Textarea
          class="w-full"
          type="text"
          label="type"
          id="desc"
          placeholder="enter description"
          v-model="form.description"
          rows="5"
        />
      </label>
      <Button
        :label="props.type == 'edit' ? 'Update' : 'Create'"
        class="col-start-1 col-span-1 w-full"
        @click="$emit('handleSubmit')"
      />
    </div>
  </div>
</template>
