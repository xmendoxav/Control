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
	<h1>Inscripción</h1>
	<form action="fInscribeAlu" method="post">
		<table align="center" class="table table-condensed">
			<tr>
				<th>---</th>
				<th>Materia</th>
				<th>Profesor</th>
				<th>Grupo</th>
				<th>Salón</th>
				<th>Horario</th>
  	  </tr>
			<?php
				for ($i=0; $i < count($this->info); $i++) {?>
				<tr>
				 <td><input type="checkbox" value="<?php echo $this->info[$i]['id_materia'];?>, <?php echo $this->info[$i]['id_profesor'] ;?>, <?php echo $this->info[$i]['id_grupo'] ;?>, <?php echo $this->info[$i]['salon'];?> " name="opt[]"></td>
				 <td><?php echo $this->info[$i]['id_materia'] ;?> </td>
				 <td><?php echo $this->info[$i]['id_profesor'] ;?> </td>
				 <td><?php echo $this->info[$i]['id_grupo'] ;?> </td>
				 <td><?php echo $this->info[$i]['salon'] ;?> </td>
				 <td> <!--Horario (Dias horas se pintan de una manera diferente)-->
				 	<?php
				 	for ($j=0; $j < count($this->info[$i]['dias']); $j++) {?>
				 		<?php echo $this->info[$i]['dias'][$j];?>---<?php echo $this->info[$i]['h_i'][$j];?>---<?php echo $this->info[$i]['h_f'][$j];?><br>
				 		
				 	<?php } ?>
				 </td>
			<?php } ?>
				</tr>
  	</table>
  	  </table>

		<input type="submit" value="Terminar" style="margin-top: 40px">
	</form>

	<form action="fCargaVAlu" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>

</div>

</body>
</html>

