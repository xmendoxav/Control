<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>

<div align="center">
	<h1>Administrador:  <?php echo $_SESSION["S_usr"] ?> --<?php echo $_SESSION["S_period"] ?>--</h1>

	<form action="fAgregaCarrera" method="post">
		<input type="submit" value="Agregar Carrera" style="margin-top: 10px; width: 115px;" >
	</form>

	<form action="fCargaVAgregarUsr" method="post">
		<input type="submit" value="Agregar Usuario" style="margin-top: 10px; width: 115px;">
	</form>

	<form action="fCatalogos" method="post">
		<input type="submit" value="Catalogos" style="margin-top: 10px; width: 115px;" >
	</form>

	<form action="fcargaCreaGrupo" method="post">
		<input type="submit" value="Crear Grupo" style="margin-top: 10px; width: 115px;" >
	</form>

	<form action="fRepoMateriasProfe" method="post">
		<input type="submit" name="periodo" value="Reporte Materias/Profesor" style="margin-top: 10px; width: 135px;" >
		<select name="periodo"  id="periodo" > 
			<option selected >Periodo</option>
			<option value="2018A" >2018A</option>
			<option value="2017B" >2017B</option>
			<option value="2017A" >2017A</option>
		</select>
	</form>

	<form action="fRepoSalon" method="post">
		<input type="submit" value="Reporte Salon" style="margin-top: 10px; width: 135px;" >
		<select name="periodo2"  id="periodo2" > 
			<option selected >Periodo</option>
			<option value="2018A" >2018A</option>
			<option value="2017B" >2017B</option>
			<option value="2017A" >2017A</option>
		</select>
	</form>

	<form action="fBackUp">
		<input type="submit" value="Respaldar Base" style="margin-top: 20px; width: 115px; color: red" >
	</form>

	<form action="fRestore" method="post" >
		<label style="margin-top: 20px; color: red" >Restaurar Base: </label><br>
		<input type="file" value="Seleccionar Archivo ... " style=" width: 300px; color: red" name="file">
		<input type="submit" value="Restaurar" style="margin-top: 10px; width: 125px; color: red" >
	</form>

	<form action="fsalir" method="post">
		<input type="submit" value="Salir" style="margin-top: 20px; width: 115px;" >
	</form>

	<!--<form method="post" action="fRestore" enctype="multipart/form-data">
    	<input type="file" name="archivo"><br>
    	<input type="submit" value="Enviar">
	</form-->

</div>

</body>
</html>
