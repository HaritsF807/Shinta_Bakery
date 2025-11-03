<template>
  <div class="min-h-screen bg-amber-50 flex items-center justify-center p-4">
    <div class="bg-pink-200 rounded-xl shadow-lg p-8 w-full max-w-md">
      <div class="flex justify-center mb-6">
        <img 
          src="logo-shinta.png" 
          alt="Shinta's Bakery Logo" 
          class="w-30 h-20 "
        />
      </div>
      
      <h1 class="text-xl font-bold text-gray-700 text-center mb-6">
        Shipping Adress
      </h1>
      
      <form @submit.prevent="submitForm" class="space-y-5">
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">Nama Pembeli</label>
          <input
            v-model="form.guest_name"
            type="text"
            placeholder="Masukkan nama Anda"
            class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          />
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
          <input
            v-model="form.guest_phone"
            type="text"
            placeholder="Masukkan nomor HP"
            class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          />
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="form.guest_email"
            type="email"
            placeholder="Masukkan email Anda"
            class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          />
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
          <textarea
            v-model="form.shipping_address"
            rows="3"
            placeholder="Masukkan alamat pengiriman"
            class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          ></textarea>
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
          <select
            v-model="form.payment_method"
            class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          >
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="cod">COD (Bayar di Tempat)</option>
            <option value="transfer">Transfer Bank</option>
          </select>
        </div>

        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
        >
          <span>Buat Pesanan</span>
        </button>
      </form>
    </div>
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

<style scoped>
/* tambahan gaya opsional */
</style>