<?php
// Iniciar la sesión al principio del script
session_start();

// Verificar si ya hay una sesión activa y redirigir al dashboard
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        /* Variables CSS para la paleta de colores */
        :root {
            --primary-dark: #0d1b2a;
            --secondary-dark: #1b263b;
            --accent-blue: #2a6f97;
            --light-blue: #61a5c2;
            --highlight: #fc7a57;
            --text-light: #e0e1dd;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Estilos generales del cuerpo */
        body {
            background-image: url('/api/placeholder/1920/1080');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Overlay con gradiente sobre el fondo */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(13, 27, 42, 0.95), 
                rgba(27, 38, 59, 0.9), 
                rgba(42, 111, 151, 0.85));
            z-index: -1;
        }

        /* Partículas flotantes en el fondo */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(97, 165, 194, 0.2);
            pointer-events: none;
        }

        /* Contenedor del formulario */
        .login-container {
            background: rgba(13, 27, 42, 0.75);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--box-shadow);
            text-align: center;
            position: relative;
            z-index: 10;
            overflow: hidden;
            border: 1px solid rgba(97, 165, 194, 0.1);
        }

        /* Efecto de borde brillante */
        .login-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            z-index: -1;
            background: linear-gradient(45deg, 
                var(--accent-blue), 
                var(--light-blue), 
                var(--highlight), 
                var(--accent-blue));
            background-size: 400% 400%;
            border-radius: 22px;
            opacity: 0;
            animation: glowing 3s ease-in-out infinite alternate;
        }

        .login-container:hover::before {
            opacity: 0.6;
        }

        /* Contenedor del logo */
        .logo-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
        }

        /* Logo con efecto resplandor */
        .logo {
            width: 100%;
            height: 100%;
            background-color: var(--light-blue);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: pulse 3s infinite;
            box-shadow: 0 0 20px rgba(97, 165, 194, 0.5);
            position: relative;
            z-index: 2;
        }

        .logo i {
            font-size: 48px;
            color: var(--primary-dark);
        }

        /* Anillos orbitales alrededor del logo */
        .orbital {
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            border: 2px dotted rgba(97, 165, 194, 0.5);
            transform: translate(-50%, -50%);
        }

        .orbital:nth-child(1) {
            width: 140px;
            height: 140px;
            animation: rotate 8s linear infinite;
        }

        .orbital:nth-child(2) {
            width: 180px;
            height: 180px;
            animation: rotate 12s linear infinite reverse;
        }

        .orbital-dot {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--highlight);
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(252, 122, 87, 0.7);
        }

        /* Estilos de título */
        h2 {
            margin-bottom: 25px;
            color: var(--text-light);
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--light-blue), var(--highlight));
            border-radius: 2px;
        }

        /* Mensaje de error o éxito */
        .mensaje {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInDown 0.5s ease-out forwards;
        }

        .mensaje i {
            margin-right: 8px;
            font-size: 18px;
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

        /* Grupos de input con efecto flotante */
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid rgba(97, 165, 194, 0.2);
            background: rgba(27, 38, 59, 0.6);
            border-radius: 10px;
            color: var(--text-light);
            font-size: 16px;
            transition: var(--transition);
        }

        .input-group i.icon {
            position: absolute;
            left: 15px;
            top: 17px;
            color: var(--light-blue);
            font-size: 18px;
            transition: var(--transition);
        }

        .input-group label {
            position: absolute;
            left: 45px;
            top: 15px;
            color: rgba(224, 225, 221, 0.7);
            font-size: 16px;
            transition: var(--transition);
            pointer-events: none;
        }

        .input-group input:focus,
        .input-group input:valid {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 2px rgba(97, 165, 194, 0.2);
        }

        .input-group input:focus + i.icon,
        .input-group input:valid + i.icon {
            color: var(--highlight);
            transform: scale(1.1);
        }

        .input-group input:focus ~ label,
        .input-group input:valid ~ label {
            top: -10px;
            left: 15px;
            font-size: 12px;
            background: var(--secondary-dark);
            padding: 0 8px;
            border-radius: 4px;
            color: var(--highlight);
        }

        /* Toggle para mostrar/ocultar contraseña */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 17px;
            color: rgba(224, 225, 221, 0.7);
            cursor: pointer;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--highlight);
        }

        /* Botón de inicio de sesión */
        button {
            background: linear-gradient(135deg, var(--accent-blue), var(--light-blue));
            color: var(--text-light);
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(42, 111, 151, 0.4);
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button i {
            margin-right: 10px;
            font-size: 18px;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(42, 111, 151, 0.6);
            background: linear-gradient(135deg, var(--light-blue), var(--highlight));
        }

        button:active {
            transform: translateY(-1px);
        }

        /* Efecto de onda al hacer clic */
        button .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background-color: rgba(255, 255, 255, 0.3);
        }

        /* Texto y enlaces */
        p {
            margin-top: 25px;
            color: var(--text-light);
            font-size: 14px;
        }

        a {
            color: var(--light-blue);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            padding-bottom: 2px;
        }

        a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background-color: var(--highlight);
            transition: var(--transition);
        }

        a:hover {
            color: var(--highlight);
        }

        a:hover::after {
            width: 100%;
        }

        /* Divisor decorativo */
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: var(--text-light);
            font-size: 12px;
            opacity: 0.7;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: rgba(224, 225, 221, 0.3);
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        /* Botones de redes sociales */
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 5px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(27, 38, 59, 0.8);
            border: 1px solid rgba(97, 165, 194, 0.2);
            color: var(--text-light);
            font-size: 18px;
            transition: var(--transition);
            cursor: pointer;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            background-color: var(--accent-blue);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Animaciones */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(97, 165, 194, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(97, 165, 194, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(97, 165, 194, 0);
            }
        }

        @keyframes rotate {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        @keyframes glowing {
            0% {
                background-position: 0% 50%;
                opacity: 0.1;
            }
            50% {
                background-position: 100% 50%;
                opacity: 0.2;
            }
            100% {
                background-position: 0% 50%;
                opacity: 0.1;
            }
        }

        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Media queries para responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                width: 90%;
                max-width: 100%;
            }

            .logo-container {
                width: 100px;
                height: 100px;
            }

            h2 {
                font-size: 24px;
            }

            .orbital:nth-child(1) {
                width: 120px;
                height: 120px;
            }

            .orbital:nth-child(2) {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>

<body>
    <!-- Contenedor de partículas para el fondo -->
    <div class="particles" id="particles"></div>

    <!-- Contenedor principal del formulario de login -->
    <div class="login-container" id="login-container">
        <!-- Logo con órbitas -->
        <div class="logo-container">
            <div class="orbital"><span class="orbital-dot" style="top:0; left:50%"></span></div>
            <div class="orbital"><span class="orbital-dot" style="bottom:10%; right:10%"></span></div>
            <div class="logo">
                <i class="fas fa-leaf"></i>
            </div>
        </div>

        <!-- Título principal -->
        <h2>Bienvenido a EcoSense</h2>

        <?php
        // Procesamiento del formulario de inicio de sesión
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['username'];
            $contrasena = $_POST['password'];

            // Incluir archivo de conexión con la base de datos
            include('conexion.php');

            // Preparar la consulta segura
            $sql = "SELECT id, usuario, contrasena FROM usuarios WHERE usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Verificar la contraseña usando password_verify
                if (password_verify($contrasena, $row['contrasena'])) {
                    // Almacenar información del usuario en la sesión
                    $_SESSION['usuario_id'] = $row['id'];
                    $_SESSION['usuario_nombre'] = $row['usuario'];

                    // Mostrar mensaje de éxito antes de redirigir
                    echo "<div class='mensaje mensaje-exito'><i class='fas fa-check-circle'></i> Inicio de sesión exitoso. Redirigiendo...</div>";
                    
                    // Script para redirigir después de un breve delay para mostrar el mensaje
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'dashboard.php';
                            }, 1500);
                         </script>";
                } else {
                    echo "<div class='mensaje mensaje-error'><i class='fas fa-exclamation-circle'></i> Usuario o contraseña incorrectos</div>";
                }
            } else {
                echo "<div class='mensaje mensaje-error'><i class='fas fa-exclamation-circle'></i> Usuario no encontrado</div>";
            }
            // Cerrar la declaración y la conexión
            $stmt->close();
            $conn->close();
        }
        ?>

        <!-- Formulario de inicio de sesión -->    
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="login-form">
            <!-- Campo de usuario con icono y etiqueta flotante -->
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <i class="fas fa-user icon"></i>
                <label for="username">Usuario</label>
            </div>

            <!-- Campo de contraseña con icono, toggle de visibilidad y etiqueta flotante -->
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-lock icon"></i>
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                <label for="password">Contraseña</label>
            </div>

            <!-- Botón de envío con efectos -->
            <button type="submit" id="login-btn">
                <i class="fas fa-sign-in-alt"></i>Iniciar Sesión
            </button>
            
            <!-- Divisor decorativo -->
            <div class="divider">o continúa con</div>
            
            <!-- Opciones de login social (solo visuales) -->
            <div class="social-login">
                <div class="social-btn"><i class="fab fa-google"></i></div>
                <div class="social-btn"><i class="fab fa-facebook-f"></i></div>
                <div class="social-btn"><i class="fab fa-apple"></i></div>
            </div>
            
            <!-- Enlace a registro -->
            <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </form>
    </div>

    <script>
        // Función para crear efecto de partículas en el fondo
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = Math.min(window.innerWidth / 10, 100);
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Tamaño aleatorio entre 2 y 6px
                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Posición inicial aleatoria
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                
                // Opacidad aleatoria
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                
                // Animación con anime.js
                const duration = Math.random() * 30000 + 15000; // Entre 15 y 45 segundos
                
                particlesContainer.appendChild(particle);
                
                anime({
                    targets: particle,
                    left: `${Math.random() * 100}%`,
                    top: `${Math.random() * 100}%`,
                    duration: duration,
                    easing: 'linear',
                    complete: function(anim) {
                        anim.restart();
                    }
                });
            }
        }
        
        // Efecto de movimiento flotante para el contenedor de login
        function floatingEffect() {
            document.addEventListener('mousemove', function (e) {
                const container = document.getElementById('login-container');
                // Calcular posición relativa del mouse
                const mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
                const mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
                
                // Aplicar efecto con un movimiento suave y limitado
                anime({
                    targets: container,
                    translateX: mouseX * 8,
                    translateY: mouseY * 5,
                    duration: 400,
                    easing: 'easeOutCubic'
                });
            });
        }
        
        // Efecto de ripple para el botón
        function createRippleEffect() {
            document.getElementById('login-btn').addEventListener('click', function(e) {
                // Crear el elemento de ripple
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                // Posicionar el ripple donde se hizo clic
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height) * 2;
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${e.clientX - rect.left - (size/2)}px`;
                ripple.style.top = `${e.clientY - rect.top - (size/2)}px`;
                
                // Eliminar el ripple después de la animación
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }
        
        // Toggle de visibilidad de la contraseña
        function passwordToggle() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
                
                // Animación del icono
                anime({
                    targets: this,
                    rotate: type === 'password' ? 0 : 360,
                    duration: 300,
                    easing: 'easeInOutSine'
                });
            });
        }
        
        // Inicializar efectos cuando la página carga
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            floatingEffect();
            createRippleEffect();
            passwordToggle();
            
            // Animación de entrada para el contenedor de login
            anime({
                targets: '.login-container',
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800,
                easing: 'easeOutCubic'
            });
            
            // Animación para los elementos dentro del formulario
            anime({
                targets: ['h2', '.input-group', 'button', '.divider', '.social-login', 'p'],
                opacity: [0, 1],
                translateY: [20, 0],
                delay: anime.stagger(100, {start: 300}),
                duration: 800,
                easing: 'easeOutCubic'
            });
        });
    </script>
</body>
</html>
