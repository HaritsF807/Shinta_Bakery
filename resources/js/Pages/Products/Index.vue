<script setup>
import Navbar from "@/Components/Navbar.vue";
import { ref, computed } from 'vue'

// ✅ Tangkap props dari Laravel
const props = defineProps({
  products: {
    type: Array,
    default: () => []
  }
})

// 🔍 State pencarian
const searchQuery = ref('')

// 🔍 Filter produk berdasarkan pencarian
const filteredProducts = computed(() => {
  if (!searchQuery.value) return props.products

  const q = searchQuery.value.toLowerCase()
  return props.products.filter(p => p.name?.toLowerCase().includes(q))
})

// ✅ Fungsi untuk format angka jadi "12.000"
function formatRupiah(value) {
  if (!value && value !== 0) return '0'
  return Number(value).toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  })
}
</script>

<template>
  <Navbar />  
  <div class="bg-amber-50 min-h-screen py-16">
    
    <!-- Header -->
    <div class="text-center py-8">
      <h1 class="text-3xl font-bold text-pink-700">Our Menu</h1>
    </div>

    <!-- Search Bar -->
    <div class="max-w-md mx-auto px-4 mb-6">
      <div class="relative">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Cari produk..."
          class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-300"
        />
        <svg
          class="absolute right-3 top-2.5 h-5 w-5 text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          ></path>
        </svg>
      </div>
    </div>

    <!-- Semua Produk -->
    <div class="px-4 pb-12">
      <div
  class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
>
  <div
    v-for="p in filteredProducts"
    :key="p.id"
    class="bg-white rounded-2xl shadow-lg overflow-hidden relative transition-transform hover:scale-[1.02]"
  >
    <!-- Gambar produk -->
    <div class="relative">
      <img
        v-if="p.image"
        :src="`/storage/${p.image}`"
        alt="produk"
        class="w-full h-48 object-cover"
      />
      <!-- Icon love -->
      <button
        class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm rounded-full p-1 hover:bg-pink-100 transition"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-5 h-5 text-pink-600"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 8.25c0-2.485-2.015-4.5-4.5-4.5-1.74 0-3.238 1.007-4 2.457A4.503 4.503 0 008.5 3.75 4.5 4.5 0 004 8.25c0 7.22 8 11.25 8 11.25s8-4.03 8-11.25z"
          />
        </svg>
      </button>
    </div>

    <!-- Isi konten -->
    <div class="p-4">
      <!-- Nama produk -->
      <h3 class="text-lg font-semibold text-gray-800 truncate">
        {{ p.name }}
      </h3>

      <!-- Harga -->
      <p class="text-pink-600 font-medium text-sm mb-2">
        Rp {{ formatRupiah(p.price) }}
      </p>

      <!-- Rating & waktu dummy (optional) -->
      <div class="flex items-center text-gray-500 text-xs space-x-3 mb-3">
        <div class="flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 24 24"
            stroke-width="0"
            class="w-4 h-4 text-yellow-400"
          >
            <path
              d="M12 .587l3.668 7.429L24 9.753l-6 5.845 1.42 8.289L12 19.771l-7.42 4.116L6 15.598 0 9.753l8.332-1.737z"
            />
          </svg>
          <span class="ml-1">5</span>
        </div>
        <div class="flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-4 h-4"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span class="ml-1">15min</span>
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex justify-between items-center">
        <span
          class="text-xs font-semibold px-2 py-1 rounded-full"
          :class="{
            'bg-green-100 text-green-700': p.stock > 0 && p.status === 'aktif',
            'bg-red-100 text-red-700': p.stock <= 0 || p.status !== 'aktif'
          }"
        >
          {{ p.stock > 0 && p.status === 'aktif' ? 'Tersedia' : 'Tidak Tersedia' }}
        </span>

        <a
          v-if="p.stock > 0 && p.status === 'aktif'"
          :href="`/products/${p.id}`"
          class="text-sm bg-pink-500 text-white px-3 py-1 rounded-lg hover:bg-pink-600 transition"
        >
          Detail
        </a>
        <button
          v-else
          disabled
          class="text-sm bg-gray-300 text-white px-3 py-1 rounded-lg cursor-not-allowed"
        >
          Habis
        </button>
      </div>
    </div>
  </div>
</div>


      <p
        v-if="filteredProducts.length === 0"
        class="text-gray-500 text-center mt-6"
      >
        Tidak ada produk ditemukan.
      </p>
    </div>

   
  </div>
   <!-- Footer -->
    <footer class="bg-pink-200 py-8 text-center text-sm text-gray-600">
      <p>Kebijakan Privasi · Syarat & Ketentuan</p>
      <p>© 2025 Shinta Bakery. All rights reserved.</p>
    </footer>
</template>
