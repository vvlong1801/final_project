<script setup>
import FileUpload from "primevue/fileupload";
import { useChallenge } from "@/stores/challenge";
import { onMounted } from "vue";
import { status } from "@/utils/option";
import { useToast } from "primevue/usetoast";
import Panel from "primevue/panel";
import InputNumber from "primevue/inputnumber";
import RadioButton from "primevue/radiobutton";
import Calendar from "primevue/calendar";
import SelectButton from 'primevue/selectbutton';

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
    <div class="card">
      <Panel header="Challenge Settings">
        <div class="flex p-2 space-x-6 h-fit">
          <div class="w-1/2 space-y-6">
            <div class="p-inputgroup flex-1">
              <span class="p-inputgroup-addon w-1/3 !justify-start">
                <p>Challenge Name</p>
              </span>

              <InputText placeholder="enter name" class="w-full md:w-14rem" />
            </div>
            <div class="p-inputgroup flex-1">
              <span class="p-inputgroup-addon w-1/3 !justify-start">
                <p>Start Date</p>
              </span>

              <Calendar v-model="date" showIcon />
            </div>
            <div class="p-inputgroup flex-1">
              <span class="p-inputgroup-addon w-1/3 !justify-start">
                <p>End Date</p>
              </span>

              <Calendar v-model="date" showIcon />
            </div>
            <div class="p-inputgroup flex-1">
              <span class="p-float-label">
                <Textarea v-model="value" rows="5" cols="30" />
                <label>Description</label>
              </span>
            </div>
          </div>
          <div class="w-1/2">
            <FileUpload accept="image/*" :maxFileSize="1000000" class="h-full">
              <template #empty>
                <div class="h-full">
                  <p>Drag and drop files to here to upload.</p>
                </div>
              </template>
            </FileUpload>
          </div>
        </div>
      </Panel>
    </div>
    <div class="card">
      <Panel header="Permissions Settings">
        <div class="grid grid-cols-2 gap-6 p-2">
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

            <InputNumber inputId="maxNumber" :min="0" />
          </div>
        </div>
      </Panel>
    </div>
    <div class="card">
      <Panel header="Conditions of participation">
        <div class="flex-col space-y-6">
          <div class="flex space-x-6">
            <div class="flex items-center justify-between space-x-4 w-1/2">
              <div>Do you need a commit to join the challenge?</div>
              <div class="flex space-x-4 items-center">
                <RadioButton
                  v-model="ingredient"
                  inputId="ingredient1"
                  name="pizza"
                  value="Cheese"
                />
                <label for="ingredient1" class="ml-2"> Yes </label>
                <RadioButton
                  v-model="ingredient"
                  inputId="ingredient1"
                  name="pizza"
                  value="Cheese"
                />
                <label for="ingredient1" class="ml-2"> No </label>
              </div>
            </div>
            <div class="p-inputgroup !justify-end !w-1/6 p-disabled">
              <span class="p-inputgroup-addon"
                ><i class="pi pi-bitcoin"></i
              ></span>
              <InputNumber placeholder="Point" />
            </div>
          </div>
          <div class="flex space-x-6">
            <div class="flex items-center justify-between space-x-4 w-1/2">
              <div>Does the challenge have a commit refund?</div>
              <div class="flex space-x-4 items-center">
                <RadioButton
                  v-model="ingredient"
                  inputId="ingredient1"
                  name="pizza"
                  value="Cheese"
                />
                <label for="ingredient1" class="ml-2"> Yes </label>
                <RadioButton
                  v-model="ingredient"
                  inputId="ingredient1"
                  name="pizza"
                  value="Cheese"
                />
                <label for="ingredient1" class="ml-2"> No </label>
              </div>
            </div>
            <div class="p-inputgroup !w-1/12 p-disabled">
              <InputNumber placeholder="100" />
              <span class="p-inputgroup-addon">%</span>
            </div>
          </div>
          <div class="flex items-center justify-start space-x-6">
            <div>Conditions of refund?</div>
            <div class="flex items-center">
              <RadioButton
                v-model="ingredient"
                inputId="ingredient1"
                name="pizza"
                value="Cheese"
              />
              <label for="ingredient1" class="ml-2">
                Completed the challenge
              </label>
            </div>
            <div class="flex items-center">
              <RadioButton
                v-model="ingredient"
                inputId="ingredient2"
                name="pizza"
                value="Mushroom"
              />
              <label for="ingredient2" class="ml-2"
                >completed within the time limit</label
              >
            </div>
          </div>
          <!-- max count -->
          <div class="flex items-center justify-start space-x-6">
            <div>Max numbers of member</div>
            <InputNumber
              v-model="value2"
              inputId="minmax-buttons"
              mode="decimal"
              showButtons
            />
          </div>
          <!-- approve required -->
          <div class="flex items-center justify-start space-x-6">
            <div>Required approve?</div>
            <div class="flex items-center">
              <RadioButton
                v-model="ingredient"
                inputId="ingredient1"
                name="pizza"
                value="Cheese"
              />
              <label for="ingredient1" class="ml-2"> Yes </label>
            </div>
            <div class="flex items-center">
              <RadioButton
                v-model="ingredient"
                inputId="ingredient2"
                name="pizza"
                value="Mushroom"
              />
              <label for="ingredient2" class="ml-2">No</label>
            </div>
          </div>
          <!-- rank members -->
          <div class="flex items-center justify-start space-x-6">
            <div>Rank member?</div>
            <SelectButton v-model="value" :options="options" optionLabel="name" multiple aria-labelledby="multiple" />
          </div>
        </div>
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
