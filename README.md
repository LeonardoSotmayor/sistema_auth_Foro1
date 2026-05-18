# Sistema de Autenticación, Gestión de Sesiones y Perfil Seguro en PHP

Un sistema web ligero y seguro desarrollado en PHP y MySQL que implementa buenas prácticas de desarrollo, control estricto de sesiones (`$_SESSION`), almacenamiento criptográfico de contraseñas con `password_hash` y protección contra inyecciones SQL mediante sentencias preparadas con PDO. Cuenta con una interfaz visual limpia y responsiva a través de una hoja de estilos centralizada (`style.css`).

## 📋 Características Básicas
* **Registro Seguro:** Validación de campos obligatorios, formato de correo electrónico y comprobación de duplicados. Las contraseñas se almacenan cifradas utilizando el algoritmo `BCRYPT`.
* **Autenticación (Login):** Validación de credenciales en servidor con `password_verify` e inicio del estado de sesión.
* **Zona Privada (Perfil):** Acceso restringido únicamente a usuarios autenticados. Permite la visualización de datos actuales y la actualización de Nombre Completo y Correo Electrónico con validación en servidor.
* **Módulo de Cuenta:** Cambio de contraseña seguro solicitando y verificando primero la contraseña actual del usuario.
* **Cierre de Sesión (Logout):** Destrucción completa de variables de sesión y redirección automática para impedir el reingreso mediante el botón "Atrás" del navegador.

## 🛠️ Requisitos del Sistema
Para ejecutar y probar este sistema localmente, necesitarás un entorno de desarrollo web local:
* **Servidor Local:** [XAMPP](https://www.apachefriends.org/) (recomendado), Laragon o similar.
* **PHP:** Versión 7.4 o superior (con la extensión **PDO MySQL** habilitada por defecto en XAMPP).
* **Base de Datos:** MySQL o MariaDB.
* **Navegador Web:** Google Chrome, Mozilla Firefox, Microsoft Edge, etc.

## 🚀 Instalación y Despliegue Local

Sigue estos pasos ordenados para montar el proyecto en tu máquina:

1. **Copiar los archivos del proyecto:**
   * Dirígete a la ruta de instalación de tu servidor local (por defecto en XAMPP es `C:\xampp\htdocs\`).
   * Crea una carpeta dentro de `htdocs` llamada `sistema_auth`.
   * Pega dentro de esa carpeta todos los archivos del sistema (`conexion.php`, `style.css`, `registro.php`, `login.php`, `perfil.php`, `cambiar_password.php`, `logout.php` y `database.sql`).

2. **Iniciar los servicios del servidor:**
   * Abre el **XAMPP Control Panel**.
   * Haz clic en el botón **"Start"** de los módulos **Apache** y **MySQL**. Asegúrate de que cambien a color verde.

3. **Configurar la Base de Datos:**
   * Abre tu navegador web e ingresa a phpMyAdmin: `http://localhost/phpmyadmin/`.
   * Haz clic en **"Nueva"** en el panel izquierdo para crear una base de datos. Nómbrala exactamente como `sistema_auth` y haz clic en crear.
   * Selecciona la base de datos creada, ve a la pestaña **"Importar"** en el menú superior, selecciona tu archivo `database.sql` y presiona el botón **"Importar"** (o "Continuar") al final de la página.

4. **Verificar Credenciales de Conexión:**
   * Abre el archivo `conexion.php` con tu editor de texto. Si utilizas los valores predeterminados de XAMPP (usuario: `'root'` y contraseña vacía: `''`), el archivo funcionará de inmediato. Si configuraste una contraseña para MySQL, agrégala en la variable `$password`.

## 🧪 Pasos para Probar el Sistema (Flujo Completo)

Una vez completada la instalación, abre tu navegador y sigue este flujo de pruebas (ideal para la estructura de tu video explicativo):

1. **Flujo de Registro (`registro.php`):**
   * Accede a `http://localhost/sistema_auth/registro.php`.
   * Registra un usuario de prueba completando todos los campos. Al finalizar con éxito, verás una alerta verde indicando que el registro fue correcto.
   * *Opcional:* Abre phpMyAdmin y verifica en la tabla `usuarios` cómo se ha almacenado el registro y cómo la contraseña está completamente oculta bajo un hash criptográfico.

2. **Flujo de Inicio de Sesión (`login.php`):**
   * Ve a `http://localhost/sistema_auth/login.php` o haz clic en el enlace inferior de la página de registro.
   * Intenta ingresar con datos erróneos para verificar la alerta roja de credenciales inválidas.
   * Ingresa las credenciales correctas del usuario que acabas de registrar. Serás redirigido inmediatamente al perfil privado.

3. **Zona Privada e Integridad de Datos (`perfil.php`):**
   * Una vez dentro, verás el mensaje de bienvenida saludándote por tu nombre.
   * Modifica tu nombre o tu correo electrónico y haz clic en "Guardar Cambios" para comprobar que la actualización en tiempo real en la base de datos se realiza de manera exitosa.

4. **Módulo de Actualización de Cuenta (`cambiar_password.php`):**
   * Haz clic en el enlace "Cambiar Contraseña".
   * Completa el formulario escribiendo tu contraseña actual incorrectamente para comprobar la validación de seguridad.
   * Escribe la contraseña actual correcta, introduce una nueva contraseña y confírmala para actualizarla de forma exitosa.

5. **Cierre de Sesión y Control de Acceso Estricto (`logout.php`):**
   * Haz clic en el enlace "Cerrar Sesión". Serás expulsado inmediatamente al `login.php`.
   * **Prueba de Seguridad Final:** Con la sesión cerrada, intenta forzar el acceso ingresando directamente la URL privada en la barra de direcciones: `http://localhost/sistema_auth/perfil.php`. Verás que el sistema te deniega el acceso automáticamente y te rebota al login, demostrando que la sesión fue destruida por completo y de forma segura.
