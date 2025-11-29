<script setup>
import Navbar from "../Components/Navbar.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  orders: Object,
  filters: Object,
});


const search = ref(props.filters?.search || "");


// Fungsi pencarian
const doSearch = () => {
  router.get(route("orders.history"), { search: search.value }, { preserveState: true });
};

// Format rupiah
const formatCurrency = (value) =>
  new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(value);

// 🔒 Sensor nama dengan asterisk (contoh: "John Doe" → "Jo** Do*")
const censorName = (name) => {
  if (!name) return "****";
  
  const words = name.trim().split(" ");
  return words.map(word => {
    if (word.length <= 2) return word; // Nama pendek tidak disensor
    const visibleChars = Math.min(2, Math.floor(word.length / 3));
    return word.substring(0, visibleChars) + "*".repeat(word.length - visibleChars);
  }).join(" ");
};

// 🔒 Sensor nomor HP dengan asterisk (contoh: "081234567890" → "0812****7890")
const censorPhone = (phone) => {
  if (!phone) return "****";
  
  const phoneStr = phone.toString();
  if (phoneStr.length <= 6) return "****"; // HP terlalu pendek
  
  const visibleStart = 4; // Tampilkan 4 digit awal
  const visibleEnd = 4;   // Tampilkan 4 digit akhir
  const censoredLength = phoneStr.length - visibleStart - visibleEnd;
  
  return phoneStr.substring(0, visibleStart) + 
         "*".repeat(Math.max(censoredLength, 3)) + 
         phoneStr.substring(phoneStr.length - visibleEnd);
};

</script>

<template>
  <Head title="Riwayat Pesanan" />

  <div class="payment-history-container">
    <!-- Navbar -->
    <Navbar />
    <br /><br /><br />

    <!-- Konten utama -->
    <main class="main-content">
      <div class="payment-history-card">
        <!-- Header -->
        <div class="section-header">
          <h1 class="section-title"><strong>Riwayat Pesanan</strong></h1>

          <!-- Search Bar -->
          <form @submit.prevent="doSearch" class="flex gap-2">
            <input
              type="text"
              v-model="search"
              placeholder="Cari Nama / No HP / Invoice / Status..."
              class="search-container"
            />
            <button type="submit" class="search-btn">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>

        <!-- Tabel -->
        <div class="table-container">
          <table class="payment-table">
            <thead>
              <tr>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Nama Pembeli</th>
                <th>No. HP</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="history-data">
              <tr v-for="order in orders.data" :key="order.id">
                <td>{{ order.invoice_number }}</td>
                <td>{{ new Date(order.created_at).toLocaleDateString("id-ID") }}</td>
                <td>{{ censorName(order.guest_name) }}</td>
                <td>{{ censorPhone(order.guest_phone) }}</td>
                <td>{{ formatCurrency(order.total_price) }}</td>
                <td :class="'status-' + order.status.toLowerCase()">
                  {{ order.status }}
                </td>
              </tr>

              <tr v-if="orders.data.length === 0">
                <td colspan="6" class="text-center text-gray-500 py-4">
                  Tidak ada pesanan ditemukan
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.payment-history-container {
  @apply font-sans bg-[#faead8] min-h-screen;
}


/* Konten utama */
.main-content {
  display: flex;
  justify-content: center;
  padding: 30px 20px;
}

.payment-history-card {
  background-color: #f93679;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(255, 64, 129, 0.3);
  padding: 30px;
  width: 100%;
  max-width: 800px;
}

/* Header */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  position: relative;
  top: 30px;
}

.section-title {
  color: white;
  font-size: 1.8rem;
  margin: 0;
  position: relative;
  bottom: 20px;
}

/* Search Bar */
.search-container {
  background-color: white;
  border-radius: 25px;
  padding: 6px 12px;
  height: 30px;
  width: 300px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.search-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: #555;
  font-size: 16px;
}

/* Table */
.table-container {
  overflow-x: auto;
}

.history-data {
  background-color: white;
}

.payment-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.payment-table th,
.payment-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.payment-table th {
  background-color: #f8f8f8;
  font-weight: 600;
  color: #555;
}

.status-pending {
  color: #ffc107;
  font-weight: bold;
}
.status-processing {
  color: #3498db;
  font-weight: bold;
}
.status-completed {
  color: #2ecc71;
  font-weight: bold;
}
.status-cancelled {
  color: #e74c3c;
  font-weight: bold;
}
</style>
