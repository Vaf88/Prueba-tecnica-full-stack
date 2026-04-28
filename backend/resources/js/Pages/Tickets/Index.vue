<template>
    <AuthenticatedLayout title="Tickets">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Tickets
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <Link href="/tickets/create" class="btn btn-primary mb-4">Crear Ticket</Link>

                        <div class="mb-4">
                            <input v-model="filters.titulo" @input="fetchTickets" type="text" placeholder="Buscar por título" class="border p-2 mr-2">
                            <select v-model="filters.prioridad" @change="fetchTickets" class="border p-2 mr-2">
                                <option value="">Todas las prioridades</option>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                            </select>
                            <input v-model="filters.fecha_desde" @input="fetchTickets" type="date" class="border p-2 mr-2">
                            <input v-model="filters.fecha_hasta" @input="fetchTickets" type="date" class="border p-2">
                        </div>

                        <div v-if="loading" class="text-center">Cargando...</div>
                        <div v-else-if="error" class="text-red-500">{{ error }}</div>
                        <div v-else>
                            <table class="table-auto w-full" v-if="tickets.data.length">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Título</th>
                                        <th class="px-4 py-2">Prioridad</th>
                                        <th class="px-4 py-2">Cliente</th>
                                        <th class="px-4 py-2">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                                        <td class="border px-4 py-2">{{ ticket.titulo }}</td>
                                        <td class="border px-4 py-2">{{ ticket.prioridad }}</td>
                                        <td class="border px-4 py-2">{{ ticket.cliente.name }}</td>
                                        <td class="border px-4 py-2">{{ ticket.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="text-gray-600">No se encontraron tickets con esos filtros.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const tickets = ref({ data: [] });
const loading = ref(false);
const error = ref(null);
const filters = ref({
    titulo: '',
    prioridad: '',
    fecha_desde: '',
    fecha_hasta: ''
});

const fetchTickets = async () => {
    loading.value = true;
    error.value = null;
    try {
        const params = new URLSearchParams();
        if (filters.value.titulo) params.append('titulo', filters.value.titulo);
        if (filters.value.prioridad) params.append('prioridad', filters.value.prioridad);
        if (filters.value.fecha_desde) params.append('fecha_desde', filters.value.fecha_desde);
        if (filters.value.fecha_hasta) params.append('fecha_hasta', filters.value.fecha_hasta);

        const response = await fetch(`/api/tickets?${params}`, {
            headers: {
                'Authorization': `Bearer ${window.localStorage.getItem('token')}`, // Asumir token guardado
                'Content-Type': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Error al cargar tickets');
        tickets.value = await response.json();
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
};

onMounted(fetchTickets);
</script>