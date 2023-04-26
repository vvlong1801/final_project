<script setup>
import Week from "./Week.vue";
import { computed } from "@vue/reactivity";
import { defineProps } from "vue";
const props = defineProps({ activeDays: Number, restDays: Number });
const countWeeks = computed(() => {
  const sessions = props.activeDays + props.restDays;
  return sessions % 7 ? Math.floor(sessions / 7) + 1 : Math.floor(sessions / 7);
});

const countSession = (week, countWeeks, totalDays) => {
  if (week === countWeeks && totalDays % 7) return totalDays % 7;
  else return 7;
};
</script>
<template>
  <div class="flex-col space-y-2">
    <div class="flex space-x-2 items-end justify-end pl-10">
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 1</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 2</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 3</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 4</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 5</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 6</p>
      </div>
      <div class="bg-red-400 flex-1 h-8 flex justify-center items-center">
        <p>Day 7</p>
      </div>
    </div>
    <Week
      v-for="week in countWeeks"
      :index="week"
      :count-sessions="countSession(week, countWeeks, activeDays + restDays)"
    />
  </div>
</template>
<style scoped>
p {
  font-size: medium;
  font-weight: 500;
  color: azure;
}
</style>