<?php
	include("../../setup/config.php");

	$titulo = $_POST['titulo'];
	$descripcion = $_POST['descripcion'];
	$video = $_FILES['video'];
	$video_nombre = $_FILES['video']['name'];
	$categoria = $_POST['categoria'];
	$chucheria = $_POST['chucheria'];
	$imagenes = $_FILES['imagenes'];
	$imagen_destacada = $_FILES['imagen_destacada'];
	$imagen_destacada_nombre = $_FILES['imagen_destacada']['name'];
	$autor = $_SESSION['IDUSUARIOS'];
	
	/*
	*
	* ----- COMIENZA LA DOCUMENTACIÓN SOBRE LOS INPUT FILE MULTIPLES -----
	*
	*/
	/* Este if es solo para asegurarme de haber recibido un dato. Por si las moscas */
	if($imagenes['size'] > 0){
		/* Lo primero que tengo que hacer, es saber si me llegó algo. Y como el comportamiento natural del $_FILES es tomar un solo archivo, pregunto si me llegó más de uno con is_array(). */
		if(is_array($imagenes['name'])){
			/* Si tengo un array, lo voy a recorrer, porque por defecto, el $_FILES se queda con el último archivo cargado */
			for($i = 0; $i < count($imagenes['name']); $i++){
					/* Cuando los recorro creo un array propio donde voy a ir guardando el nombre de cada archivo, físico y temporal (Esto lo voy a necesitar más adelante )*/
					$archivos[] = array(
							'name' => $imagenes['name'][$i],
							'tmp_name' => $imagenes['tmp_name'][$i]
					);
			}
		} else {
			/* Si no me llegó más de un archivo, igualmente creo el array y meto el único archivo que me llegó. Esto lo hago porque después uso un foreach que me sirve para mostrar si tengo uno o tengo 100 archivos. Optimizo el uso de estructuras */
			$archivos[] = $imagenes;
		}

		/* Esta variable $i la estoy usando solamente porque si me llega más de un archivo necesito que tengan alguna diferencia en el nombre */
		$i = 0;

		/* Recorro mi array donde fui guardando todo lo que cargó el usuario */
		foreach ($archivos as $foto) {
			/* Tomo el nombre de cada imagen y lo guardo en una variable */
			$foto_nombre = $foto['name'];
			/* Le saco la extensión */
			$extensiones = pathinfo($foto_nombre, PATHINFO_EXTENSION);
			/*
				- La variable $i: Me va a servir para que, por ejemplo, todas las fotos del ID 15 no se llamen 15_imagenes_TITULO.jpg, porque se pisarían, entonces se van a llamar  150_imagenes_TITULO.jpg, 151_imagenes_TITULO.jpg, 152_imagenes_TITULO.jpg, etc. Esto obviamente lo podemos cambiar para que quede de la manera que queramos.
			*/
			$foto_nombre = $i . "_imgs_" . time() . "." . $extensiones;
			/* Hago el move_uploaded_file para guardar la foto en nuestras carpetas */
			move_uploaded_file($foto['tmp_name'], "../../uploads/$foto_nombre");
			/* Incremento la $i para que cambie según la foto */
			$i++;
			$archivos_final[] = $foto_nombre;
		}

		$insertar = implode(',', $archivos_final);
	}

	/*
	*
	* ----- FIN DE LA DOCUMENTACIÓN SOBRE LOS INPUT FILE MULTIPLES -----
	*
	*/

	$er_titulo = "/^[a-z0-9-\.*\s]{5,80}$/i";
	$txt_titulo = preg_match($er_titulo, $titulo, $coincidencia_titulo);

	if($categoria && $chucheria && $titulo && $descripcion && $imagen_destacada){
		if($video['size'] > 0){
			$extension = pathinfo($video_nombre, PATHINFO_EXTENSION);
			$video_nombre = "video_" . time() . '.' . $extension;
			move_uploaded_file($video['tmp_name'], "../../uploads/$video_nombre");
		}

		if($imagen_destacada['size'] > 0){
			$extension_img = pathinfo($imagen_destacada_nombre, PATHINFO_EXTENSION);
			/*if($extension_img == 'jpg' || $extension_img == 'jpeg'){
				$original = imagecreatefromjpeg($imagen_destacada['tmp_name']);
				$ancho_original = imagesx($original);
				$alto_original = imagesy($original);

				$ancho = 555;
				$alto = round($ancho * $alto_original / $ancho_original);

				$nueva = imagecreatetruecolor($ancho, $alto);

				imagecopyresampled(
					$nueva, $original,
					0, 0,
					0, 0,
					$ancho, $alto,
					$ancho_original, $alto_original
				);
				imagejpeg($nueva, "../../uploads/$imagen_destacada_nombre", 100);
			}
			*/
			$imagen_destacada_nombre = "img_" . time() . "." . $extension_img;
			move_uploaded_file($imagen_destacada['tmp_name'], "../../uploads/$imagen_destacada_nombre");
		}

		$c = "INSERT INTO
			articulos
		SET
			TITULO = '$titulo',
			DESCRIPCION = '$descripcion',
			VIDEO = '$video_nombre',
			IMG_DESTACADA = '$imagen_destacada_nombre',
			A_ESTADO = '1',
			FECHA_ALTA = NOW(),
			FKCHUCHERIA = '$chucheria',
			FKUSUARIO = '$autor'";		

		if($extensiones != ''){
			$c .= ", IMAGENES  = '$insertar'";
		}		

		if(mysqli_query($conexion, $c)){

			$art_id = mysqli_insert_id($conexion);
			
			foreach($categoria as $cat) {
				$c2 = "INSERT INTO
					articulos_categorias
				SET
					FKARTICULO = '$art_id',
					FKCATEGORIA = '$cat' ";

				mysqli_query($conexion, $c2);
			}
		}
		
		$rta = 'ok';
		header("Location: ../index.php?s=posts_listado&m=$rta");
	} else {
		$c = 'falló';
		$rta = 'error';
		header("Location: ../index.php?s=agregar_post&m=$rta");
	}

	echo mysqli_error($conexion);
?>
