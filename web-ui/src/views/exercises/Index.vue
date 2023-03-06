<script setup>
import { onMounted } from 'vue';

import BaseView from "../BaseView.vue";
import { useEquipment } from "@/stores/equipment";

const store = useEquipment();

onMounted(store.getEquipments);
</script>
<template>
  <base-view title="Exercises">
    <div class="card h-64">
      <DataView></DataView>
    </div>
  </base-view>
</template>
