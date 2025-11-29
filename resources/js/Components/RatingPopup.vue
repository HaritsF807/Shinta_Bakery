<template>
  <Transition name="modal">
    <div v-if="isOpen" class="modal-overlay" @click.self="close">
      <div class="modal-container">
        <!-- Close Button -->
        <button class="close-btn" @click="close">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>

        <!-- Header -->
        <div class="modal-header">
          <h2>⭐ Bagaimana pengalaman Anda?</h2>
          <p>Berikan testimoni untuk pesanan Anda</p>
        </div>

        <!-- Rating Stars -->
        <div class="rating-container">
          <div class="stars">
            <button
              v-for="star in 5"
              :key="star"
              type="button"
              class="star"
              :class="{ active: star <= selectedRating, hover: star <= hoverRating }"
              @click="selectRating(star)"
              @mouseenter="hoverRating = star"
              @mouseleave="hoverRating = 0"
            >
              ★
            </button>
          </div>
          <p v-if="selectedRating > 0" class="rating-text">
            {{ ratingLabels[selectedRating - 1] }}
          </p>
        </div>

        <!-- Comment Textarea -->
        <div class="form-group">
          <label>Komentar (Opsional)</label>
          <textarea
            v-model="comment"
            placeholder="Ceritakan pengalaman Anda dengan produk kami..."
            maxlength="500"
            rows="4"
          ></textarea>
          <span class="char-count">{{ comment.length }}/500</span>
        </div>

        <!-- Submit Button -->
        <button
          class="submit-btn"
          :disabled="!selectedRating || isSubmitting"
          @click="submitTestimonial"
        >
          <span v-if="!isSubmitting">Kirim Testimoni</span>
          <span v-else>Mengirim...</span>
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  isOpen: Boolean,
  orderId: Number,
  orderInvoice: String,
})

const emit = defineEmits(['close', 'submitted'])

const selectedRating = ref(0)
const hoverRating = ref(0)
const comment = ref('')
const isSubmitting = ref(false)

const ratingLabels = [
  'Sangat Buruk',
  'Kurang Memuaskan',
  'Cukup Baik',
  'Memuaskan',
  'Sangat Memuaskan!'
]

const selectRating = (rating) => {
  selectedRating.value = rating
}

const close = () => {
  emit('close')
}

const submitTestimonial = () => {
  if (!selectedRating.value) return

  isSubmitting.value = true

  Inertia.post('/testimonials', {
    order_id: props.orderId,
    rating: selectedRating.value,
    comment: comment.value,
  }, {
    onSuccess: () => {
      isSubmitting.value = false
      emit('submitted')
      close()
    },
    onError: (errors) => {
      isSubmitting.value = false
      console.error('Error submitting testimonial:', errors)
      alert('Gagal mengirim testimoni. Silakan coba lagi.')
    }
  })
}
</script>

<style scoped>
/* Modal Overlay */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  padding: 20px;
}

/* Modal Container */
.modal-container {
  background: linear-gradient(135deg, #fff5f7 0%, #fff9e6 100%);
  border-radius: 24px;
  padding: 40px;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  position: relative;
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Close Button */
.close-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: transparent;
  border: none;
  cursor: pointer;
  color: #666;
  transition: color 0.2s ease;
  padding: 8px;
}

.close-btn:hover {
  color: #333;
}

/* Header */
.modal-header {
  text-align: center;
  margin-bottom: 32px;
}

.modal-header h2 {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 8px;
}

.modal-header p {
  font-size: 14px;
  color: #666;
}

/* Rating Container */
.rating-container {
  text-align: center;
  margin-bottom: 32px;
}

.stars {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-bottom: 16px;
}

.star {
  background: none;
  border: none;
  font-size: 48px;
  color: #D1D5DB;
  cursor: pointer;
  transition: all 0.2s ease;
  padding: 0;
  line-height: 1;
}

.star:hover,
.star.hover {
  color: #FFD700;
  transform: scale(1.2);
}

.star.active {
  color: #FFD700;
}

.rating-text {
  font-size: 18px;
  font-weight: 600;
  color: #FF6B6B;
  margin-top: 8px;
}

/* Form Group */
.form-group {
  margin-bottom: 24px;
  position: relative;
}

.form-group label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
}

.form-group textarea {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #E5E7EB;
  border-radius: 12px;
  font-size: 14px;
  font-family: inherit;
  resize: vertical;
  transition: border-color 0.2s ease;
  background: white;
}

.form-group textarea:focus {
  outline: none;
  border-color: #FFD700;
}

.char-count {
  position: absolute;
  bottom: -20px;
  right: 0;
  font-size: 12px;
  color: #999;
}

/* Submit Button */
.submit-btn {
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, #f93679 0%, #FF4081 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(249, 54, 121, 0.3);
}

.submit-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(249, 54, 121, 0.4);
}

.submit-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Transitions */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

/* Responsive */
@media (max-width: 600px) {
  .modal-container {
    padding: 24px;
  }

  .modal-header h2 {
    font-size: 24px;
  }

  .star {
    font-size: 40px;
  }
}
</style>
