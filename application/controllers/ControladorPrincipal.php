<?php
session_start(); //Se inicia una session, para poder usar el tipo de usuario y nombre a lo largo del proyecto
defined('BASEPATH') OR exit('No direct script access allowed');

//WINDOWS:
 require('C:\xampp\fpdf\fpdf.php'); //Libreria para la creación de PDF´s
//UBUNTU: require('/opt/lampp/htdocs/fpdf/fpdf.php');

class PDF extends FPDF{ //Clase que extiende de FPDF,

	function Header(){
		$date = date('F d, o');
		$this->SetFont('Times','I',12);
		$this->Cell(35,1,$date,0,1,'C');
	}

	/**function Footer(){
		//Imagen de footer
		//Para WINDOWS:
		//$this->Image('C:\xampp\fpdf\footerUaemex.png',2,25,15,3);

		//Para UBUNTU:
		$this->Image('/opt/lampp/htdocs/fpdf/footerUaemex.jpeg',2,25,15,3);
	}*/

}
class ControladorPrincipal extends CI_Controller { //Definición principal

	public function __construct(){ //Definición del modelo
		parent:: __construct();
		$this->load->model('ModelosP');
	}

 	public function fBackUp(){ //Función para restaurar la base de datos
  		$respuesta = $this->ModelosP->backUpTotal();
  		$this->load->view('VaddDone');
 	 }

 	public function fRestore(){
	  	$nameRespaldo = $this->input->post('file');

	  	if ($nameRespaldo != "") {
	  		$respuesta = $this->ModelosP->restore($nameRespaldo);
	  		if($respuesta == 0){ //Si se regresa un 0 es exito
	  			$this->load->view('VaddDone');	
	  		}else{  //En otro caso es un fail
	  			$this->load->view('VaddFailAdmin');	
	  		}
	  	}else{
	  		$this->load->view('VaddFailAdmin');	
	  	}
	  }

	public function login(){ //Funcion que carga el Login principal
		$this->load->view('Vlogin');
	}

	public function fCargaVAgregarUsr(){ //Función para cargar vista para agregar usuarios
		$this->load->view('VaddUser');
	}

	public function fsalir(){ //Funcion para salir (Cargar el Login)
		$this->load->view('Vlogin');
	}

	public function fUserTipe(){ //Funcion para verificar si existe el Usuario
		//Obtener el usuario y la contraseña del login
		$usr = strtoupper($this->input->post('usr'));
		$psw = strtoupper($this->input->post('psw'));
		$period = strtoupper($this->input->post('period'));

		
		$_SESSION["S_usr"]=$usr;
		if (($usr == 'SUPERUSER') && ($psw == '12345')) {
			$this->load->view('Vadministrador');
		}else{
			$psw2 = $this->ModelosP->verifyPsw($usr); //Obtener la contraseña del usuario ingresado
			$psw2 = $psw2['contraseña'];
			if($psw2 == NULL){ //No se econtro contraseña, ese usuario NO existe
				$this->load->view('Vlogin');
			}elseif ($psw2 != $psw) { //Se encontro una contraseña, PERO NO COINCIDEN
				$this->load->view('Vlogin');
			}else{ //Se Encontro contraseña y SI COINCIDEN
				//Averiguar de que tipo es el usuario que está ingresando
				$tUser = $this->ModelosP->getTypeUser($usr);
				$tUser = $tUser['tipo'];

				//Se asignan las variables de SESSION (Variables 'superglobales', el NOMBRE y el tipo de USUARIO), para poder ser utilizadas a lo largo de todo el proyecto
				$_SESSION["S_usr"]=$usr;
				$_SESSION["S_tUser"]=$tUser;
				$_SESSION["S_period"]=$period;

				//Una vez obtenido el tipo de USUARIO se cargaran las diferentes vistas para cada uno de estos
				if($tUser == 'Administrador'){
					$this->load->view('Vadministrador'); //Cargar vista de  Administrador
				}elseif($tUser == 'Docente') {
					$this->grupos = $this->ModelosP->obtenInfoGruposProfe($_SESSION["S_usr"]);

					$idProfe = $this->ModelosP->ObtenIdProfe($_SESSION["S_usr"]); //Obtiene el id del profe (usando su nombre)
					$this->materiasProfe = $this->ModelosP->obtenMaterias2($idProfe);
					$this->load->view('Vprofesor', $this->grupos, $this->materiasProfe); //Cargar vista de  profesor

					$this->load->view('Vprofesor',$this->grupos); //Cargar vista de  profesor

				}else{
					$this->load->view('Valumno'); //Cargar vista de Alumno
				}

			}
		}
	}
	public function fcargaVistaProfe(){
		$this->load->view('Vprofesor');
	}
	public function fCargaVadministrador(){ //Funcion para cargar la vista de adminsitrador
		$this->load->view('Vadministrador'); //Cargar vista de  Administrador
	}

