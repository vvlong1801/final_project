<script setup>
const pageIndex = 2;
</script>
<template>
  <div class="card">
    confirmation
    <div class="flex justify-between">
      <Button
        icon="pi pi-angle-left"
        label="Back"
        @click="$emit('prevPage', pageIndex)"
      />
      <Button
        icon="pi pi-check"
        label="Complete"
        @click="$emit('complete')"
        iconPos="right"
        class="p-button-success"
      />
    </div>
  </div>
</template>
