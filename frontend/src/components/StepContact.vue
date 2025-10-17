<script setup>
defineProps(['contactData'])
</script>

<template>
  <div>
    <h2>Krok 2 Dane kontaktowe</h2>
    <input v-model="contactData.phone" placeholder="Telefon" />
    <input v-model="contactData.email" placeholder="Email" />
  </div>
</template>
