<script setup>
import { useChallenge } from "../../stores/challenge";
import BaseView from "../BaseView.vue";

import { onMounted } from "vue";
const store = useChallenge();

onMounted(store.getChallenges);
</script>
<template>
  <base-view title="Challenges">
    <Toast />
    <div class="card space-y-6 min-h-full">
      <Toolbar>
        <template #start>
          <Button
            label="New"
            type="button"
            icon="pi pi-plus"
            class="!mr-2"
            @click="$router.push({ name: 'challenges.create' })"
          />
        </template>
        <template #end>
          <span class="p-input-icon-left">
            <i class="pi pi-search" />
            <InputText placeholder="Search..." />
          </span>
        </template>
      </Toolbar>
      <div class="w-full grid grid-cols-4 gap-6">
        <Card v-for="challenge in store.challenges" :key="challenge.id">
          <template #header>
            <img
              alt="challenge cover"
              :src="challenge.image?.url"
              class="rounded-t"
            />
          </template>
          <template #title>
            <div class="flex justify-between items-center">
              <div>{{ challenge.name }}</div>
              <Badge value="active" class="p-badge-success" />
            </div>
          </template>
          <template #subtitle>
            <div class="flex justify-between items-center">
              <div>{{ challenge.type }}</div>
              <Badge
                :value="`${challenge.exercises_count} exercises`"
                class="p-badge-success"
              />
            </div>
          </template>
          <template #footer>
            <div class="flex justify-end space-x-2">
              <Button
                icon="pi pi-pencil"
                aria-label="Edit"
                @click="
                  $router.push({
                    name: 'challenges.edit',
                    params: {
                      id: challenge.id,
                    },
                  })
                "
                class="p-button-sm"
              />
              <Button
                icon="pi pi-trash"
                aria-label="Delete"
                class="p-button-danger p-button-sm"
                @click="store.deleteChallenge(challenge.id)"
              />
            </div>
          </template>
        </Card>
      </div>
    </div>
  </base-view>
</template>
