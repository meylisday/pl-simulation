<template>
  <div>
    <h1>Premier League Teams</h1>
    <ul>
      <li v-for="team in teams" :key="team.id">
        {{ team.name }} (Strength: {{ team.strength }})
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const teams = ref([])

onMounted(() => {
  fetch('http://localhost:8000/api/teams')
      .then(res => res.json())
      .then(data => teams.value = data)
})
</script>
