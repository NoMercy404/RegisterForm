<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  experiences: Array
})

const addExperience = () => {
  props.experiences.push({
    company: '',
    position: '',
    dateFrom: '',
    dateTo: ''
  })
}

const removeExperience = (index) => {
  props.experiences.splice(index, 1)
}

</script>

<template>
  <div>
    <h2>Krok 3 Doświadczenie zawodowe</h2>
    <div v-for="(exp, index) in experiences" :key="index" style="margin-bottom:10px; border:1px solid #ccc; padding:10px;">
      <input v-model="exp.company" placeholder="Firma" />
      <input v-model="exp.position" placeholder="Stanowisko" />
      <input v-model="exp.dateFrom" type="date" />
      <input v-model="exp.dateTo" type="date" />
      <button @click="removeExperience(index)">Usuń</button>
    </div>
    <button @click="addExperience">Dodaj doświadczenie</button>
  </div>
</template>
