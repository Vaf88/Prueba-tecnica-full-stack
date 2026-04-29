# 📄 DOCUMENTACIÓN TÉCNICA -- SISTEMA DE GESTIÓN DE TICKETS

## 🧾 1. Descripción General

Este proyecto consiste en una aplicación fullstack para la gestión de
tickets de soporte técnico.\
Permite crear, consultar y filtrar tickets asociados a clientes, con una
arquitectura moderna basada en Laravel (backend) y Vue.js (frontend).\
El sistema fue desarrollado siguiendo buenas prácticas de validación,
estructura de código y separación de responsabilidades.

## 🏗️ 2. Arquitectura

-   Backend: Laravel 11 (API REST)\
-   Frontend: Vue 3 + Inertia\
-   Base de datos: SQLite (configurable a SQL Server)\
-   Autenticación: Laravel Sanctum

Se utiliza un enfoque SPA (Single Page Application) con comunicación
mediante API.

## ⚙️ 3. Funcionalidades Implementadas

### 🔹 Backend (Laravel)

**Endpoints principales**

-   POST /api/tickets\
    Permite crear tickets con validaciones:
    -   Título máximo 120 caracteres\
    -   Descripción obligatoria\
    -   Prioridad (baja, media, alta)\
    -   Cliente válido
-   GET /api/tickets\
    Permite listar tickets con filtros:
    -   Por prioridad\
    -   Por rango de fechas\
    -   Búsqueda por título

**Modelo Ticket** - Relación con usuario (cliente)\
- Uso de fillable\
- Implementación de HasFactory

**Base de Datos** - Tabla tickets con: - PK y FK\
- Índices\
- Timestamps

**Seeders** - 5 usuarios\
- 20 tickets

**Validaciones** - Backend con JSON consistente\
- Manejo de errores

**Pruebas** - Validación\
- Creación\
- Filtros

------------------------------------------------------------------------

### 🔹 Frontend (Vue.js)

**Páginas** - /tickets → listado + filtros\
- /tickets/create → formulario

**Componentes** - Layout base\
- Estados reactivos

**Integración API** - Fetch + headers\
- Manejo de errores

------------------------------------------------------------------------

## 🗄️ 4. Base de Datos

-   Migraciones Laravel\
-   Índices optimizados\
-   Configurable vía .env

------------------------------------------------------------------------

## 🧪 5. Calidad del Código

-   Código organizado\
-   Validaciones frontend + backend\
-   Pruebas (21 assertions)\
-   Documentación clara

------------------------------------------------------------------------

## 🚀 6. Instrucciones de Ejecución

### Ejecución general

    ./dev.sh

### Manual

    composer install
    npm install
    php artisan migrate
    php artisan db:seed
    npm run build
    php artisan serve

Acceso: - /login\
- /tickets

------------------------------------------------------------------------

## 📊 7. Consultas BD

    sqlite3 database/database.sqlite
    .tables
    .schema users
    .schema tickets

    SELECT * FROM users LIMIT 20;
    SELECT * FROM tickets LIMIT 20;
    SELECT * FROM tickets WHERE prioridad = 'alta';

Consulta directa:

    sqlite3 database/database.sqlite "SELECT * FROM tickets LIMIT 20;"

Tinker:

    php artisan tinker

------------------------------------------------------------------------

## 📁 8. Estructura

/backend\
/frontend\
dev.sh\
README.md

------------------------------------------------------------------------

## 🧠 9. Decisiones Técnicas

-   Laravel + Vue + Inertia\
-   Sanctum\
-   Índices en DB\
-   Validaciones backend\
-   SQLite para desarrollo

------------------------------------------------------------------------

## ✅ 10. Conclusión

El sistema cumple con los requerimientos:\
- Gestión de tickets\
- Filtros\
- Validaciones\
- Escalabilidad

Proyecto listo para evaluación.
