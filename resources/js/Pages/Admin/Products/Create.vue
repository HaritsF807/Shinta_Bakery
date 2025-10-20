<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

// props dari controller
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

// handle file upload
const handleFileChange = (e) => {
  form.image = e.target.files[0] ?? null
}

// submit form
const submit = () => {
  form.post('/admin/products', {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <Head title="Tambah Produk" />

  <div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Tambah Produk</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-medium">Nama Produk</label>
        <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
      </div>

      <div>
        <label class="block font-medium">Deskripsi</label>
        <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">Harga</label>
          <input v-model="form.price" type="number" class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="block font-medium">Stok</label>
          <input v-model="form.stock" type="number" class="w-full border p-2 rounded" />
        </div>
      </div>

      <div>
        <label class="block font-medium">Status</label>
        <select v-model="form.status" class="w-full border p-2 rounded">
          <option value="aktif">Aktif</option>
          <option value="nonaktif">Nonaktif</option>
        </select>
      </div>

      <div>
        <label class="block font-medium">Kategori</label>
        <select v-model="form.category_id" class="w-full border p-2 rounded">
          <option value="">-- Pilih Kategori --</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }}
          </option>
        </select>
      </div>

      <div>
        <label class="block font-medium">Gambar Produk (opsional)</label>
        <input type="file" @change="handleFileChange" accept="image/*" class="w-full" />
      </div>

      <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Simpan Produk
        </button>
      </div>
    </form>
  </div>
</template>
