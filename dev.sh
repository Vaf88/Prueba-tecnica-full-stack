#!/bin/bash

# Script para desarrollo - Inicia backend y frontend

echo "🚀 Iniciando desarrollo del proyecto Gestión de Tickets"
echo ""

# Función para verificar si un puerto está en uso
check_port() {
    if lsof -Pi :$1 -sTCP:LISTEN -t >/dev/null ; then
        echo "❌ Puerto $1 ya está en uso"
        return 1
    else
        echo "✅ Puerto $1 disponible"
        return 0
    fi
}

# Verificar puertos
echo "Verificando puertos..."
check_port 8000 || exit 1
check_port 5173 || exit 1
echo ""

# Iniciar backend
echo "📦 Iniciando backend (Laravel)..."
cd backend
if [ ! -f ".env" ]; then
    echo "Creando archivo .env..."
    cp .env.example .env
    php artisan key:generate
fi

# Verificar si la base de datos existe
if [ ! -f "database/database.sqlite" ]; then
    echo "Creando base de datos SQLite..."
    touch database/database.sqlite
    php artisan migrate
    php artisan db:seed
fi

echo "Iniciando servidor Laravel en puerto 8000..."
php artisan serve --host=0.0.0.0 --port=8000 &
BACKEND_PID=$!
cd ..
echo "✅ Backend iniciado (PID: $BACKEND_PID)"
echo ""

# Esperar un poco para que el backend inicie
sleep 3

# Iniciar frontend
echo "🎨 Iniciando frontend (Vue.js)..."
cd frontend
echo "Instalando dependencias si es necesario..."
npm install > /dev/null 2>&1
echo "Iniciando servidor Vue en puerto 5173..."
npm run dev &
FRONTEND_PID=$!
cd ..
echo "✅ Frontend iniciado (PID: $FRONTEND_PID)"
echo ""

echo "🎉 ¡Desarrollo iniciado exitosamente!"
echo ""
echo "📱 Acceder a la aplicación:"
echo "   Frontend: http://localhost:5173"
echo "   Backend API: http://localhost:8000"
echo ""
echo "🛑 Para detener: presiona Ctrl+C o ejecuta: kill $BACKEND_PID $FRONTEND_PID"

# Mantener el script corriendo
wait