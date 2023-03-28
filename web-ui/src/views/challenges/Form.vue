<script setup>
import FileUpload from "primevue/fileupload";
import { useToast } from "primevue/usetoast";
import { useChallenge } from "@/stores/challenge";
import { useExercise } from "@/stores/exercise";
import { onMounted } from "vue";
import { status } from "@/utils/option";

const toast = useToast();
const store = useChallenge();
const { exercises, getExercises } = useExercise();

onMounted(() => {
  store.getChallengeTypes();
  getExercises();
});

const onUpload = async (event, type) => {
  const file = event.files[0];
  const formData = new FormData();
  formData.append("file", file);
  formData.append("collection", "challenges");
  formData.append("type", type);

  try {
    const res = await window.axios.post("upload", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    store.form[type] = res.data.data || res.data;

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
  <div class="card flex space-y-6 min-h-full">
    <div class="w-1/3 grid grid-cols-2 gap-4">
      <label id="title" class="col-span-2">
        <div>Name</div>
        <input-text
          id="name"
          placeholder="enter name..."
          class="w-full"
          v-model="store.form.name"
        />
      </label>
      <label for="type">
        <div>Type</div>
        <Dropdown
          id="type"
          class="w-full"
          v-model="store.form.type"
          optionLabel="name"
          :options="store.challengeTypes"
          placeholder="enter type"
          dataKey="id"
        />
      </label>
      <label for="status">
        <div>Status</div>
        <Dropdown
          id="status"
          class="w-full"
          :options="status"
          v-model="store.form.status"
          placeholder="enter status"
        />
      </label>
      <label for="banner" class="col-span-2">
        <div>Banner</div>
        <FileUpload
          name="banner"
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
              <span v-if="store.form.banner">{{
                store.form.banner?.filename
              }}</span>
            </div>
          </template>
          <template #content>
            <Image
              v-if="store.form.image"
              :src="store.form.image?.url"
              :alt="store.form.image?.name"
              class="w-full flex justify-center items-center"
            />
            <div v-else>
              <p>Drag and drop files to here to upload.</p>
            </div>
          </template>
        </FileUpload>
      </label>
    </div>
    <div class="w-2/3"></div>
  </div>
</template>
