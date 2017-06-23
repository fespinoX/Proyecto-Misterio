
<section id="contenedorHome">
	<h1 class="hidden">Prisión &amp; Libertad</h1>

</section>
<section class="section--home--proyecto">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2>El proyecto</h2>
				<p>Con el objetivo de <strong>construir una comunidad en la cual alumnos y profesores convivan en diversos espacios creativos, académicos, profesionales</strong>, y compartiendo las etapas que cada uno transita, Escuela Da Vinci es parte de un proyecto de extensión entre diversos espacios académicos internacionales.</p>
				<p>Bajo la consigna: "PRISION Y LIBERTAD¨, los estudiantes de 4to cuatrimestre de la Carrera de Cine de Animación, serán parte de un proceso de trabajo de manera conjunta y comunitaria, entre la UNSAM y la Universidad de Richmond, Virginia en Estados Unidos.</p>
				<p><strong>El objetivo es desarrollar experiencias audiovisuales</strong>, pudiendo alojar todo el material del proceso en una plataforma de trabajo interactivo donde los alumnos de las diferentes casas de estudio podrán intervenirlo.</p>
			</div>
		</div>
	</div>
</section>

<section class="section--home--videos container">
			<?php
				$consulta_videos = <<<SQL
				SELECT
					IDARTICULO,
					UCASE(TITULO) AS TITULO,
					DESCRIPCION,
					IMG_DESTACADA
				FROM
					articulos
				ORDER BY
					IDARTICULO
					DESC
				LIMIT 3
SQL;

			$r1 = mysqli_query($conexion, $consulta_videos);
			while($array_videos = mysqli_fetch_assoc($r1)){
			?>


		<article class="col-md-4 home__videos">
			<div class="home__videos__img">
				<a href="index.php?s=video&vid=<?php echo $array_videos['IDARTICULO']; ?>"><img src="uploads/<?php echo $array_videos['IMG_DESTACADA'] ?>"></a>
			</div>
			<a href="index.php?s=video&vid=<?php echo $array_videos['IDARTICULO']; ?>"><h3 class="home__videos__title"><?php echo $array_videos['TITULO'] ?></h3></a>
			<p class="home__videos__desc"><?php echo trim_desc($array_videos['DESCRIPCION']) ?></p>
		</article>
		<?php
			}//cierre while
		?>


</section>

<section class="section--home--info">
	<div class="container">
		<div class="row">
			<div class="section--home--info__title col-md-11 col-md-offset-1">
				<h3>La Experiencia</h3>
			</div>
			<div class="col-md-5 col-md-offset-1">
					<iframe width="400" height="200" src="https://www.youtube.com/embed/0J_5nFjUSEE" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="col-md-5">
				<p>Esta experiencia se extiende a otras de las carreras de la Escuela, como Diseño y Programación Web y Mobile, cuyos alumnos programarán la plataforma de documental interactivo, para alojar el contenido que se vaya generando, y Diseño Gráfico quienes realizarán todo el aspecto gráfico de los audiovisuales, y los afiches de cada trabajo. Generando así un verdadero Proyecto Transmedia.</p>
			</div>
		</div>		
	</div>
</section>

<section class="section--home--quote">
	<div class="container">
		<blockquote>
			"Con el objetivo de construir una comunidad en la cual alumnos y profesores convivan en diversos espacios creativos, académicos, profesionales, y compartiendo las etapas que cada uno transita..."
		</blockquote>		
	</div>
</section>

<section class="section--home--otros-videos container">
	<div class="section--home--otros-videos__title">
		<h3>VIDEOS</h3>
	</div>
	<ul class="row">
		<?php
			$consulta_videos = <<<SQL
			SELECT
				IDARTICULO,
				UCASE(TITULO) AS TITULO,
				DESCRIPCION,
				VIDEO,
				IMG_DESTACADA
			FROM
				articulos
			ORDER BY
				IDARTICULO
				DESC
			LIMIT 4
SQL;

		$r2 = mysqli_query($conexion, $consulta_videos);
		while($array_videos = mysqli_fetch_assoc($r2)){
		?>
		<li class="col-md-3">
			<a class="seccion--home--otros-videos__video__img" href="index.php?s=video&vid=<?php echo $array_videos['IDARTICULO']; ?>"><img src="uploads/<?php echo $array_videos['IMG_DESTACADA'] ?>"></a>
			<a href="index.php?s=video&vid=<?php echo $array_videos['IDARTICULO']; ?>"><h4 class="section--home--otros-videos__video__title"><?php echo $array_videos['TITULO'] ?></h4></a>
		</li>
		<?php } ?>
	</ul>

	<p class="seccion--home--otros-videos__ver-todos"><a class="linki" href="?s=videos">Ver todos</a></p>
</section>
