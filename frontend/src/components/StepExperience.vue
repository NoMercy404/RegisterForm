<script setup>
import { ref, nextTick } from 'vue'

defineProps(['experiences'])

const emit = defineEmits(['add', 'remove'])

const containerRef = ref(null)

const addExperience = () => {
  const prevScrollTop = containerRef.value ? containerRef.value.scrollTop : null
  emit('add')
  nextTick(() => {
    if (containerRef.value && prevScrollTop !== null) {
      containerRef.value.scrollTop = prevScrollTop
    }
  })
}

const removeExperience = (index) => {
  emit('remove', index)
}
</script>

<template>
  <div class="step-container" ref="containerRef">
    <h2 class="step-title">Doświadczenie zawodowe</h2>

    <div v-for="(exp, index) in experiences" :key="index" class="experience-card">
      <div class="card-header">
        <button v-if="experiences.length > 1" @click="removeExperience(index)" class="btn-remove">Usuń</button>
      </div>

      <div class="form-group">
        <label>Firma</label>
        <input v-model="exp.company" type="text" placeholder="Nazwa firmy" class="glass-input" />
      </div>

      <div class="form-group">
        <label>Stanowisko</label>
        <input v-model="exp.position" type="text" placeholder="Nazwa stanowiska" class="glass-input" />
      </div>

      <div class="date-row">
        <div class="form-group">
          <label>Od</label>
          <input v-model="exp.dateFrom" type="date" class="glass-input" />
        </div>
        <div class="form-group">
          <label>Do</label>
          <input v-model="exp.dateTo" type="date" class="glass-input" />
        </div>
      </div>
    </div>

    <button @click="addExperience" class="btn-add-experience">
      + Dodaj doświadczenie
    </button>
  </div>
</template>

<style scoped>
.step-container {
  width: 100%;
  height: calc(100vh - 300px);
  overflow-y: auto;
  scrollbar-gutter: stable both-edges;
  padding-right: 8px;
  overflow-anchor: none;
}

.step-title {
  color: white;
  font-size: 22px;
  margin-bottom: 16px;
  font-weight: 700;
}

.experience-card {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 10px;
  padding: 14px;
  margin-bottom: 12px;
  backdrop-filter: blur(10px);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  padding-bottom: 8px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.card-number {
  color: rgba(255, 255, 255, 0.6);
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-remove {
  padding: 6px 12px;
  background: rgba(255, 100, 100, 0.2);
  border: 1px solid rgba(255, 100, 100, 0.4);
  color: rgba(255, 150, 150, 1);
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-remove:hover {
  background: rgba(255, 100, 100, 0.3);
  border-color: rgba(255, 100, 100, 0.6);
}

.form-group {
  margin-bottom: 10px;
}

label {
  display: block;
  color: rgba(255, 255, 255, 0.8);
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.glass-input {
  width: 100%;
  padding: 8px 10px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  color: white;
  font-size: 13px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(10px);
}

.glass-input::placeholder {
  color: rgba(255, 255, 255, 0.4);
}

.glass-input:focus {
  outline: none;
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(0, 212, 255, 0.5);
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.15);
}

.date-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.btn-add-experience {
  width: 100%;
  padding: 8px 10px;
  background: rgba(255, 255, 255, 0.1);
  border: 2px dashed rgba(255, 255, 255, 0.3);
  color: white;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  margin-top: 8px;
}

.btn-add-experience:hover {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(0, 212, 255, 0.5);
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.15);
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.1) inset !important;
  -webkit-text-fill-color: white !important;
}
</style>