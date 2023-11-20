<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header class="overflow-auto">
    <div class="w-full bg-gray-800">
      <nav class="flex justify-center text-white p-5">
        <RouterLink class="text-2xl px-4" to="/">Home</RouterLink>
        <RouterLink class="text-2xl px-4" to="/about">About</RouterLink>
      </nav>
    </div>
  </header>
  <RouterView/>
</template>

<style scoped>

</style>
