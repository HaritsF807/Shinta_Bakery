<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  guest_name: '',
  guest_email: '',
  guest_phone: '',
  shipping_address: '',
  cart: [] // nanti diisi dari localStorage keranjang
})

function submit() {
  form.post('/checkout')
}
</script>

<template>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Checkout sebagai Tamu</h1>

    <form @submit.prevent="submit" class="space-y-3">
      <input v-model="form.guest_name" placeholder="Nama Lengkap" class="border p-2 w-full rounded" />
      <input v-model="form.guest_email" placeholder="Email" class="border p-2 w-full rounded" />
      <input v-model="form.guest_phone" placeholder="Nomor Telepon" class="border p-2 w-full rounded" />
      <textarea v-model="form.shipping_address" placeholder="Alamat Pengiriman" class="border p-2 w-full rounded"></textarea>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Buat Pesanan
      </button>
    </form>
  </div>
</template>
