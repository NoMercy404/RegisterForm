<script setup>
import { ref } from 'vue'
import StepBasic from './StepBasic.vue'
import StepContact from './StepContact.vue'
import StepExperience from './StepExperience.vue'
import axios from 'axios'

const currentStep = ref(1)

const basicData = ref({ firstName:'', lastName:'', birthDate:'' })
const contactData = ref({ phone:'', email:'' })
const experiences = ref([{ company:'', position:'', dateFrom:'', dateTo:'' }])

const submittedData = ref(null) // dane po wysłaniu

const today = new Date().toISOString().split('T')[0]

// ===== WALIDACJE =====
const validateBasic = () => {
  if(!basicData.value.firstName.trim()){ alert('Imię jest wymagane!'); return false }
  if(!basicData.value.lastName.trim()){ alert('Nazwisko jest wymagane!'); return false }
  if(!basicData.value.birthDate){ alert('Data urodzenia jest wymagana!'); return false }
  if(basicData.value.birthDate >= today){ alert('Data urodzenia musi być wcześniejsza niż dzisiaj!'); return false }
  return true
}

const validateContact = () => {
  if(!contactData.value.phone.trim()){ alert('Telefon jest wymagany!'); return false }
  const phonePattern = /^(\+48\s?)?(\d{3}-?\d{3}-?\d{3})$/
  if(!phonePattern.test(contactData.value.phone)){
    alert('Nieprawidłowy numer telefonu! Dozwolone formaty: 111222333, 111-222-333, +48 111222333, +48 111-222-333')
    return false
  }
  if(!contactData.value.email.trim()){ alert('E-mail jest wymagany!'); return false }
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if(!emailPattern.test(contactData.value.email)){ alert('Nieprawidłowy adres e-mail!'); return false }
  return true
}

const validateExperiences = () => {
  for(let i=0; i<experiences.value.length; i++){
    const exp = experiences.value[i]
    if(!exp.company.trim()){ alert(`Wpis ${i+1}: Firma jest wymagana!`); return false }
    if(!exp.position.trim()){ alert(`Wpis ${i+1}: Stanowisko jest wymagane!`); return false }
    if(!exp.dateFrom){ alert(`Wpis ${i+1}: Data rozpoczęcia jest wymagana!`); return false }
    if(!exp.dateTo){ alert(`Wpis ${i+1}: Data zakończenia jest wymagana!`); return false }
    if(exp.dateFrom > exp.dateTo){ alert(`Wpis ${i+1}: Data rozpoczęcia nie może być późniejsza niż data zakończenia!`); return false }
    if(exp.dateFrom > today){ alert(`Wpis ${i+1}: Data rozpoczęcia nie może być późniejsza od dzisiejszej daty!`); return false }
  }
  return true
}

// ===== Obsługa kroków =====
const next = () => currentStep.value++
const prev = () => currentStep.value--

// ===== Dodawanie i usuwanie doświadczeń =====
const addExperience = () => experiences.value.push({ company:'', position:'', dateFrom:'', dateTo:'' })
const removeExperience = (index) => experiences.value.splice(index, 1)

// ===== Submit =====
const submit = async () => {
  if(!validateBasic()) return
  if(!validateContact()) return
  if(!validateExperiences()) return

  try {
    const res = await axios.post('http://localhost:8000/api/candidates', {
      basicData: basicData.value,
      contactData: contactData.value,
      experiences: experiences.value
    })

    submittedData.value = res.data.data
    currentStep.value = 4
  } catch(e) {
    alert('Błąd: '+(e.response?.data?.error || e.message))
  }
}

// ===== Reset formularza =====
const resetForm = () => {
  basicData.value = { firstName:'', lastName:'', birthDate:'' }
  contactData.value = { phone:'', email:'' }
  experiences.value = [{ company:'', position:'', dateFrom:'', dateTo:'' }]
  submittedData.value = null
  currentStep.value = 1
}
</script>

<template>
  <div>
    <!-- Krok 1-3: formularz -->
    <template v-if="currentStep <= 3">
      <component
          :is="currentStep===1 ? StepBasic : currentStep===2 ? StepContact : StepExperience"
          v-bind="{ basicData, contactData, experiences }"
          @add="addExperience"
          @remove="removeExperience"
      />
      <div style="margin-top:20px;">
        <button @click="prev" :disabled="currentStep===1">Poprzedni</button>
        <button v-if="currentStep<3" @click="next">Następny</button>
        <button v-else @click="submit">Wyślij</button>
      </div>
    </template>

    <!-- Krok 4: podsumowanie danych -->
    <div v-else>
      <h2>Podsumowanie danych</h2>
      <p><strong>Imię:</strong> {{ submittedData.basicData.firstName }}</p>
      <p><strong>Nazwisko:</strong> {{ submittedData.basicData.lastName }}</p>
      <p><strong>Data urodzenia:</strong> {{ submittedData.basicData.birthDate }}</p>
      <p><strong>Telefon:</strong> {{ submittedData.contactData.phone }}</p>
      <p><strong>Email:</strong> {{ submittedData.contactData.email }}</p>

      <h3>Doświadczenie zawodowe:</h3>
      <ul>
        <li v-for="(exp, index) in submittedData.experiences" :key="index">
          {{ exp.company }} - {{ exp.position }} ({{ exp.dateFrom }} → {{ exp.dateTo }})
        </li>
      </ul>

      <button @click="resetForm">Powrót do rejestracji</button>
    </div>
  </div>
</template>
