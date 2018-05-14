
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$this->load->view('librerias');
	?>
	<meta charset="utf-8">
	<title>Profesor</title>
</head>

<script type="text/javascript" src="/CodeIgSistemaCE/js/jquery-3.3.1.min.js">
</script>
<script type="text/javascript">

$(document).ready(function() {
var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
var container = $(document.createElement('div')).css({
padding: '15px', margin: '30px', width: '200px',
borderTopColor: '#999', borderBottomColor: '#999',
borderLeftColor: '#999', borderRightColor: '#999'
});

$('#btAdd').click(function() {
if (iCnt <= 19) {

iCnt = iCnt + 1;


$(container).append('<tr><td>Día: <select class="form-control" name="dias[]" style="width: 130px" required ><option></option><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option><option>Sábado</option></select></td> <td>H.I: <input style="margin-left: 25px; width: 90px"  type="time" class="form-control" name="H_I[]" required ></td><td>H.F: <input style="margin-left: 25px; width: 90px" type="time" class="form-control" name="H_F[]" required ></td></tr>');

//<tr> <td> <label id=tb'+iCnt+' style="margin-left: 150px;" >Elige el producto: '+iCnt+' </label><select  class="form-control" name="dias[]"><option value="--" class="form-control">---</option></select></td> <td align="center" style="padding:10px;"> <label id=tb'+iCnt+' style="margin-left: 250px;" >Cantidad: </label> <input type="number"  style="margin-left: 250px;" min=1 class="form-control" name="cantArts[]"> </td> </tr>

if (iCnt == 1) {

var divSubmit = $(document.createElement('div'));
$(divSubmit).append('');
}

$('#main').after(container, divSubmit);
}
else { //se establece un limite para añadir elementos, 20 es el limite

$(container).append('<label>Limite Alcanzado</label>');
$('#btAdd').attr('class', 'bt-disable');
$('#btAdd').attr('disabled', 'disabled');

}
});

$('#btRemove').click(function() { // Elimina un elemento por click
	if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
	if (iCnt == 0) { $(container).empty();
		$(container).remove();
		$('#btSubmit').remove();
		$('#btAdd').removeAttr('disabled');
		$('#btAdd').attr('class', 'bt')
	}
});



$('#btRemoveAll').click(function() { // Elimina todos los elementos del contenedor

$(container).empty();
$(container).remove();
$('#btSubmit').remove(); iCnt = 0;
$('#btAdd').removeAttr('disabled');
$('#btAdd').attr('class', 'bt');

});
});

// Obtiene los valores de los textbox al dar click en el boton "Enviar"
var divValue, values = '';

