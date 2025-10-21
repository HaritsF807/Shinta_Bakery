<script setup>
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({ category: Object })

const form = useForm({
  name: props.category.name
})

// Simpan perubahan
function submit() {
  form.put(`/admin/categories/${props.category.id}`)
}

// Batal edit → balik ke index
function cancel() {
  router.visit('/admin/categories')
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Kategori</label>
        <input
          v-model="form.name"
          type="text"
          class="border p-2 w-full rounded"
        />
      </div>

      <div class="flex space-x-2">
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Simpan Perubahan
        </button>

        <button
          type="button"
          @click="cancel"
          class="bg-red-500 text-white px-4 py-2 rounded hover:bg-gray-500"
        >
          Batal
        </button>
      </div>
    </form>
  </div>
</template>