  public function fCargaVAlu(){ //Funcion para cargar la vista de adminsitrador
		$this->load->view('Valumno'); //Cargar vista de  Administrador
	}

	public function fCargaVProfe(){
		$this->grupos = $this->ModelosP->obtenInfoGruposProfe($_SESSION["S_usr"]);

		$idProfe = $this->ModelosP->ObtenIdProfe($_SESSION["S_usr"]); //Obtiene el id del profe (usando su nombre)
					$this->materiasProfe = $this->ModelosP->obtenMaterias2($idProfe);
		$this->load->view('Vprofesor', $this->grupos);

		$this->load->view('Vprofesor'); //Cargar vista de  profesor

	}


	public function fAgregaCarrera(){ //Funcion para CARGAR la vista para agregar una CARRERA
		$this->load->view('VagregaCarrera'); //Cargar la vista para agregar una carrera
	}

	public function fAddCarrera(){ //Funncion para agregar UNA CARRERA
		$nomCarrera = $this->input->post('name');
		$id = $this->input->post('id');
		$respuesta = $this->ModelosP->agregaCarrera($nomCarrera, $id);
		if($respuesta == NULL){
			echo "Ocurrio un PROBLEMA :C";
		}else{
			$this->load->view('VaddDone');
		}
	}

	public function fAgregaAdmin(){ //Funcion para agregar un administrador (solo a la tabla de usuarios)
		$usr = strtoupper($this->input->post('name'));
		$psw = strtoupper($this->input->post('psw'));
		$type = $this->input->post('type');
		//Se agrega a la base de datos
		$respuesta = $this->ModelosP->agregaUser($usr, $psw, $type);
		if($respuesta == NULL){
			echo "Hubo un Problema al insertar el usuario";
		}else{
			$this->load->view('VaddDone');
		}
	}

	public function fAgregaDocen(){ //Funcion para agregar un Docente
		$usr = strtoupper($this->input->post('name'));
		$psw = strtoupper($this->input->post('psw'));
		$type = $this->input->post('type');
		//Se agrega a la base de datos
		$respuesta = $this->ModelosP->agregaUser($usr, $psw, $type);
		$respuesta = $this->ModelosP->agregaDocen($usr);
		if($respuesta == NULL){
			echo "Hubo un Problema al insertar el usuario";
		}else{
			$this->load->view('VaddDone');
		}
	}

	public function fAgregaAlumno(){ //Funcion para agregar un Alumno
		$usr = strtoupper($this->input->post('name'));
		$psw = strtoupper($this->input->post('psw'));
		$plan = ($this->input->post('plan'));
		$type = $this->input->post('type');
		//Se agrega a la base de datos
		$respuesta = $this->ModelosP->agregaUser($usr, $psw, $type);
		$respuesta = $this->ModelosP->agregaAlu($usr, $plan);
		if($respuesta == NULL){
			echo "Hubo un Problema al insertar el usuario";
		}else{
			$this->load->view('VaddDone');
		}
	}

