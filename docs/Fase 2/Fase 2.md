# Trabajo de Fin de Grado

## Fase 2 - Análisis y Diseño

> Alonso Hernández Robles 2º DAW AULA

### 1. Diagrama de Casos de Uso

<div style="text-align: center; border: 1px solid black; padding: 10px; border-radius: 10px;">
    <img src="Diagramas/Diagrama%20de%20Casos%20de%20Uso.drawio.png" alt="Diagrama de Casos de Uso" style="zoom: 75%;" />
</div>

<div style="page-break-after: always;"></div>

### 2. Diagrama de Clases

<div style="text-align: center; border: 1px solid black; padding: 10px; border-radius: 10px;">
    <img src="Diagramas/Diagrama%20de%20Clases.drawio.png" alt="Diagrama de Clases" />
</div>

<div style="page-break-after: always;"></div>

### 3. Diagrama Entidad-Relación de la Base de Datos

<div style="text-align: center; border: 1px solid black; padding: 10px; border-radius: 10px;">
    <img src="Diagramas/Diagrama%20Entidad-Relación.drawio.png" alt="Diagrama Entidad-Relación" />
</div>

#### 3.1. Paso a Tablas

- CATEGORIA(**id**, nombre)
- PRODUCTO(**id**, nombre, descripcion, precio, stock, oferta, fecha, imagen, *categoria_id*)
    - *categoria_id*: Clave foránea de CATEGORIA(id)
- PEDIDO(**id**, provincia, localidad, direccion, coste, estado, fecha, hora, *usuario_id*)
    - *usuario_id*: Clave foránea de USUARIO(id)
- USUARIO(**id**, nombre, apellidos, email, password, rol, imagen, color)
- LINEA_PEDIDO(**id**, unidades, *producto_id*, *pedido_id*)
    - *producto_id*: Clave foránea de PRODUCTO(id)
    - *pedido_id*: Clave foránea de PEDIDO(id)
- VALORACION(**id**, comentario, puntuacion, *usuario_id*, *producto_id*) 
    - *usuario_id*: Clave foránea de USUARIO(id)
    - *producto_id*: Clave foránea de PRODUCTO(id)

#### 3.2. Normalización

Todas las tablas están en 1FN, 2FN y 3FN.

<div style="page-break-after: always;"></div>

### 4. Diseño de las Páginas

#### 4.0. Pop-Up de Aviso para Administradores

<img src="Imágenes/image-0.png" alt="Pop-Up de Aviso para Administradores" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.1. Página de Inicio (Productos Recomendados)

<img src="Imágenes/image.png" alt="Página de Inicio (Productos Recomendados)" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.2. Página de Productos Filtrados por Categoría

<img src="Imágenes/image-1.png" alt="Página de Productos Filtrados por Categoría" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.3. Página de Producto

<img src="Imágenes/image-2.png" alt="Página de Producto" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.4. Página de Registro

<img src="Imágenes/image-3.png" alt="Página de Registro" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.5. Página de Inicio de Sesión

<img src="Imágenes/image-4.png" alt="Página de Inicio de Sesión" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.6. Página de Gestión de Usuario

<img src="Imágenes/image-5.png" alt="Página de Gestión de Usuario" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.7. Página de Carrito

<img src="Imágenes/image-6.png" alt="Página de Carrito" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.8. Página de Hacer Pedido

<img src="Imágenes/image-7.png" alt="Página de Hacer Pedido" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.9. Página de Pedido Listo (Pendiente a Confirmar)

<img src="Imágenes/image-8.png" alt="Página de Pedido Listo (Pendiente a Confirmar)" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.10. Página de Mis Pedidos

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

#### 4.11. Página de Administración de Categorías

<img src="Imágenes/image-11.png" alt="Página de Administración de Categorías" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.12. Página de Creación de Categoría

<img src="Imágenes/image-12.png" alt="Página de Creación de Categoría" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.13. Página de Edición de Categoría

<img src="Imágenes/image-13.png" alt="Página de Edición de Categoría" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.14. Página de Administración de Productos

<img src="Imágenes/image-14.png" alt="Página de Administración de Productos" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.15. Página de Creación de Producto

<img src="Imágenes/image-15.png" alt="Página de Creación de Producto" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.16. Página de Edición de Producto

<img src="Imágenes/image-16.png" alt="Página de Edición de Producto" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.17. Página de Administración de Usuarios

<img src="Imágenes/image-17.png" alt="Página de Administración de Usuarios" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.18. Página de Creación de Usuario

<img src="Imágenes/image-18.png" alt="Página de Creación de Usuario" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

<div style="page-break-after: always;"></div>

#### 4.19. Página de Edición de Usuario

<img src="Imágenes/image-19.png" alt="Página de Edición de Usuario" style="text-align: center; border: 1px solid black; border-radius: 10px;"/>

#### 4.20. Página de Administración de Pedidos

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

#### 4.21. Página de Ver Pedido

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

#### 4.22. Página de Política de Privacidad

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

#### 4.23. Página de Condiciones de Uso

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

#### 4.24. Página de Sobre Nosotros

Se ideará en la siguiente y última fase, ya que no es totalmente relevante.

<div style="page-break-after: always;"></div>

### 5. Mapa de Navegación

<div style="text-align: center; border: 1px solid black; padding: 10px; border-radius: 10px;">
    <img src="Diagramas/Mapa%20de%20Navegación.drawio.png" alt="Mapa de Navegación" />
</div>