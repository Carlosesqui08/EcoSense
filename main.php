<?php
// Iniciamos la sesión para poder guardar datos del usuario
session_start();

// Verificamos si ya hay una sesión activa, en ese caso redirigimos al dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoSense IoT - Inicio de Sesión</title>
    <style>
        /* Definición de variables CSS para facilitar cambios de color en todo el sitio */
        :root {
            --primary-dark: #0d253f;
            /* Azul oscuro - color base */
            --primary-medium: #1a4b78;
            /* Azul medio para gradientes */
            --primary-light: #2e7cb9;
            /* Azul claro para detalles */
            --accent: #00e5ff;
            /* Color turquesa brillante para acentos */
            --text-light: #f4f8fb;
            /* Color claro para textos */
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            /* Sombra estándar */
        }

        /* Reseteo básico de estilos para mayor consistencia */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Configuración del fondo y disposición general */
        body {
            background-image: url("fondo.jpg");
            /* Imagen de fondo (reemplazar con tu imagen) */
            background-size: cover;
            /* Escalar la imagen para cubrir toda la pantalla */
            background-position: center;
            /* Centrar la imagen */
            background-attachment: fixed;
            /* Fijar la imagen al hacer scroll */
            display: flex;
            /* Usar flexbox para centrar contenido */
            justify-content: center;
            /* Centrado horizontal */
            align-items: center;
            /* Centrado vertical */
            min-height: 100vh;
            /* Altura mínima de 100% del viewport */
            position: relative;
            /* Para posicionar elementos internos */
            overflow: hidden;
            /* Evitar scroll si no es necesario */
        }

        /* Capa de superposición con gradiente sobre el fondo */
        body::before {
            content: '';
            /* Elemento vacío */
            position: absolute;
            /* Posicionamiento absoluto */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Gradiente diagonal con transparencia para mejor legibilidad del contenido */
            background: linear-gradient(0deg, rgba(13, 37, 63, 0.85), rgba(26, 75, 120, 0.8));
            z-index: -50;
            /* Colocar detrás del contenido */
        }

        /* Contenedor principal del formulario de login */
        .login-container {
            background: rgba(10, 25, 47, 0.8);
            /* Fondo semi-transparente */
            backdrop-filter: blur(10px);
            /* Efecto de desenfoque del fondo */
            width: 100%;
            /* Ancho completo dentro del contenedor */
            max-width: 400px;
            /* Ancho máximo para pantallas grandes */
            padding: 40px;
            /* Espacio interno */
            border-radius: 16px;
            /* Bordes redondeados */
            box-shadow: var(--box-shadow);
            /* Sombra para efecto de elevación */
            text-align: center;
            /* Texto centrado */
            transform: translateY(20px);
            /* Posición inicial para animación */
            opacity: 0;
            /* Invisible inicialmente */
            animation: fadeIn 0.6s ease-out forwards;
            /* Animación de entrada */
        }

        /* Espacio para el logo de la empresa */
        .logo {
            width: 120px;
            /* Ancho del logo */
            height: 120px;
            /* Alto del logo */
            margin: 0 auto 20px;
            /* Márgenes (centrado) */
            background: url("logo.jpg");
            /* Imagen de logo (reemplazar) */
            background-size: contain;
            /* Ajustar tamaño */
            background-position: center;
            /* Centrar imagen */
            background-repeat: no-repeat;
            /* Evitar repetición */
            border-radius: 50%;
            /* Forma circular */
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.6);
            /* Resplandor */
            animation: pulse 3s infinite;
            /* Animación de pulso continua */
        }

        /* Estilo del título principal */
        h2 {
            margin-bottom: 25px;
            /* Espacio inferior */
            color: var(--text-light);
            /* Color de texto */
            font-size: 28px;
            /* Tamaño de fuente */
            font-weight: 600;
            /* Grosor de fuente */
            letter-spacing: 1px;
            /* Espaciado entre letras */
            position: relative;
            /* Para el decorador inferior */
            padding-bottom: 12px;
            /* Espacio para el decorador */
        }

        /* Línea decorativa debajo del título */
        h2::after {
            content: '';
            /* Elemento vacío */
            position: absolute;
            /* Posicionamiento absoluto */
            bottom: 0;
            /* Alineado abajo */
            left: 50%;
            /* Centrado horizontal */
            transform: translateX(-50%);
            /* Ajuste de centrado */
            width: 60px;
            /* Ancho de la línea */
            height: 3px;
            /* Grosor de la línea */
            background: var(--accent);
            /* Color de acento */
            border-radius: 2px;
            /* Bordes redondeados */
        }

        /* Contenedor de cada campo de entrada */
        .input-group {
            position: relative;
            /* Para posicionar la etiqueta */
            margin-bottom: 22px;
            /* Espacio entre campos */
        }

        /* Etiquetas de los campos de entrada */
        .input-group label {
            position: absolute;
            /* Posicionamiento absoluto */
            left: 15px;
            /* Posición horizontal */
            top: 14px;
            /* Posición vertical */
            color: #aaa;
            /* Color gris claro */
            transition: all 0.3s ease;
            /* Transición suave */
            pointer-events: none;
            /* No interceptar clics */
        }

        /* Campos de entrada (usuario y contraseña) */
        .input-group input {
            width: 100%;
            /* Ancho completo */
            padding: 14px 15px;
            /* Espacio interno */
            border: 1px solid rgba(255, 255, 255, 0.1);
            /* Borde sutil */
            background: rgba(255, 255, 255, 0.07);
            /* Fondo semi-transparente */
            border-radius: 8px;
            /* Bordes redondeados */
            color: var(--text-light);
            /* Color de texto */
            font-size: 16px;
            /* Tamaño de fuente */
            transition: all 0.3s ease;
            /* Transición suave */
        }

        /* Estilo al enfocar o tener contenido en los campos */
        .input-group input:focus,
        .input-group input:valid {
            border-color: var(--accent);
            /* Borde destacado */
            outline: none;
            /* Quitar contorno predeterminado */
        }

        /* Animación de etiqueta flotante */
        .input-group input:focus+label,
        .input-group input:valid+label {
            top: -10px;
            /* Mover arriba */
            left: 12px;
            /* Ajustar posición horizontal */
            font-size: 12px;
            /* Reducir tamaño */
            background: var(--primary-dark);
            /* Fondo para legibilidad */
            padding: 0 5px;
            /* Espacio interno */
            color: var(--accent);
            /* Color destacado */
        }

        /* Botón de inicio de sesión */
        button {
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            /* Gradiente */
            color: var(--text-light);
            /* Color del texto */
            padding: 15px;
            /* Espacio interno */
            border: none;
            /* Sin borde */
            border-radius: 8px;
            /* Bordes redondeados */
            cursor: pointer;
            /* Cambiar cursor */
            width: 100%;
            /* Ancho completo */
            font-size: 16px;
            /* Tamaño de texto */
            font-weight: 600;
            /* Grosor de fuente */
            letter-spacing: 1px;
            /* Espaciado entre letras */
            transition: all 0.3s ease;
            /* Transición suave */
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.3);
            /* Sombra con brillo */
            position: relative;
            /* Para efectos internos */
            overflow: hidden;
            /* Contener efectos internos */
            margin-top: 10px;
            /* Espacio superior */
        }

        /* Efecto al pasar el cursor sobre el botón */
        button:hover {
            transform: translateY(-3px);
            /* Elevación ligera */
            box-shadow: 0 8px 20px rgba(0, 229, 255, 0.5);
            /* Sombra más pronunciada */
        }

        /* Efecto de onda al hacer clic */
        button::after {
            content: '';
            /* Elemento vacío */
            position: absolute;
            /* Posicionamiento absoluto */
            top: 50%;
            /* Centrado vertical */
            left: 50%;
            /* Centrado horizontal */
            width: 300%;
            /* Tamaño mayor que el botón */
            height: 300%;
            background: rgba(255, 255, 255, 0.1);
            /* Color blanco semi-transparente */
            border-radius: 50%;
            /* Forma circular */
            transform: translate(-50%, -50%) scale(0);
            /* Inicialmente invisible */
            transition: transform 0.5s ease-out;
            /* Transición suave */
        }

        /* Activación del efecto de onda */
        button:active::after {
            transform: translate(-50%, -50%) scale(1);
            /* Expandir al tamaño completo */
        }

        /* Estilo para texto informativo */
        p {
            margin-top: 20px;
            /* Espacio superior */
            color: var(--text-light);
            /* Color de texto */
            font-size: 14px;
            /* Tamaño de fuente */
        }

        /* Estilo para enlaces */
        a {
            color: var(--accent);
            /* Color de acento */
            text-decoration: none;
            /* Sin subrayado */
            font-weight: 500;
            /* Grosor de fuente */
            transition: all 0.3s ease;
            /* Transición suave */
        }

        /* Efecto al pasar el cursor sobre enlaces */
        a:hover {
            text-decoration: none;
            /* Mantener sin subrayado */
            color: #7df9ff;
            /* Color más claro */
            text-shadow: 0 0 5px rgba(0, 229, 255, 0.5);
            /* Efecto de brillo */
        }

        /* Estilo para mensajes de error y éxito */
        .mensaje {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out;
        }

        .mensaje-error {
            background: rgba(255, 80, 80, 0.15);
            border: 1px solid rgba(255, 80, 80, 0.3);
            color: #ff6b6b;
        }

        .mensaje-exito {
            background: rgba(80, 255, 120, 0.15);
            border: 1px solid rgba(80, 255, 120, 0.3);
            color: #4dffa6;
        }

        /* Definición de la animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                /* Inicio invisible */
                transform: translateY(20px);
                /* Desde abajo */
            }

            to {
                opacity: 1;
                /* Final visible */
                transform: translateY(0);
                /* Posición final */
            }
        }

        /* Definición de la animación de pulso para el logo */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 229, 255, 0.7);
                /* Inicio sin sombra */
            }

            70% {
                box-shadow: 0 0 0 15px rgba(0, 229, 255, 0);
                /* Expansión máxima */
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 229, 255, 0);
                /* Vuelta al inicio */
            }
        }

        /* Adaptaciones para dispositivos móviles */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                /* Reducir padding */
                width: 90%;
                /* Ajustar ancho */
            }

            .logo {
                width: 100px;
                /* Logo más pequeño */
                height: 100px;
            }

            h2 {
                font-size: 24px;
                /* Título más pequeño */
            }
        }
    </style>