	public function fCatalogos(){ //Funcion para cargar la vista que mostrará todos los CATALOGOS
		//OJO aquí, por la manera en la que se desplegaran los catalogos, primero hay que obtenerlos (planes, carreras, alumnos etc.) para que en la vista a través de un SELECT se deplieguen los que se requieren y eviytar estar haciendo uno por uno
		//Obtener todos los catalogos de la base de datos

		//Obtener tipos de examenes
		$this->tExamenes = $this->ModelosP->obtenTexamenes();
		//Obtener los salones
		$this->salones = $this->ModelosP->obtenSalones();
		//Obtener las carreras
		$this->carreras = $this->ModelosP->obtenCarreras();
		//Obtener los planes de estudio
		$this->planes = $this->ModelosP->obtenPlanes();
		//Obtener los PROfesores
		$this->profesores = $this->ModelosP->obtenProfesores();
		//Obtener las materias
		$this->materias = $this->ModelosP->obtenMaterias(0);
		//Obtener los alumnos
		$this->Alumnos = $this->ModelosP->obtenAlumnos();

    //var_dump($this->salones);
    //die();

		//Ya se tiene todos los catalogos en esas variables, solo queda enviarsela a una vista que despliegue los que el usuario quiera en ese momoento
		$this->load->view('VshowCatalogos', $this->tExamenes, $this->salones, $this->carreras, $this->planes, $this->profesores, $this->materias, $this->Alumnos);
	}

	public function fcargaCreaGrupo(){ //Funcion que carga la vista para la creacion de un grupo
		//Como desde la vista se elige el profesor, materia del grupo, hay que obtenerlos de la base
		//Obtener los PROfesores
		$this->profesores = $this->ModelosP->obtenProfesores();
		//Obtener las materias
		$this->materias = $this->ModelosP->obtenMaterias(0);
		//Obtener los salones
		$this->salones = $this->ModelosP->obtenSalones();

		//Enviarselos a la vista
		$this->load->view('VcreaGrupo', $this->profesores, $this->materias, $this->salones);
	}

	public function fCrearUnGrupo(){ //Funcion que CREA UN GRUPO
		$profe = $this->input->post('profe');
		$materia = $this->input->post('materia');
		$salon = $this->input->post('salon');
		$dias = $this->input->post('dias');
		$H_I = $this->input->post('H_I');
		$H_F = $this->input->post('H_F');

		//Obtener el id del profedsor (Por que entró su nombre)
		$idProfe = $this->ModelosP->ObtenIdProfe($profe);
		//Obtener el id de una materia (Por qué le entró su nombre)
		$idMateria = $this->ModelosP->ObtenIdMateria($materia);
		//Insertar el grupo y el horario.
		//El horario (Dias y horas) están en un vector, una para cada uno, se harán arreglos para poder insertarse en la base de datos.

		$dias = implode(",", $dias); //Se une el vector en un String separado por comas
		$H_I = implode(",", $H_I); //Lo mismo con la hora inicial
		$H_F = implode(",", $H_F); //Lo mismo con la hora final

		//Se obtiene el ultimo id del "---" (Funcion generica que lo hace), esta ves será de grupo
		//(Le entra el nombre de la tabla y el nombre del atributo)
		$lastIdGroup = $this->ModelosP->LastId("grupo", "id_grupo");
		$lastIdGroup = $lastIdGroup +1;

		//Insertar el grupo y el horario (Y)
		$this->ModelosP->InsertaGrupo($lastIdGroup, $idProfe, $idMateria);
		$this->ModelosP->InsertaHorario($salon, $dias, $lastIdGroup, $H_I, $H_F);

		$this->load->view('VaddDone');
	}

	public function fcargaVregistroCalif(){ //Funcion para cargar la vista para registrar calificaciones
		//La vista de registro de calificaciones necesita de varios parametros. Primero obtener esos parametros.
		$grupo = $this->input->post('mater');
		
		$this->alumnos = $this->ModelosP->ObtenAlumnosGrupo($grupo);
		die();
		$idProfe = $this->ModelosP->ObtenIdProfe($_SESSION["S_usr"]); //Obtiene el id del profe (usando su nombre)
		$this->materiasProfe = $this->ModelosP->obtenMaterias2($idProfe); //Obtiene las materias de un profe
		//var_dump($materiasProfe);
		/*for ($i=0; $i<($materiasProfe); $i++){
			$aux = $materiasProfe[$i];
			$materia = $aux['id_materia'];
			$grupos = $aux['id_grupo'];
		}
		$envio['id_materias'] = $materia;
		$envio['id_grupos'] = $grupos;
		*/
		

		$this->load->view('VRegisCalif', $this->materiasProfe); //Se carga la vista con los datos necesarios
	}

