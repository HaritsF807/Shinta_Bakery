<script setup>
import Navbar from "@/Components/Navbar.vue";
import { ref, computed, watch } from "vue";
import { router } from "@inertiajs/vue3"; // ⚡ untuk kirim query ke backend

// ✅ Props dari Laravel
const props = defineProps({
  products: Array,
  categories: Array,
  selectedCategory: [String, Number, null]
});

// 🔍 State pencarian dan kategori terpilih
const searchQuery = ref("");
const selectedCategory = ref(props.selectedCategory || "");

// 🔄 Kalau kategori berubah → refresh data ke server
watch(selectedCategory, (newCategory) => {
  router.get(
    "/products",
    { category: newCategory || null }, // kirim query ?category=id
    { preserveState: true, replace: true } // biar gak reload full
  );
});

// 🔍 Filter produk di sisi frontend berdasarkan pencarian
const filteredProducts = computed(() => {
  let items = props.products;

  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase();
    items = items.filter((p) => p.name?.toLowerCase().includes(q));
  }

  return items;
});

// 💰 Format harga
function formatRupiah(value) {
  if (!value && value !== 0) return "0";
  return Number(value).toLocaleString("id-ID", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  });
}
console.log("Produk dari Laravel:", props.products);
</script>

<template>
  <Navbar />
  <div class="bg-amber-50 min-h-screen py-16">
    <!-- Header -->
    <div class="text-center py-8">
      <h1 class="text-3xl font-bold text-pink-700">Our Menu</h1>
    </div>

    <!-- 🔽 Filter kategori + 🔍 Search bar -->
    <div class="max-w-4xl mx-4 flex flex-col sm:flex-row gap-4 px-8 mb-8">
      <!-- Dropdown kategori -->
      <select
        v-model="selectedCategory"
        class="w-full sm:w-1/3 px-4 py-2 rounded-full border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-pink-300"
      >
        <option value="">Semua Kategori</option>
        <option
          v-for="cat in props.categories"
          :key="cat.id"
          :value="cat.id"
        >
          {{ cat.name }}
        </option>
      </select>

      <!-- Input pencarian -->
      <div class="relative flex-1">
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

    <!-- Daftar Produk -->
    <div class="px-4 pb-12">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
            <button
              class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm rounded-full p-1 hover:bg-pink-100 transition"
            >
            
            </button>
          </div>

          <!-- Isi -->
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 truncate">
              {{ p.name }}
            </h3>
            <p class="text-pink-600 font-medium text-sm mb-2">
              Rp {{ formatRupiah(p.price) }}
            </p>

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
