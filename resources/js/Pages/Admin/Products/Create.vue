<template>
  <Head title="Tambah Produk" />

  <div class="min-h-screen bg-amber-100 p-6 flex justify-center items-center">
    <div class="bg-pink-500 rounded-xl shadow-lg w-full max-w-4xl p-6">
      <!-- Header -->
      <h1 class="text-2xl font-bold text-white mb-6">Add Product</h1>

      <!-- Form Container -->
      <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Kolom Kiri -->
          <div class="space-y-6">
            <!-- Nama Produk -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
              <input
                v-model="form.name"
                type="text"
                placeholder="Contoh: Kue Lapis Legit"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              />
              <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
            </div>

            <!-- Deskripsi -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
              <textarea
                v-model="form.description"
                placeholder="Deskripsi singkat produk..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              ></textarea>
              <span v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</span>
            </div>

            <!-- Upload Gambar -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
              <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                <input
                  type="file"
                  @change="handleFileChange"
                  accept="image/*"
                  class="w-full text-sm text-gray-700"
                />
                <div v-if="previewImage" class="mt-4">
                  <img :src="previewImage" alt="Preview" class="max-w-full h-auto rounded-lg" />
                </div>
              </div>
              <span v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</span>
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="space-y-6">
            <!-- Stok -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
              <input
                v-model="form.stock"
                type="number"
                placeholder="100"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              />
              <span v-if="form.errors.stock" class="text-red-500 text-sm">{{ form.errors.stock }}</span>
            </div>

            <!-- Harga -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
              <input
                v-model="form.price"
                type="number"
                placeholder="10000"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              />
              <span v-if="form.errors.price" class="text-red-500 text-sm">{{ form.errors.price }}</span>
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
              <span v-if="form.errors.status" class="text-red-500 text-sm">{{ form.errors.status }}</span>
            </div>

            <!-- Kategori -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
              <select
                v-model="form.category_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              >
                <option value="">Pilih Kategori</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
              <span v-if="form.errors.category_id" class="text-red-500 text-sm">{{ form.errors.category_id }}</span>
            </div>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-4 mt-8">
          <a href="/admin/products">
          <button
            type="button"
            @click="form.reset()"
            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
          >
            Batal
          </button>
          </a>
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

// props dari controller (categories dikirim dari Laravel)
defineProps({
  categories: Array,
})

// form inertia
const form = useForm({
  name: '',
  description: '',
  price: '',
  stock: '',
  status: 'aktif',
  category_id: '',
  image: null,
})

// preview gambar
const previewImage = ref(null)

const handleFileChange = (e) => {
  const file = e.target.files[0]
  form.image = file ?? null

  if (file) {
    previewImage.value = URL.createObjectURL(file)
  } else {
    previewImage.value = null
  }
}

// kirim ke server
const submit = () => {
  form.post('/admin/products', {
    onSuccess: () => {
      form.reset()
      previewImage.value = null
    },
  })
}
</script>
