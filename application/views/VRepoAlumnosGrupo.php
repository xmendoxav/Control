<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Materias, Profesores</title>
</head>
<body>
<div align="center">
	<h1>Alumnos del Grupo:  <?php echo $_SESSION['group']; ?> del Profesor <?php echo $_SESSION['S_usr']; ?></h1>
	<form action="fPDFAlumnosGrupo" method="post">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Id Alumno</th>
				<th>Nombre Alumno</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->alumnos); $i++) {?>
				<tr>
				 <td><?php echo $this->alumnos[$i]['id_alumno'] ;?> </td>
				 <td><?php echo $this->alumnos[$i]['nom_alumno'] ;?> </td>
			<?php } ?>
				</tr>
  	</table>
  	  </table>

		<input type="submit" value="Generar PDF" style="margin-top: 40px">
	</form>

	<form action="fCargaVProfe" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>

