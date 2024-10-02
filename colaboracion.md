# 🤝 Colaboración en **SistemaWebHotel**

¡Gracias por tu interés en contribuir! A continuación, te explicamos de manera rápida y clara cómo colaborar eficientemente en el proyecto.

---

## 🚀 1. Clonar el Repositorio
Clona el repositorio para trabajar localmente:
terminal
git clone https://github.com/AynorEL/SistemaWebHotel.git
## 🛠️ 2. Crear un Branch para tus Cambios
Siempre crea un branch para trabajar sin afectar el branch principal:

terminal
```git checkout -b nombre-del-branch```
Tip: Usa nombres descriptivos como fix-login-issue o feature-reservation-system.

## ✍️ 3. Hacer Cambios y Commit
Realiza tus cambios y guárdalos con un commit:

terminal
```git add . ```
git commit -m "Descripción clara de los cambios"
## ⬆️ 4. Subir los Cambios (Push)
Envía tus cambios a GitHub con el siguiente comando:

terminal
```git push origin nombre-del-branch```
## 🔄 5. Crear un Pull Request (PR)
Sigue estos pasos para crear un Pull Request:

Ve al repositorio en GitHub.
Haz clic en Pull Requests.
Selecciona New Pull Request y elige tu branch.
Escribe una descripción clara de los cambios.
## 👨‍💻 6. Revisión y Fusión
Tu Pull Request será revisado por un miembro del equipo. Si es aprobado, será fusionado al branch main. Si hay observaciones, recibirás comentarios para ajustar.

## ⬇️ 7. Actualizar tu Branch Local
Una vez fusionado el PR, actualiza tu branch main local:

terminal
```git pull origin main```
🧑‍🤝‍🧑 ¿Dudas?
Contáctanos por WhatsApp +51 930 791 412 o abre una Issue en el repositorio.

SISTEMA_WEB_HOTEL/
│
├── almacenamiento/            # (Parece vacío en la imagen, pero posiblemente aquí se almacenan archivos temporales o documentos)
│
├── app/                       # Lógica principal de la aplicación
│   ├── controladores/         # Controladores que manejan la lógica de negocio
│   │   ├── DashboardControlador.php
│   │   ├── HabitacionControlador.php
│   │   ├── PagoControlador.php
│   │   ├── ReservaControlador.php
│   │   └── UsuarioControlador.php
│   │
│   ├── middlewares/           # Middleware para la autenticación
│   │   └── autenticacionMiddleware.php
│   │
│   ├── modelos/               # Modelos que representan la base de datos (No se ven en detalle en la imagen)
│   │
│   ├── parciales/             # Componentes reutilizables como la barra lateral
│   │   └── barra_lateral.php
│   │
│   ├── vistas/                # Vistas que renderizan las páginas
│   │   ├── autenticacion/     # Vistas relacionadas con la autenticación
│   │   ├── dashboard/         # Vistas del panel de control
│   │   │   └── index.php
│   │   ├── habitaciones/      # Vistas para gestión de habitaciones
│   │       ├── actualizar.php
│   │       ├── crear.php
│   │       └── index.php
│   │   ├── layouts/           # Posiblemente plantillas comunes para todas las páginas
│   │   ├── pagos/             # Vistas para la gestión de pagos
│   │   ├── reservas/          # Vistas para la gestión de reservas
│   │   └── usuarios/          # Vistas para la gestión de usuarios
│   │       ├── actualizar.php
│   │       ├── crear.php
│   │       └── index.php
│   │
│   └── styles.css             # Archivo de estilos CSS
│
├── configuracion/             # Archivos de configuración del sistema
│   ├── base_datos.php         # Configuración de la base de datos
│   └── configuracion_app.php   # Configuración general de la aplicación
│
├── pruebas/                   # (Posiblemente para tests o scripts de pruebas)
│
├── public/                    # Archivos públicos accesibles desde el navegador
│   ├── css/                   # Archivos CSS
│   ├── img/                   # Imágenes
│   └── js/                    # Archivos JavaScript
│       └── scripts.js         # Script principal JavaScript
│   ├── dashboard.php          # Página del dashboard (publicamente accesible)
│   ├── index.php              # Página de inicio
│   └── login.php              # Página de inicio de sesión
│
├── sql/                       # Archivos relacionados con la base de datos (puede contener scripts SQL)
│
├── vendor/                    # Dependencias instaladas por Composer (carpeta gestionada automáticamente)
│
├── .env                       # Variables de entorno
├── .gitattributes             # Atributos de Git
├── .gitignore                 # Archivos y carpetas ignoradas por Git
├── colaboracion.md            # Documento de colaboración (posiblemente con instrucciones para contribuir)
└── README.md                  # Documentación general del proyecto
