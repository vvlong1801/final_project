<script setup>
import Sidebar from "./partials/Sidebar.vue";
import { RouterView } from "vue-router";
</script>
<template>
  <div>
    <aside
      id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidebar"
    >
      <!-- header -->
      <header
        class="sidebar-header border-b h-[4rem] shrink-0 flex items-center justify-center relative dark:border-gray-700"
      ></header>
      <!-- drawer -->
      <nav
        class="sidebar-nav h-full flex-1 py-6 overflow-x-hidden overflow-y-auto shadow-2xl"
      >
        <Sidebar></Sidebar>
      </nav>
    </aside>
    <div
      class="flex flex-col flex-1 min-h-screen gap-y-6 pl-64 w-screen bg-gray-100"
    >
      <header
        class="top-bar sticky top-0 z-10 flex h-16 w-full float-right shrink-0 items-center border-b bg-white dark:bg-gray-800 dark:border-gray-700"
      >
        <div>
          <button
            type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            aria-expanded="false"
            data-dropdown-toggle="dropdown-user"
          >
            <span class="sr-only">Open user menu</span>
            <img
              class="w-8 h-8 rounded-full"
              src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
              alt="user photo"
            />
          </button>
        </div>
      </header>
      <div class="content flex-1 w-full px-4 mx-auto md:px-6 lg:px-8 max-w-7x">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
