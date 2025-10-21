<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Form Checkout</h1>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Pembeli</label>
        <input v-model="form.guest_name" type="text" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">No HP</label>
        <input v-model="form.guest_phone" type="text" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Email</label>
        <input v-model="form.guest_email" type="email" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Alamat Pengiriman</label>
        <textarea v-model="form.shipping_address" class="w-full border rounded p-2" rows="3" required></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1">Metode Pembayaran</label>
        <select v-model="form.payment_method" class="w-full border rounded p-2" required>
          <option value="">-- Pilih Metode Pembayaran --</option>
          <option value="cod">COD (Bayar di Tempat)</option>
          <option value="transfer">Transfer Bank</option>
        </select>
      </div>

      <button
        type="submit"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
      >
        Buat Pesanan
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  guest_name: '',
  guest_email: '',
  guest_phone: '',
  shipping_address: '',
  payment_method: '',
})

function submitForm() {
  form.post(route('checkout.store'))
}
</script>
