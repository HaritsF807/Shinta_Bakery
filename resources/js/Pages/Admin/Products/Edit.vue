<template>
  <div class="min-h-screen bg-amber-100 p-6 flex justify-center items-center">
    <div class="bg-pink-500 rounded-xl shadow-lg w-full max-w-4xl p-6">
      <!-- Header -->
      <h1 class="text-2xl font-bold text-white mb-6">Edit Produk</h1>

      <!-- Form Container -->
      <div class="bg-white rounded-lg shadow p-6">
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
              <!-- Name Field -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="Nama Produk"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                />
                <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
              </div>

              <!-- Description Field -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea
                  v-model="form.description"
                  placeholder="Deskripsi produk..."
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                ></textarea>
                <div v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description }}</div>
              </div>

              <!-- Upload Images -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                  <input
                    type="file"
                    @change="e => form.image = e.target.files[0]"
                    class="mb-2"
                  />
                  <div v-if="props.product.image" class="mt-2">
                    <img
                      :src="`/storage/${props.product.image}`"
                      alt="Gambar"
                      class="w-32 h-32 object-cover rounded mx-auto"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
              <!-- Stock -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                <input
                  v-model="form.stock"
                  type="number"
                  placeholder="Jumlah stok"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                />
                <div v-if="errors.stock" class="text-red-500 text-sm mt-1">{{ errors.stock }}</div>
              </div>

              <!-- Price -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                <input
                  v-model="form.price"
                  type="number"
                  placeholder="Harga produk"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                />
                <div v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price }}</div>
              </div>

              <!-- Status -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="form.status"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                >
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                </select>
              </div>

              <!-- Category -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select
                  v-model="form.category_id"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                >
                  <option value="">Pilih Kategori</option>
                  <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-end space-x-4 mt-8">
            <button
              type="button"
              @click="cancelEdit"
              class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
            >
              Batal
            </button>

            <button
              type="submit"
              class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
            >
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  product: Object,
  categories: Array,
  errors: Object,
  auth: Object
})

const categories = props.categories

const form = useForm({
  name: props.product.name,
  description: props.product.description,
  price: props.product.price,
  stock: props.product.stock,
  status: props.product.status,
  category_id: props.product.category_id,
  image: null
})

function submit() {
  form.transform(data => ({
    ...data,
    _method: 'PUT'
  }))
  form.post(route('admin.products.update', props.product.id), {
    forceFormData: true,
  })
}

function cancelEdit() {
  window.history.back() // balik ke halaman sebelumnya
}
</script>

<style scoped>
/* styling tambahan opsional */
</style>
