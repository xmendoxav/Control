<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Profesor</title>
</head>
<body>

<div align="center">
	<h1>Profesor: <?php echo $_SESSION["S_usr"] ?> --<?php echo $_SESSION["S_period"] ?>-- </h1>
	<form action="fcargaVregistroCalif" method="post">
		<input type="submit" value="Registro de Calificaciones" style="margin-top: 10px; width: 175px;" >
	</form>

	<form action="flistamateriasHorarios" method="post">
		<input type="submit" value="Lista Materias/Horarios" style="margin-top: 10px; width: 175px;">
	</form>

	<form action="flistaAlumnosGrupo" method="post">
		<input type="submit" value="Lista Alumnos/Grupo" style="margin-top: 10px; width: 175px;" >
		<select name="grupo"  id="grupo" > 
			<option selected >Grupo</option>
			<?php
				for ($i=0; $i < count($this->grupos); $i++) {?>
					<option><?php echo $this->grupos[$i]['id_grupo'] ;?></option>
			<?php } ?>
		</select>
	</form>

	<form action="fRepoCalif" method="post">
		<input type="submit" value="Reporte de Calificaciones" style="margin-top: 10px; width: 175px;" >
		<select name="grupo2"  id="grupo2" > 
			<option selected >Grupo</option>
			<?php
				for ($i=0; $i < count($this->grupos); $i++) {?>
					<option><?php echo $this->grupos[$i]['id_grupo'] ;?></option>
			<?php } ?>
		</select>

		<select name="period"  id="period" > 
			<option selected >Periodo</option>
			<option value="2018A" >2018A</option>
			<option value="2017B" >2017B</option>
			<option value="2017A" >2017A</option>
			<option value="2016B" >2016B</option>
			<option value="2016A" >2016A</option>
		</select>

		<select name="tExa"  id="tExa" > 
			<option selected >T. Examen</option>
			<option value="1">Ordinario</option>
			<option value="2" >Extraordinario</option>
			<option value="3" >Titulo</option>
			<option value="4" >Especial</option>
		</select>
	</form>

	<form action="fsalir" method="post">
		<input type="submit" value="Salir" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>
