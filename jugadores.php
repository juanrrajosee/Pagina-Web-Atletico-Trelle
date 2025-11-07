<?php $activePage = 'jugadores'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores - Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="jugadores.css">
</head>
<body>
    <?php include __DIR__.'/includes/header.php'; ?>

    <main>
        <h2 class="page-title">Atlético Trelle - Jugadores</h2>

        <section class="jugadores">
            <div class="jugador">
                <img src="./ImagenesJugadores/xoelygubi.jpg" alt="Entrenadores">
                <h3>Iker Gabeiras y Xoel Cid</h3>
                <p>Entrenadores</p>
                <a href="#">Ver perfil</a>
            </div>

            <div class="jugador">
                <img src="./ImagenesJugadores/adrian.png" alt="adrian">
                <h3>Adiran Rodriguez</h3>
                <p>Posición: Lateral Izquierdo</p>
                <a href="#">Ver perfil</a>
            </div>

            <div class="jugador">
                <img src="./ImagenesJugadores/altamira.png" alt="altamira">
                <h3>Adrian Altamira</h3>
                <p>Posición: Central/Lateral Derecho</p>
                <a href="#">Ver perfil</a>
            </div>

            <div class="jugador">
                <img src="./ImagenesJugadores/anxo.png" alt="anxo">
                <h3>Anxo</h3>
                <p>Posición: Mediocentro</p>
                <a href="#">Ver perfil</a>
            </div>

            <!-- 🔽 Mantén aquí el resto de tarjetas de jugadores exactamente como las tenías en jugadores.html -->
            <!-- ... -->
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
