# Trabajo de Fin de Grado

## Fase 1 - Concreción de la idea

> Alonso Hernández Robles 2º DAW AULA

La aplicación web constará de una tienda online de señales de tráfico, con distintas funcionalidades para cada una de las partes implicadas en el proceso que se detallarán a continuación.

### 1. Funcionalidades

- **Ver señales de tráfico**: Cualquier usuario podrá ver las señales de tráfico disponibles en la tienda online, donde podrá ver el nombre, categoría, precio, oferta (si la hay) y la imagen de la señal de tráfico, tanto en la página principal como en una página específica para cada señal de tráfico, donde podrá ver una descripción detallada de la señal.
- **Buscar señales de tráfico**: Cualquier usuario podrá buscar señales de tráfico por nombre.
- **Filtrar señales de tráfico**: Cualquier usuario podrá filtrar señales de tráfico por categoría.

#### 1.1. Usuario no registrado

- **Registro**: El usuario podrá registrarse en la aplicación web, proporcionando un nombre, apellidos, correo electrónico, contraseña e imagen de perfil.
- **Inicio de sesión**: El usuario podrá iniciar sesión en la aplicación web, proporcionando su correo electrónico y contraseña. Un botón para recordar al usuario durante 7 días estará disponible.

#### 1.2. Usuario registrado

- **Cierre de sesión**: El usuario podrá cerrar sesión en la aplicación web.
- **Gestión de perfil**: El usuario podrá gestionar su perfil, donde podrá ver y editar su nombre, apellidos, correo electrónico e imagen de perfil, además personalizar el color de la interfaz. Por defecto, la interfaz será de color azul.
- **Carrito de la compra**: El usuario podrá añadir señales de tráfico al carrito de la compra, donde podrá ver el precio total de las señales añadidas y proceder a la compra. Este carrito se guardará en una cookie durante 3 días.
- **Mis Pedidos**: El usuario podrá ver un historial de los pedidos realizados, donde podrá ver el precio total de la compra, la fecha de compra y las señales de tráfico compradas.
- **Realizar pedido**: El usuario podrá realizar un pedido de las señales de tráfico añadidas al carrito de la compra, proporcionando una provincia, localidad y dirección de envío y haciendo el pago mediante PayPal. Tras realizar el pago, se enviará un correo electrónico al usuario con los detalles del pedido, y cuando se confirme, se enviará otro correo electrónico con la confirmación del pedido.

##### 1.2.1. Usuarios con rol Administrador

- **Crear, editar y eliminar productos**: El usuario administrador podrá crear, editar y eliminar productos de la tienda online, proporcionando categoría, un nombre, descripción, precio, oferta de descuento e imagen de la señal de tráfico.
- **Crear, editar y eliminar categorías**: El usuario administrador podrá crear, editar y eliminar categorías de productos de la tienda online, proporcionando un nombre.
- **Crear, editar y eliminar usuarios**: El usuario administrador podrá crear, editar y eliminar usuarios de la aplicación web, proporcionando un nombre, apellidos, correo electrónico, contraseña, imagen de perfil y rol de usuario.
- **Confirmar y eliminar pedidos**: El usuario administrador podrá confirmar y eliminar pedidos de la aplicación web.

##### 1.2.2. Usuarios que han comprado un producto

- **Valorar producto**: El usuario podrá valorar un producto de la tienda online, proporcionando un comentario y una puntuación del 1 al 5.

### 2. Modelos de Datos

De cara a la implementación de la aplicación web, se necesitarán los siguientes tipos de datos con sus respectivos atributos:

#### 2.1. Usuario

- **ID**: Identificador único del usuario.
- **Nombre**: Nombre del usuario.
- **Apellidos**: Apellidos del usuario.
- **Correo electrónico**: Correo electrónico del usuario.
- **Contraseña**: Contraseña del usuario hasheada.
- **Imagen de perfil**: Imagen de perfil del usuario.
- **Rol**: Rol del usuario (usuario, administrador).
- **Color de interfaz**: Color de la interfaz del usuario en hexadecimal.

#### 2.2. Producto

- **ID**: Identificador único del producto.
- **Categoría**: Categoría del producto.
- **Nombre**: Nombre del producto.
- **Descripción**: Descripción del producto.
- **Fecha detallada**: Fecha y hora de la última actualización del producto.
- **Precio**: Precio del producto.
- **Oferta**: Oferta de descuento del producto.
- **Imagen**: Imagen del producto.

