<template>
  <div class="min-h-screen bg-amber-50">
    <Navbar />

    <div class="p-6 pt-32">

      <!-- ====== TOMBOL AKTIF/NONAKTIF ALL (DITAMBAHKAN DI SINI) ====== -->
      <div class="mb-6 flex gap-3">
        <!-- Tombol Aktifkan Semua Produk (kecuali stok 0) -->
        <button
          @click="activateAll"
          :disabled="loading"
          class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition disabled:opacity-60"
        >
          <span v-if="!loading">Aktifkan Semua Produk (kecuali stok 0)</span>
          <span v-else>Memproses...</span>
        </button>

        <!-- Tombol Nonaktifkan Semua Produk -->
        <button
          @click="deactivateAll"
          :disabled="loading"
          class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700 transition disabled:opacity-60"
        >
          <span v-if="!loading">Nonaktifkan Semua Produk</span>
          <span v-else>Memproses...</span>
        </button>
      </div>
      <!-- ============================================================ -->

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full mr-4">
            <!-- icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500 font-semibold uppercase">Pendapatan Bulan Ini</p>
            <p class="text-xl font-bold text-gray-800">{{ stats.incomeThisMonth }}</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-pink-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500 font-semibold uppercase">Item Terjual</p>
            <p class="text-xl font-bold text-gray-800">{{ stats.shipmentThisMonth }}</p>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-blue-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500 font-semibold uppercase">Perlu Dikirim</p>
            <p class="text-xl font-bold text-gray-800">{{ stats.shipmentPending }} Pesanan</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <div class="bg-white rounded-xl shadow p-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Pesanan Masuk ({{ pendingOrders.length }})</h2>
            <a href="/admin/orders" class="text-sm text-pink-600 hover:underline">Lihat Semua</a>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Invoice</th>
                  <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Pelanggan</th>
                  <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                  <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="order in pendingOrders" :key="order.id" class="hover:bg-gray-50 transition">
                  <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ order.id }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ order.customer }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600 font-bold">{{ order.amount }}</td>
                  <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">
                      {{ order.status }}
                    </span>
                  </td>
                </tr>
                
                <tr v-if="pendingOrders.length === 0">
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 italic">
                        Belum ada pesanan baru yang masuk.
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Ulasan Terbaru</h2>
          </div>
          
          <div class="space-y-4">
            <div v-for="(review, index) in reviews" :key="index" class="flex gap-3 border-b pb-3 last:border-0">
              <img :src="review.image || 'https://via.placeholder.com/60'" class="w-10 h-10 object-cover rounded-full shadow-sm" alt="Produk" />
              <div class="flex-1">
                <div class="flex justify-between">
                    <h4 class="text-sm font-bold text-gray-800">{{ review.product_name }}</h4>
                    <span class="text-xs text-gray-400">{{ review.user_name }}</span>
                </div>
                <div class="flex items-center my-1">
                  <span v-for="n in 5" :key="n" :class="n <= review.rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
                </div>
                <p class="text-sm text-gray-600 line-clamp-2">"{{ review.comment }}"</p>
              </div>
            </div>

            <div v-if="reviews.length === 0" class="text-center py-8 text-gray-400 italic">
                Belum ada ulasan dari pelanggan.
            </div>
          </div>
        </div>
      </div>

      <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Produk Terlaris Bulan Ini</h2>
        
        <div class="flex space-x-4 overflow-x-auto pb-4">
          <div v-for="item in bestSellers" :key="item.id" class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4 min-w-[220px] max-w-[220px] flex-shrink-0 border border-gray-100">
            <div class="relative">
              <img :src="item.image" :alt="item.name" class="w-full h-32 object-cover rounded-lg mb-3" />
              <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-pink-600 shadow-sm">
                  {{ item.total_sold }} Terjual
              </div>
            </div>
            
            <h3 class="font-bold text-gray-800 truncate" :title="item.name">{{ item.name }}</h3>
            <p class="text-pink-600 font-bold mt-1">{{ item.price }}</p>
            
            <div class="mt-3 flex justify-between items-center">
              <span :class="['px-2 py-1 text-xs font-bold rounded', item.available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700']">
                {{ item.available ? 'Stok Ada' : 'Habis' }}
              </span>
            </div>
          </div>

          <div v-if="bestSellers.length === 0" class="w-full text-center py-10 bg-white rounded-xl border border-dashed border-gray-300 text-gray-400">
             Belum ada data penjualan yang cukup untuk menentukan Best Seller.
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import Navbar from "@/Components/NavbarAdmin.vue";
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

// akses props inertia global (mis. csrf token)
const page = usePage();

// MENERIMA DATA DARI CONTROLLER
const props = defineProps({
    stats: Object,          // Income, Shipment, Pending Count
    pendingOrders: Array,   // Daftar 5 order pending terbaru
    reviews: Array,         // Daftar 5 ulasan terbaru
    bestSellers: Array      // Daftar 5 produk terlaris
});

// extract values to local refs so template binding is simple
const stats = props.stats ?? {};
const pendingOrders = props.pendingOrders ?? [];
const reviews = props.reviews ?? [];
const bestSellers = props.bestSellers ?? [];

const loading = ref(false);

function activateAll() {
  if (!confirm('Yakin mengaktifkan semua produk (kecuali stok 0)?')) return;
  loading.value = true;

  Inertia.post('/admin/products/activate-all', {}, {
    onSuccess: () => {
      loading.value = false;
      // reload page to reflect changes (or you can update local data)
      Inertia.reload();
      alert('Produk berhasil diaktifkan (stok > 0).');
    },
    onError: (errors) => {
      loading.value = false;
      console.error(errors);
      alert('Gagal mengaktifkan produk. Cek console untuk detail.');
    }
  });
}

function deactivateAll() {
  if (!confirm('Yakin menonaktifkan semua produk?')) return;
  loading.value = true;

  Inertia.post('/admin/products/deactivate-all', {}, {
    onSuccess: () => {
      loading.value = false;
      Inertia.reload();
      alert('Produk berhasil dinonaktifkan.');
    },
    onError: (errors) => {
      loading.value = false;
      console.error(errors);
      alert('Gagal menonaktifkan produk. Cek console untuk detail.');
    }
  });
}
</script>
