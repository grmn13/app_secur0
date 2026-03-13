# app_secur0
App web para el taller de secur0 en el IES Galileo | Hecha por Juan Sousa, Nicolas Gonzalez y Germán Olmeda

# 📝 NoteApp - Gestión de Notas Personales

¡Bienvenido a **NoteApp**! Esta es una aplicación web sencilla diseñada para que los usuarios puedan gestionar sus notas personales de forma segura y eficiente. Este proyecto fue desarrollado por nuestro grupo como una solución práctica para el almacenamiento y organización de información.


## 🚀 Características Principales

* **Gestión de Notas**: Interfaz para crear, visualizar y organizar notas personales.
* **Base de Datos**: Persistencia de datos utilizando **MariaDB**.
* **Arquitectura de Contenedores**: Despliegue estandarizado mediante **Docker**.


## 🔒 Medidas de Seguridad Implementadas

Para nosotros, la seguridad de los datos es primordial. Hemos implementado las siguientes capas de protección en el código:

1.  **Prevención de SQL Injection**: Utilizamos **Consultas Preparadas (Prepared Statements)** en todas las interacciones con la base de datos. Esto garantiza que las entradas del usuario nunca sean ejecutadas como comandos SQL maliciosos.

2.  **Seguridad en Contraseñas con Salts**: Las contraseñas no se guardan en texto plano; aplicamos un **Salt** personalizado y utilizamos el algoritmo `password_hash` (BCrypt) para proteger las credenciales contra ataques de tablas arcoíris.

3.  **Gestión de Sesiones**: Implementamos un sistema de **Sesiones PHP** que valida la identidad del usuario en cada página sensible, redirigiendo al login si no se detecta una sesión activa.

4. **Protección contra fuerza bruta**: Debido a que el entorno es un contenedor sencillo, donde se dificulta implementar herramientas como fail2ban, hemos optado por añadir un pequeño delay de 3 segundos cuando haya un intento de inicio de sesión fallido. De esta manera la fuerza bruta se vuelve mucho menos viable para el atacante.

5.  **Protección del Servidor**: Hemos configurado el servidor Apache para **deshabilitar el listado de directorios**, evitando que cualquier persona pueda navegar por la estructura de archivos del proyecto desde el navegador.


## 🛠️ Cómo desplegar la aplicación

### Requisitos Previos
* Tener instalado **Docker** y **Docker Compose**.

### Instrucciones de Lanzamiento

1. **Preparar los archivos**: Asegúrate de tener el archivo `docker-compose.yml`, el `Dockerfile`, el script `config.php` y el resto de archivos fuente en la misma carpeta.
2. **Levantar los contenedores**: Abre una terminal en la carpeta del proyecto y ejecuta:
   ```bash
   docker-compose up --build
3. **Acceder a la App**: Una vez que los logs indiquen que los servicios están listos, abre tu navegador en: http://localhost:8080
