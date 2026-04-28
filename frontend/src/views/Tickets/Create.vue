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

const fetchUsers = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await fetch('http://localhost:8000/api/users')
    if (!response.ok) {
      throw new Error('No se pudieron cargar los clientes')
    }
    users.value = await response.json()
    if (users.value.length) {
      form.value.cliente_id = users.value[0].id.toString()
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
    const response = await fetch('http://localhost:8000/api/tickets', {
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
.create-ticket-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.ticket-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.form-textarea {
  min-height: 100px;
  resize: vertical;
}

.form-actions {
  display: flex;
  gap: 10px;
  margin-top: 30px;
}

.submit-button, .cancel-button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.submit-button {
  background-color: #28a745;
  color: white;
}

.submit-button:hover:not(:disabled) {
  background-color: #218838;
}

.submit-button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}

.cancel-button {
  background-color: #6c757d;
  color: white;
}

.cancel-button:hover {
  background-color: #5a6268;
}

.error {
  color: #dc3545;
  font-size: 14px;
  margin-top: 5px;
}

.warning {
  color: #856404;
  font-size: 14px;
  margin-top: 5px;
}

.success-message {
  color: #155724;
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
  padding: 10px;
  border-radius: 4px;
  margin-top: 20px;
}

.error-message {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
  padding: 10px;
  border-radius: 4px;
  margin-top: 20px;
}
</style>