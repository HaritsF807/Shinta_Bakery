<template>
  <div class="halaman">
    <div class="invoice-container">
      <!-- Header -->
      <div class="invoice-header">
        <img src="/logo-shinta.png" alt="Shinta Bakery Logo" class="logo" />
        <div class="business-info">
          <div class="business-details">
            <h1 class="business-name">Shinta Bakery</h1>
            <p class="business-website">www.shintabakery.com</p>
            <p class="business-email">shintabakery@email.com</p>
            <p class="business-phone">085612884003</p>
          </div>
        </div>
      </div>

      <!-- Body -->
      <div class="invoice-body">
        <!-- Customer + Invoice Info -->
        <div class="invoice-info">
          <div class="customer-info">
            <h3>Billed to</h3>
            <p class="customer-name">
              <strong>{{ order.guest_name ?? order.user?.name ?? 'Customer' }}</strong>
            </p>
            <p>{{ order.shipping_address }}</p>
            <p>{{ order.guest_email }}</p>
            <p>{{ order.guest_phone }}</p>
          </div>

          <div class="invoice-details">
            <div class="invoice-number">
              <span>Invoice number</span>
              <p>#{{ order.invoice_number }}</p>
            </div>
            <div class="invoice-date">
              <span>Invoice date</span>
              <p>{{ formatDate(order.created_at) }}</p>
            </div>
          </div>

          <div class="total-amount">
            <p>Rp. {{ formatCurrency(order.total_price) }}</p>
          </div>
        </div>

        <!-- Items -->
        <div class="item-details">
          <table class="items-table">
            <thead>
              <tr>
                <th>ITEM DETAIL</th>
                <th>QTY</th>
                <th>AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in order.items" :key="index">
                <td>
                  <div class="item-name">{{ item.product?.name ?? 'Produk' }}</div>
                  <button class="review-btn" @click="reviewItem(item)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                      <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87-.69 6.9L12 19l-4.31 2.15-.69-6.9-5-4.87 6.91-1.01L12 2z"
                      />
                    </svg>
                    Review
                  </button>
                </td>
                <td>{{ item.quantity }}</td>
                <td>Rp. {{ formatCurrency(item.price) }}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" class="total-label">Total</td>
                <td>Rp. {{ formatCurrency(order.total_price) }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <button class="print-btn" @click="printInvoice">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path
              d="M6 18H4a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-2">
            </path>
            <rect x="6" y="14" width="12" height="8"></rect>
          </svg>
          Print Invoice
        </button>

        <button class="whatsapp-btn" @click="confirmInWhatsapp">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
              d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
            </path>
          </svg>
          Confirm in Whatsapp
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  order: Object
})

const formatCurrency = (value) => {
  if (!value) return '0'
  return Number(value).toLocaleString('id-ID')
}

const formatDate = (value) => {
  return new Date(value).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}

const printInvoice = () => {
  window.print()
}

const confirmInWhatsapp = () => {
  const phoneNumber = '085612884003'
  const message = `Halo, saya ingin konfirmasi pesanan ${props.order.invoice_number} dengan total Rp. ${formatCurrency(props.order.total_price)}.`
  const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`
  window.open(whatsappUrl, '_blank')
}

const reviewItem = (item) => {
  alert(`Review produk: ${item.product?.name ?? 'Produk'}`)
}
</script>

<style scoped>
.halaman{
  
  background-color: #FFF5E6;
  
}

.invoice-container {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #FFF5E6;
  padding: 30px;
  max-width: 800px;
  margin: 0 auto;
  
}

/* Header Styles */
.invoice-header {
  background-color: white;
  padding: 20px;
  border-radius: 10px 10px 0 0;
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}

.logo {
  border-radius: 50%;
  width: 100px;
  height: 90px;
  position: relative;
  bottom: 10px;
}

.business-details {
  flex: 1;
  position: relative;
  right: 20px;
}

.business-name {
  color: #FF4081;
  font-size: 1.5rem;
  margin-bottom: 5px;
}

.business-website,
.business-email,
.business-phone {
  color: #666;
  font-size: 0.9rem;
  margin: 3px 0;
}

/* Invoice Body Styles */
.invoice-body {
  background-color: white;
  padding: 20px;
  border-radius: 0 0 10px 10px;
}

.invoice-info {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 1px solid #eee;
}

.customer-info h3 {
  margin-bottom: 10px;
  color: #333;
}

.customer-name {
  font-weight: bold;
  margin-bottom: 5px;
}

.invoice-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.invoice-number,
.invoice-date {
  display: flex;
  flex-direction: column;
}

.invoice-number span,
.invoice-date span {
  font-size: 0.8rem;
  color: #666;
  margin-bottom: 5px;
}

.invoice-number p,
.invoice-date p {
  font-weight: bold;
  color: #333;
}

.total-amount {
  text-align: right;
  font-size: 1.5rem;
  font-weight: bold;
  color: #FF6F00;
  position: relative;
  top: 40px; 
}

/* Item Details Table */
.item-details {
  margin-top: 20px;
}

.items-table {
  width: 100%;
  border-collapse: collapse;
}

.items-table th {
  text-align: left;
  padding: 10px 15px;
  border-bottom: 2px solid #eee;
  font-weight: 600;
  color: #555;
  font-size: 0.9rem;
}

.items-table td {
  padding: 15px;
  border-bottom: 1px solid #eee;
  vertical-align: top;
}

.item-name {
  font-weight: 600;
  margin-bottom: 5px;
}

.review-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background-color: #FFD740;
  color: #333;
  border: none;
  border-radius: 15px;
  padding: 3px 8px;
  font-size: 0.8rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.review-btn:hover {
  background-color: #FFCA28;
}

.review-btn svg {
  width: 12px;
  height: 12px;
  fill: #333;
}

.total-label {
  font-weight: bold;
  text-align: right;
  position: relative;
  right: 30px;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 30px;
}

.print-btn,
.whatsapp-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 15px 20px;
  border: none;
  border-radius: 25px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  color: white;
  text-decoration: none;
}

.print-btn {
  background-color: #2196F3;
}

.print-btn:hover {
  background-color: #1976D2;
}

.whatsapp-btn {
  background-color: #4CAF50;
}

.whatsapp-btn:hover {
  background-color: #388E3C;
}

.print-btn svg,
.whatsapp-btn svg {
  width: 20px;
  height: 20px;
}

/* Responsive Design */
@media (max-width: 600px) {
  .invoice-container {
    padding: 20px;
    max-width: 100%;
  }
  
  .invoice-header {
    padding: 15px;
  }
  
  .invoice-body {
    padding: 15px;
  }
  
  .invoice-info {
    flex-direction: column;
    gap: 20px;
  }
  
  .invoice-details {
    flex-direction: row;
    flex-wrap: wrap;
    gap: 20px;
  }
  
  .items-table th,
  .items-table td {
    padding: 10px;
    font-size: 0.9rem;
  }
  
  .action-buttons {
    gap: 10px;
  }
  
  .print-btn,
  .whatsapp-btn {
    padding: 12px 15px;
    font-size: 0.9rem;
  }
}
</style>