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
	<h2>Reporte Kardex</h2>
	<h1>Alumno:  <?php echo $_SESSION["S_usr"]; ?> - - -  Id: <?php echo $this->idAlu; ?> - - - - Carrera: <?php echo $this->carrera;?> - - - - Plan: <?php echo $this->plan;?> </h2>
	<form action="fPDFKardex" method="post">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Periodo</th>
				<th>Materia</th>
				<th>Profesor</th>
				<th>Calificación</th>
				<th>Tipo Examen</th>
				<th>Grupo</th>
				<th>Salón</th>
				<th>Horario</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->tiraMaterias); $i++) {?>
				<tr>
				 <td><?php echo $this->tiraMaterias[$i]['periodo'] ;?> </td>
				 <td><?php echo $this->tiraMaterias[$i]['nom_materia'] ;?> </td>
         		 <td><?php echo $this->tiraMaterias[$i]['nom_profesor'] ;?> </td>
         		 <td><?php echo $this->tiraMaterias[$i]['calificacion'] ;?> </td>
         		 <td><?php echo $this->tiraMaterias[$i]['tipo_examen'] ;?> </td>
				 <td><?php echo $this->tiraMaterias[$i]['id_grupo'] ;?> </td>
        		 <td><?php echo $this->tiraMaterias[$i]['id_salon'] ;?> </td>

				 <td> <!--Horario (Dias horas se pintan de una manera diferente)-->
				 	<?php
				 	for ($j=0; $j < count($this->infoH[$i]['dias']); $j++) {?>
				 		<?php echo $this->infoH[$i]['dias'][$j];?>     <?php echo $this->infoH[$i]['h_i'][$j];?>---<?php echo $this->infoH[$i]['h_f'][$j];?><br>

				 	<?php } ?>
				 </td>
			<?php } ?>
				</tr>
  	</table>
  	  </table>

		<input type="submit" value="Generar PDF" style="margin-top: 40px">
	</form>

	<form action="fCargaVAlu" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>
