<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <main class="home-container">
    <div class="welcome-section">
      <h1>Sistema de Gestión de Tickets</h1>
      <p>Una aplicación fullstack para gestionar tickets de soporte técnico.</p>

      <div class="navigation">
        <RouterLink to="/tickets" class="nav-button primary">
          Ver Tickets
        </RouterLink>
        <RouterLink to="/tickets/create" class="nav-button secondary">
          Crear Ticket
        </RouterLink>
      </div>
    </div>

    <div class="features-section">
      <h2>Características</h2>
      <div class="features-grid">
        <div class="feature-card">
          <h3>📋 Gestión de Tickets</h3>
          <p>Crear y gestionar tickets de soporte con información detallada.</p>
        </div>
        <div class="feature-card">
          <h3>🔍 Filtros Avanzados</h3>
          <p>Buscar tickets por título, prioridad y rango de fechas.</p>
        </div>
        <div class="feature-card">
          <h3>👥 Gestión de Clientes</h3>
          <p>Asociar tickets a clientes del sistema.</p>
        </div>
        <div class="feature-card">
          <h3>⚡ API REST</h3>
          <p>Backend robusto con endpoints RESTful.</p>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.home-container {
  width: 100%;
}

.welcome-section {
  text-align: center;
  margin-bottom: 60px;
}

.welcome-section h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333;
}

.welcome-section p {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 40px;
}

.navigation {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.nav-button {
  display: inline-block;
  padding: 15px 30px;
  text-decoration: none;
  border-radius: 8px;
  font-weight: bold;
  font-size: 1.1rem;
  transition: all 0.3s ease;
}

.nav-button.primary {
  background-color: #007bff;
  color: white;
}

.nav-button.primary:hover {
  background-color: #0056b3;
}

.nav-button.secondary {
  background-color: #28a745;
  color: white;
}

.nav-button.secondary:hover {
  background-color: #1e7e34;
}

.features-section {
  margin-top: 60px;
}

.features-section h2 {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 40px;
  color: #333;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

.feature-card {
  background: white;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  text-align: center;
}

.feature-card h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: #333;
}

.feature-card p {
  color: #666;
  line-height: 1.5;
}
</style>
