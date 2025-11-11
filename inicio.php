<?php $activePage = 'inicio'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlético Trelle - Inicio</title>
    <link rel="stylesheet" href="inicio.css">
</head>
<body>
    <?php include __DIR__.'/includes/header.php'; ?>

    <section class="hero-slider" aria-label="Imágenes destacadas del club">
        <div class="slider-track">
            <div class="slide"><img src="ImagenesInicio/imagen_portada.JPG" alt="Plantilla del Atlético Trelle"></div>
            <div class="slide"><img src="ImagenesInicio/foto_en_la_iglesia.jpg" alt="Presentación del club"></div>
            <div class="slide"><img src="ImagenesInicio/trellevsbarco.jpg" alt="Cartel del próximo partido"></div>
            <div class="slide"><img src="GaleriaImagenes/IMG3.JPG" alt="Jugadores celebrando un gol"></div>
            <div class="slide"><img src="GaleriaImagenes/IMG7.JPG" alt="Afición animando al Atlético Trelle"></div>
        </div>
    </section>

    <main class="inicio-layout">
        <section class="news-column" aria-labelledby="titulo-noticias">
            <h2 id="titulo-noticias" class="column-title">Últimas noticias</h2>

            <article class="noticia">
                <img src="./ImagenesInicio/foto_en_la_iglesia.jpg" alt="Atlético Trelle resucita">
                <h3>Cinco jóvenes resucitan el Atlético Trelle por amor al fútbol</h3>
                <p>Un grupo de jóvenes ha devuelto a la vida al Atlético Trelle, un histórico equipo ourensano, con el objetivo de competir nuevamente y mantener viva la pasión por el fútbol en la comunidad.</p>
                <a href="https://www.lavozdegalicia.es/noticia/ourense/toen/2023/07/31/cinco-jovenes-resucitan-atletico-trelle-amor-futbol/0003_202307O31C5991.htm" target="_blank" rel="noopener">
                    Leer más en La Voz de Galicia
                </a>
            </article>

            <article class="noticia">
                <h3>Próximo partido: CD Barco "B" vs Atlético Trelle</h3>
                <img src="./ImagenesInicio/trellevsbarco.jpg" alt="Cartel del partido">
                <p>El Atlético Trelle se enfrentará al CD Barco "B" el sábado 5 de octubre de 2024 a las 17:00 en el Campo Municipal do Campiño (Viloria).</p>
            </article>
        </section>

        <aside class="instagram-column" aria-labelledby="titulo-instagram">
            <h2 id="titulo-instagram" class="column-title">Últimos posts en Instagram</h2>
            <div class="instagram-feed">
                <blockquote class="instagram-media"
                    data-instgrm-captioned
                    data-instgrm-permalink="https://www.instagram.com/p/DPetKyqiKFZ/?utm_source=ig_embed&amp;utm_campaign=loading"
                    data-instgrm-version="14"
                    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin:1px; max-width:540px; min-width:326px; padding:0; width:99.375%;">
                    ...
                </blockquote>

                <blockquote class="instagram-media"
                    data-instgrm-captioned
                    data-instgrm-permalink="https://www.instagram.com/p/DPPMqS4CP-6/?utm_source=ig_embed&amp;utm_campaign=loading"
                    data-instgrm-version="14"
                    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin:1px; max-width:540px; min-width:326px; padding:0; width:99.375%;">
                    ...
                </blockquote>

                <blockquote class="instagram-media"
                    data-instgrm-captioned
                    data-instgrm-permalink="https://www.instagram.com/p/DO5P0nSCnA6/?utm_source=ig_embed&amp;utm_campaign=loading"
                    data-instgrm-version="14"
                    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin:1px; max-width:540px; min-width:326px; padding:0; width:99.375%;">
                    ...
                </blockquote>
            </div>
        </aside>
    </main>
    
    <footer>
        <p>&copy; 2025 Atlético Trelle - Todos los derechos reservados</p>
    </footer>

    <script async src="https://www.instagram.com/embed.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const slider = document.querySelector('.hero-slider');
      if (!slider) return;

      const track = slider.querySelector('.slider-track');
      const slides = Array.from(track.children);
      if (slides.length <= 1) {
        return;
      }

      const totalSlides = slides.length;

      const firstClone = slides[0].cloneNode(true);
      const lastClone = slides[totalSlides - 1].cloneNode(true);
      track.appendChild(firstClone);
      track.insertBefore(lastClone, track.firstElementChild);

      let index = 1;
      let isSliding = false;
      let autoTimer = null;
      const interval = 3500;

      function setPosition(instant = false) {
        track.style.transition = instant ? 'none' : 'transform 0.7s ease';
        track.style.transform = `translateX(-${index * 100}%)`;
        if (instant) {
          void track.offsetWidth;
        }
      }

      function moveTo(newIndex) {
        if (isSliding) return;
        isSliding = true;
        index = newIndex;
        setPosition(false);
      }

      function startAuto() {
        stopAuto();
        autoTimer = setInterval(() => moveTo(index + 1), interval);
      }

      function stopAuto() {
        if (autoTimer) {
          clearInterval(autoTimer);
          autoTimer = null;
        }
      }

      setPosition(true);
      startAuto();

      track.addEventListener('transitionend', () => {
        if (index === totalSlides + 1) {
          index = 1;
          setPosition(true);
        } else if (index === 0) {
          index = totalSlides;
          setPosition(true);
        }
        isSliding = false;
      });

      slider.addEventListener('mouseenter', stopAuto);
      slider.addEventListener('mouseleave', startAuto);
    });
    </script>
</body>
</html>
