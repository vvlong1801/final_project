<script setup>
import { defineProps } from "vue";
import { useRoute } from "vue-router";
const route = useRoute();
const props = defineProps({
  item: {
    type: Object,
    default: () => ({}),
  },
  index: {
    type: Number,
    default: 0,
  },
  root: {
    type: Boolean,
    default: true,
  },
  // parentItemKey: {
  //   type: String,
  //   default: null,
  // },
});

const checkActiveItem = (item) => {
  return route.path.includes(item.to);
};
</script>
<template>
  <li>
    <div v-if="root && item.visible !== false" class="app-menu_item-root_text">
      {{ item.label }}
    </div>
    <router-link
      v-if="item.to && !item.items && item.visible !== false"
      tabindex="0"
      :to="item.to"
      class="app-menu_item-item"
      :class="{ 'menu_item-active': checkActiveItem(item) }"
    >
      <i :class="item.icon"></i>
      <span>{{ item.label }}</span>
      <i
        class="pi pi-fw pi-angle-down layout-submenu-toggler"
        v-if="item.items"
      ></i>
    </router-link>
    <Transition
      v-if="item.items && item.visible !== false"
      name="layout-submenu"
    >
      <ul v-show="root ? true : isActiveMenu" class="layout-submenu">
        <app-menu-item
          v-for="(child, i) in item.items"
          :key="child"
          :index="i"
          :item="child"

          :root="false"
        ></app-menu-item>
      </ul>
    </Transition>
  </li>
</template>
