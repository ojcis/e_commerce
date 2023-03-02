<template>
  <div class="flex-col bg-white justify-center rounded m-2 p-4 shadow-xl hover:bg-gray-200 w-96 h-32">
    <router-link :to="`/products/${props.id}`">
      <h2 class="text-2xl font-semibold text-center pb-4">{{ props.name }}</h2>
    </router-link>
    <div class="flex">
      <router-link :to="`/products/${props.id}`" class="text-center text-xl flex-grow">
        <p class="text-center text-xl flex-grow">{{ props.full_price }} EUR</p>
      </router-link>
      <button @click.stop="$emit('addToCart', props.id)" class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white rounded">Add to cart</button>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Product {
  id: number;
  name: string;
  full_price: number;
}

const props = defineProps<Product>();
</script>