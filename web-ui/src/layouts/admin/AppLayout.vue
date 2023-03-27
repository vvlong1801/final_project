<script setup>
import { RouterView } from "vue-router";
import AppTopbar from "./partials/AppTopbar.vue";
import AppSidebar from "./partials/AppSidebar.vue";
</script>
<template>
  <div class="layout-wrapper">
    <app-topbar></app-topbar>
    <div class="layout-sidebar">
      <app-sidebar></app-sidebar>
    </div>
    <div class="layout-main-container">
      <div class="relative w-full">
        <router-view></router-view>
      </div>
      <!-- <app-footer></app-footer> -->
    </div>
    <!-- <app-config></app-config> -->
    <div class="hidden"></div>
  </div>
</template>
