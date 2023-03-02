<template>
  <div class="pt-16 text-3xl font-bold">
    <h1 v-if="authUser.message">{{ authUser.message }}</h1>
    <h1 v-else-if="authUser.name"> Welcome, {{ authUser.name }}!</h1>
    <h1 v-else>Welcome, please login!</h1>
  </div>
</template>

<script setup lang="ts">
import { inject } from "vue";
import type { AuthUser } from "@/types/AuthUser";

const authUser = inject("authUser") as AuthUser;

setTimeout(() => {
  authUser.message = "";
}, 3500);

</script>
