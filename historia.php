<?php 
session_start();
$activePage = 'historia'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historia y Directiva - Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css"/>
  <link rel="stylesheet" href="historia.css"/>
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main>
    <section class="seccion">
      <h2>Historia del pueblo y del club</h2>
      <p>
        La parroquia de <strong>Trelle</strong> (nombre oficial: <em>Nosa Señora dos Anxos de Trelle</em>) pertenece al 
        municipio de <strong>Toén</strong>, en la provincia de <strong>Ourense</strong> (Galicia). Está formada por dos 
        entidades de población: <em>Trelle</em> y <em>Trellerma</em>. El nombre refleja la tradición local gallega y, en gallego, 
        puede aparecer como “Trelle” o “Parroquia de Trelle”.
      </p>
      <p>
        Históricamente, como muchas parroquias gallegas, Trelle se desarrolló alrededor de su iglesia parroquial, 
        que servía como eje religioso y social. La economía rural y la agricultura fueron la base de su desarrollo 
        durante siglos, consolidando un fuerte sentimiento de comunidad y cooperación entre sus habitantes.
      </p>
      <p>
        Este espíritu comunitario es el que inspiró la creación del <strong>Atlético Trelle</strong>, un club que 
        representa la identidad del pueblo, la unión vecinal y el orgullo de pertenecer a una tierra con raíces y valores sólidos.
      </p>
    </section>

    <section class="seccion">
      <h2>¿Por qué se creó?</h2>
      <p>
        El <strong>Atlético Trelle</strong> nació con la vocación de representar a su parroquia y a sus vecinos en el mundo del fútbol. 
        Inspirado por la lucha, la unidad y el orgullo local, el club pretende reivindicar a Trelle como un referente 
        deportivo y social dentro de la provincia de Ourense.
      </p>
      <p>
        Desde sus comienzos, el club ha destacado por:
      </p>
      <ul>
        <li>Ofrecer un punto de encuentro para jóvenes y adultos, fomentando valores como el trabajo en equipo y el compromiso.</li>
        <li>Servir de vínculo entre la tradición rural de Trelle y el deporte moderno, representando el espíritu del pueblo.</li>
        <li>Apostar por el desarrollo deportivo local, apoyando a nuevos talentos y fortaleciendo la identidad colectiva.</li>
      </ul>
    </section>

    <section class="seccion">
      <h2>Directiva y valores</h2>
      <p>
        Además del componente deportivo, el club cuenta con una <strong>directiva comprometida</strong> con su entorno. 
        Formada por vecinos de la parroquia, su objetivo es que el club sea una herramienta de cohesión social y de 
        promoción del deporte base.
      </p>
      <p>
        La filosofía del Atlético Trelle se basa en tres pilares:
      </p>
      <ul>
        <li><strong>Cultura del esfuerzo:</strong> fomentar la disciplina y el compromiso diario.</li>
        <li><strong>Compromiso comunitario:</strong> mantener el club como símbolo de unión vecinal.</li>
        <li><strong>Inclusión y futuro:</strong> abrir las puertas a todos los públicos, apoyando la participación juvenil y femenina.</li>
      </ul>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
