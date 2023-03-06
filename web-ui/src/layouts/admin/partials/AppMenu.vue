<script setup>
import { ref } from "vue";
import AppMenuItem from "./AppMenuItem.vue";
import { appMenu } from "@/configs/menu";
const model = ref(appMenu);

</script>
<template>
  <ul class="layout-menu">
    <template v-for="(item, i) in model" :key="item">
      <app-menu-item
        v-if="!item.separator"
        :item="item"
        :index="i"
      ></app-menu-item>
      <li v-if="item.separator" class="menu-separator"></li>
    </template>
  </ul>
</template>
