# MVC APP 

Aplicación web desarrollada durante mis **prácticas curriculares** en una cooperativa.  
El proyecto tiene como objetivo facilitar el trabajo de los transportistas, permitiendo consultar y actualizar información de inventario mediante una interfaz web conectada a la base de datos corporativa.
⚠️ Nota: El archivo `conexion.php` ha sido modificado por temas de seguridad.

## Tecnologías utilizadas
- **PHP 7** con arquitectura **Modelo-Vista-Controlador (MVC)**
- **SQL Server** con procedimientos almacenados
- **HTML5, CSS3, JavaScript, jQuery**
- **AJAX** para actualización dinámica
- **PDO + ODBC** para la conexión a base de datos

## Funcionalidades principales
- **Autenticación de usuarios** con validación mediante procedimientos almacenados.
- **Panel principal** con menú y control de vistas.
- **Módulo de inventario**:
  - Filtros por tipo y estado de productos.
  - Visualización en tablas paginadas.
  - Edición de unidades y fechas de caducidad.
  - Guardado de cambios individual o masivo (con confirmación visual mediante un sistema de semáforos).

## Estructura del proyecto
- `controller/`: controladores para login, logout, inventario, etc.
- `model/`: conexión y lógica de acceso a la base de datos.
- `view/`: vistas principales (login, dashboard, inventario, etc.).
- `lista_inventario/`: módulo completo para gestión del inventario.
- `templates/`: cabeceras reutilizables.
- `js/`: scripts de paginación y control dinámico.
- `docs/`: documentación asociada (memoria y explicación detallada).

## Documentación
En la carpeta `docs/` se incluye:
- **Documentación APP Cofano.pdf** → Explicación técnica del sistema.
- **Memoria Prácticas Curriculares.pdf** → Memoria completa de las prácticas realizadas.

## Vídeo demostrativo
Puede añadirse un vídeo de la aplicación en funcionamiento dentro de la carpeta `docs/` para complementar la documentación.

## Autor
- Pablo Enrique Guntín Garrido
