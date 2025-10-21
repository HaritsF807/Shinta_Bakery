<script setup>
defineProps({ product: Object })
</script>

<template>
  <div class="p-6 max-w-3xl mx-auto">
    <div class="flex flex-col md:flex-row gap-6">
      <img
        v-if="product.image"
        :src="`/storage/${product.image}`"
        alt="produk"
        class="w-full md:w-1/2 h-64 object-cover rounded-lg shadow"
      />

      <div>
        <h1 class="text-3xl font-bold mb-2">{{ product.name }}</h1>
        <p class="text-gray-600 mb-4">Kategori: {{ product.category?.name || '-' }}</p>
        <p class="text-xl font-semibold text-green-700 mb-3">
          Rp {{ product.price.toLocaleString('id-ID') }}
        </p>
        <p class="text-gray-700 mb-6">{{ product.description || 'Tidak ada deskripsi.' }}</p>

        <button
          class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700"
        >
          Tambah ke Keranjang
        </button>
      </div>
    </div>
  </div>
</template>
