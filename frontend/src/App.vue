<template>
  <div class="p-8">
    <h1 class="text-3xl mb-4">Premier League Simulation</h1>

    <div class="flex gap-4 mb-6">
      <button @click="simulateNext" :disabled="loading" class="px-4 py-2 bg-blue-500 text-white rounded disabled:opacity-50">
        Next Week
      </button>
      <button @click="resetSimulation" :disabled="loading" class="px-4 py-2 bg-red-500 text-white rounded disabled:opacity-50">
        Reset
      </button>
      <button @click="playAll" :disabled="loading" class="px-4 py-2 bg-green-500 text-white rounded disabled:opacity-50">
        Play All
      </button>
    </div>

    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="text-white text-xl animate-spin">Loading...</div>
    </div>

    <h2 class="text-xl font-semibold mb-2">Current Week: {{ currentWeek }}</h2>

    <h2 class="text-xl font-semibold mb-2">Standings</h2>
    <table class="w-full border mb-8 text-center">
      <thead>
      <tr>
        <th class="border p-2">#</th>
        <th class="border p-2">Team</th>
        <th class="border p-2">PTS</th>
        <th class="border p-2">P</th>
        <th class="border p-2">W</th>
        <th class="border p-2">D</th>
        <th class="border p-2">L</th>
        <th class="border p-2">GD</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(item, index) in standings" :key="item.team.id"
          :class="index === 0 ? 'bg-green-100' : index === standings.length - 1 ? 'bg-red-100' : ''">
        <td class="border p-2">{{ index + 1 }}</td>
        <td class="border p-2">{{ item.team.name }}</td>
        <td class="border p-2">{{ item.PTS }}</td>
        <td class="border p-2">{{ item.P }}</td>
        <td class="border p-2">{{ item.W }}</td>
        <td class="border p-2">{{ item.D }}</td>
        <td class="border p-2">{{ item.L }}</td>
        <td class="border p-2">{{ item.GD }}</td>
      </tr>
      </tbody>
    </table>

    <h2 class="text-xl font-semibold mb-2">Matches This Week — Week {{ currentWeek }}</h2>
    <table class="w-full border mb-8 text-center">
      <thead>
      <tr>
        <th class="border p-2">Home</th>
        <th class="border p-2">Score</th>
        <th class="border p-2">Away</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="match in matches" :key="match.id">
        <td class="border p-2">{{ match.home_team.name }}</td>
        <td class="border p-2">
          <template v-if="match.played">
            {{ match.home_goals }} : {{ match.away_goals }}
          </template>
          <template v-else>
            - : -
          </template>
        </td>
        <td class="border p-2">{{ match.away_team.name }}</td>
      </tr>
      </tbody>
    </table>

    <h2 class="text-xl font-semibold mb-2">Predictions</h2>
    <table class="w-full border mb-8 text-center">
      <thead>
      <tr>
        <th class="border p-2">Team</th>
        <th class="border p-2" v-for="pos in positions" :key="pos">
          {{ pos }} place
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in predictions" :key="item.team.id">
        <td class="border p-2">{{ item.team.name }}</td>
        <td v-for="pos in positions" :key="pos" class="border p-2">
          <div class="relative h-4 bg-gray-200 rounded">
            <div class="absolute top-0 left-0 h-4 bg-green-400 rounded"
                 :style="{ width: getProbability(item.positions, pos) + '%' }">
            </div>
            <div class="relative text-sm">{{ getProbability(item.positions, pos) }}%</div>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from './api.js'

const standings = ref([]);
const matches = ref([]);
const currentWeek = ref(1);
const predictions = ref([]);
const positions = [1, 2, 3, 4];
const loading = ref(false);

async function loadStandings() {
  const { data } = await api.get('/standings');
  standings.value = data;
}

async function loadCurrentWeek() {
  const { data } = await api.get('/weeks');
  const current = data.find(w => w.is_current);
  if (current) {
    currentWeek.value = current.number;
    await loadMatches(current.id);
  } else {
    currentWeek.value = 'Season Complete';
    matches.value = [];
  }
}

async function loadMatches(weekId) {
  const { data } = await api.get(`/matches/week/${weekId}`);
  matches.value = data;
}

async function simulateNext() {
  loading.value = true;
  await api.post('/simulate/next');
  await api.post('/simulate/predict');
  await reloadAll();
  loading.value = false;
}

async function resetSimulation() {
  loading.value = true;
  await api.post('/simulate/reset');
  await api.post('/simulate/predict');
  await reloadAll();
  loading.value = false;
}

async function reloadAll() {
  await loadStandings();
  await loadCurrentWeek();
  await loadPredictions();
}

async function loadPredictions() {
  const { data } = await api.get('/predictions');
  predictions.value = data;
}

function getProbability(positionsArray, position) {
  const found = positionsArray.find(p => p.position === position);
  return found ? (found.probability * 100).toFixed(1) : '0.0';
}

async function playAll() {
  loading.value = true;

  let hasNext = true;
  while (hasNext) {
    const { data } = await api.get('/weeks');
    const current = data.find(w => w.is_current);
    if (!current) break;
    await api.post('/simulate/next');
  }

  await api.post('/simulate/predict');
  await reloadAll();
  loading.value = false;
}

onMounted(() => {
  reloadAll();
});
</script>
