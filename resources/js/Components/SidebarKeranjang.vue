<template>
  <!-- Overlay dengan animasi fade -->
  <transition name="fade">
    <div 
      v-if="visible"
      class="overlay"
      @click.self="$emit('close')"
    >
      <!-- Sidebar dengan animasi slide -->
      <transition name="slide">
        <div class="cart-sidebar">
          <!-- Header -->
          <div class="cart-header">
            <h2>Your cart <span>({{ cartItems.length }})</span></h2>
            <button class="close-btn" @click="$emit('close')">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>

          <!-- Cart Items -->
          <div class="cart-items">
            <div v-for="(item, index) in cartItems" :key="index" class="cart-item">
              <div class="item-info">
                <div class="item-name">{{ item.name }}</div>
                <div class="item-price">Rp. {{ formatCurrency(item.price) }}</div>
              </div>
              
              <div>
               <button class="remove-btn" @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="3 6 5 6 21 6"></polyline>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
              </button>

              <div class="item-controls">
                <button class="quantity-btn" @click="decreaseQuantity(index)">-</button>
                <span class="quantity">{{ item.quantity }}</span>
                <button class="quantity-btn" @click="increaseQuantity(index)">+</button>
              </div>
              </div>
              
             
            </div>
          </div>
          
          <!-- Divider -->
          <div class="divider"></div>
          
          <!-- Summary -->
          <div class="cart-summary">
            <div class="summary-row">
              <span>Sub Total</span>
              <span>Rp. {{ formatCurrency(subTotal) }}</span>
            </div>
            
            <button class="checkout-btn" @click="proceedToCheckout">
              Set Shipping Address
            </button>
            
            <p class="shipping-note">
              Set your shipping address so we know where to deliver your order.
            </p>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>


<script>
export default {
  name: 'SideBarKeranjang',
  props: {
    cartItems: {
      type: Array,
      required: true,
      default: () => []
    },
    visible: { // dikontrol dari parent (Navbar)
      type: Boolean,
      default: true
    }
  },
  computed: {
    subTotal() {
      return this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
    }
  },
  methods: {
    formatCurrency(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    increaseQuantity(index) {
      this.$set(this.cartItems[index], 'quantity', this.cartItems[index].quantity + 1);
      this.$emit('update:cartItems', this.cartItems);
    },
    decreaseQuantity(index) {
      if (this.cartItems[index].quantity > 1) {
        this.$set(this.cartItems[index], 'quantity', this.cartItems[index].quantity - 1);
        this.$emit('update:cartItems', this.cartItems);
      }
    },
    removeItem(index) {
      this.cartItems.splice(index, 1);
      this.$emit('update:cartItems', this.cartItems);
    },
    proceedToCheckout() {
      this.$emit('proceed-to-checkout');
    }
  }
};
</script>

<style scoped>
/* Overlay background */
.overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0,0,0,0.4);
  z-index: 999;
}

/* Sidebar container */
.cart-sidebar {
  background-color: #FFF5E6;
  width: 370px;
  max-width: 100%;
  height: 100vh;
  position: absolute;
  right: 0;
  top: 0;
  box-shadow: -5px 0 20px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  padding: 20px;
  overflow-y: auto;
  z-index: 1000;
}

/* --- Animations --- */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-enter-active, .slide-leave-active {
  transition: transform 1s ease;
}
.slide-enter-from {
  transform: translateX(100%);
}
.slide-leave-to {
  transform: translateX(100%);
}
/* --- Your Existing Styles (unchanged) --- */
.cart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid #ddd;
}
.cart-header h2 {
  font-size: 1.5rem;
  color: #333;
}
.cart-header h2 span {
  color: #FF4081;
  font-weight: bold;
}
.close-btn {
  background-color: #FF4081;
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.close-btn:hover {
  background-color: #E91E63;
}
.cart-items {
  flex: 1;
  overflow-y: auto;
  margin-bottom: 20px;
}
.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 0;
  border-bottom: 1px solid #eee;
}
.item-info {
  flex: 1;
  margin-right: 15px;
}
.item-name {
  font-weight: 600;
  margin-bottom: 5px;
  color: #333;
}
.item-price {
  color: #666;
  font-size: 0.9rem;
}
.item-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  
}
.quantity-btn {
  
  color: #333;
  border-radius: 5px;
  width: 10px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.quantity {
    color: #333;
  font-weight: bold;
  min-width: 20px;
  text-align: center;
}
.remove-btn {
    position: relative;
    left: 30px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px;
  transition: transform 0.2s ease;
}
.remove-btn:hover {
  transform: scale(1.2);
}
.divider {
  height: 1px;
  background-color: #ddd;
  margin: 20px 0;
}
.cart-summary {
  background-color: #FFCDD2;
  padding: 20px;
  border-radius: 10px;
}
.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  font-weight: bold;
}
.summary-row span:first-child {
  color: #FF4081;
}
.summary-row span:last-child {
  color: #333;
}
.checkout-btn {
  width: 100%;
  background-color: #FF4081;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 12px 20px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-bottom: 15px;
}
.checkout-btn:hover {
  background-color: #E91E63;
}
.shipping-note {
  font-size: 0.85rem;
  color: #666;
  text-align: center;
  line-height: 1.4;
}
@media (max-width: 480px) {
  .cart-sidebar { width: 100%; }
}
</style>
