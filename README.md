# Hotel Decameron Backend

Backend API desarrollada en Laravel para la gestión de reservas del Hotel Decameron.

## Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js y npm (opcional, si se usan herramientas front-end o de assets)

## Instalación

 Clona el repositorio:
   git clone https://github.com/cesarkortez/hotel_backend.git
   cd hotel_decameron_backend

Instala las dependencias de PHP:

composer install
Copia el archivo de entorno y configura tus variables:
cp .env.example .env

Genera la clave de la aplicación:
php artisan key:generate

Configura tu base de datos en .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_db
DB_USERNAME=usuario
DB_PASSWORD=contraseña

Ejecuta las migraciones y seeders (opcional):
php artisan migrate --seed

Levanta el servidor de desarrollo:
php artisan serve

Comandos Comunes

Ejecutar migraciones:
php artisan migrate

Revertir migraciones:
php artisan migrate:rollback

Correr los tests:
php artisan test

Limpiar cachés:
php artisan optimize:clear

# Documentación de Diagramas UML

## Diagramas de Clases

- **Hotel y RoomConfiguration**
  - Muestra la relación de uno a muchos entre `Hotel` y `RoomConfiguration`.
  - Archivo: `docs/diagramas/Diagrama_Clase.png`

## Diagrama de Flujo

- **Proceso de Reserva**
  - Muestra el flujo desde que el cliente consulta disponibilidad hasta confirmar la reserva.
  - Archivo: `docs/diagramas/Diagrama_Flujo.png`
