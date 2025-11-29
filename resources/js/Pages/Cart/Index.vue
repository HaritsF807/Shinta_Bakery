<template>
  <div class="min-h-screen bg-gray-50 py-10 px-6">
    <!-- Header -->
    <div class="max-w-5xl mx-auto mb-8">
      <h1 class="text-3xl font-bold text-pink-600">🛒 Keranjang Belanja</h1>
      <p class="text-gray-600 mt-1">Kamu memiliki {{ Object.keys(cart).length }} item di keranjangmu</p>
    </div>

    <!-- Jika kosong -->
    <div v-if="Object.keys(cart).length === 0" class="text-center py-20">
      <p class="text-gray-500 text-lg">Keranjang kamu masih kosong 😅</p>
      <a href="/products" class="inline-block mt-6 bg-pink-600 text-white px-5 py-3 rounded-lg hover:bg-pink-700 transition">
        Lihat Produk →
      </a>
    </div>

    <!-- List Produk -->
    <div v-else class="max-w-5xl mx-auto bg-white rounded-xl shadow-md p-6 space-y-4">
      <div
        v-for="(item, key) in cart"
        :key="item.id"
        class="flex items-center justify-between p-4 border-b border-gray-100"
      >
        <!-- Gambar -->
        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
          <img
            :src="item.image ? `/storage/${item.image}` : 'https://placehold.co/100x100?text=No+Image'"
            class="w-full h-full object-cover"
          />
        </div>

        <!-- Info Produk -->
        <div class="flex-1 ml-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ item.name }}</h3>
          <p class="text-sm text-gray-500">Rp {{ item.price.toLocaleString('id-ID') }}</p>
        </div>

        <!-- Kontrol jumlah -->
        <div class="flex items-center space-x-2 relative bottom-8 left-24">
        <span class="font-medium">Qty:</span>
        
        <button
          @click="updateQuantity(item.id, item.quantity - 1)"
          class="w-7 h-7 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold flex items-center justify-center"
        >
          −
        </button>

        <span class="w-6 text-center font-semibold">{{ item.quantity }}</span>

        <button
    @click="updateQuantity(item.id, item.quantity + 1)"
    class="w-7 h-7 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold flex items-center justify-center"
  >
    +
  </button>
</div>


        <!-- Subtotal -->
        <div class="font-semibold text-gray-700">
          Rp {{ (item.price * item.quantity).toLocaleString('id-ID') }}
        </div>

        <!-- Tombol hapus -->
        <button
          @click="removeItem(item.id)"
          class="ml-4 text-gray-400 hover:text-red-500"
          title="Hapus"
        >
          🗑️
        </button>
      </div>
    </div>

    <!-- Ringkasan Total -->
    <div v-if="Object.keys(cart).length" class="max-w-5xl mx-auto mt-6 bg-pink-50 rounded-xl p-6 shadow-md">
      <div class="flex justify-between items-center mb-4">
        <span class="text-gray-700 font-semibold text-lg">Total:</span>
        <span class="text-2xl font-bold text-pink-600">
          Rp {{ totalHarga.toLocaleString('id-ID') }}
        </span>
      </div>

      <div class="flex justify-between">
        <button
          @click="clearCart"
          class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition"
        >
          Kosongkan
        </button>

        <button
          @click="checkStockBeforeCheckout"
          class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition"
        >
          Lanjut ke Checkout →
        </button>
      </div>
    </div>

    <!-- Toast Notification -->
    <div
      v-if="showToast"
      class="fixed top-20 right-6 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-slide-in z-50"
    >
      <span class="text-2xl">⚠️</span>
      <div>
        <p class="font-semibold">{{ toastMessage }}</p>
        <p class="text-sm opacity-90">{{ toastDetail }}</p>
      </div>
      <button @click="showToast = false" class="ml-4 text-xl hover:text-gray-200">×</button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

const props = defineProps({
  cart: Object
})

// Toast notification state
const showToast = ref(false)
const toastMessage = ref('')
const toastDetail = ref('')

// Hapus item
function removeItem(id) {
  router.delete(`/cart/remove/${id}`, {
    preserveScroll: true,
    onSuccess: () => console.log('Item dihapus'),
  })
}

// Update jumlah
function updateQuantity(id, newQty) {
  if (newQty <= 0) {
    removeItem(id)
  } else {
    router.post(`/cart/update/${id}`, { quantity: newQty }, { preserveScroll: true })
  }
}

// Kosongkan semua
function clearCart() {
  if (confirm('Kosongkan semua isi keranjang?')) {
    router.delete('/cart/clear', { preserveScroll: true })
  }
}

// 🔍 Validasi stok sebelum checkout
async function checkStockBeforeCheckout() {
  try {
    // Kirim request untuk cek stok
    const response = await axios.post('/cart/validate-stock', {
      cart: props.cart
    })
    
    // Jika semua stok cukup, lanjut ke checkout
    if (response.data.success) {
      window.location.href = '/checkout'
    }
  } catch (error) {
    // Jika stok tidak cukup, tampilkan toast
    if (error.response && error.response.data) {
      showToast.value = true
      toastMessage.value = error.response.data.message || 'Stok tidak mencukupi!'
      toastDetail.value = error.response.data.detail || ''
      
      // Auto hide toast setelah 5 detik
      setTimeout(() => {
        showToast.value = false
      }, 5000)
    }
  }
}

// Total harga
const totalHarga = computed(() =>
  Object.values(props.cart).reduce((sum, item) => sum + item.price * item.quantity, 0)
)
</script>

<style scoped>
@keyframes slide-in {
  from {
    transform: translateX(400px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-slide-in {
  animation: slide-in 0.3s ease-out;
}
</style>
