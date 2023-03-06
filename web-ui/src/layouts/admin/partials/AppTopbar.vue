<template>
  <div class="layout-topbar">
    <router-link to="/" class="layout-topbar-logo">
      <span>CHALLENGE ME</span>
    </router-link>

    <button class="text-left layout-topbar-button">
      <i class="pi pi-bars"></i>
    </button>

    <button class="hidden layout-topbar-button">
      <i class="pi pi-ellipsis-v "></i>
    </button>

    <div class="ml-auto p-0">
      <button @click="">
        <i class="pi pi-calendar"></i>
        <span>Calendar</span>
      </button>
      <button @click="">
        <i class="pi pi-user"></i>
        <span>Profile</span>
      </button>
      <button @click="">
        <i class="pi pi-cog"></i>
        <span>Settings</span>
      </button>
    </div>
  </div>
</template>
