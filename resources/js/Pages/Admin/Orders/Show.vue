<script setup>
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
  order: Object,
})

const form = useForm({
  status: props.order.status,
  payment_status: props.order.payment_status,
})

const updateStatus = () => {
  form.put(route('admin.orders.update', props.order.id), {
    preserveScroll: true,
    onSuccess: () => alert('Status pesanan berhasil diperbarui!'),
  })
}
</script>

<template>
  <Head title="Detail Pesanan" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Pesanan #{{ order.invoice_number }}
      </h2>
    </template>

    <div class="py-24 bg-amber-100 h-screen">
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-4">Informasi Pelanggan</h3>
          <p><strong>Nama:</strong> {{ order.user?.name || order.guest_name || 'Tamu' }}</p>
          <p><strong>Email:</strong> {{ order.user?.email || order.guest_email || '-' }}</p>
          <p><strong>No HP:</strong> {{ order.guest_phone }}</p>
          <p><strong>Alamat:</strong> {{ order.shipping_address }}</p>

          <h3 class="text-lg font-semibold mt-6 mb-4">Rincian Pesanan</h3>
          <table class="min-w-full border border-gray-200 mb-4">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 border">Produk</th>
                <th class="px-4 py-2 border">Qty</th>
                <th class="px-4 py-2 border">Harga</th>
                <th class="px-4 py-2 border">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in order.items" :key="item.id">
                <td class="px-4 py-2 border">{{ item.product.name }}</td>
                <td class="px-4 py-2 border text-center">{{ item.quantity }}</td>
                <td class="px-4 py-2 border">Rp {{ item.price.toLocaleString('id-ID') }}</td>
                <td class="px-4 py-2 border">Rp {{ item.subtotal.toLocaleString('id-ID') }}</td>
              </tr>
            </tbody>
          </table>

          <p class="text-right text-lg font-semibold">
            Total: Rp {{ order.total_price.toLocaleString('id-ID') }}
          </p>

          <div class="mt-6">
            <label class="block font-medium text-gray-700 mb-2">Ubah Status</label>
            <select v-model="form.status" class="border rounded px-8 py-2">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
            
            <button
              @click="updateStatus"
              class="ml-3 bg-pink-600 text-white px-8 py-2 rounded hover:bg-pink-500 relative"
              style="left: 560px;"
              >
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
