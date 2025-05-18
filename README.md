# TpLabEmpresas

## Sistema de Gestión Web para Información de Empresas y Noticias

Este proyecto es una aplicación web desarrollada con PHP y MySQL. Permite la gestión y visualización de información sobre empresas y noticias relacionadas. Incluye funcionalidades de búsqueda y manejo de usuarios. Fue desarrollado como parte de un trabajo práctico de laboratorio.

## Características Principales

* **Gestión de Empresas:** Ver listado, ver detalles, (agregar, editar, eliminar).
* **Gestión de Noticias:** Ver listado de noticias, ver contenido detallado de una noticia, (agregar, editar, eliminar).
* **Búsqueda:** Funcionalidad para buscar información de noticias.
* **Conexión a Base de Datos MySQL:** Implementación de la lógica de conexión a la base de datos.
* **Estructura Modular:** Organización del código en archivos `.php` dedicados a diferentes funcionalidades (`empresa.php`, `noticia.php`, `buscador.php`, `detalle.php`, etc.).

## Tecnologías Utilizadas

* **Lenguaje Backend:** PHP
* **Base de Datos:** MySQL
* **Frontend:** HTML, CSS, 
* **Gestor de Paquetes (Frontend):** npm 
* **Herramientas de Base de Datos:** MySQL Workbench 

## Prerrequisitos

Para ejecutar este proyecto localmente, necesitarás un entorno de servidor web que soporte PHP y una base de datos MySQL. Esto usualmente se configura con paquetes como XAMPP, WAMP, MAMP o configurando Apache/Nginx manualmente.

* Servidor Web (Apache, Nginx, etc.) con soporte para PHP 
* MySQL Server
* Git
* [Si usas npm/Yarn para dependencias frontend:] Node.js y npm o Yarn

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto:

1.  **Clonar el Repositorio:**
    ```bash
    git clone [https://github.com/FiammaB/TpLabEmpresas.git](https://github.com/FiammaB/TpLabEmpresas.git)
    ```
2.  **Configuración del Servidor Web:**
    * Copia los archivos del repositorio (la carpeta `TpLabEmpresas`) al directorio de documentos de tu servidor web (ej: `htdocs` para Apache, `www` para Nginx).
    * Asegúrate de que tu servidor web esté configurado para procesar archivos `.php`.
3.  **Configuración de la Base de Datos MySQL:**
    * Accede a tu gestor de base de datos (ej: phpMyAdmin, MySQL Workbench, línea de comandos).
    * Crea una base de datos con el nombre `tp1-p1-lab-grupo7`.
        ```sql
        CREATE DATABASE tp1-p1-lab-grupo7;
        ```
    * [**Instrucciones Cruciales:** Describe cómo crear las tablas `empresa`, `noticia` .
    * [**Configuración de Conexión:**] Edita el archivo `conexion.php` ubicado en `[Ruta donde esté conexion.php, ej: template_html/includes/conexion.php]` para actualizar las credenciales de conexión a tu base de datos MySQL local (nombre de usuario, contraseña, host si no es `localhost`).

4.  **Instalar Dependencias (si aplica):**
    * Si usaste npm/Yarn para dependencias frontend, navega a la carpeta del proyecto en la terminal y ejecuta:
        ```bash
        npm install # o yarn install
        ```
    * Si usaste Composer para dependencias PHP, navega a la carpeta raíz y ejecuta:
        ```bash
        composer install
        ```

## Ejecución

Una vez configurado el servidor web y la base de datos, y colocadas los archivos en el directorio correcto:

* Abre tu navegador web.
* Navega a la URL donde tu servidor web está sirviendo la carpeta del proyecto. Si la pusiste directamente en el directorio raíz de tu servidor local, podría ser:
    ```
    http://localhost/TpLabEmpresas/index.php
    ```
  



## Autor

* **Fiamma Brizuela**
    * [Tu Perfil de GitHub](https://github.com/FiammaB)
  
---