#### 2.3. Categoría

- **ID**: Identificador único de la categoría.
- **Nombre**: Nombre de la categoría.

#### 2.4. Pedido

- **ID**: Identificador único del pedido.
- **Usuario**: Usuario que ha realizado el pedido.
- **Provincia**: Provincia de envío del pedido.
- **Localidad**: Localidad de envío del pedido.
- **Dirección**: Dirección de envío del pedido.
- **Coste**: Coste total del pedido.
- **Fecha**: Fecha de realización del pedido.
- **Hora**: Hora de realización del pedido.
- **Estado**: Estado del pedido (pendiente a confirmar, confirmado, denegado).

### 3. Páginas

En primer lugar, todas las páginas contienen un encabezado con el logotipo de la tienda online, un menú de navegación con las siguientes opciones: Tienda de Señales de Tráfico (Inicio), Iniciar Sesión, Registrarse, Carrito, Mis Pedidos y Cerrar Sesión, y un pie de página con información relevante burocrática de la tienda online.

Para los usuarios con rol de administrador, se añadirá una opción en el menú de navegación para acceder al panel de administración, donde se podrán gestionar los productos, categorías, pedidos y usuarios de la aplicación web.

La aplicación web constará de las siguientes páginas (vistas) con sus respectivas funcionalidades:

#### 3.0. Página de Inicio (Productos Recomendados)

- Se mostrarán previsiblemente 6 productos aleatorios de la tienda online, donde se podrá ver el nombre, categoría, precio, oferta y la imagen de la señal de tráfico.
- Al hacer clic en una señal de tráfico, se redirigirá a la página específica de la señal de tráfico.
- Esta página permite filtrar señales de tráfico por categoría y buscar señales de tráfico por nombre.

#### 3.1. Página de Señal de Tráfico

- Se mostrará el nombre, categoría, precio, oferta, descripción y la imagen de la señal de tráfico.
- Se mostrarán los comentarios y la puntuación de la señal de tráfico de cada uno de los usuarios que han comprado el producto. Si el usuario no ha comprado el producto, no podrá valorar la señal de tráfico.
- Esta página permite valorar la señal de tráfico y añadir la señal de tráfico al carrito de la compra en cantidad elegida.

#### 3.2. Página de Iniciar Sesión

- Se mostrará un formulario para iniciar sesión en la aplicación web, donde se podrá proporcionar el correo electrónico y la contraseña.
- Se mostrará un botón para recordar al usuario durante 7 días.

#### 3.3. Página de Registrarse

- Se mostrará un formulario para registrarse en la aplicación web, donde se podrá proporcionar el nombre, apellidos, correo electrónico, contraseña e imagen de perfil.

#### 3.4. Página de Perfil de Usuario

- Se podrá editar el perfil del usuario, donde se podrá ver y editar el nombre, apellidos, correo electrónico e imagen de perfil, además de personalizar el color de la interfaz.

#### 3.5. Página de Carrito

- Se mostrarán las señales de tráfico añadidas al carrito de la compra, donde se podrá ver el precio total de las señales añadidas y proceder a la compra.
- Si no hay señales de tráfico añadidas al carrito de la compra, se mostrará un mensaje indicando que el carrito de la compra está vacío y un botón para volver a la tienda de señales de tráfico.

#### 3.6. Página de Mis Pedidos

- Se mostrará un historial de los pedidos realizados, donde se podrá ver el precio total de la compra, la fecha de compra y las señales de tráfico, en cada uno de los pedidos.
- Si no hay pedidos realizados, se mostrará un mensaje indicando que no hay pedidos realizados y un botón para volver a la tienda de señales de tráfico.

#### 3.7. Página de Panel de Administración (Usuarios)

- Se mostrará un listado de los usuarios registrados en la aplicación web, donde se podrá ver el identificador, nombre, apellidos, correo electrónico, imagen de perfil y rol de usuario.
- Se podrán crear, editar y eliminar usuarios de la aplicación web.

##### 3.7.1. Página de Crear Usuario

