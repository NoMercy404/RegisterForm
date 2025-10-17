<script setup>
defineProps(['basicData'])
</script>

<template>
  <div>
    <h2>Krok 1 Podstawowe dane</h2>
    <input v-model="basicData.firstName" type='text' placeholder="First Name"/>
    <input v-model="basicData.lastName" type='text' placeholder="Last Name"/>
    <input v-model="basicData.birthDate" type="date"/>
  </div>
</template>
