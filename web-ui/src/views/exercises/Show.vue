<script setup>
import BaseView from "../BaseView.vue";
import Tag from "primevue/tag";
import FormExercise from "./Form.vue";
import { useRoute } from "vue-router";
import { onMounted } from "vue";
import { useExercise } from "@/stores/exercise";

// const route = useRoute();
// const store = useExercise();
// onMounted(async () => {
//   await store.getExerciseById(route.params.id);
//   store.form.setValues(store.editItem);
// });
</script>
<template>
  <base-view title="Detail Exercises">
    <div class="flex">
      <div class="basis-3/4 card flex space-x-6 mr-6">
        <div class="relative top-0 left-0">
          <p class="text-2xl font-bold">Exercise name</p>
          <!-- <p class="text-lg text-gray-500">Created by: Admin</p> -->

          <div class="flex mt-6 items-center space-x-4">
            <img src="@/assets/images/nguc.png" alt="abc" class="h-8" />
            <img src="@/assets/images/ta.png" alt="abc" class="h-8" />
          </div>
          <div class="flex space-x-2 mt-2">
            <p class="text-lg text-gray-500">Group Exercise:</p>
            <Tag value="cardio" />
            <Tag value="build muscle" />
            <Tag value="warm-up" />
          </div>

          <p class="mt-6">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aperiam
            vero cumque, earum omnis mollitia voluptatem nobis animi aut
            nesciunt velit unde modi numquam molestiae voluptatum eveniet
            ducimus neque itaque corporis. Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Aperiam vero cumque, earum omnis
          </p>
          <div class="flex w-full space-x-6 mt-6">
            <img
              src="@/assets/images/exercise_1.gif"
              alt="abc"
              class="w-full"
            />
            <iframe
              class="w-full"
              src="https://www.youtube.com/embed/7m9Ishxizwk"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
          <p class="mt-4">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aperiam
            vero cumque, earum omnis mollitia voluptatem nobis animi aut
            nesciunt velit unde modi numquam molestiae voluptatum eveniet
            ducimus neque itaque corporis. Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Aperiam vero cumque, earum omnis
            mollitia voluptatem nobis animi aut nesciunt velit unde modi numquam
            molestiae voluptatum eveniet ducimus neque itaque corporis. Lorem
            ipsum dolor, sit amet consectetur adipisicing elit. Aperiam vero
            cumque, earum omnis mollitia voluptatem nobis animi aut nesciunt
            velit unde modi numquam molestiae voluptatum eveniet ducimus neque
            itaque corporis. Lorem ipsum dolor, sit amet consectetur adipisicing
            elit. Aperiam vero cumque, earum omnis mollitia voluptatem nobis
            animi aut nesciunt velit unde modi numquam molestiae voluptatum
            eveniet ducimus neque itaque corporis.
          </p>
        </div>
      </div>
      <div class="basis-1/4 space-y-6">
        <div class="card flex items-center justify-between">
          <p class="font-bold text-lg w-2/5">Challenge</p>
          <div
            class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
          >
            10
          </div>
        </div>
        <div class="card flex items-center justify-between">
          <p class="font-bold text-lg">Challenge</p>
          <div
            class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
          >
            10
          </div>
        </div>
        <div class="card flex items-center justify-between">
          <p class="font-bold text-lg">Challenge</p>
          <div
            class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
          >
            10
          </div>
        </div>
        <div class="flex justify-between items-center">
          <Button icon="pi pi-arrow-left" label="Back" />
          <Button
            icon="pi pi-pencil"
            label="Edit"
            @click="$router.push({ name: 'exercises.edit', params: { id: 1 } })"
          />
        </div>
      </div>
    </div>
  </base-view>
</template>
