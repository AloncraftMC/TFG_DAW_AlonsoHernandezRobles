# TODO (Tareas TFG)

> Ordenadas por prioridad y tiempo estimado de cada tarea.

## 0 - 15 minutos ⚡️

- Añadir `"C. "` a los enlaces de Google Maps.

<hr>

## 15 - 60 minutos ⏳

- Añadir el usuario del pedido si la vista actual es de admin y es distinto al usuario logueado (debajo de "Realizado...").

<hr>

## 1h - 2h 🔄

- Añadir animaciones a los textos de `$_SESSION` (que desaparezcan tras unos pocos segundos).
- Añadir confirmaciones a todas las eliminaciones.
- Hacer que al logearse con el botón de carrito añada *actually* el producto al carrito.
- Si pones una imagen nueva en gestión o edición de usuario y la quitas, no vuelve la imagen anterior. En edición de productos sí funciona.

<hr>

## 2h - 6h 🎨

- Envío de correos al usuario cuando se registra y también cuando se hace un pedido.
- Cookie del carrito compleja (para cada usuario).

<hr>

## 6h - 12h 📦

- *Responsiveness* (Adaptabilidad) completa.

<hr>

## Más de 12h (es decir, una jornada entera) 💰

- Pagos con PayPal.

<hr>

## ??? horas 🐛

- Solucionar problema de carga de imágenes en gestión de usuario
- Al iniciar sesión por el botón del carrito, redirigir al producto en el que estaba (a veces no va)
- Al eliminar un usuario siendo admin, me sale error: (y también al eliminar una categoría). El registro se elimina, pero el error sale:

```
Fatal error: Uncaught PDOException: Error de conexión: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ''3'' at line 1 in C:\xampp\htdocs\DWES\Proyecto Final DWES\lib\BaseDatos.php:54 Stack trace: #0 C:\xampp\htdocs\DWES\Proyecto Final DWES\models\Usuario.php(224): lib\BaseDatos->ejecutar('ALTER TABLE usu...', Array) #1 C:\xampp\htdocs\DWES\Proyecto Final DWES\controllers\UsuarioController.php(586): models\Usuario->delete() #2 C:\xampp\htdocs\DWES\Proyecto Final DWES\index.php(143): controllers\UsuarioController->eliminar() #3 {main} thrown in
C:\xampp\htdocs\DWES\Proyecto Final DWES\lib\BaseDatos.php
on line
54
```

<hr>

## Imposible (♾️ horas) 

- Botón de ver producto siempre abajo (ajuste css)

<div style="page-break-after: always;"></div>

- Revisar que se eliminan todas las variables de `$_SESSION` para evitar mensajes que no deben aparecer.