<script setup>
import FileUpload from "primevue/fileupload";
import { useChallenge } from "@/stores/challenge";
import { onMounted } from "vue";
import { status } from "@/utils/option";
import { useToast } from "primevue/usetoast";
import Panel from "primevue/panel";
import InputNumber from "primevue/inputnumber";

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
  <div class="flex-col space-y-6">
    <div class="card col-span-2">
      <Panel header="Challenge Settings">
        <div class="flex">
          <div class="w-1/2"></div>
          <div class="w-1/2">
            
          </div>
        </div>
      </Panel>
    </div>
    <div class="card">
      <Panel header="Permissions Settings">
        <div class="grid grid-cols-2 gap-6">
          <div class="p-inputgroup flex-1">
            <span class="p-inputgroup-addon w-1/2 !justify-start">
              <p>limited scope of participation</p>
            </span>

            <Dropdown placeholder="All" class="w-full md:w-14rem" />
          </div>
          <div class="p-inputgroup flex-1">
            <span class="p-inputgroup-addon w-1/2 !justify-start">
              <p>member censorship</p>
            </span>

            <Dropdown placeholder="All" class="w-full md:w-14rem" />
          </div>
          <div class="p-inputgroup flex-1">
            <span class="p-inputgroup-addon w-1/2 !justify-start">
              <p>result censorship</p>
            </span>

            <Dropdown placeholder="All" class="w-full md:w-14rem" />
          </div>
          <div class="p-inputgroup flex-1">
            <span class="p-inputgroup-addon w-1/2 !justify-start">
              <p>maximum members</p>
            </span>

            <InputNumber inputId="maxNumber" :min="0"  />
          </div>
        </div>
      </Panel>
    </div>
    <div class="card">
      <Panel header="Conditions of participation">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
      </Panel>
    </div>
    <div class="card col-span-2">
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
  </div>
</template>
