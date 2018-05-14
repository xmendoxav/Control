<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Calificaciones.</title>
</head>
<body>
<div align="center">
	<h1>Calificaciones.</h1>
	<h2>Grupo:  <?php echo $_SESSION['group2']; ?> Materia: <?php echo $this->materia['nom_materia']; ?> Periodo: <?php echo $this->period; ?></h2> 
	<form action="fPDFCalifAlumnos" method="post" target="_blank">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Id Alumno</th>
				<th>Nombre Alumno</th>
				<th>Tipo de Examen</th>
				<th>Calificación</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->infoRepo); $i++) {?>
				<tr>
				 <td><?php echo $this->infoRepo[$i]['id_alumno'] ;?> </td>
				 <td><?php echo $this->infoRepo[$i]['nom_alumno'] ;?> </td>
				 <td><?php echo $this->infoRepo[$i]['tipo_examen'] ;?> </td>
				 <td><?php echo $this->infoRepo[$i]['calificacion'] ;?> </td>
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