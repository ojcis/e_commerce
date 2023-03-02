<template>
  <h3 v-if="state.isLoading" class="pt-16 text-3xl font-bold">Loading...</h3>
  <h3 v-if="state.isError" class="pt-16 text-3xl font-bold">Something is worong!</h3>
  <div class="flex justify-center w-full">
    <h3 v-if="state.message" class="pt-2 text-3xl font-bold">{{ state.message }}</h3>
  </div>
  <div v-for="product in state.products" :key="product.id">
    <ProductCard
      :id="product.id"
      :name="product.name"
      :full_price="product.full_price"
      @addToCart="addToCart"
    />
  </div>
</template>

<script setup lang="ts">
import { onMounted, reactive, inject } from "vue";
import axios from "axios";
import type { Product } from "@/types/Product";
import ProductCard from "@/components/ProductCard.vue";
import type { AuthUser } from "@/types/AuthUser";

const url = "http://127.0.0.1:8000/api/v1/products";
const authUser = inject("authUser") as AuthUser;
const state = reactive({
  products: [] as Product[],
  message: "",
  isLoading: false,
  isError: false,
});

const addToCart = async (productId: number) => {
  try {
    const addToCartUrl = "http://127.0.0.1:8000/api/v1/cart/add";
    const params = {
      user_id: authUser.id,
      product_id: productId,
      amount: 1,
    };
    const data = await axios.post(addToCartUrl, params, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    state.message = data.data.message;
  } catch (error) {
    console.log("error");
  }
};

onMounted(async () => {
  try {
    state.isLoading = true;
    const data = await axios.get(url, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    state.products = data.data.data;
    state.isLoading = false;
  } catch (error) {
    state.isError = true;
    state.isLoading = false;
  }
});
</script>

<style></style>
