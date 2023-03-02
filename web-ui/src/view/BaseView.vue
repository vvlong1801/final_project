<script setup>
import { defineProps } from "vue";
import Breadcrumbs from "@/components/atoms/Breadcrumbs.vue";
const props = defineProps(["title", "breadcrumbs"]);

const breadcrumbs = [
  {
    title: "Dashboard",
    href: "/",
  },
  {
    title: "Equipment",
    href: "/equipments",
  },
  {
    title: "Table",
    href: "",
  },
];
</script>
<template>
  <div class="space-y-6">
    <div class="space-y-2">
      <h1 name="title" class="text-2xl font-bold tracking-tight">
        {{ props.title }}
      </h1>
      <Breadcrumbs :items="breadcrumbs"></Breadcrumbs>
    </div>
    <slot></slot>
  </div>
</template>
