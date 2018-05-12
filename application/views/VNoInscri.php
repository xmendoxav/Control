<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
</head>
<body>
<form method= "post" action="fCargaVAlu">
	<h1 align="center">¡El alumno <?php echo $_SESSION["S_usr"]; ?> NO tiene inscripciones en el periodo <?php echo $_SESSION["S_period"]; ?>!</h1>
	<table align="center">
		<tr>
			<td style="padding:10px;">
				<input type="submit" value="Regresar"> 
  	  		</td> 
 </form>
</tr>
</table>
</body>
</html>
