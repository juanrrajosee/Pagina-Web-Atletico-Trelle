<?php
session_start();
$activePage = 'galeria';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="galeria.css">
</head>

<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>
        <h2 class="page-title">Atlético Trelle - Galería</h2>
        <section class="galeria">
            <!-- Lista completa de imágenes con enlaces a lightbox -->
            <div class="imagen"><a href="#img1"><img src="./GaleriaImagenes/IMG1.webp" alt="Foto 1"></a></div>
            <div class="imagen"><a href="#img2"><img src="./GaleriaImagenes/IMG2.webp" alt="Foto 2"></a></div>
            <div class="imagen"><a href="#img3"><img src="./GaleriaImagenes/IMG3.webp" alt="Foto 3"></a></div>
            <div class="imagen"><a href="#img4"><img src="./GaleriaImagenes/IMG4.webp" alt="Foto 4"></a></div>
            <div class="imagen"><a href="#img5"><img src="./GaleriaImagenes/IMG5.webp" alt="Foto 5"></a></div>
            <div class="imagen"><a href="#img6"><img src="./GaleriaImagenes/IMG6.webp" alt="Foto 6"></a></div>
            <div class="imagen"><a href="#img7"><img src="./GaleriaImagenes/IMG7.webp" alt="Foto 7"></a></div>
            <div class="imagen"><a href="#img8"><img src="./GaleriaImagenes/IMG8.webp" alt="Foto 8"></a></div>
            <div class="imagen"><a href="#img9"><img src="./GaleriaImagenes/IMG9.webp" alt="Foto 9"></a></div>
            <div class="imagen"><a href="#img10"><img src="./GaleriaImagenes/IMG10.webp" alt="Foto 10"></a></div>
            <div class="imagen"><a href="#img11"><img src="./GaleriaImagenes/IMG11.webp" alt="Foto 11"></a></div>
            <div class="imagen"><a href="#img12"><img src="./GaleriaImagenes/IMG12.webp" alt="Foto 12"></a></div>
        </section>

        <!-- Lightbox para cada imagen -->
        <div class="lightbox" id="img1"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG1.webp"
                alt="Foto 1"></div>
        <div class="lightbox" id="img2"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG2.webp"
                alt="Foto 2"></div>
        <div class="lightbox" id="img3"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG3.webp"
                alt="Foto 3"></div>
        <div class="lightbox" id="img4"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG4.webp"
                alt="Foto 4"></div>
        <div class="lightbox" id="img5"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG5.webp"
                alt="Foto 5"></div>
        <div class="lightbox" id="img6"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG6.webp"
                alt="Foto 6"></div>
        <div class="lightbox" id="img7"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG7.webp"
                alt="Foto 7"></div>
        <div class="lightbox" id="img8"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG8.webp"
                alt="Foto 8"></div>
        <div class="lightbox" id="img9"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG9.webp"
                alt="Foto 9"></div>
        <div class="lightbox" id="img10"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG10.webp"
                alt="Foto 10"></div>
        <div class="lightbox" id="img11"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG11.webp"
                alt="Foto 11"></div>
        <div class="lightbox" id="img12"><a href="#" class="close">&times;</a><img src="./GaleriaImagenes/IMG12.webp"
                alt="Foto 12"></div>
    </main>

    <footer>
        <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
    </footer>
</body>

</html>