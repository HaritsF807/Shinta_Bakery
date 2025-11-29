<template>
  <div class="min-h-screen bg-amber-50">
    <Navbar />

    <div class="p-6 pt-32">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📝 Testimoni Pelanggan</h1>
        <p class="text-gray-600 mt-2">Kelola semua testimoni dan ulasan dari pelanggan</p>
      </div>

      <!-- Testimonials Table -->
      <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-pink-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Invoice</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rating</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Komentar</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="testimonial in testimonials.data" :key="testimonial.id" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-medium text-pink-600">#{{ testimonial.invoice_number }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ testimonial.customer_name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <span v-for="n in 5" :key="n" :class="n <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300'" class="text-lg">★</span>
                    <span class="ml-2 text-sm text-gray-600">({{ testimonial.rating }}/5)</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <p class="text-sm text-gray-600 max-w-md truncate" :title="testimonial.comment">
                    {{ testimonial.comment || '-' }}
                  </p>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-600">
                    <span v-if="testimonial.products.length <= 2">{{ testimonial.products.join(', ') }}</span>
                    <span v-else>{{ testimonial.products[0] }} +{{ testimonial.products.length - 1 }} lainnya</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ testimonial.created_at }}
                </td>
              </tr>

              <tr v-if="testimonials.data.length === 0">
                <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                  Belum ada testimoni dari pelanggan.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="testimonials.data.length > 0" class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t">
          <div class="text-sm text-gray-600">
            Menampilkan {{ testimonials.from }} - {{ testimonials.to }} dari {{ testimonials.total }} testimoni
          </div>
          <div class="flex gap-2">
            <a
              v-for="link in testimonials.links"
              :key="link.label"
              :href="link.url"
              v-html="link.label"
              :class="[
                'px-3 py-2 text-sm rounded-lg transition',
                link.active ? 'bg-pink-600 text-white font-bold' : 'bg-white text-gray-600 hover:bg-pink-100',
                !link.url ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
              ]"
            ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from "@/Components/NavbarAdmin.vue"
import { defineProps } from 'vue'

const props = defineProps({
  testimonials: Object
})
</script>

<style scoped>
/* Custom styling jika diperlukan */
</style>
