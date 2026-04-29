<template>
  <div class="create-ticket-container">
    <h1>Crear Ticket</h1>

    <form @submit.prevent="submitForm" class="ticket-form">
      <div class="form-group">
        <label for="titulo">Título</label>
        <input
          id="titulo"
          v-model="form.titulo"
          type="text"
          required
          maxlength="120"
          class="form-input"
        >
        <span v-if="errors.titulo" class="error">{{ errors.titulo[0] }}</span>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea
          id="descripcion"
          v-model="form.descripcion"
          required
          class="form-textarea"
        ></textarea>
        <span v-if="errors.descripcion" class="error">{{ errors.descripcion[0] }}</span>
      </div>

      <div class="form-group">
        <label for="prioridad">Prioridad</label>
        <select
          id="prioridad"
          v-model="form.prioridad"
          required
          class="form-select"
        >
          <option value="baja">Baja</option>
          <option value="media">Media</option>
          <option value="alta">Alta</option>
        </select>
        <span v-if="errors.prioridad" class="error">{{ errors.prioridad[0] }}</span>
      </div>

      <div class="form-group">
        <label for="cliente_id">Cliente</label>
        <select
          id="cliente_id"
          v-model="form.cliente_id"
          required
          class="form-select"
        >
          <option disabled value="">Seleccione un cliente</option>
          <option
            v-for="user in users"
            :key="user.id"
            :value="user.id"
          >
            {{ user.name }}
          </option>
        </select>
        <span v-if="!users.length && !loading" class="warning">No hay clientes disponibles.</span>
        <span v-if="errors.cliente_id" class="error">{{ errors.cliente_id[0] }}</span>
      </div>

      <div class="form-actions">
        <button type="submit" :disabled="loading" class="submit-button">
          {{ loading ? 'Creando...' : 'Crear Ticket' }}
        </button>
        <router-link to="/tickets" class="cancel-button">Cancelar</router-link>
      </div>
    </form>

    <div v-if="success" class="success-message">¡Ticket creado exitosamente!</div>
    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

interface User {
  id: number
  name: string
  email: string
}

const router = useRouter()
const form = ref({
  titulo: '',
  descripcion: '',
  prioridad: 'baja',
  cliente_id: ''
})
const errors = ref<Record<string, string[]>>({})
const loading = ref(false)
const success = ref(false)
const error = ref('')
const users = ref<User[]>([])
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL ?? ''

const fetchUsers = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await fetch(`${apiBaseUrl}/api/users`)
    if (!response.ok) {
      throw new Error('No se pudieron cargar los clientes')
    }
    users.value = await response.json()
    const firstUser = users.value[0]
    if (firstUser) {
      form.value.cliente_id = firstUser.id.toString()
    }
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido'
  } finally {
    loading.value = false
  }
}

const submitForm = async () => {
  loading.value = true
  error.value = ''
  success.value = false
  errors.value = {}
  try {
    const response = await fetch(`${apiBaseUrl}/api/tickets`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        titulo: form.value.titulo,
        descripcion: form.value.descripcion,
        prioridad: form.value.prioridad,
        cliente_id: parseInt(form.value.cliente_id)
      })
    })
    if (!response.ok) {
      const data = await response.json()
      if (response.status === 422) {
        errors.value = data.errors
      } else {
        throw new Error(data.message || 'Error al crear ticket')
      }
    } else {
      success.value = true
      form.value = { titulo: '', descripcion: '', prioridad: 'baja', cliente_id: users.value[0]?.id.toString() || '' }
      setTimeout(() => {
        router.push('/tickets')
      }, 2000)
    }
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido'
  } finally {
    loading.value = false
  }
}

onMounted(fetchUsers)
</script>

<style scoped>
.create-ticket-container h1 {
  color: #2c3e50;
  margin-bottom: 1.5rem;
  font-size: 2rem;
}

.ticket-form {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  max-width: 700px;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #2c3e50;
  font-size: 0.95rem;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  font-family: inherit;
  transition: all 0.3s ease;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-textarea {
  min-height: 120px;
  resize: vertical;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.submit-button,
.cancel-button {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  font-weight: 600;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.submit-button {
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
  flex: 1;
}

.submit-button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
}

.submit-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.cancel-button {
  background-color: #e0e0e0;
  color: #2c3e50;
  flex: 1;
}

.cancel-button:hover {
  background-color: #d0d0d0;
}

.form-group span.error {
  color: #d32f2f;
  font-size: 0.85rem;
  margin-top: 0.25rem;
  display: block;
}

.form-group span.warning {
  color: #f57c00;
  font-size: 0.85rem;
  margin-top: 0.25rem;
  display: block;
}

.success-message {
  color: #1b5e20;
  background-color: #c8e6c9;
  border-left: 4px solid #28a745;
  padding: 1rem;
  border-radius: 8px;
  margin-top: 1.5rem;
  font-weight: 500;
}

.error-message {
  color: #b71c1c;
  background-color: #ffcdd2;
  border-left: 4px solid #d32f2f;
  padding: 1rem;
  border-radius: 8px;
  margin-top: 1.5rem;
  font-weight: 500;
}
</style>