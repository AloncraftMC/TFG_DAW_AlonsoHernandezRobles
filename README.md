# Trabajo de Fin de Grado

> Alonso Hernández Robles

> Desarrollo de Aplicaciones Web 2024/2025
> IES Francisco Ayala

## 0. Documentación:

- [Memoria](https://github.com/AloncraftMC/TFG_DAW_AlonsoHernandezRobles/tree/main/docs/Fase%20Final/TFG_DAW_AlonsoHernandezRobles.pdf)

- [WakaTime - Reporte General](https://github.com/AloncraftMC/TFG_DAW_AlonsoHernandezRobles/tree/main/docs/Fase%20Final/TFG_Report_WakaTime.pdf)
- [WakaTime - Información y Archivos](https://github.com/AloncraftMC/TFG_DAW_AlonsoHernandezRobles/tree/main/docs/Fase%20Final/TFG_WakaTime.pdf)

## 1. Uso local: Instalación

Para ejecutar el proyecto localmente, es necesario tener instalado PHP, XAMPP y Composer. A continuación se detallan los pasos para la instalación y configuración del entorno de desarrollo:

- Descargar e instalar [XAMPP](https://www.apachefriends.org/es/index.html) en el sistema operativo.
- Descargar el proyecto y descomprimirlo en la carpeta `htdocs` de XAMPP. Por defecto, esta carpeta se encuentra en `C:\xampp\htdocs` en Windows.
- Descargar e instalar [Composer](https://getcomposer.org/download/) en el sistema operativo.
- Abrir una terminal y navegar hasta la carpeta del proyecto descomprimido en `htdocs`.
- Ejecutar el siguiente comando para instalar las dependencias del proyecto:
```bash
composer install
```
- Crear una base de datos en MySQL con el nombre `tienda` e importar el script `tienda.sql` que se encuentra en la carpeta `database` del proyecto. Este script crea las tablas necesarias para el funcionamiento del proyecto.
- Configurar el archivo `.env` con los datos de conexión a la base de datos, las credenciales de correo electrónico y las credenciales de PayPal. A continuación se muestra un ejemplo de configuración:
```env
DB_HOST='localhost'
DB_NAME='tienda'
DB_USER='root'
DB_PASSWORD=''

MAIL_USERNAME='senalesdetrafico.store@gmail.com'
MAIL_PASSWORD='xxxx xxxx xxxx xxxx'     # Cambiar por la contraseña de la cuenta de aplicaciones de Gmail.

PAYPAL_CLIENT_ID='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' # Cambiar por el ID de cliente de PayPal Developer.
PAYPAL_SECRET='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'    # Cambiar por el secreto de cliente de PayPal Developer.
```
- Iniciar el servidor Apache y MySQL desde el panel de control de XAMPP.
- Abrir un navegador web y acceder a la siguiente URL para verificar que el proyecto se ha instalado correctamente:
```bash
http://localhost/TFG_DAW_AlonsoHernandezRobles
```

## 2. Uso remoto: Servidor web

La aplicación web está alojada en un servidor remoto por *Hostinger*. Para acceder a la aplicación, se puede utilizar el siguiente enlace:

- https://señalesdetrafico.store