<script setup>
import { ref, computed } from 'vue'
import StepBasic from './StepBasic.vue'
import StepContact from './StepContact.vue'
import StepExperience from './StepExperience.vue'
import axios from 'axios'

const currentStep = ref(1)
const basicData = ref({ firstName: '', lastName: '', birthDate: '' })
const contactData = ref({ phone: '', email: '' })
const experiences = ref([{ company: '', position: '', dateFrom: '', dateTo: '' }])
const submittedData = ref(null)

const today = new Date().toISOString().split('T')[0]

const validateBasic = () => {
  if (!basicData.value.firstName.trim()) { alert('Imię jest wymagane!'); return false }
  if (!basicData.value.lastName.trim()) { alert('Nazwisko jest wymagane!'); return false }
  if (!basicData.value.birthDate) { alert('Data urodzenia jest wymagana!'); return false }
  if (basicData.value.birthDate >= today) { alert('Data urodzenia musi być wcześniejsza niż dzisiaj!'); return false }
  return true
}

const validateContact = () => {
  if (!contactData.value.phone.trim()) { alert('Telefon jest wymagany!'); return false }
  const phonePattern = /^(\+48\s?)?(\d{3}-?\d{3}-?\d{3})$/
  if (!phonePattern.test(contactData.value.phone)) {
    alert('Nieprawidłowy numer telefonu! Dozwolone formaty: 111222333, 111-222-333, +48 111222333, +48 111-222-333')
    return false
  }
  if (!contactData.value.email.trim()) { alert('E-mail jest wymagany!'); return false }
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailPattern.test(contactData.value.email)) { alert('Nieprawidłowy adres e-mail!'); return false }
  return true
}

const validateExperiences = () => {
  for (let i = 0; i < experiences.value.length; i++) {
    const exp = experiences.value[i]
    if (!exp.company.trim()) { alert(`Wpis ${i + 1}: Firma jest wymagana!`); return false }
    if (!exp.position.trim()) { alert(`Wpis ${i + 1}: Stanowisko jest wymagane!`); return false }
    if (!exp.dateFrom) { alert(`Wpis ${i + 1}: Data rozpoczęcia jest wymagana!`); return false }
    if (!exp.dateTo) { alert(`Wpis ${i + 1}: Data zakończenia jest wymagana!`); return false }
    if (exp.dateFrom > exp.dateTo) { alert(`Wpis ${i + 1}: Data rozpoczęcia nie może być późniejsza niż data zakończenia!`); return false }
    if (exp.dateFrom > today) { alert(`Wpis ${i + 1}: Data rozpoczęcia nie może być późniejsza od dzisiejszej daty!`); return false }
  }
  return true
}

const next = () => {
  if (currentStep.value === 1 && !validateBasic()) return
  if (currentStep.value === 2 && !validateContact()) return
  currentStep.value++
}

const prev = () => currentStep.value--

const addExperience = () => experiences.value.push({ company: '', position: '', dateFrom: '', dateTo: '' })
const removeExperience = (index) => experiences.value.splice(index, 1)

const submit = async () => {
  if (!validateBasic()) return
  if (!validateContact()) return
  if (!validateExperiences()) return

  try {
    const res = await axios.post('http://localhost:8000/api/candidates', {
      basicData: basicData.value,
      contactData: contactData.value,
      experiences: experiences.value
    })
    submittedData.value = res.data.data
    currentStep.value = 4
  } catch (e) {
    alert('Błąd: ' + (e.response?.data?.error || e.message))
  }
}

const resetForm = () => {
  basicData.value = { firstName: '', lastName: '', birthDate: '' }
  contactData.value = { phone: '', email: '' }
  experiences.value = [{ company: '', position: '', dateFrom: '', dateTo: '' }]
  submittedData.value = null
  currentStep.value = 1
}

const progressWidth = computed(() => {
  if (currentStep.value === 1) return '33%'
  if (currentStep.value === 2) return '66%'
  return '100%'
})
</script>

