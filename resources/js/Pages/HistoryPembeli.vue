<template>
  <div class="payment-history-container">
    <!-- Header -->
    <div>
      <Navbar />
    </div>
    <br /><br /><br />

    <!-- Main Content -->
    <main class="main-content">
      <div class="payment-history-card">
        <!-- Header Section dengan Search -->
        <div class="section-header">
          <h1 class="section-title"><strong>Payment History</strong></h1>

          <!-- Search Bar -->
          <div class="">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search..."
              class="search-container"
            />
            <button class="search-btn">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>

        <!-- Tabel -->
        <div class="table-container">
          <table class="payment-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Phone Number</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="history-data">
              <tr
                v-for="payment in filteredPayments"
                :key="payment.id"
              >
                <td>{{ payment.orderId }}</td>
                <td>{{ payment.date }}</td>
                <td>{{ payment.amount }}</td>
                <td>{{ payment.phoneNumber }}</td>
                <td :class="'status-' + payment.status.toLowerCase()">
                  {{ payment.status }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-controls">
          <div class="items-per-page">
            <select v-model="itemsPerPage" @change="updatePagination">
              <option value="5">5</option>
              <option value="10" selected>10</option>
              <option value="20">20</option>
              <option value="50">50</option>
            </select>
            <span>per page</span>
          </div>

          <div class="page-info">
            <select v-model="currentPage" @change="updatePagination">
              <option v-for="page in totalPages" :key="page" :value="page">
                {{ page }}
              </option>
            </select>
            <span>of {{ totalPages }} pages</span>

            <div class="page-navigation">
              <button
                :disabled="currentPage <= 1"
                @click="currentPage--"
                class="page-button"
              >
                &lt;
              </button>
              <button
                :disabled="currentPage >= totalPages"
                @click="currentPage++"
                class="page-button"
              >
                &gt;
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import Navbar from "../Components/Navbar.vue";

export default {
  name: "PaymentHistory",
  components: {
    Navbar,
  },
  data() {
    return {
      searchQuery: "",
      payments: [
        { id: 1, orderId: "#15267", date: "Aug 1, 2025", amount: 100, phoneNumber: "08xxxxxx21", status: "Success" },
        { id: 2, orderId: "#153587", date: "Aug 26, 2023", amount: 300, phoneNumber: "08xxxxxx13", status: "Success" },
        { id: 3, orderId: "#12436", date: "Sep 12, 2025", amount: 100, phoneNumber: "08xxxxxx57", status: "Pending" },
        { id: 4, orderId: "#16879", date: "Sep 12, 2025", amount: 500, phoneNumber: "08xxxxxx03", status: "Pending" },
      ],
      currentPage: 1,
      itemsPerPage: 10,
      totalItems: 4,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    },
    filteredPayments() {
      if (!this.searchQuery) return this.payments;
      const query = this.searchQuery.toLowerCase();
      return this.payments.filter(
        (p) =>
          p.orderId.toLowerCase().includes(query) ||
          p.phoneNumber.toLowerCase().includes(query) ||
          p.status.toLowerCase().includes(query)
      );
    },
  },
  methods: {
    updatePagination() {
      console.log(`Page: ${this.currentPage}, Items per page: ${this.itemsPerPage}`);
    },
  },
};
</script>

<style scoped>
.payment-history-container {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #faead8;
  min-height: 100vh;
}

/* Main Content */
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

/* Header Section (Title + Search) */
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
  display: flex;
  align-items: center;
  background-color: white;
  border-radius: 25px;
  padding: 6px 12px;
  height: 30px;
  width: 250px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  position: relative;
  top: 20px;
}

.search-input {
  border: none;
  outline: none;
  padding: 6px 10px;
  font-size: 14px;
  border-radius: 20px;
  width: 140px;
  color: #555;
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

.status-success {
  color: #4caf50;
  font-weight: bold;
}

.status-pending {
  color: #ffc107;
  font-weight: bold;
}

/* Pagination */
.pagination-controls {
  display: flex;
  background-color: white;
  justify-content: space-between;
  align-items: center;
  padding-top: 20px;
  border-top: 1px solid #eee;
}

.items-per-page,
.page-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.page-navigation {
  display: flex;
  gap: 5px;
}

.page-button {
  padding: 5px 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f8f8f8;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.page-button:hover:not(:disabled) {
  background-color: #e8e8e8;
}

.page-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .search-input {
    width: 100%;
  }

  .pagination-controls {
    flex-direction: column;
    gap: 15px;
  }
}
</style>
