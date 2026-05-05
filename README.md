# DigiTech - Tienda de Componentes Informáticos

Bienvenido al repositorio de DigiTech, un ejemplo de plataforma web e-commerce desarrollada para la venta de componentes informáticos y hardware.

## Enlace al Proyecto (Demo Online)
El proyecto se encuentra desplegado y totalmente funcional en el siguiente enlace:
http://digitech-msos.infinityfreeapp.com
Derante la instalación, me percaté que necesitatis tener acceso al hosting (en mi caso
infinityfree), pero para la creación del la cuenta utilice un correo personal. Supongo que en la presentación os lo podré mostar en persona.

---

## Características Principales

* **Catálogo de Productos:** Visualización de hardware organizado por categorías.
* **Buscador Integrado:** Filtrado de productos por nombre, descripción o categoría.
* **Sistema de Usuarios:** Registro e inicio de sesión seguro.
* **Gestión de Carrito:** Opción de añadir productos y calcular el total de la compra.
* **Panel de Administración:** Zona restringida para crear, editar o eliminar productos y categorías, además de gestionar el inventario.
* **Diseño Responsivo:** Interfaz adaptable a dispositivos móviles utilizando Bootstrap y un modo oscuro personalizado.

---

## Tecnologías Utilizadas

* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5, Bootstrap Icons.
* **Backend:** PHP (Programación Orientada a Objetos y estructurada).
* **Base de Datos:** MySQL (con arquitectura relacional e integridad referencial).
* **Servidor de Desarrollo:** XAMPP (Apache + MariaDB).
* **Despliegue:** InfinityFree (Hosting Linux).

---

## Instalación en Local

Si deseas ejecutar este proyecto en un entorno local, sigue estos pasos:

1.  Clona o descarga este repositorio y coloca la carpeta `digitech` dentro de tu directorio `htdocs` o similar.
2.  Abre tu gestor de base de datos local (phpMyAdmin o HeidiSQL) y crea una base de datos llamada `digitech_db`.
3.  Importa el archivo **`digitech.sql`** que se incluye en la carpeta raíz del proyecto.
4.  Abre el archivo `includes/conexion.php` y verifica que las credenciales coincidan con tu servidor local (normalmente usuario `root` y contraseña en blanco).
5.  Abre tu navegador y entra en `http://localhost/digitech/`.

---

## Credenciales de Acceso (Pruebas)

Para probar las funcionalidades completas del panel de administración, puedes utilizar la siguiente cuenta preconfigurada:

* **Rol:** Administrador
* **Email:** admin@digitech.com
* **Contraseña:** admin

---

##  Autor
* Mauricio Samuel Olivares Soliz
* 2º DAW Y