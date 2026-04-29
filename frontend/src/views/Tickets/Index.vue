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
.tickets-container h1 {
  color: #2c3e50;
  margin-bottom: 1.5rem;
  font-size: 2rem;
}

.filters {
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  display: flex;
  gap: 12px;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.filter-input,
.filter-select {
  padding: 0.75rem 1rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  flex: 1;
  min-width: 200px;
}

.filter-input:focus,
.filter-select:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.create-button {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  text-decoration: none;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.create-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
}

.tickets-table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.tickets-table th {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 1rem;
  text-align: left;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.tickets-table td {
  padding: 1rem;
  border-bottom: 1px solid #e8eef5;
}

.tickets-table tbody tr {
  transition: all 0.3s ease;
}

.tickets-table tbody tr:hover {
  background-color: #f8f9fa;
  box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.1);
}

.loading,
.error,
.no-tickets {
  text-align: center;
  padding: 2rem;
  font-size: 1.1rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.error {
  color: #d32f2f;
  background-color: #ffebee;
  border-left: 4px solid #d32f2f;
}

.no-tickets {
  color: #757575;
}

.loading {
  color: #667eea;
  font-weight: 600;
}
</style>