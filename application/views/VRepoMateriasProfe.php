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
	<h1>Materias, Profesores Periodo:  <?php echo $_SESSION["S_period"]; ?></h1>
	<form action="fPDFMateriasProfesPeriodo" method="post">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Id Materia</th>
				<th>Materia</th>
				<th>Profesor</th>
				<th>Grupo</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->materiasPeriod); $i++) {?>
				<tr>

				 <td><?php echo $this->materiasPeriod[$i]['id_materia'] ;?> </td>
				 <td><?php echo $this->materiasPeriod[$i]['nom_materia'] ;?> </td>
				 <td><?php echo $this->materiasPeriod[$i]['nom_profesor'] ;?> </td>
        		 <td><?php echo $this->materiasPeriod[$i]['id_grupo'] ;?> </td>

			<?php } ?>
				</tr>
  	</table>
  	  </table>

		<input type="submit" value="Generar PDF" style="margin-top: 40px">
	</form>

	<form action="fCargaVadministrador" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>