function GetTextValue() {

$(divValue).empty();
$(divValue).remove(); values = '';

$('.input').each(function() {
divValue = $(document.createElement('div')).css({
padding:'5px', width:'200px'
});
values += this.value + '<br />'
});

$(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
$('body').append(divValue);

}

function hacer_click(){
	var datos = document.getElementById('seleccion').value;
	var profe = document.getElementById('profe').value;
	//var id_materia = document.getElementById('materia').value;
	//var id_grupo = document.getElementById('seleccion').value;
	console.log(datos,profe);
	$.ajax({
        type: "GET",
        url: "Control/application/controllers/ControladorPrincipal/obtenAlumnos",
        contenttype: "application/json; charset=utf-8",
        data: {
        	'seleccion': 	datos,
        	'profe'    : 	profe
        },
        success: function (result) {
        	console.log("recibiendo");
        	$('#resultado').html(response);
            //Hacer algo con el resultado en caso que la petición haya sido exitosa
        },
        error: function (jqXHR, textStatus, errorThrown) {
        	alert('error:'+jqXHR);
            //Hacer algo con el resultado en caso que la petición haya fallado
        }
    });
}

$(document).ready(function(){
	$("#boton").click(function(){
		var profe = $('#profe').val();
		var datos = $('#seleccion').val();
		console.log(profe, datos);
		$.post("Control/application/controllers/ControladorPrincipal/obtenAlumnos",{profesor: profe, datosGrupo:datos}, function(datos){
			$("#resultado2").html(datos);
		});
	});
});


function mostrarAlumnos(){
	var datos = document.getElementById('seleccion').value;
	var profe = document.getElementById('profe').value;

	$.ajax({
		url:"http://localhost/CodeIgSistemaCE/index.php/ControladorPrincipal/obtenAlumnos",
		type:"POST",
		data:{datosProfe:datos, profesor:profe}, 
		success: function(respuesta){
			//alert(respuesta);
			respuestaGlobal = respuesta;

			registros = eval(respuesta);

			if (registros!=""){

			
			html = "<form action = "+"agregaCalificaciones"+" method="+"post"+"><table class='table table-responsive table-bordered'><thead>";
			html +="<tr><th align="+"center"+">Nombre</th><th>Numero de cuenta</th><th>Examen</th><th>Calificacion</th></th>";//nombre de los campos a mostrar
			html += "</thead><tbody>";
			for (var i=0; i<registros.length; i++){
				html+="<tr> <input type = "+ "text "+" id  = "+"id_alumno "+" name = "+"id_alumno[] "+" value = "+registros[i]["id_alumno"]+" style = "+"visibility:hidden"+"> <input type = "+ "text "+" id  = "+"id_grupo "+" name = "+"id_grupo"+" value = "+registros[i]["id_grupo"]+" style = "+"visibility:hidden"+"> <td>"+registros[i]["nom_alumno"]+"</td>  <td>"+registros[i]["id_alumno"]+"</td><td><select id= "+"examen "+"name="+"examen[] "+" class="+"form-control"+"><option id="+"tipo_examen "+" name="+"tipo_examen"+" class="+"form-control"+" value = "+"1"+">Ordinario</option> <option id="+"tipo_examen"+" name="+"tipo_examen"+" class="+"form-control"+" value = "+"2"+">Extra</option><option id="+"tipo_examen"+" name="+"tipo_examen"+" class="+"form-control"+" value = "+"3"+">Titulo</option> <td><input type="+"text"+" name= "+"calificacion[]"+" id="+"calificacion"+" class="+"form-control"+"></td> ";
			}}else{
				html+="<tr> <td>No se encontraron registros</td> </tr>";
			}

			html += "</body></table><input type = "+"submit"+" value = "+"Guardar"+" class = "+"form-control"+" > <form action="+"fcargaVistaProfe"+" method="+"post"+"><input type="+"submit"+" class = "+"form-control"+" ></form> </form>";
			$("#muestraDatos").html(html);

		}
	})

}
function agregaralumno(){
	//alert(respuestaGlobal);d
	var examen = document.getElementById('examen').value;
	var calificacion = document.getElementById('calificacion').value;
	alert(examen);
}
</script>
<body>

<div align="center">
	<h1>Registrar Calificaciones</h1>
	<form action="fRegistraCalif" method="post" id="formulario">
		<table align="center">
		<tr>
			<td><label>Profesor: </label></td>
			<td style="padding:10px;">
				<input readonly name="profe" id="profe" class="form-control" type="text" value="<?php echo $_SESSION["S_usr"]?>">
  	  		</td>
  	  		<td><label>Materia: </label></td>
  	  		<td style="padding:10px;">
				<select id= "seleccion"name="materia" class="form-control" required>
					
					<?php
						for ($i=0; $i < count($this->materiasProfe); $i++) {?>
						<option id="id_grupo" name="id_grupo" class="form-control"><?php echo $this->materiasProfe[$i]['id_grupo']."-".$this->materiasProfe[$i]['nom_materia'];?></option>
					<?php } ?>
  		     	</select>
  		     	<td><input type="button" value="Desplegar" id="hola" class="form-control" onclick="mostrarAlumnos()" /></td>
  		     	
	        </form>

  	  		</td>


  	  	</tr>

  	  </table>
</div>
<form action="fCargaVProfe" method="post">
		<input type="submit" value="Regresar" style="margin-top: 20px; width: 175px;" >
	</form>
</body>
<div id="muestraDatos"></div>

</html>

