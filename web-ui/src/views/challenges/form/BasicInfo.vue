<script setup>
import FileUpload from "primevue/fileupload";
import { useChallenge } from "@/stores/challenge";
import { onMounted } from "vue";
import { status } from "@/utils/option";
import { useToast } from "primevue/usetoast";

const challengeStore = useChallenge();
const toast = useToast();
const pageIndex = 0;

onMounted(challengeStore.getChallengeTypes);

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

    challengeStore.form[type] = res.data.data || res.data;

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
  <div class="card flex flex-col space-y-6 min-h-full">
    <div class="grid grid-cols-5 gap-4">
      <label id="title" class="col-span-2">
        <div>Name</div>
        <input-text
          id="name"
          placeholder="enter name..."
          class="w-full"
          v-model="challengeStore.form.name"
        />
      </label>
      <label for="type" class="row-start-2 col-span-2">
        <div>Type</div>
        <Dropdown
          id="type"
          class="w-full"
          v-model="challengeStore.form.type"
          :options="challengeStore.challengeTypes"
          placeholder="enter type"
        />
      </label>
      <label for="status" class="row-start-3 col-span-2">
        <div>Status</div>
        <Dropdown
          id="status"
          class="w-full"
          :options="status"
          v-model="challengeStore.form.status"
          placeholder="enter status"
        />
      </label>
      <label for="image" class="row-start-1 col-span-3 row-span-3 col-start-3">
        <div>Banner</div>
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
              <span v-if="challengeStore.form.image">{{
                challengeStore.form.image?.filename
              }}</span>
            </div>
          </template>
          <template #content>
            <Image
              v-if="challengeStore.form.image"
              :src="challengeStore.form.image?.url"
              :alt="challengeStore.form.image?.name"
              class="w-full flex justify-center items-center"
            />
            <div v-else>
              <p>Drag and drop files to here to upload.</p>
            </div>
          </template>
        </FileUpload>
      </label>
      <label for="description" class="col-span-5">
        <div>Description</div>
        <Textarea
          id="description"
          v-model="challengeStore.form.description"
          class="w-full"
          rows="3"
        />
      </label>
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