	public function fRegistraCalif(){ //Funcion para registras calificaciones
		

	}

	public function flistamateriasHorarios(){ //Funcion para listar als materias y horarios de PROFESOR
		//Nombre, materias, profesor, grupo, periodo, plan estudio, horario, fecha

	    //Obtener las materias y la info de ellas
	    $this->materiasProfe = $this->ModelosP->ObtenAllMateriasProfe($_SESSION["S_usr"]);
	  
	    if (count($this->materiasProfe) == 0) {
	    	//Indicar que ese alukno no tiene inscripciones a ese semestre
	    	$this->load->view('VNoMateriasProfe');
	    }else{
	    	for ($i=0; $i < count($this->materiasProfe); $i++) {
				$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->materiasProfe[$i]['id_grupo']));
				$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->materiasProfe[$i]['id_grupo']));
				$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->materiasProfe[$i]['id_grupo']));
			}
			
			$this->load->view('VlistamateriasHorarios',$this->materiasProfe, $this->infoH);
	    }
	}

	public function fPDFMateriasHorarios(){ //Función que genera el PDF del reporte de inscripciones de un alumno
		//Obtener nuevamente la información que se usará en el reporte
		$nombre ="Profesor: ".$_SESSION["S_usr"];

    	$this->materiasProfe = $this->ModelosP->ObtenAllMateriasProfe($_SESSION["S_usr"]);
    	//var_dump($this->tiraMaterias[0]['id_grupo']);
    	//die();
    	for ($i=0; $i < count($this->materiasProfe); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->materiasProfe[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->materiasProfe[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->materiasProfe[$i]['id_grupo']));
		}
		//Generar el PDF
		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Times','I',12);
		$pdf->Cell(6,0,$nombre,0,0,'A');
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(7,1,'Materias/Horarios: '.$_SESSION["S_period"],0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',16);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(6, 1, "Nombre", 1, 0, 'C');
		$pdf->Cell(3, 1, "Grupo", 1, 0, 'C');
		$pdf->Cell(5, 1, "Salón", 1, 0, 'C');

		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->materiasProfe); $i++) {
			$pdf->Cell(6, 1, $this->materiasProfe[$i]["nom_materia"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->materiasProfe[$i]["id_grupo"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->materiasProfe[$i]["id_salon"], 1, 1, 'C');
		}

		$pdf->Output();
	}

	public function flistaAlumnosGrupo(){ //Funcion para listar los ALUMNOS y GRUPOS

	}

	public function fRepoCalif(){ //Funcion para reporte de CALIFICACIONES (EL QUE GENERA EL PROFE)
		$grupo = $this->input->post('grupo2');
		$_SESSION['group2'] = $grupo;
		$this->period = $this->input->post('period');
		$_SESSION['periodoo'] = $this->period;
		$tExa = $this->input->post('tExa');

		$this->materia = $this->ModelosP->ObtenMateria($grupo);
		$this->infoRepo = $this->ModelosP->ObtenCalifAlumnos($grupo, $this->period);
		//var_dump($this->materia, $this->infoRepo);
		//die();
		$this->load->view('VRepoCalif', $this->materia, $this->infoRepo, $this->period);
	}

	public function fPDFCalifAlumnos(){ //Hace el PDF de lo de arriba
		$this->materia = $this->ModelosP->ObtenMateria($_SESSION['group2']);
		$this->infoRepo = $this->ModelosP->ObtenCalifAlumnos($_SESSION['group2'], $_SESSION['periodoo']);

		//Generar el PDF 
		$nombre = "Calificaciones del Grupo: ".$_SESSION['group2'].", Materia: ".$this->materia['nom_materia'].", Periodo: ".$_SESSION['periodoo'];

		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,$nombre,0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',14);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(3, 1, "Id Alumno", 1, 0, 'C');
		$pdf->Cell(5, 1, "Nombre Alumno", 1, 0, 'C');
		$pdf->Cell(4, 1, "Tipo Examen", 1, 0, 'C');
		$pdf->Cell(3, 1, "Calificacion", 1, 0, 'C');

		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->infoRepo); $i++) {
			$pdf->Cell(3, 1, $this->infoRepo[$i]["id_alumno"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->infoRepo[$i]["nom_alumno"], 1, 0, 'C');
			$pdf->Cell(4, 1, $this->infoRepo[$i]["tipo_examen"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->infoRepo[$i]["calificacion"], 1, 0, 'C');

		}

		$pdf->Output();
	}


	public function fPDFCalifAlumnos(){ //Hace el PDF de lo de arriba
		$this->materia = $this->ModelosP->ObtenMateria($_SESSION['group2']);
		$this->infoRepo = $this->ModelosP->ObtenCalifAlumnos($_SESSION['group2'], $_SESSION['periodoo']);

		//Generar el PDF 
		$nombre = "Calificaciones del Grupo: ".$_SESSION['group2'].", Materia: ".$this->materia['nom_materia'].", Periodo: ".$_SESSION['periodoo'];

		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,$nombre,0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',14);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(3, 1, "Id Alumno", 1, 0, 'C');
		$pdf->Cell(5, 1, "Nombre Alumno", 1, 0, 'C');
		$pdf->Cell(4, 1, "Tipo Examen", 1, 0, 'C');
		$pdf->Cell(3, 1, "Calificacion", 1, 0, 'C');

		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->infoRepo); $i++) {
			$pdf->Cell(3, 1, $this->infoRepo[$i]["id_alumno"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->infoRepo[$i]["nom_alumno"], 1, 0, 'C');
			$pdf->Cell(4, 1, $this->infoRepo[$i]["tipo_examen"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->infoRepo[$i]["calificacion"], 1, 0, 'C');

		}

		$pdf->Output();
	}

	public function cargaVInscrGrupo(){ //Funcion para hacer una inscripción a un grupo
		//Se necesitan varias cosas para cargar esa vista:
		//Primero se obtiene la info de los grupos que hay (Materias, profesores, horarios)
		//Para que pueda elegir el alumno a cual inscribirse
		$this->info = $this->ModelosP->obtenInfoGrupos();

		//Como la tabla contiene id´s y nos interesan los nombres, se modificaran los arreglos obtenidos.
		for ($i=0; $i < count($this->info); $i++) {
			$this->info[$i]['id_profesor'] = $this->ModelosP->ObtenNomProfe($this->info[$i]['id_profesor']);
			$this->info[$i]['id_materia'] = $this->ModelosP->ObtenNomMateria($this->info[$i]['id_materia']);
			$this->info[$i]['salon'] = $this->ModelosP->ObtenSalon($this->info[$i]['id_grupo']);
			$this->info[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->info[$i]['id_grupo']));
			$this->info[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->info[$i]['id_grupo']));
			$this->info[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->info[$i]['id_grupo']));
		}
		//var_dump($this->info[2]['dias'][0]);
		//var_dump($this->info[2]['h_i'][0]);
		//var_dump($this->info[2]['h_f'][0]);
		//die();
		$this->load->view('VInscripGrupo', $this->info);
	}

	public function fInscribeAlu(){
		$opt = $this->input->post('opt');
		$idAlu = $this->ModelosP->ObtenIdAlumno($_SESSION["S_usr"]);
		//Seprar la info obtenida por la vista de inscripción
    for ($i=0; $i < count($opt) ; $i++) {
      $this->infoInscri[$i] = explode(",", $opt[$i]);
      $this->ModelosP->AgregaInscriAlu($this->infoInscri[$i][2], $idAlu, $_SESSION["S_period"]);
    }
    $this->load->view('VaddDoneAlu');
	}

	public function frepoInscrip(){ //Reporte de INSCRIPCIONES
    //Nombre, materias, profesor, grupo, periodo, plan estudio, horario, fecha

    //Obtener la informacion para la tira de materias
    $this->idAlu = $this->ModelosP->ObtenIdAlumno($_SESSION["S_usr"]);
    $planCarrera= $this->ModelosP->ObtenMasInfo($_SESSION["S_usr"]);
    $this->plan = $planCarrera['plan_estudio'];
    $this->carrera = $planCarrera['nom_carrera'];

    $this->tiraMaterias = $this->ModelosP->ObtenTiraMaterias($_SESSION["S_usr"]);

    if (count($this->tiraMaterias) == 0) {
    	//Indicar que ese alukno no tiene inscripciones a ese semestre
    	$this->load->view('VNoInscri');
    }else{
    	for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->tiraMaterias[$i]['id_grupo']));
		}
		//var_dump($this->tiraMaterias);
		//var_dump($this->infoH[2]['dias']);
		//die();

		$this->load->view('VRepoInscri',$this->tiraMaterias, $this->idAlu, $this->plan, $this->carrera, $this->infoH);
    }
	}

	public function fPDFInscribeAlu(){ //Función que genera el PDF del reporte de inscripciones de un alumno
		//Obtener nuevamente la información que se usará en el reporte
		$nombre ="Nombre: ".$_SESSION["S_usr"];
		$this->idAlu = "Id: ".$this->ModelosP->ObtenIdAlumno($_SESSION["S_usr"]);
    	$planCarrera= $this->ModelosP->ObtenMasInfo($_SESSION["S_usr"]);
    	$this->plan ="Plan: ".$planCarrera['plan_estudio'];
    	$this->carrera ="Carrera: ".$planCarrera['nom_carrera'];
    	$this->tiraMaterias = $this->ModelosP->ObtenTiraMaterias($_SESSION["S_usr"]);
    	//var_dump($this->tiraMaterias[0]['id_grupo']);
    	//die();
    	for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->tiraMaterias[$i]['id_grupo']));
		}
		//Generar el PDF
		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Times','I',12);
		$pdf->Cell(6,0,$nombre,0,0,'A');
		$pdf->Cell(3,0,$this->idAlu,0,0,'A');
		$pdf->Cell(5,0,$this->carrera,0,0,'A');
		$pdf->Cell(5,1,$this->plan,0,1,'A');
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,'Materias  '.$_SESSION["S_period"],0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',16);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(6, 1, "Nombre", 1, 0, 'C');
		$pdf->Cell(5, 1, "Profesor", 1, 0, 'C');
		$pdf->Cell(3, 1, "Grupo", 1, 0, 'C');
		$pdf->Cell(5, 1, "Salón", 1, 0, 'C');

		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$pdf->Cell(6, 1, $this->tiraMaterias[$i]["nom_materia"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->tiraMaterias[$i]["nom_profesor"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->tiraMaterias[$i]["id_grupo"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->tiraMaterias[$i]["id_salon"], 1, 1, 'C');
		}

		$pdf->Output();
	}

	public function fKardex(){ //Funcion para generar el KARDEX de una alumno
		//Nombre, materias, profesor, grupo, periodo, plan estudio, horario, fecha

    //Obtener la informacion para la tira de materias
    $this->idAlu = $this->ModelosP->ObtenIdAlumno($_SESSION["S_usr"]);
    $planCarrera= $this->ModelosP->ObtenMasInfo($_SESSION["S_usr"]);
    $this->plan = $planCarrera['plan_estudio'];
    $this->carrera = $planCarrera['nom_carrera'];

    $this->tiraMaterias = $this->ModelosP->ObtenAllTiraMaterias($_SESSION["S_usr"]);

    if (count($this->tiraMaterias) == 0) {
    	//Indicar que ese alukno no tiene inscripciones a ese semestre
    	$this->load->view('VNoInscri');
    }else{
    	for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->tiraMaterias[$i]['id_grupo']));
		}
		//var_dump($this->tiraMaterias);
		//var_dump($this->infoH[2]['dias']);
		//die();

		$this->load->view('VKardex',$this->tiraMaterias, $this->idAlu, $this->plan, $this->carrera, $this->infoH);
	}
}
	
	public function fPDFKardex(){ //Función que genera el PDF del reporte de inscripciones de un alumno
		//Obtener nuevamente la información que se usará en el reporte
		$nombre ="Nombre: ".$_SESSION["S_usr"];
		$this->idAlu = "Id: ".$this->ModelosP->ObtenIdAlumno($_SESSION["S_usr"]);
    	$planCarrera= $this->ModelosP->ObtenMasInfo($_SESSION["S_usr"]);
    	$this->plan ="Plan: ".$planCarrera['plan_estudio'];
    	$this->carrera ="Carrera: ".$planCarrera['nom_carrera'];
    	$this->tiraMaterias = $this->ModelosP->ObtenAllTiraMaterias($_SESSION["S_usr"]);
    	//var_dump($this->tiraMaterias[0]['id_grupo']);
    	//die();
    	for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->tiraMaterias[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->tiraMaterias[$i]['id_grupo']));
		}
		//Generar el PDF
		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Times','I',12);
		$pdf->Cell(6,0,$nombre,0,0,'A');
		$pdf->Cell(3,0,$this->idAlu,0,0,'A');
		$pdf->Cell(5,0,$this->carrera,0,0,'A');
		$pdf->Cell(5,1,$this->plan,0,1,'A');
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,'Rporte Kardex  ',0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',16);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(6, 1, "Nombre", 1, 0, 'C');
		$pdf->Cell(5, 1, "Profesor", 1, 0, 'C');
		$pdf->Cell(3, 1, "Grupo", 1, 0, 'C');
		$pdf->Cell(5, 1, "Salón", 1, 0, 'C');

		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->tiraMaterias); $i++) {
			$pdf->Cell(6, 1, $this->tiraMaterias[$i]["nom_materia"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->tiraMaterias[$i]["nom_profesor"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->tiraMaterias[$i]["id_grupo"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->tiraMaterias[$i]["id_salon"], 1, 1, 'C');
		}

		$pdf->Output();
	}

	public function fRepoMateriasProfe(){ //Reporte de Materias-Profesor (Administrador)

		

		$period = $this->input->post('periodo'); //Se obtiene el periodo del que se quiere la info
		$_SESSION["S_period2"]=$period;
		$this->materiasPeriod = $this->ModelosP->ObtenMateriasPorfes($period);			
		$this->load->view('VRepoMateriasProfe', $this->materiasPeriod);

		
	}

	public function fPDFMateriasProfesPeriodo(){
		//Obtener nuevamente la información que se usará en el reporte
		//te pdio
		$this->materiasPeriod = $this->ModelosP->ObtenMateriasPorfes($_SESSION["S_period2"]);
		$encabezado = 'Reporte Materias/Profesores, Periodo '.$_SESSION["S_period2"];
		//Generar el PDF
		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,$encabezado,0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',16);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(6, 1, "Id Materia", 1, 0, 'C');
		$pdf->Cell(5, 1, "Materia", 1, 0, 'C');
		$pdf->Cell(3, 1, "Profesor", 1, 0, 'C');
		$pdf->Cell(5, 1, "Grupo", 1, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->materiasPeriod); $i++) {
			$pdf->Cell(6, 1, $this->materiasPeriod[$i]["id_materia"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->materiasPeriod[$i]["nom_materia"], 1, 0, 'C');
			$pdf->Cell(3, 1, $this->materiasPeriod[$i]["nom_profesor"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->materiasPeriod[$i]["id_grupo"], 1, 1, 'C');
		}
		$pdf->Output();
	}




	public function fRepoSalon(){



		 //Reporte de Salon (Administrador)
		$period = $this->input->post('periodo2'); //Se obtiene el periodo del que se quiere la info
		$_SESSION["S_period3"]=$period;
		$this->salonesPeriod = $this->ModelosP->ObtenInfoSalones($period);
		for ($i=0; $i < count($this->salonesPeriod); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->salonesPeriod[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->salonesPeriod[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->salonesPeriod[$i]['id_grupo']));
		}
		$this->load->view('VRepoSalones', $this->salonesPeriod, $this->infoH);




	}

	public function fPDFRepoSalon(){ //Genera el PDF del reporte de arriba xD
		$this->salonesPeriod = $this->ModelosP->ObtenInfoSalones($_SESSION["S_period3"]);
		for ($i=0; $i < count($this->salonesPeriod); $i++) {
			$this->infoH[$i]['dias'] = explode(",",$this->ModelosP->ObtenDiasH($this->salonesPeriod[$i]['id_grupo']));
			$this->infoH[$i]['h_i'] = explode(",",$this->ModelosP->ObtenH_I($this->salonesPeriod[$i]['id_grupo']));
			$this->infoH[$i]['h_f'] = explode(",",$this->ModelosP->ObtenH_F($this->salonesPeriod[$i]['id_grupo']));
		}
		$encabezado = 'Reporte Salones, Periodo '.$_SESSION["S_period3"];
		//Generar el PDF
		$pdf = new PDF('P', 'cm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Times','BU',18);
		$pdf->Cell(19,1,$encabezado,0,0,'C');
		$pdf->Ln(1);
		$pdf->Ln(1);
		$pdf->SetFont('Times','B',16);
		$pdf->SetDrawColor(0,80,180);
		$pdf->SetFillColor(430,430,10);
		$pdf->SetLineWidth(0.08);
		$pdf->Cell(2, 1, "Salón", 1, 0, 'C');
		$pdf->Cell(5, 1, "Materia", 1, 0, 'C');
		$pdf->Cell(2, 1, "Grupo", 1, 0, 'C');
		$pdf->Cell(4, 1, "Profesor", 1, 0, 'C');
		$pdf->Cell(5, 1, "Horario", 1, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Times','',12);

		for ($i=0; $i < count($this->salonesPeriod); $i++) {
			$pdf->Cell(2, 1, $this->salonesPeriod[$i]["id_salon"], 1, 0, 'C');
			$pdf->Cell(5, 1, $this->salonesPeriod[$i]["nom_materia"], 1, 0, 'C');
			$pdf->Cell(2, 1, $this->salonesPeriod[$i]["id_grupo"], 1, 0, 'C');
			$pdf->Cell(4, 1, $this->salonesPeriod[$i]["nom_profesor"], 1, 0, 'C');

			for ($j=0; $j < count($this->infoH[$i]['dias']) ; $j++) { 
				$StringHorario = $this->infoH[$i]['dias'][$j]."--".$this->infoH[$i]['h_i'][$j]."---".$this->infoH[$i]['h_f'][$j];
				if ($j == 0) {
					$esp = 5;
				}else{
					$esp = 31;
				}
				$pdf->Cell($esp, 1, $StringHorario, 0, 1, 'C');
			}
		}
		$pdf->Output();


	}
	public function obtenAlumnos(){
		echo "LLgemos";
		die();
		$profe = $this->input->post('profesor');
		$datos = $this->input->post('datosProfe');
		$id_grupo = explode("-", $datos);
		$nombreGrupo = $id_grupo[1];
		$id_grupos = $id_grupo[0];

		//$respuesta = $this->ModelosP->ObtenAlumnosProfeGrupo($profe, $datos);//en el modelo tenemos que regresar el valor como objeto; $respuetsa->result
		//echo json_encode($respuesta);
		$id_profesor = $this->ModelosP->ObtenIdProfe($profe);
		$id_materia = $this->ModelosP->buscaidGrupo($nombreGrupo,$id_profesor);
		
		$id_alumnos = $this->ModelosP->buscaIdAlumnos($id_materia);
		$alumnos = $this->ModelosP->buscaAlumosGrupo($id_profesor,$id_grupos);

		echo "va";
		//echo (json_encode($profe));


		echo json_encode($alumnos);

		//$datos['seleccion'] obtiene el valor ese merengues
	}

	public function agregaCalificaciones(){
		$tipo_examen = $this->input->post("examen");
		$calificacion = $this->input->post("calificacion");
		$id_alumno = $this->input->post("id_alumno");
		$datos = $this->input->post("id_grupo");
		var_dump(count($id_alumno));
		for ($i=0; $i <sizeof($id_alumno) ; $i++) { 
			 $id_inscripcion[$i] = $this->ModelosP->buscaIdInscripcion($id_alumno[$i],$datos);
		}
		
		for ($i=0; $i < sizeof($id_inscripcion) ; $i++) {
			$respuesta[$i]=$this->ModelosP->ingresaCalificacion($calificacion[$i],$tipo_examen[$i],$id_inscripcion[$i]);
		}
		echo "Trabajo hecho";
		$this->load->view('Vprofesor');
	}

}
