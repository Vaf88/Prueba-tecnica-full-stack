<template>
  <div class="tickets-container">
    <h1>Gestión de Tickets</h1>

    <div class="filters">
      <input
        v-model="filters.titulo"
        @input="fetchTickets"
        type="text"
        placeholder="Buscar por título"
        class="filter-input"
      >
      <select
        v-model="filters.prioridad"
        @change="fetchTickets"
        class="filter-select"
      >
        <option value="">Todas las prioridades</option>
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
      </select>
      <input
        v-model="filters.fecha_desde"
        @input="fetchTickets"
        type="date"
        class="filter-input"
      >
      <input
        v-model="filters.fecha_hasta"
        @input="fetchTickets"
        type="date"
        class="filter-input"
      >
    </div>

    <router-link to="/tickets/create" class="create-button">Crear Ticket</router-link>

    <div v-if="loading" class="loading">Cargando...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <table v-if="tickets.data && tickets.data.length" class="tickets-table">
        <thead>
          <tr>
            <th>Título</th>
            <th>Prioridad</th>
            <th>Cliente</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets.data" :key="ticket.id">
            <td>{{ ticket.titulo }}</td>
            <td>{{ ticket.prioridad }}</td>
            <td>{{ ticket.cliente.name }}</td>
            <td>{{ ticket.created_at }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else class="no-tickets">No se encontraron tickets con esos filtros.</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface Ticket {
  id: number
  titulo: string
  descripcion: string
  prioridad: string
  cliente_id: number
  created_at: string
  cliente: {
    id: number
    name: string
    email: string
  }
}

interface TicketsResponse {
  data: Ticket[]
  current_page: number
  last_page: number
  per_page: number
  total: number
}

const tickets = ref<TicketsResponse>({
  data: [],
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
})
const loading = ref(false)
const error = ref('')
const filters = ref({
  titulo: '',
  prioridad: '',
  fecha_desde: '',
  fecha_hasta: ''
})
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL ?? ''

const fetchTickets = async () => {
  loading.value = true
  error.value = ''
  try {
    const params = new URLSearchParams()
    if (filters.value.titulo) params.append('titulo', filters.value.titulo)
    if (filters.value.prioridad) params.append('prioridad', filters.value.prioridad)
    if (filters.value.fecha_desde) params.append('fecha_desde', filters.value.fecha_desde)
    if (filters.value.fecha_hasta) params.append('fecha_hasta', filters.value.fecha_hasta)

    const response = await fetch(`${apiBaseUrl}/api/tickets?${params}`)
    if (!response.ok) throw new Error('Error al cargar tickets')
    tickets.value = await response.json()
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido'
  } finally {
    loading.value = false
  }
}

onMounted(fetchTickets)
</script>

<style scoped>
.tickets-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.filters {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.filter-input, .filter-select {
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.create-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  margin-bottom: 20px;
}

.create-button:hover {
  background-color: #0056b3;
}

.tickets-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.tickets-table th, .tickets-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.tickets-table th {
  background-color: #f8f9fa;
}

.loading, .error, .no-tickets {
  text-align: center;
  padding: 20px;
  font-size: 18px;
}

.error {
  color: #dc3545;
}

.no-tickets {
  color: #6c757d;
}
</style>