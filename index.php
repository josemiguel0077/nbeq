<?php

function crear_hash(){
	$key = '';
	$numeros = range(0, 9);
	$letras = range('a', 'z');
	$keys = array_merge($numeros, $letras);
	for($i = 0; $i < 6; $i++){
		$key .= $keys[array_rand($keys)];
	}
	return $key;
}

if(!empty($_POST['cantidad']) 
&& !empty($_FILES['index'])){
	
	$links = '';
	$cantidad = $_POST['cantidad'];
	$index = $_FILES['index']['tmp_name'];
	$dominio = 'https://'.$_SERVER['SERVER_NAME'];

	for($i = 0; $i < $cantidad; $i++){
		
		$hash = crear_hash();
		$datos = file_get_contents($index);
		
		file_put_contents($hash, $datos);
		$links .= $dominio.'/'.$hash.PHP_EOL;
		
	}
	
	if(!empty($links)){
		
		$length = strlen($links);
		$filename = crear_hash();
		$filename = $filename.'.txt';
		
		header('Content-Length: '.$length);
		header('Content-Type: text/plain');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename='.$filename);
		
		die($links);
		
	}
	
}

?>

<!doctype html>
<html lang="es">
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
	
	<title>Generador de Links</title>
	
	<link rel="stylesheet" href="https://bootswatch.com/3/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
	
	<style>
	body { 
	    padding-top: 70px;
		background-color: #f1f1f1;
	}
	
	.navbar-inverse {
		background-color: #000000;
		border-color: #000000;
	}
	
	.navbar-inverse .navbar-brand {
		width: 100%;
		color: #ffffff;
		text-align: center;
	}
	
	.navbar-inverse .navbar-header {
		width: 100%;
	}
	
	.container {
		width: 100%;
		max-width: 400px;
		text-align: center;
	}
	
	.form-control {
		height: auto;
	}
	</style>

</head>
<body>
	
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Generador de Links</a>
		</div>
	</div>
</nav>

<div class="container">
	
	<form action="" method="post" 
	enctype="multipart/form-data" autocomplete="off">
	
		<div class="panel panel-default">
			<div class="panel-body">
		  
				<div class="form-group">
					<label class="control-label">Cantidad de links</label>
					<input type="number" name="cantidad" class="form-control" required>
				</div>
				
				<div class="form-group">
					<label class="control-label">Selecciona el index.html</label>
					<input type="file" name="index" class="form-control" required>
				</div>
				
			</div>
			
			<div class="panel-footer">
			    <button class="btn btn-block btn-primary">
					<strong>Generar Links</strong>
				</button>
			</div>
			
		</div>
		
	</form>

</div>

</body>
</html>
