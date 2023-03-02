<script setup>
import { onMounted, onUpdated } from "vue";
import { RouterLink } from "vue-router";
import { useExercise } from "@/store/exercise.js";
import BaseView from "../BaseView.vue";
import GridPagination from "../../components/atoms/GridPagination.vue";
import ExCard from "./components/ExCard.vue";
const store = useExercise();
onMounted(store.getExercises);
</script>
<template>
  <base-view title="Exercise">
    <div class="grid lg:grid-cols-6 sm:grid-cols-4 gap-6">
      <router-link to="/exercises/new">
        <div
          class="h-full border border-gray-200 rounded-lg shadow flex items-center justify-center bg-white cursor-pointer"
        >
          <font-awesome-icon
            icon="fa-solid fa-plus"
            class="text-3xl font-bold"
          />
        </div>
      </router-link>
      <ex-card
        v-for="exercise in store.exercises"
        :name="exercise.name"
        :key="exercise.id"
        :level="exercise.level"
      ></ex-card>
    </div>

    <grid-pagination
      :data="store.dataPagination"
      @paginate="(page) => store.setCurrentPage(page)"
    ></grid-pagination>
  </base-view>
</template>
