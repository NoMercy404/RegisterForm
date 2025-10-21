<script setup>
import FormWizard from './components/FormWizard.vue'

</script>

<template>
  <div id="app">
    <FormWizard />
  </div>
</template>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body, html {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  width: 100vw;
  height: 100vh;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

#app {
  width: 100vw;
  height: 100vh;
  background: linear-gradient(135deg, rgba(9, 41, 152, 0.95) 0%, #000000 25%, rgba(4, 28, 94, 0.95) 50%, #000000 75%, #092998F2 100%);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
  position: fixed;
  top: 0;
  left: 0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(30px); }
}
</style>