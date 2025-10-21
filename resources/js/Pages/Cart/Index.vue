<script setup>
import { Head, router } from '@inertiajs/vue3'

defineProps({
  cart: Object
})

function removeItem(id) {
  router.delete(`/cart/remove/${id}`)
}

function clearCart() {
  if (confirm('Kosongkan semua isi keranjang?')) {
    router.delete('/cart/clear')
  }
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">🛒 Keranjang Belanja</h1>

    <table v-if="Object.keys(cart).length" class="min-w-full border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border">Gambar</th>
          <th class="p-2 border">Nama Produk</th>
          <th class="p-2 border">Harga</th>
          <th class="p-2 border">Jumlah</th>
          <th class="p-2 border">Subtotal</th>
          <th class="p-2 border text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in cart" :key="item.id">
          <td class="p-2 border">
            <img :src="`/storage/${item.image}`" class="w-16 h-16 object-cover rounded" />
          </td>
          <td class="p-2 border">{{ item.name }}</td>
          <td class="p-2 border">Rp {{ item.price.toLocaleString('id-ID') }}</td>
          <td class="p-2 border">{{ item.quantity }}</td>
          <td class="p-2 border">
            Rp {{ (item.price * item.quantity).toLocaleString('id-ID') }}
          </td>
          <td class="p-2 border text-center">
            <button
              @click="removeItem(item.id)"
              class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
            >
              Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-else class="text-gray-500 mt-4">Keranjang kosong.</div>

    <div v-if="Object.keys(cart).length" class="mt-6 flex justify-between items-center">
      <button @click="clearCart" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
        Kosongkan
      </button>

      <a href="/checkout" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Lanjut ke Checkout
      </a>
    </div>
  </div>
</template>
