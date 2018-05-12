<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Salones</title>
</head>
<body>
<div align="center">
	<h1>Salones: <?php echo $_SESSION["S_period"]; ?> </h2>
	<form action="fPDFRepoSalon" method="post">
		<table align="center" class="table table-condensed">
			<tr>
				<th>Salón</th>
				<th>Materia</th>
				<th>Grupo</th>
				<th>Profesor</th>
				<th>Horario</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->salonesPeriod); $i++) {?>
				<tr>

				 <td><?php echo $this->salonesPeriod[$i]['id_salon'] ;?> </td>
				 <td><?php echo $this->salonesPeriod[$i]['nom_materia'] ;?> </td>
        		 <td><?php echo $this->salonesPeriod[$i]['id_grupo'] ;?> </td>
        		 <td><?php echo $this->salonesPeriod[$i]['nom_profesor'] ;?> </td>

				 <td> <!--Horario (Dias horas se pintan de una manera diferente, un poco rara xD)-->
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

	<form action="fCargaVadministrador" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>