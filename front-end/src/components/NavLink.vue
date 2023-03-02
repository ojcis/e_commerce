<template>
  <RouterLink class="text-2xl text-white font-semibold px-12 py-3 hover:bg-red-400"  :to="props.link">{{ props.name }}</RouterLink>
</template>

<script setup lang="ts">
interface Link {
  link: string;
  name: string;
}
const props = defineProps<Link>();
</script>