<template>
    <AuthenticatedLayout title="Crear Ticket">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Ticket
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label class="block text-gray-700">Título</label>
                                <input v-model="form.titulo" type="text" class="border w-full p-2" required maxlength="120">
                                <span v-if="errors.titulo" class="text-red-500">{{ errors.titulo[0] }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Descripción</label>
                                <textarea v-model="form.descripcion" class="border w-full p-2" required></textarea>
                                <span v-if="errors.descripcion" class="text-red-500">{{ errors.descripcion[0] }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Prioridad</label>
                                <select v-model="form.prioridad" class="border w-full p-2" required>
                                    <option value="baja">Baja</option>
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                </select>
                                <span v-if="errors.prioridad" class="text-red-500">{{ errors.prioridad[0] }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Cliente</label>
                                <select v-model="form.cliente_id" class="border w-full p-2" required>
                                    <option disabled value="">Seleccione un cliente</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                </select>
                                <span v-if="!users.length && !loading" class="text-gray-600">No hay clientes disponibles.</span>
                                <span v-if="errors.cliente_id" class="text-red-500">{{ errors.cliente_id[0] }}</span>
                            </div>
                            <button type="submit" :disabled="loading" class="btn btn-primary">
                                {{ loading ? 'Creando...' : 'Crear Ticket' }}
                            </button>
                        </form>
                        <div v-if="success" class="text-green-500 mt-4">Ticket creado exitosamente!</div>
                        <div v-if="error" class="text-red-500 mt-4">{{ error }}</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
    titulo: '',
    descripcion: '',
    prioridad: 'baja',
    cliente_id: ''
});
const errors = ref({});
const loading = ref(false);
const success = ref(false);
const error = ref(null);
const users = ref([]);

const fetchUsers = async () => {
    loading.value = true;
    error.value = null;
    try {
        const response = await fetch('/api/users', {
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('No se pudieron cargar los clientes');
        }

        users.value = await response.json();
        if (users.value.length) {
            form.value.cliente_id = users.value[0].id;
        }
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
};

const submitForm = async () => {
    loading.value = true;
    error.value = null;
    success.value = false;
    errors.value = {};
    try {
        const response = await fetch('/api/tickets', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(form.value)
        });
        if (!response.ok) {
            const data = await response.json();
            if (response.status === 422) {
                errors.value = data.errors;
            } else {
                throw new Error(data.message || 'Error al crear ticket');
            }
        } else {
            success.value = true;
            form.value = { titulo: '', descripcion: '', prioridad: 'baja', cliente_id: users.value[0]?.id || '' };
        }
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
};

onMounted(fetchUsers);
</script>