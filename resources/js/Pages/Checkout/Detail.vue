<script setup>
defineProps({
  order: Object
})
</script>

<template>
  <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Rincian Pesanan #{{ order.id }}</h1>

    <div class="mb-6 space-y-1">
      <p><strong>Status Pesanan:</strong> {{ order.status }}</p>
      <p><strong>Status Pembayaran:</strong> {{ order.payment_status }}</p>
      <p><strong>Metode Pembayaran:</strong> {{ order.payment_method }}</p>
      <p><strong>Total Harga:</strong> Rp {{ order.total_price.toLocaleString('id-ID') }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-2">📦 Daftar Produk</h2>
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border">Produk</th>
          <th class="p-2 border text-center">Jumlah</th>
          <th class="p-2 border text-right">Harga</th>
          <th class="p-2 border text-right">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in order.items" :key="item.id">
          <td class="p-2 border">
            {{ item.product?.name || 'Produk Dihapus' }}
          </td>
          <td class="p-2 border text-center">{{ item.quantity }}</td>
          <td class="p-2 border text-right">Rp {{ item.price.toLocaleString('id-ID') }}</td>
          <td class="p-2 border text-right">Rp {{ item.subtotal.toLocaleString('id-ID') }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6">
      <h2 class="text-lg font-semibold mb-2">📍 Alamat Pengiriman</h2>
      <p>{{ order.shipping_address }}</p>

      <h2 class="text-lg font-semibold mt-4 mb-2">📞 Kontak</h2>
      <p>No HP: {{ order.guest_phone }}</p>
      <p>Email: {{ order.guest_email }}</p>
    </div>

    <div class="mt-6 text-center">
      <a
        href="/products"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Kembali ke Produk
      </a>
    </div>
  </div>
</template>
