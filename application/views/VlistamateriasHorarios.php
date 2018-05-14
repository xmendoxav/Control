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
	<h1>Profesor:  <?php echo $_SESSION["S_usr"]; ?> Periodo: <?php echo $_SESSION["S_period"]; ?> </h2>
	<form action="fPDFMateriasHorarios" method="post"  target="_blank">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Id Materia</th>
				<th>Nombre materia</th>
				<th>Salon</th>
				<th>Horario</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->materiasProfe); $i++) {?>
				<tr>

				 <td><?php echo $this->materiasProfe[$i]['id_materia'] ;?> </td>
				 <td><?php echo $this->materiasProfe[$i]['nom_materia'] ;?> </td>
        		 <td><?php echo $this->materiasProfe[$i]['id_salon'] ;?> </td>

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

	<form action="fCargaVProfe" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>
