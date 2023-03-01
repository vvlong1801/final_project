<script setup>
import { defineProps } from "vue";
import { RouterLink } from "vue-router";
import { menu as menuItems } from "@/config/menu";

const props = defineProps(["drawer"]);
</script>
<template>
  <ul class="menu bg-base-100 p-2 rounded-box grid grid-col gap-1">
    <li v-for="item in menuItems">
      <router-link
        :to="{ name: item.route }"
        :class="{ active: $route.name.includes(item.prefix) }"
        class="py-2 px-4"
      >
        {{ item.title }}
      </router-link>
    </li>
  </ul>
</template>
