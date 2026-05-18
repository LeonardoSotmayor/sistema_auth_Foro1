<?php
session_start();
require 'conexion.php';

// Validar si la sesión está activa
if (!isset($_SESSION['usuario_cedula'])) {
    header("Location: login.php");
    exit;
}

$cedula = $_SESSION['usuario_cedula'];
$mensaje_error = '';
$mensaje_exito = '';

// Procesar la actualización de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevo_correo = trim($_POST['correo']);

    if (!empty($nuevo_nombre) && filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
        // Verificar que el nuevo correo no pertenezca a OTRO usuario
        $stmt_check = $pdo->prepare("SELECT cedula FROM usuarios WHERE correo = :correo AND cedula != :cedula");
        $stmt_check->execute(['correo' => $nuevo_correo, 'cedula' => $cedula]);
        
        if ($stmt_check->rowCount() > 0) {
            $mensaje_error = "El correo ingresado ya está siendo usado por otra cuenta.";
        } else {
            // Actualizar datos en la base de datos
            $stmt_update = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo WHERE cedula = :cedula");
            $stmt_update->execute(['nombre' => $nuevo_nombre, 'correo' => $nuevo_correo, 'cedula' => $cedula]);
            $mensaje_exito = "Tus datos han sido actualizados con éxito.";
        }
    } else {
        $mensaje_error = "Los datos ingresados contienen formatos no válidos.";
    }
}

// Obtener los datos actualizados del usuario para mostrarlos en los inputs
$stmt = $pdo->prepare("SELECT nombre, correo FROM usuarios WHERE cedula = :cedula");
$stmt->execute(['cedula' => $cedula]);
$usuario = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
        
        <?php if(!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($mensaje_exito)): ?>
            <div class="mensaje-exito"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>

        <div class="links-perfil">
            <a href="cambiar_password.php">Cambiar Contraseña</a>
            <a href="logout.php" style="color: #e74c3c; font-weight: bold;">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>