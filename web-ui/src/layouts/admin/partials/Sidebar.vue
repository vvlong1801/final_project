<script setup>
import { defineProps } from "vue";
import { RouterLink } from "vue-router";
import { menu as menuItems } from "@/config/menu";

const props = defineProps(["drawer"]);
</script>
<template>
  <div class="h-full px-3 overflow-y-auto bg-gray-50 dark:bg-gray-800">
    <ul class="space-y-2">
      <li v-for="(item, index) in menuItems" :key="index">
        <router-link
          :to="{ name: item.route }"
          class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
          :class="{ active: $route.name.includes(item.prefix) }"
        >
          <font-awesome-icon :icon="item.icon ?? 'fa-solid fa-layer-group'" />
          <span class="ml-3">{{ item.title }}</span>
        </router-link>
      </li>
    </ul>
  </div>
</template>
