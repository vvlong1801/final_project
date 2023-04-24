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
    <div class="grid grid-cols-4 gap-6 mb-6">
      <div class="card flex items-center justify-between h-full">
        <p class="font-bold text-lg">Challenge</p>
        <div
          class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
        >
          10
        </div>
      </div>
      <div class="card flex items-center justify-between h-full">
        <p class="font-bold text-lg">Challenge</p>
        <div
          class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
        >
          10
        </div>
      </div>
      <div class="card flex items-center justify-between h-full">
        <p class="font-bold text-lg">Challenge</p>
        <div
          class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
        >
          10
        </div>
      </div>
      <div class="card flex items-center justify-between h-full">
        <p class="font-bold text-lg">Challenge</p>
        <div
          class="w-20 font-extrabold text-5xl text-center text-white bg-red-600 rounded-md py-2"
        >
          10
        </div>
      </div>
    </div>

    <div class="card flex space-x-6">
      <div class="w-1/3 space-y-6">
        <!-- <img
          src="@/assets/images/panel.jpg"
          alt="abc"
          class="rounded-md w-full"
        /> -->
        <img
          src="@/assets/images/exercise_1.gif"
          alt="abc"
          class="rounded-md w-full"
        />
        <iframe
          class="w-full"
          src="https://www.youtube.com/watch?v=9-2jNyQSZJg"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
      </div>
      <div class="w-full relative top-0 left-0">
        <Button
          class="!absolute !top-0 !right-0 w-16"
          label="Edit"
          @click="
            $router.push({
              name: 'exercises.edit',
              params: {
                id: 1,
              },
            })
          "
        />
        <p class="text-2xl font-bold">Exercise name</p>
        <p class="text-lg text-gray-500">Exercise group</p>
        <div class="flex mt-2 items-center">
          <Tag class="mr-4 w-32" value="Created by"></Tag>
          <div class="flex gap-4 w-10">
            <img
              src="@/assets/images/panel.jpg"
              class="rounded-full"
              alt="abc"
            />
          </div>
        </div>
        <div class="flex mt-2 items-center">
          <Tag class="mr-4 w-32" value="Effected muscles"></Tag>
          <div class="flex gap-4 h-8">
            <img src="@/assets/images/nguc.png" alt="abc" />
          </div>
        </div>
        <div class="flex mt-2 items-center">
          <Tag class="mr-4 w-32" value="Used equipment"></Tag>
          <div class="flex gap-4 h-8">
            <img src="@/assets/images/ta.png" alt="abc" />
          </div>
        </div>
        <p class="mt-4">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aperiam vero
          cumque, earum omnis mollitia voluptatem nobis animi aut nesciunt velit
          unde modi numquam molestiae voluptatum eveniet ducimus neque itaque
          corporis. Lorem ipsum dolor, sit amet consectetur adipisicing elit.
          Aperiam vero cumque, earum omnis mollitia voluptatem nobis animi aut
          nesciunt velit unde modi numquam molestiae voluptatum eveniet ducimus
          neque itaque corporis. Lorem ipsum dolor, sit amet consectetur
          adipisicing elit. Aperiam vero cumque, earum omnis mollitia voluptatem
          nobis animi aut nesciunt velit unde modi numquam molestiae voluptatum
          eveniet ducimus neque itaque corporis. Lorem ipsum dolor, sit amet
          consectetur adipisicing elit. Aperiam vero cumque, earum omnis
          mollitia voluptatem nobis animi aut nesciunt velit unde modi numquam
          molestiae voluptatum eveniet ducimus neque itaque corporis.
        </p>
      </div>
    </div>
  </base-view>
</template>
