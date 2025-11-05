<script setup>
import Navbar from "@/Components/NavbarAdmin.vue";
import { Head, Link } from '@inertiajs/vue3';

// Data dari controller Laravel
defineProps({
  orders: Object,
});

// Fungsi format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(value);
};
</script>

<template>
  <Navbar />
  <Head title="Admin - Daftar Pesanan" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manajemen Pesanan
      </h2>
    </template>

    <div class=" bg-amber-100 py-28">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <!-- Card Utama -->
        <div class="bg-pink-500 p-8 rounded-lg shadow-lg">
          <h1 class="text-white text-2xl font-bold mb-6">Daftar Pesanan</h1>

          <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Tabel -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="(order, index) in orders.data"
                  :key="order.id"
                  :class="{'bg-gray-50': index % 2 === 0}"
                >
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ order.invoice_number }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ order.customer_name || 'Tamu' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ formatCurrency(order.total_price) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span
                      :class="{
                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                        'bg-blue-100 text-blue-800': order.status === 'processing',
                        'bg-green-100 text-green-800': order.status === 'completed',
                        'bg-red-100 text-red-800': order.status === 'cancelled',
                      }"
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                    >
                      {{ order.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <Link
                      :href="route('admin.orders.show', order.id)"
                      class="px-3 py-1 bg-pink-500 text-white text-sm font-medium rounded-full hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500"
                    >
                      Lihat / Konfirmasi
                    </Link>
                  </td>
                </tr>

                <tr v-if="orders.data.length === 0">
                  <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Belum ada pesanan yang masuk.
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
              <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-700">
                  Halaman {{ orders.current_page }} dari {{ orders.last_page }}
                </span>
              </div>

              <div class="flex items-center space-x-1">
                <Link
                  :href="orders.prev_page_url || '#'"
                  class="px-3 py-1 border border-gray-300 rounded text-sm"
                  :class="{ 'opacity-50 cursor-not-allowed': !orders.prev_page_url }"
                >
                  &lt;
                </Link>

                <Link
                  :href="orders.next_page_url || '#'"
                  class="px-3 py-1 border border-gray-300 rounded text-sm"
                  :class="{ 'opacity-50 cursor-not-allowed': !orders.next_page_url }"
                >
                  &gt;
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