- Se mostrará un formulario para crear un usuario en la aplicación web, donde se podrá proporcionar el nombre, apellidos, correo electrónico, contraseña, imagen de perfil y rol de usuario.

##### 3.7.2. Página de Editar Usuario

- Se mostrará un formulario para editar un usuario de la aplicación web, donde se podrá modificar el nombre, apellidos, correo electrónico, contraseña, imagen de perfil y rol de usuario.

#### 3.8. Página de Panel de Administración (Productos)

- Se mostrará un listado de los productos de la tienda online, donde se podrá ver el identificador, nombre, categoría, precio, oferta y la imagen de la señal de tráfico.
- Se podrán crear, ver, editar y eliminar productos de la tienda online.

##### 3.8.1. Página de Crear Producto

- Se mostrará un formulario para crear un producto en la tienda online, donde se podrá proporcionar la categoría, un nombre, descripción, precio, oferta de descuento e imagen de la señal de tráfico.

##### 3.8.2. Página de Editar Producto

- Se mostrará un formulario para editar un producto de la tienda online, donde se podrá modificar la categoría, un nombre, descripción, precio, oferta de descuento e imagen de la señal de tráfico.

#### 3.9. Página de Panel de Administración (Categorías)

- Se mostrará un listado de las categorías de productos de la tienda online, donde se podrá ver el identificador y el nombre de la categoría.
- Se podrán crear, editar y eliminar categorías de productos de la tienda online.

##### 3.9.1. Página de Crear Categoría

- Se mostrará un formulario para crear una categoría de productos de la tienda online, donde se podrá proporcionar un nombre.

##### 3.9.2. Página de Editar Categoría

- Se mostrará un formulario para editar una categoría de productos de la tienda online, donde se podrá modificar un nombre.

#### 3.10. Página de Panel de Administración (Pedidos)

- Se mostrará un listado de los pedidos realizados en la aplicación web, donde se podrá ver el identificador, usuario, provincia, localidad, dirección, coste, fecha, hora y estado del pedido.
- Se podrán confirmar, denegar y eliminar pedidos de la aplicación web.

### 4. Tecnologías

Para la implementación de la aplicación web, se utilizarán las siguientes tecnologías:

#### 4.1. Lenguajes

- **HTML5**: Lenguaje de marcado para la estructura de la aplicación web.
- **CSS3**: Lenguaje de estilado para el diseño de la aplicación web.
- **JavaScript**: Lenguaje de programación para la interactividad de la aplicación web en el lado del cliente.
- **PHP**: Lenguaje de programación para la lógica de la aplicación web en el lado del servidor.
- **SQL**: Lenguaje de consulta estructurado para la gestión de la base de datos alojada en un servidor MySQL (PHPMyAdmin).

#### 4.2. Software

- **Visual Studio Code**: Editor de código fuente para la escritura de código HTML, CSS, JavaScript y PHP.
- **XAMPP**: Paquete de software libre que consiste principalmente en el sistema de gestión de bases de datos MySQL y los intérpretes para lenguajes de script PHP y Perl, en servidor local Apache.
- **PHPMyAdmin**: Herramienta de administración de bases de datos MySQL.
- **Git**: Sistema de control de versiones para el seguimiento de los cambios en el código fuente.
- **GitHub**: Plataforma de desarrollo colaborativo para alojar proyectos utilizando el sistema de control de versiones Git.
- **Figma**: Herramienta de diseño de interfaces de usuario y prototipado de aplicaciones web.
- **PayPal**: Pasarela de pagos para realizar transacciones monetarias en la aplicación web.
- **Hostinger**: Servicio de alojamiento web para publicar en un servidor la aplicación web en producción.

### 5. Observaciones

Todos los datos proporcionados por los usuarios en la aplicación web serán validados y almacenados en una base de datos MySQL alojada en un servidor local de XAMPP, y en un servidor en producción de Hostinger.

La aplicación web será responsive, es decir, se adaptará a cualquier dispositivo (móvil, tablet, ordenador) para una mejor experiencia de usuario.

Se puede realizar un seguimiento de los cambios en el código fuente de la aplicación web en el repositorio de GitHub:

<h1><a href="https://github.com/AloncraftMC/TFG_DAW_AlonsoHernandezRobles"><img width="40" src="https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png">/AloncraftMC/TFG_DAW_AlonsoHernandezRobles</a></h1>