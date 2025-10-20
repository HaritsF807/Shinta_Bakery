<script setup>
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  product: Object,
  categories: Array
})

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
  form.put(route('admin.products.update', props.product.id))
}


</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Produk</label>
        <input v-model="form.name" type="text" class="border p-2 w-full rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Deskripsi</label>
        <textarea v-model="form.description" class="border p-2 w-full rounded"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1">Harga</label>
        <input v-model="form.price" type="number" class="border p-2 w-full rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Stok</label>
        <input v-model="form.stock" type="number" class="border p-2 w-full rounded" />
      </div>

      <div>
        <label class="block font-semibold mb-1">Status</label>
        <select v-model="form.status" class="border p-2 w-full rounded">
          <option value="aktif">Aktif</option>
          <option value="nonaktif">Nonaktif</option>
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">Kategori</label>
        <select v-model="form.category_id" class="border p-2 w-full rounded">
          <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">Gambar Produk</label>
        <input type="file" @change="e => form.image = e.target.files[0]" />
        <div v-if="props.product.image" class="mt-2">
          <img :src="`/storage/${props.product.image}`" alt="Gambar" class="w-24 h-24 object-cover rounded" />
        </div>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Simpan Perubahan
      </button>
    </form>
  </div>
</template>
