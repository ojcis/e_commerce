<template>
  <div class="flex justify-center w-full">
    <h3 v-if="state.message" class="pt-2 text-3xl font-bold">{{ state.message }}</h3>
  </div>
  <div class="flex flex-col max-w-4xl justify-center w-full">
    <div class="flex w-full bg-red-600 justify-center rounded-t-xl mt-4 p-4 shadow-xl">
      <h3 class="text-4xl text-white font-semibold text-center mr-1">Name:</h3>
      <input v-model="state.product.name" type="text" class="text-4xl text-black font-semibold text-center rounded" />
    </div>
    <div class="flex flex-col max-w-4xl w-full bg-white items-center rounded-b-xl p-4 shadow-xl">
      <ul class="flex flex-wrap w-full bg-white justify-around items-center my-4">
        <div class="flex flex-col justify-center">
          <li class="text-center text-2xl my-1">Available:</li>
          <input v-model="state.product.available" type="number" min="1" class="text-center border-black border-2 text-2xl my-1 w-40 rounded">
        </div>
        <div class="flex flex-col justify-center">
          <li class="text-center text-2xl my-1">Price:</li>
          <div class="flex items-center justify-center">
            <input v-model="state.product.price" type="number" step="0.01" min="0.01" class="text-center border-black border-2 text-2xl my-1 mr-1 w-40 rounded">
            <li class="text-2xl">EUR</li>
          </div>
        </div>
        <div class="flex flex-col justify-center">
          <li class="text-center text-2xl my-1">Vat rate:</li>
          <div class="flex items-center justify-center">
            <input v-model="state.product.vat_rate" type="number" class="text-center border-black border-2 text-2xl my-1 mr-1 w-24 rounded">
            <li class="text-2xl">%</li>
          </div>
        </div>
      </ul>
      <div class="flex w-full justify-end mt-1">
        <button @click="create" class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white rounded mr-1 text-xl ">Add Product</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { inject, reactive } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import type { Product } from "@/types/Product";
import type { AuthUser } from "@/types/AuthUser";

const url = "http://127.0.0.1:8000/api/v1/products";
const router = useRouter();
const authUser = inject("authUser") as AuthUser;
const state = reactive({
  product: {} as Product,
});

const create = async () => {
  try {
    const params = {
      name: state.product.name,
      available: state.product.available,
      price: state.product.price * 100,
      vat_rate: state.product.vat_rate / 100,
    };
    const data = await axios.post(url, params, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    await router.push("/products/" + data.data.data.id);
  } catch (error) {
    console.log("error");
  }
};
</script>