<template>
  <div class="wizard-wrapper">
    <!-- Progress Bar -->
    <div class="progress-section">
      <div class="progress-bar-bg">
        <div class="progress-bar-fill" :style="{ width: progressWidth }"></div>
      </div>

      <div class="progress-steps">
        <div :class="['step-indicator', { active: currentStep >= 1 }]">
          <div class="step-circle">{{ currentStep > 1 ? '✓' : '1' }}</div>
          <span>Dane</span>
        </div>
        <div :class="['step-indicator', { active: currentStep >= 2 }]">
          <div class="step-circle">{{ currentStep > 2 ? '✓' : '2' }}</div>
          <span>Kontakt</span>
        </div>
        <div :class="['step-indicator', { active: currentStep >= 3 }]">
          <div class="step-circle">{{ currentStep > 3 ? '✓' : '3' }}</div>
          <span>Doświadczenie</span>
        </div>
      </div>
    </div>

    <div class="form-card">
      <template v-if="currentStep <= 3">
        <transition name="fade-slide" mode="out-in">
          <component
              :is="currentStep === 1 ? StepBasic : currentStep === 2 ? StepContact : StepExperience"
              v-bind="{ basicData, contactData, experiences }"
              @add="addExperience"
              @remove="removeExperience"
              :key="currentStep"
          />
        </transition>

        <div class="form-buttons">
          <button class="btn btn-secondary" @click="prev" :disabled="currentStep === 1">
            ← Poprzedni
          </button>
          <button v-if="currentStep < 3" class="btn btn-primary" @click="next">
            Następny →
          </button>
          <button v-else class="btn btn-success" @click="submit">
            ✓ Wyślij
          </button>
        </div>
      </template>

      <template v-else>
        <div class="success-section">
          <div class="success-icon">✓</div>
          <h2>Formularz wysłany!</h2>
          <p>Dziękujemy za wypełnienie formularza</p>

          <div class="summary-card">
            <div class="summary-row">
              <span class="label">Imię i nazwisko:</span>
              <span class="value">{{ submittedData.basicData.firstName }} {{ submittedData.basicData.lastName }}</span>
            </div>
            <div class="summary-row">
              <span class="label">Data urodzenia:</span>
              <span class="value">{{ submittedData.basicData.birthDate }}</span>
            </div>
            <div class="summary-row">
              <span class="label">Telefon:</span>
              <span class="value">{{ submittedData.contactData.phone }}</span>
            </div>
            <div class="summary-row">
              <span class="label">Email:</span>
              <span class="value">{{ submittedData.contactData.email }}</span>
            </div>
          </div>

          <div class="experience-section">
            <h3>Doświadczenie zawodowe:</h3>
            <div v-for="(exp, i) in submittedData.experiences" :key="i" class="exp-item">
              <strong>{{ exp.company }} - {{ exp.position }}</strong>
              <small>{{ exp.dateFrom }} → {{ exp.dateTo }}</small>
            </div>
          </div>

          <button class="btn btn-primary" @click="resetForm">Powrót do rejestracji</button>
        </div>
      </template>
    </div>
  </div>
</template>

<style scoped>
.wizard-wrapper {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 800px;
}

.progress-section {
  margin-bottom: 20px;
}

.progress-bar-bg {
  height: 6px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 30px;
  backdrop-filter: blur(10px);
}

.progress-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, #00d4ff, #0099ff);
  transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.6);
}

.progress-steps {
  display: flex;
  justify-content: space-between;
}

.step-indicator {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  opacity: 0.5;
  transition: opacity 0.3s;
}

.step-indicator.active {
  opacity: 1;
}

.step-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  border: 2px solid rgba(255, 255, 255, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  color: white;
  transition: all 0.3s;
  font-size: 18px;
}

.step-indicator.active .step-circle {
  background: linear-gradient(135deg, #00d4ff, #0099ff);
  border-color: rgba(0, 212, 255, 0.8);
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
}

.step-indicator span {
  color: white;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-card {
  backdrop-filter: blur(20px);
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 30px;
  padding: 30px 25px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  animation: slideUp 0.5s ease-out;
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

.form-buttons {
  display: flex;
  gap: 15px;
  margin-top: 40px;
}

.btn {
  flex: 1;
  padding: 14px 24px;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-primary {
  background: linear-gradient(135deg, #00d4ff, #0099ff);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.15);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary:hover:not(:disabled) {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
}

.btn-success {
  background: linear-gradient(135deg, #00d466, #00aa44);
  color: white;
}

.btn-success:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 212, 102, 0.4);
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.success-section {
  text-align: center;
  color: white;
  max-height: calc(100vh - 240px);
  overflow-y: auto;
  padding-right: 8px;
}

.success-icon {
  width: 64px;
  height: 64px;
  background: linear-gradient(135deg, #00d4ff, #0099ff);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
  margin: 0 auto 20px;
  box-shadow: 0 10px 30px rgba(0, 212, 102, 0.3);
}

.success-section h2 {
  font-size: 26px;
  margin: 0 0 8px 0;
  font-weight: 700;
}

.success-section p {
  font-size: 15px;
  opacity: 0.8;
  margin-bottom: 20px;
}

.summary-card {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 15px;
  padding: 20px;
  margin: 20px 0;
  text-align: left;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.summary-row:last-child {
  border-bottom: none;
}

.summary-row .label {
  opacity: 0.7;
  font-weight: 500;
}

.summary-row .value {
  font-weight: 600;
}

.experience-section {
  text-align: left;
  margin: 20px 0;
}

.experience-section h3 {
  font-size: 16px;
  margin-bottom: 15px;
  opacity: 0.8;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.exp-item {
  background: rgba(255, 255, 255, 0.08);
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 10px;
  display: block;
}

.exp-item small {
  display: block;
  opacity: 0.6;
  margin-top: 5px;
  font-size: 12px;
}

.fade-slide-enter-active, .fade-slide-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateX(20px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>