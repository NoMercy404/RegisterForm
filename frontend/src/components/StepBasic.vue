<script setup>
defineProps(['basicData'])
</script>

<template>
  <div class="step-container">
    <h2 class="step-title">Dane podstawowe</h2>
    <div class="grid-two">
      <div class="form-group">
        <label>Imię</label>
        <input v-model="basicData.firstName" type="text" placeholder="Wpisz swoje imię" class="glass-input" />
      </div>
      <div class="form-group">
        <label>Nazwisko</label>
        <input v-model="basicData.lastName" type="text" placeholder="Wpisz swoje nazwisko" class="glass-input" />
      </div>
    </div>
    <div class="form-group">
      <label>Data urodzenia</label>
      <input v-model="basicData.birthDate" type="date" class="glass-input" />
    </div>
  </div>
</template>

<style scoped>
.step-container {
  width: 100%;
}

.grid-two {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.step-title {
  color: white;
  font-size: 28px;
  margin-bottom: 30px;
  font-weight: 700;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  color: rgba(255, 255, 255, 0.8);
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.glass-input {
  width: 100%;
  padding: 14px 16px;
  background: rgba(255, 255, 255, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 12px;
  color: white;
  font-size: 15px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(10px);
}

.glass-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.glass-input:focus {
  outline: none;
  background: rgba(255, 255, 255, 0.2);
  border-color: rgba(0, 212, 255, 0.6);
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.15) inset !important;
  -webkit-text-fill-color: white !important;
}
</style>