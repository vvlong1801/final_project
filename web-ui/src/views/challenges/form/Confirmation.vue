<script setup>
import { useChallenge } from "@/stores/challenge";
import { status } from "@/utils/option";

const { form, challengeTypes } = useChallenge();
const pageIndex = 2;
</script>
<template>
  <div class="card flex flex-col space-y-6">
    <Image :src="form.image?.url" :alt="form.image?.name" />
    <div class="flex space-x-6">
      <div class="w-1/3 flex grid grid-cols-2 gap-6">
        <input-text v-model="form.name" class="col-span-2" />
        <Dropdown
          id="type"
          class="w-full"
          v-model="form.type"
          :options="challengeTypes"
          placeholder="enter type"
        />
        <Dropdown
          id="status"
          class="w-full"
          :options="status"
          v-model="form.status"
          placeholder="enter status"
        />
        <Textarea v-model="form.description" class="col-span-2" />
      </div>
      <Divider layout="vertical" />
      <div class="w-2/3 grid grid-cols-3">
        <Image
          v-for="exe in form.exercises"
          :key="exe.id"
          :src="exe.gif?.url"
          :alt="exe.name"
        />
      </div>
    </div>
    <div class="flex justify-between">
      <Button
        icon="pi pi-angle-left"
        label="Back"
        @click="$emit('prevPage', pageIndex)"
      />
      <Button
        icon="pi pi-check"
        label="Create"
        @click="$emit('submit')"
        iconPos="right"
        class="p-button-success"
      />
    </div>
  </div>
</template>
