<script setup>
import { defineProps } from "vue";
import { RouterLink } from "vue-router";
const props = defineProps(["items"]);
</script>
<template>
  <div class="text-sm breadcrumbs">
    <ul>
      <li v-for="item in props.items">
        <router-link :to="item.href" :class="{ disabled: item.href === '' }">{{
          item.title
        }}</router-link>
      </li>
    </ul>
  </div>
</template>
