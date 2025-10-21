<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  product: Object
})

function addToCart() {
  router.post(`/cart/add/${props.product.id}`, {}, {
    onSuccess: () => alert('Produk ditambahkan ke keranjang!')
  })
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold">{{ product.name }}</h1>
    <p>Kategori: {{ product.category.name }}</p>
    <p class="text-green-700 font-semibold">Rp {{ product.price.toLocaleString() }}</p>
    <p class="mb-4">{{ product.description }}</p>

    <button
      @click="addToCart"
      class="bg-amber-700 text-white px-4 py-2 rounded hover:bg-amber-800"
    >
      Tambah ke Keranjang
    </button>
  </div>
</template>
