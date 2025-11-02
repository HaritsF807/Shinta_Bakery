<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Menerima 'orders' (objek paginasi) dari controller
defineProps({
  orders: Object,
});

// Fungsi untuk format mata uang
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(value);
};
</script>

<template>
  <Head title="Admin - Daftar Pesanan" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Pesanan</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                
                <tr v-for="order in orders.data" :key="order.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.invoice_number }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
  {{ order.customer_name || 'Tamu' }}
</td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatCurrency(order.total_price) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="{
                      'bg-yellow-100 text-yellow-800': order.status === 'pending',
                      'bg-blue-100 text-blue-800': order.status === 'processing',
                      'bg-green-100 text-green-800': order.status === 'completed',
                      'bg-red-100 text-red-800': order.status === 'cancelled',
                    }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                      {{ order.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <Link :href="route('admin.orders.show', order.id)" class="text-indigo-600 hover:text-indigo-900">
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

            </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>