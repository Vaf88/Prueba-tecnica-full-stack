<script setup lang="ts">
import { RouterView, RouterLink } from 'vue-router'
</script>

<template>
  <div class="app">
    <nav class="navbar">
      <div class="navbar-container">
        <RouterLink to="/" class="navbar-brand">
          <span class="brand-icon">🎫</span>
          <span class="brand-text">Tickets</span>
        </RouterLink>
        <div class="navbar-menu">
          <RouterLink to="/" class="nav-link">Inicio</RouterLink>
          <RouterLink to="/tickets" class="nav-link">Gestión</RouterLink>
          <RouterLink to="/about" class="nav-link">Acerca de</RouterLink>
        </div>
      </div>
    </nav>

    <main class="main-content">
      <RouterView />
    </main>

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-section">
          <h4>Gestión de Tickets</h4>
          <p>Solución moderna para administrar y dar seguimiento a tus tickets.</p>
        </div>

        <div class="footer-section">
          <h4>Enlaces</h4>
          <ul>
            <li><RouterLink to="/">Inicio</RouterLink></li>
            <li><RouterLink to="/tickets">Tickets</RouterLink></li>
            <li><RouterLink to="/about">Información</RouterLink></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4>Contacto</h4>
          <p>Email: soporte@tickets.com</p>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; 2026 Gestión de Tickets</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>

/* RESET REAL */
html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  overflow-x: hidden;
}

/* CONTENEDOR PRINCIPAL */
.app {
  min-height: 100vh;
  width: 100%;
  display: flex;
  flex-direction: column;
  background: #f8f9fa;
}

/* NAVBAR FULL WIDTH */
.navbar {
  background: linear-gradient(135deg, #667eea, #764ba2);
  position: sticky;
  top: 0;
  z-index: 100;
}

/* 🔥 QUITAMOS EL MAX-WIDTH */
.navbar-container {
  width: 100%;
  padding: 1rem 3rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* BRAND */
.navbar-brand {
  display: flex;
  gap: 0.5rem;
  text-decoration: none;
  color: white;
  font-weight: bold;
  font-size: 1.3rem;
}

/* MENU */
.navbar-menu {
  display: flex;
  gap: 1.5rem;
}

.nav-link {
  color: white;
  text-decoration: none;
  padding: 0.4rem 0.8rem;
  border-radius: 6px;
}

.nav-link:hover,
.router-link-active {
  background: rgba(255,255,255,0.2);
}

/* 🔥 MAIN FULL WIDTH */
.main-content {
  flex: 1;
  width: 100%;
  padding: 2rem 3rem;
}

/* FOOTER */
.footer {
  background: #2c3e50;
  color: white;
}

/* 🔥 FULL WIDTH */
.footer-container {
  width: 100%;
  padding: 3rem;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
}

.footer-section h4 {
  margin-bottom: 10px;
}

.footer-bottom {
  text-align: center;
  padding: 1rem;
  background: #1f2d3a;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .navbar-container {
    flex-direction: column;
  }

  .main-content {
    padding: 1rem;
  }

  .footer-container {
    padding: 2rem 1rem;
  }
}
</style>

<style>
/* ESTILOS GLOBALES: Esto DEBE ir sin "scoped" */
html, body, #app {
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
  background-color: #f8f9fa; /* Asegura el color base en toda la raíz */
}

* {
  box-sizing: border-box;
}
</style>

<style scoped>
/* ESTILOS DEL CONTENEDOR */
.app {
  width: 100%;
  display: flex;
  background: #f8f9fa;
}

.main-content {
  flex: 0;
  width: 100%;
  margin: 0 auto;
  padding: 2rem;
}

.footer {
  margin-top: auto; /* Refuerzo para que el footer siempre esté abajo */
  width: 100%;
}
</style>