</head>

<body>
    <!-- Contenedor principal del formulario de login -->
    <div class="login-container">
        <!-- Espacio para el logo de la empresa -->
        <div class="logo"></div>
        <!-- Título principal -->
        <h2>Bienvenido a EcoSense</h2>
        
        <?php
        // Procesamiento del formulario de inicio de sesión
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['username'];
            $contrasena = $_POST['password'];
            
            // Incluir archivo de conexión con la base de datos
            include('conexion.php');
            
            // Verificar credenciales con la función iniciarSesion
            if (iniciarSesion($usuario, $contrasena)) {
                // Iniciar sesión y almacenar información del usuario
                session_start(); // Si ya se inició una sesión, esto la continúa
                
                // Obtener información del usuario para guardar en la sesión
                $sql = "SELECT id, usuario FROM usuarios WHERE usuario = '$usuario'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['usuario_id'] = $row['id'];
                    $_SESSION['usuario_nombre'] = $row['usuario'];
                }
                
                // Mostrar mensaje de éxito
                echo "<div class='mensaje mensaje-exito'>Inicio de sesión exitoso. Redirigiendo...</div>";
                
                // Redirección directa con JavaScript que se ejecuta inmediatamente
                echo "<script>
                      // Esperar brevemente para mostrar el mensaje
                      setTimeout(function() {
                          window.location.href = 'dashboard.php';
                      }, 1000);
                      </script>";
                exit(); // Detener la ejecución del script PHP
            } else {
                // Mostrar mensaje de error
                echo "<div class='mensaje mensaje-error'>Usuario o contraseña incorrectos</div>";
            }
        }
        ?>
        
        <!-- Formulario de inicio de sesión -->    
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <!-- Campo de usuario con etiqueta flotante -->
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <label for="username">Usuario</label>
            </div>

            <!-- Campo de contraseña con etiqueta flotante -->
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>

            <!-- Botón de envío con efectos -->
            <button type="submit">Iniciar Sesión</button>
            <!-- Enlace a registro -->
            <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </form>
    </div>

    <script>
        // Efecto de movimiento flotante para el contenedor de login
        document.addEventListener('mousemove', function (e) {
            const container = document.querySelector('.login-container');
            // Calcular posición relativa del mouse en la ventana
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            // Convertir a un rango de movimiento limitado (-5px a 5px)
            const moveX = mouseX * 10 - 5;
            const moveY = mouseY * 10 - 5;

            // Aplicar transformación suave al contenedor
            container.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });

        // Animación para los campos de entrada
        const inputs = document.querySelectorAll('input');
        // Para cada campo de entrada, añadir listeners de eventos
        inputs.forEach(input => {
            // Al enfocar el campo
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            // Al quitar el foco del campo
            input.addEventListener('blur', () => {
                // Solo restaurar si está vacío
                if (input.value === '') {
                    input.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>

</html>
