<template>
  <navigation />
  <div class="flex flex-wrap justify-center">
    <router-view />
  </div>
</template>

<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
import { RouterView } from "vue-router";
</script>

<style>
body {
  background-color: #efefef;
}
</style>
