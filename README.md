# Prueba Técnica - Gestión de Tickets

## Descripción
Implementación de un sistema de gestión de tickets de soporte utilizando Laravel (backend) y Vue.js (frontend), con base de datos SQL Server.

## Estructura del Proyecto

```
/
├── backend/          # API REST con Laravel
├── frontend/         # SPA con Vue.js
└── README.md
```

## Tecnologías Utilizadas
- **Backend**: Laravel 11, PHP 8.4, SQLite (o SQL Server)
- **Frontend**: Vue.js 3, TypeScript, Vue Router
- **Base de Datos**: SQLite para desarrollo, SQL Server para producción

## Instalación y Configuración

### Backend (Laravel)

1. Instalar dependencias:
```bash
cd backend
composer install
```

2. Configurar entorno:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar base de datos:
   - Para desarrollo: usar SQLite (ya configurado)
   - Para producción: cambiar `DB_CONNECTION=sqlsrv` en `.env`

4. Ejecutar migraciones y seeders:
```bash
php artisan migrate
php artisan db:seed
```

5. Iniciar servidor:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Frontend (Vue.js)

1. Instalar dependencias:
```bash
cd frontend
npm install
```

2. Iniciar servidor de desarrollo:
```bash
npm run dev
```

3. Abrir navegador en `http://localhost:5173`

## Endpoints API

### Autenticación
- `POST /api/login` - Iniciar sesión y obtener token

### Tickets
- `GET /api/tickets` - Listar tickets con filtros (prioridad, fecha_desde, fecha_hasta, titulo)
- `POST /api/tickets` - Crear nuevo ticket

### Usuarios
- `GET /api/users` - Listar usuarios (clientes)

## Funcionalidades Implementadas

### Backend
- ✅ Modelo Ticket con relaciones
- ✅ Controlador API con validaciones
- ✅ Migraciones con índices para optimización
- ✅ Seeders para datos de prueba
- ✅ Pruebas unitarias y de feature
- ✅ Autenticación con Sanctum

### Frontend
- ✅ Página de listado de tickets con filtros
- ✅ Página de creación de tickets
- ✅ Estados de carga y manejo de errores
- ✅ Validaciones básicas en UI
- ✅ Navegación con Vue Router

## Desarrollo

### Ejecutar ambos servidores

1. Terminal 1 - Backend:
```bash
cd backend && php artisan serve --host=0.0.0.0 --port=8000
```

2. Terminal 2 - Frontend:
```bash
cd frontend && npm run dev
```

### Acceder a la aplicación
- Frontend: `http://localhost:5173`
- Backend API: `http://localhost:8000`

## Pruebas
Ejecutar pruebas del backend:
```bash
cd backend && php artisan test
```

## Decisiones Técnicas
- **Separación clara**: Backend y frontend en carpetas distintas
- **API First**: Backend como API REST pura
- **SPA moderna**: Frontend con Vue.js 3 y TypeScript
- **Base de datos**: SQLite para desarrollo, SQL Server para producción
- **Autenticación**: Laravel Sanctum para tokens API
- **Validaciones**: Tanto en backend como frontend
- **Índices DB**: Para rendimiento en consultas filtradas

## Notas
- El frontend consume la API del backend en `http://localhost:8000`
- Para producción, actualizar las URLs de la API
- Los datos de prueba incluyen usuarios y tickets de ejemplo