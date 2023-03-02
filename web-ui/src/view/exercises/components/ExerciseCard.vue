<script setup>
const props = defineProps(["name", "level", "muscles"]);
</script>
<template>
  <div class="card image-full bg-base-100 shadow-xl">
    <figure class="w-full object-cover">
      <img src="@/assets/images/test-exe.png" alt="Movie" />
    </figure>
    <div class="card-body p-4">
      <div class="grid grid-cols-3">
        <div class="grid grid-rows-4 col-span-2 gap-2 items-center">
          <div class="flex gap-4">
            <div class="avatar">
              <div class="w-8 rounded bg-white drop-shadow-sm shadow-white p-1">
                <img src="@/assets/images/chest.png" alt="muscle" />
              </div>
            </div>
          </div>
          <div></div>
          <div></div>
          <div class="text-lg font-semibold">{{ props.name }}</div>
        </div>
        <div class="grid grid-rows-4 items-center justify-end">
          <div class="flex gap-4 text-white">
            <font-awesome-icon
              icon="fa-solid fa-pencil"
              class="cursor-pointer"
            />
            <font-awesome-icon
              icon="fa-solid fa-trash-can"
              class="cursor-pointer"
            />
          </div>
          <div></div>
          <div></div>
          <div class="badge badge-primary">{{ props.level }}</div>
        </div>
      </div>
    </div>
  </div>
</template>
