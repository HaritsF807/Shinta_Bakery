<template>
  <div class="bg-white min-h-screen">
    <!-- Main Product Section -->
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Product Image -->
        <div class="md:w-1/2">
          <div class="relative rounded-lg overflow-hidden shadow-lg">
            <img 
              :src="`/storage/${product.image}`" 
              :alt="product.name"
              class="w-full h-auto object-cover"
            />
          </div>
          
          <!-- Mini Preview Bar (Mobile) -->
          <div class="md:hidden mt-4 p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <img 
                :src="product.image" 
                :alt="product.name"
                class="w-12 h-12 object-cover rounded"
              />
              <div>
                <h3 class="font-semibold text-gray-800">{{ product.name }}</h3>
                <p class="text-xs text-green-600 uppercase">{{ product.category?.name }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Product Details -->
        <div class="md:w-1/2">
          <!-- Hot Sale Badge -->
          <div class="mb-4">
            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
              HOT SALE
            </span>
          </div>
          
          <!-- Product Title -->
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ product.name }}</h1>
          
          <!-- Category & Rating -->
          <div class="flex items-center mb-4">
            <span class="text-sm text-green-600 uppercase font-medium mr-3">{{ product.category.name }}</span>
            <div class="flex items-center">
              <div class="flex text-yellow-400">
                <svg v-for="star in 5" :key="star" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.917c1.924-.302 3.882.212 5.574 1.435 1.692 1.223 2.987 2.964 3.57 5.006.583 2.043.452 4.303-1.016 6.192-1.468 1.89-3.74 2.762-6.016 2.762-2.276 0-4.548-.872-6.016-2.762-1.468-1.889-1.599-4.149-.583-6.192 1.016-1.89 2.846-3.762 4.57-5.006 1.692-1.223 3.65-1.737 5.574-1.435z"></path>
                </svg>
              </div>
              <span class="ml-2 text-sm text-gray-600">4.9 (2130 reviews)</span>
            </div>
          </div>

          <!-- Price -->
          <p class="text-2xl text-green-700 font-semibold mb-4">
            Rp {{ formatRupiah(product.price) }}
          </p>

          <!-- Description -->
          <div class="mb-6">
            <h3 class="font-semibold text-gray-800 mb-2">Description:</h3>
            <p class="text-gray-700 leading-relaxed">
              {{ product.description }}
            </p>
          </div>

          <!-- Size Selection -->
          <div class="mb-6" v-if="product.sizes && product.sizes.length">
            <h3 class="font-semibold text-gray-800 mb-3">Size:</h3>
            <div class="flex space-x-3">
              <button 
                v-for="size in product.sizes" 
                :key="size" 
                @click="selectedSize = size"
                :class="[
                  'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                  selectedSize === size 
                    ? 'bg-pink-500 text-white' 
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                ]"
              >
                {{ size }}
              </button>
            </div>
          </div>

          <!-- Ingredients -->
          <div v-if="product.ingredients && product.ingredients.length" class="mb-8">
            <h3 class="font-semibold text-gray-800 mb-3">Ingredients:</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
              <li v-for="(ingredient, index) in product.ingredients" :key="index">
                {{ ingredient }}
              </li>
            </ul>
          </div>

          <!-- Add to Cart Section -->
          <div class="border-t pt-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <label class="text-gray-700 font-medium">Qty:</label>
                <div class="flex items-center border rounded-md">
                  <button 
                    @click="decreaseQuantity" 
                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md transition-colors"
                  >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                  </button>
                  <input 
                    type="number" 
                    v-model="quantity" 
                    class="w-12 text-center border-x py-1 focus:outline-none w-16"
                    min="1"
                  />
                  <button 
                    @click="increaseQuantity" 
                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md transition-colors w-8"
                  >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <button 
                @click="addToCart"
                class="px-6 py-3 bg-pink-500 text-white font-medium rounded-md hover:bg-pink-600 transition-colors shadow-md"
              >
                ADD TO CART
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Shopping Cart Icon (Top Right) -->
    <div class="fixed top-4 right-4">
      <a href="/cart">
      <button 
        class="p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow"
      >
        <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10v8a2 2 0 002 2H5a2 2 0 002-2v-8m12-4l-4 4m0 0l-4-4m4 4V3"></path>
        </svg>
      </button>
      </a>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

// Props dari Laravel
const props = defineProps({
  product: Object,
  errors: Object,
  auth: Object,
})

// State
const selectedSize = ref('Regular')
const quantity = ref(1)

// Fungsi kuantitas
const decreaseQuantity = () => {
  if (quantity.value > 1) quantity.value--
}
const increaseQuantity = () => {
  quantity.value++
}

// Kirim ke Laravel via Inertia
const addToCart = () => {
  router.post(`/cart/add/${props.product.id}`, {
    quantity: quantity.value,
    size: selectedSize.value
  }, {
    onSuccess: () => alert('Produk ditambahkan ke keranjang!')
  })
}

// Lihat keranjang (sementara alert)
const viewCart = () => {
  alert('Menuju halaman keranjang...')
}

function formatRupiah(value) {
  if (!value && value !== 0) return "0";
  return Number(value).toLocaleString("id-ID", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  });
}
</script>

<style scoped>
/* Styling tambahan opsional */
</style>
