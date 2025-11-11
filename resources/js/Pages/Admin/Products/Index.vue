<script setup>
import Navbar from "@/Components/NavbarAdmin.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount, computed } from "vue"; // ✅ 1. IMPORT COMPUTED

// Props dari Laravel controller
const props = defineProps({
  products: Array,
  categories: Array, // Sekarang berisi array of objects [{id, name}, ...]
  selectedCategory: [String, Number, null], // Ini adalah ID
});

// State dropdown
const showCategoryDropdown = ref(false);
// ✅ 2. State menyimpan ID kategori, bukan nama
const selectedCategory = ref(props.selectedCategory || null);

// ✅ 3. Buat computed untuk mendapatkan NAMA kategori yang dipilih
const selectedCategoryName = computed(() => {
  if (!selectedCategory.value) {
    return "Semua Kategori";
  }
  // Cari di props.categories berdasarkan ID
  const category = props.categories.find(
    (c) => c.id == selectedCategory.value
  );
  return category ? category.name : "Semua Kategori";
});

// 🗑️ Fungsi hapus produk (Tetap sama)
function deleteProduct(id) {
  if (confirm("Yakin ingin menghapus produk ini?")) {
    router.delete(`/admin/products/${id}`);
  }
}

// ✅ 4. Fungsi pilih kategori DIPERBARUI
function selectCategory(cat) { // 'cat' bisa berupa object {id, name} atau null
  selectedCategory.value = cat ? cat.id : null; // Simpan ID-nya
  showCategoryDropdown.value = false; // tutup dropdown

  router.get(
    "/admin/products", // ✅ 5. RUTE DIPERBAIKI (ke products, bukan categories)
    { category: selectedCategory.value }, // Kirim ID kategori sebagai query
    { preserveState: true, replace: true }
  );
}

// 🚪 Tutup dropdown saat klik di luar area (Tetap sama)
function closeDropdownOnOutsideClick(e) {
  const dropdown = document.querySelector(".relative");
  if (dropdown && !dropdown.contains(e.target)) {
    showCategoryDropdown.value = false;
  }
}

onMounted(() => {
  document.addEventListener("click", closeDropdownOnOutsideClick);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", closeDropdownOnOutsideClick);
});

// 💰 Helper format Rupiah (Tetap sama)
function formatRupiah(value) {
  if (value == null || value === "") return "-";
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(value);
}
</script>

<template>
  <Navbar />
  <div
    class=" bg-amber-100 p-6 flex justify-center items-center relative "
    style="height: 800px;"
  >
    <Head title="Daftar Produk" />

    <div class="bg-pink-500 rounded-xl shadow-lg w-full max-w-6xl p-6 relative top-16">
      <h1 class="text-2xl font-bold text-white mb-8">Catalog</h1>

      <div class="flex justify-between items-center mb-6">
        <div class="flex space-x-4">
          <div class="relative">
            <button
              @click.stop="showCategoryDropdown = !showCategoryDropdown"
              class="bg-white text-gray-800 px-4 py-2 rounded-full flex items-center space-x-2 focus:outline-none"
            >
              <span>{{ selectedCategoryName }}</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>

            <div
              v-if="showCategoryDropdown"
              class="absolute mt-2 w-full bg-white rounded-md shadow-lg z-10"
            >
              <div
                @click="selectCategory(null)" class="px-4 py-2 cursor-pointer hover:bg-gray-100"
              >
                Semua Kategori
              </div>

              <div
                v-for="cat in categories"
                :key="cat.id" @click="selectCategory(cat)" class="px-4 py-2 cursor-pointer hover:bg-gray-100"
              >
                {{ cat.name }} </div>
            </div>
          </div>

          <a
            :href="`/admin/products/create`"
            class="bg-white text-black-500 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors relative"
            style="left: 790px;"
            >
            Add Product
          </a>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Gambar
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Nama
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Harga
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Stok
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Status
              </th>
              <th
                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center"
              >
                Aksi
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <tr
              v-for="p in products"
              :key="p.id"
              :class="p.id % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
              class="hover:bg-gray-100 transition"
            >
              <td class="px-6 py-4 text-center">
                <img
                  v-if="p.image"
                  :src="
                    p.image.startsWith('storage')
                      ? `/${p.image}`
                      : `/storage/${p.image}`
                  "
                  alt="gambar produk"
                  class="w-16 h-16 object-cover rounded mx-auto"
                />
                <span v-else class="text-gray-400 italic">tidak ada</span>
              </td>

              <td class="px-6 py-4 text-sm font-medium text-gray-900">
                {{ p.name }}
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">
                {{ formatRupiah(p.price) }}
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">{{ p.stock }}</td>

              <td class="px-6 py-4 text-sm">
                <span
                  :class="{
                    'text-green-600': p.status === 'aktif',
                    'text-red-600': p.status === 'nonaktif',
                  }"
                >
                  {{ p.status }}
                </span>
              </td>

              <td class="px-6 py-4 text-center">
                <a
                  :href="`/admin/products/${p.id}/edit`"
                  class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-medium transition"
                >
                  Edit
                </a>
                <button
                  @click="deleteProduct(p.id)"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium transition ml-2"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <p
        v-if="products.length === 0"
        class="text-gray-200 mt-6 italic text-center"
      >
        Belum ada produk tersedia.
      </p>
    </div>
  </div>
</template>