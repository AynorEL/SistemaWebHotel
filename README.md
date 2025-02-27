# SistemaWebHotel

Este es un sistema de gestión hotelera desarrollado en PHP con Bootstrap, utilizando una arquitectura MVC (Modelo-Vista-Controlador). El sistema permite gestionar reservas, clientes, habitaciones, pagos y generar reportes.

![Vista del Dashboard](public/img/index.png)
![Vista del Usurio](public/img/usuarios.png)


## Tabla de Contenidos
1. [Descripción General](#descripción-general)
2. [Requisitos](#requisitos)
3. [Instalación](#instalación)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Uso](#uso)
6. [Archivos Importantes](#archivos-importantes)
7. [Mantenimiento](#mantenimiento)

---

## Descripción General

El **SistemaWebHotel** permite a los administradores gestionar las actividades diarias de un hotel, como el control de habitaciones, la gestión de reservas, la administración de pagos, y la generación de reportes. También incluye autenticación para proteger las páginas internas del sistema.

## Requisitos

- XAMPP o cualquier servidor local que soporte PHP y MySQL.
- PHP versión 7.4 o superior.
- MySQL/MariaDB para la base de datos.
- Composer (opcional) si se incluyen dependencias externas.

## Instalación

1. Clona el repositorio en tu servidor local:
    ```bash
    git clone https://github.com/AynorEL/SistemaWebHotel.git
    ```

2. Configura la base de datos:
    - Importa el archivo SQL desde `sql/` en phpMyAdmin para crear las tablas necesarias.
    - Edita el archivo `.env` con las credenciales de tu base de datos.

3. Asegúrate de que Apache y MySQL están corriendo en XAMPP o tu servidor local.

4. Accede a la carpeta `public` desde el navegador:
    ```bash
    http://localhost/SistemaWebHotel/public
    ```