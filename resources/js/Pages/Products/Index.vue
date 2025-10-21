<script setup>
defineProps({ products: Array })
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-center">Produk Kami 🍞</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div
        v-for="p in products"
        :key="p.id"
        class="border rounded-xl shadow hover:shadow-lg transition p-4 bg-white"
        :class="{ 'opacity-60': p.stock <= 0 || p.status !== 'aktif' }"
      >
        <img
          v-if="p.image"
          :src="`/storage/${p.image}`"
          alt="produk"
          class="w-full h-48 object-cover rounded-lg mb-3"
        />

        <div class="text-lg font-semibold mb-1">{{ p.name }}</div>
        <div class="text-gray-600 mb-2">
          Rp {{ p.price.toLocaleString('id-ID') }}
        </div>

        <!-- stok dan status -->
        <div class="text-sm mb-2">
          <span class="font-semibold">Stok:</span> {{ p.stock }}
        </div>
        <div
          class="inline-block px-2 py-1 text-xs font-semibold rounded-full mb-3"
          :class="{
            'bg-green-100 text-green-700 border border-green-400':
              p.stock > 0 && p.status === 'aktif',
            'bg-red-100 text-red-700 border border-red-400':
              p.stock <= 0 || p.status !== 'aktif'
          }"
        >
          {{ p.stock > 0 && p.status === 'aktif' ? 'Tersedia' : 'Tidak Tersedia' }}
        </div>

        <!-- tombol aksi -->
        <div>
          <a
            v-if="p.stock > 0 && p.status === 'aktif'"
            :href="`/products/${p.id}`"
            class="mt-3 inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
          >
            Lihat Detail
          </a>

          <button
            v-else
            disabled
            class="mt-3 inline-block bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed"
          >
            Tidak Tersedia
          </button>
        </div>
      </div>
    </div>

    <p v-if="products.length === 0" class="text-gray-500 text-center mt-6">
      Belum ada produk tersedia.
    </p>
  </div>
</template>
