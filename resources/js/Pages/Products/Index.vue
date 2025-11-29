<script setup>
import Navbar from "@/Components/Navbar.vue";
import CustomDropdown from "@/Components/CustomDropdown.vue";
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

// 🎨 Format kategori untuk dropdown
const categoryOptions = computed(() => {
  const options = [
    { value: "", label: "✨ Semua Kategori" }
  ];
  
  props.categories.forEach(cat => {
    options.push({
      value: cat.id,
      label: cat.name
    });
  });
  
  return options;
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
  <div class="bg-amber-50 min-h-screen pt-24 pb-16">
    <!-- Header -->
    <div class="text-center py-16">
      <h1 class="text-4xl font-bold text-pink-700 tracking-tight">Our Menu</h1>
    </div>

    <!-- 🔽 Filter kategori + 🔍 Search bar -->
    <div class="max-w-4xl mx-4 flex flex-col sm:flex-row gap-4 px-8 mb-8">
      <!-- Dropdown kategori dengan animasi keren 🎨 -->
      <div class="w-full sm:w-1/3">
        <CustomDropdown
          v-model="selectedCategory"
          :options="categoryOptions"
          placeholder="✨ Semua Kategori"
        />
      </div>

      <div class="relative flex-1">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Cari produk..."
          class="search-input w-full px-4 py-3 pl-12 rounded-full border-2 border-pink-200 focus:outline-none focus:border-pink-400 transition-all duration-300"
        />
        <svg
          class="search-icon absolute left-4 top-3.5 h-5 w-5 text-pink-400"
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
          class="bg-white rounded-2xl shadow-lg overflow-hidden relative transition-transform"
          :class="{
            'hover:scale-[1.02]': p.stock > 0 && p.status === 'aktif',
            'opacity-60 grayscale': p.stock <= 0 || p.status !== 'aktif'
          }"
        >
          <!-- Gambar produk -->
          <div class="relative">
            <img
              v-if="p.image"
              :src="`/storage/${p.image}`"
              alt="produk"
              class="w-full h-48 object-cover"
            />
            
            <!-- Badge "Habis" atau "Nonaktif" -->
            <div 
              v-if="p.stock <= 0 || p.status !== 'aktif'"
              class="absolute inset-0 bg-black/40 flex items-center justify-center"
            >
              <span class="bg-red-500 text-white px-4 py-2 rounded-full font-bold text-sm">
                {{ p.stock <= 0 ? 'STOK HABIS' : 'TIDAK TERSEDIA' }}
              </span>
            </div>
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
                class="text-sm bg-gray-300 text-gray-500 px-3 py-1 rounded-lg cursor-not-allowed"
              >
                Detail
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

<style scoped>
.search-input {
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(254, 243, 249, 0.85) 100%);
  backdrop-filter: blur(10px);
  box-shadow: 
    0 4px 6px rgba(236, 72, 153, 0.12),
    0 2px 4px rgba(236, 72, 153, 0.08),
    inset 0 1px 1px rgba(255, 255, 255, 0.8);
  font-weight: 500;
  color: #831843;
  position: relative;
}

.search-input::placeholder {
  color: #f9a8d4;
  font-weight: 500;
}

.search-input:hover {
  background: linear-gradient(135deg, rgba(254, 243, 249, 0.95) 0%, rgba(252, 231, 243, 0.9) 100%);
  backdrop-filter: blur(12px);
  box-shadow: 
    0 8px 16px rgba(236, 72, 153, 0.2),
    0 4px 8px rgba(236, 72, 153, 0.15),
    0 0 20px rgba(236, 72, 153, 0.1),
    inset 0 1px 1px rgba(255, 255, 255, 0.9);
  transform: translateY(-2px);
  animation: shimmer 2s ease-in-out infinite;
}

.search-input:focus {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  box-shadow: 
    0 0 0 4px rgba(236, 72, 153, 0.15), 
    0 8px 20px rgba(236, 72, 153, 0.2),
    0 4px 8px rgba(236, 72, 153, 0.15),
    inset 0 1px 1px rgba(255, 255, 255, 1);
  transform: translateY(-1px);
}

.search-icon {
  transition: all 0.3s ease;
}

.search-input:focus + .search-icon {
  color: #ec4899;
  transform: scale(1.1);
  filter: drop-shadow(0 0 4px rgba(236, 72, 153, 0.4));
}

.search-input:hover + .search-icon {
  animation: pulse-icon 1.5s ease-in-out infinite;
}

@keyframes shimmer {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

@keyframes pulse-icon {
  0%, 100% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.8;
    transform: scale(1.05);
  }
}
</style>
