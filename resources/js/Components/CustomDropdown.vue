<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  options: Array,
  placeholder: {
    type: String,
    default: 'Pilih...'
  }
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const dropdownRef = ref(null);

// Cari label dari value yang dipilih
const selectedLabel = computed(() => {
  if (!props.modelValue) return props.placeholder;
  const selected = props.options.find(opt => opt.value === props.modelValue);
  return selected ? selected.label : props.placeholder;
});

function toggleDropdown() {
  isOpen.value = !isOpen.value;
}

function selectOption(value) {
  emit('update:modelValue', value);
  isOpen.value = false;
}

// Close dropdown when clicking outside
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div ref="dropdownRef" class="custom-dropdown">
    <!-- Trigger Button -->
    <button
      type="button"
      @click="toggleDropdown"
      class="dropdown-trigger"
      :class="{ 'is-open': isOpen }"
    >
      <span class="selected-text">{{ selectedLabel }}</span>
      <svg
        class="dropdown-icon"
        :class="{ 'rotate': isOpen }"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M19 9l-7 7-7-7"
        />
      </svg>
    </button>

    <!-- Dropdown Menu -->
    <Transition name="dropdown">
      <div v-if="isOpen" class="dropdown-menu">
        <div class="dropdown-content">
          <button
            v-for="option in options"
            :key="option.value"
            type="button"
            @click="selectOption(option.value)"
            class="dropdown-item"
            :class="{ 'is-selected': option.value === modelValue }"
          >
            <span>{{ option.label }}</span>
            <svg
              v-if="option.value === modelValue"
              class="check-icon"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              />
            </svg>
          </button>
        </div>
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.custom-dropdown {
  position: relative;
  width: 100%;
}

.dropdown-trigger {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(254, 243, 249, 0.85) 100%);
  backdrop-filter: blur(10px);
  border: 2px solid #f9a8d4;
  border-radius: 9999px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 
    0 4px 6px rgba(236, 72, 153, 0.12),
    0 2px 4px rgba(236, 72, 153, 0.08),
    inset 0 1px 1px rgba(255, 255, 255, 0.8);
  font-size: 0.95rem;
  font-weight: 500;
  color: #831843;
}

.dropdown-trigger:hover {
  background: linear-gradient(135deg, rgba(254, 243, 249, 0.95) 0%, rgba(252, 231, 243, 0.9) 100%);
  backdrop-filter: blur(12px);
  border-color: #ec4899;
  box-shadow: 
    0 8px 16px rgba(236, 72, 153, 0.2),
    0 4px 8px rgba(236, 72, 153, 0.15),
    0 0 20px rgba(236, 72, 153, 0.1),
    inset 0 1px 1px rgba(255, 255, 255, 0.9);
  transform: translateY(-2px) scale(1.01);
}

.dropdown-trigger.is-open {
  border-color: #ec4899;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  box-shadow: 
    0 0 0 4px rgba(236, 72, 153, 0.15),
    0 8px 20px rgba(236, 72, 153, 0.2),
    inset 0 1px 1px rgba(255, 255, 255, 1);
  transform: translateY(-1px);
}

.selected-text {
  flex: 1;
  text-align: left;
  color: #831843;
}

.dropdown-icon {
  width: 1.25rem;
  height: 1.25rem;
  color: #ec4899;
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  flex-shrink: 0;
  margin-left: 0.5rem;
}

.dropdown-icon.rotate {
  transform: rotate(180deg);
}

.dropdown-menu {
  position: absolute;
  top: calc(100% + 0.5rem);
  left: 0;
  right: 0;
  z-index: 50;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(12px);
  border-radius: 1rem;
  box-shadow: 
    0 20px 50px rgba(0, 0, 0, 0.2),
    0 10px 20px rgba(0, 0, 0, 0.1),
    0 0 0 1px rgba(236, 72, 153, 0.15),
    0 0 30px rgba(236, 72, 153, 0.1);
  overflow: hidden;
}

.dropdown-content {
  max-height: 16rem;
  overflow-y: auto;
  padding: 0.5rem;
}

/* Custom Scrollbar */
.dropdown-content::-webkit-scrollbar {
  width: 6px;
}

.dropdown-content::-webkit-scrollbar-track {
  background: #fce7f3;
  border-radius: 3px;
}

.dropdown-content::-webkit-scrollbar-thumb {
  background: #f9a8d4;
  border-radius: 3px;
}

.dropdown-content::-webkit-scrollbar-thumb:hover {
  background: #ec4899;
}

.dropdown-item {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  text-align: left;
  background: transparent;
  border: none;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 0.95rem;
  color: #1f2937;
  font-weight: 500;
}

.dropdown-item:hover {
  background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
  color: #831843;
  transform: translateX(6px) scale(1.02);
  box-shadow: 0 2px 8px rgba(236, 72, 153, 0.15);
}

/* Stagger animation for dropdown items */
.dropdown-item {
  animation: slideIn 0.3s ease-out backwards;
}

.dropdown-item:nth-child(1) { animation-delay: 0.05s; }
.dropdown-item:nth-child(2) { animation-delay: 0.08s; }
.dropdown-item:nth-child(3) { animation-delay: 0.11s; }
.dropdown-item:nth-child(4) { animation-delay: 0.14s; }
.dropdown-item:nth-child(5) { animation-delay: 0.17s; }
.dropdown-item:nth-child(n+6) { animation-delay: 0.2s; }

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-10px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.dropdown-item.is-selected {
  background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
  color: white;
}

.dropdown-item.is-selected:hover {
  background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
  transform: translateX(4px);
}

.check-icon {
  width: 1.25rem;
  height: 1.25rem;
  flex-shrink: 0;
  animation: checkmark 0.3s ease;
}

/* Animations */
@keyframes checkmark {
  0% {
    transform: scale(0) rotate(-45deg);
    opacity: 0;
  }
  50% {
    transform: scale(1.2) rotate(0deg);
  }
  100% {
    transform: scale(1) rotate(0deg);
    opacity: 1;
  }
}

/* Dropdown Transition */
.dropdown-enter-active {
  animation: dropdown-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.dropdown-leave-active {
  animation: dropdown-out 0.2s cubic-bezier(0.4, 0, 1, 1);
}

@keyframes dropdown-in {
  0% {
    opacity: 0;
    transform: translateY(-10px) scale(0.95);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes dropdown-out {
  0% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
  100% {
    opacity: 0;
    transform: translateY(-10px) scale(0.95);
  }
}

/* Mobile Responsive */
@media (max-width: 640px) {
  .dropdown-trigger {
    padding: 0.65rem 0.875rem;
    font-size: 0.9rem;
  }

  .dropdown-item {
    padding: 0.65rem 0.875rem;
    font-size: 0.9rem;
  }
}
</style>
