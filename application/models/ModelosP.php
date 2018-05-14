<?php
	class ModelosP extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function backUpTotal(){ //Funcion para hacer un BackUp total de la base de datos
			$dbname = 'controlescolar'; //Nombre de la base de datos a hacer el BackUp
 			$name_file = ($dbname. "_" .date("d-m-Y_H-i-s"). ".sql"); //El nombre del archivo tendra la fecha y la base a la que pertenece 

 			// PARA WINDOWS:
 			$comandoW = 'C:\xampp\mysql\bin\mysqldump -u root '; //Comando de Windows para ejecutar mysqldump
 			$path_fileW=($dbname.' > '.'C:\Users\eco-4\Desktop\RespaldoCE'.'\RT_');//Ruta del archivo donde se guardará el respaldo	
  			$respuesta = exec($comandoW.$path_fileW.$name_file); 


 			//PARA UBUNTU: 
 			//$comandoU = '/opt/lampp/bin/mysqldump -u root ';
 			//$path_fileU = ($dbname.'>'.'/home/eco4109/Escritorio/respaldosBase/respaldosTotales/'."'$name_file'");
 			//$respuesta = exec($comandoU.$path_fileU.".sql");
			///opt/lampp/bin/mysqldump -u root proyecto trabajadores > /home/eco4109/Escritorio/respaldosBase/respaldosTotales/respaldo.sql

			//exec("intruccion para iniciar mysqldump", nombre_base>Direccion_y_nombre_del_respaldo.sql);
 			return $respuesta; //Se regresa el estado de la ejecucion, si es 0 se pudo hacer			
		}

		public function restore($nameBD){
			set_time_limit(720);
			//Corta el nombre(cuestiones de sintaxis, NO QUITAR, en uBuntu no hay problema)
 			$nameBD = substr($nameBD, 3);
 		
 			// PARA WINDOWS:
 			$respuesta = exec('C:\xampp\mysql\bin\mysql -u root controlescolar < C:\Users\eco-4\Desktop\RespaldoCE\RT_'.$nameBD); //Comando de Windows para ejecutar mysql (Restaurar la base de datos)
 			
 
 			//PARA UBUNTU: 
			//exec('/opt/lampp/bin/mysql -u root CREATE database IF NOT EXISTS proyecto');
 			//$respuesta = exec("/opt/lampp/bin/mysql -u root proyecto < /home/eco4109/Escritorio/respaldosBases/respaldosTotales/".$nameBD);
			//exec("intruccion para iniciar mysqldump", nombre_base>Direccion_y_nombre_del_respaldo.sql);
 			return $respuesta; //Se regresa el estado de la ejecucion, si es 0 se pudo hacer
		}

		public function verifyPsw($usr){ //Funcion para obtener la contraseña del usuario ingresado
			$query = "SELECT (contraseña) FROM usuarios WHERE nombre = '".$usr."'";
			$resultado = $this->db->query($query);
			return $resultado->row_array();
		}

		public function getTypeUser($usr){ //Funcion para obtener el tipo de usuario que se esta logeando
			$query = "SELECT (tipo) FROM usuarios WHERE nombre = '".$usr."'";
			$resultado = $this->db->query($query);
			return $resultado->row_array();
		}

		public function agregaUser($usr, $psw, $type){ //Funcion para insertar un administrador
			$query="INSERT INTO usuarios (nombre,contraseña,tipo) VALUES('".$usr."','".$psw."','".$type."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function agregaDocen($usr){ //Función para agregar un DOCENTE
			$query="INSERT INTO profesor (nom_profesor) VALUES('".$usr."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function agregaAlu($usr, $plan){ //Fucnion para agregar ALUMNO
			$query="INSERT INTO alumno (nom_alumno, id_plan) VALUES('".$usr."','".$plan."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function agregaCarrera($nomCarrera, $id){ //Funcion para agregar una CARRERA
			$query="INSERT INTO carrera (id_carrera, nom_carrera) VALUES('".$id."','".$nomCarrera."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function obtenTexamenes(){ //Funcion para obtener los tipos de EXAMENES
			$query = "SELECT * FROM tipo_examen";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenSalones(){ //Funcion para obtener los tipos de EXAMENES
			$query = "SELECT * FROM salon";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenCarreras(){ //Funcion para obtener las CARRERAS
			$query = "SELECT * FROM carrera";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenPlanes(){ //Funcion para obtener los PLANES DE ESTUDIO
			$query = "SELECT * FROM plan_estudio";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenProfesores(){ //Funcion para obtener los PROFESORES
			$query = "SELECT * FROM profesor";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function ObtenIdProfe($nom){ //Funcion para obtener el ID de un profesor (Le entra el nombre)
			$query = "SELECT (id_profesor) FROM profesor WHERE nom_profesor = '".$nom."'";
			$resultado = ($this->db->query($query)->row_array());
			$idProfe = $resultado['id_profesor'];
			return $idProfe;
		}

		public function ObtenNomProfe($idProfe){
			//Funcion para obtener el ID de un profesor (Le entra el nombre)
			$query = "SELECT (nom_profesor) FROM profesor WHERE id_profesor = '".$idProfe."'";
			$resultado = ($this->db->query($query)->row_array());
			$nomProfe = $resultado['nom_profesor'];
			return $nomProfe;
		}

		public function obtenMaterias($idProfe){ //Funcion para obtener las MATERIAS. OJO CON ESTA, sirve para obtener TODAS LAS MATERIAS EXISTENTES , pero tambien para las de un profesor en especifico.
			if($idProfe == 0){ //Si le entra un 0, se obtienen TODAS las materias de la base de datos
				$query = "SELECT * FROM materia";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}else{ //Si el ID es diferente de cero, se obtienen todas las materias de el profesor con ese ID, como no hay una relacion directa entre materias y los profesores, se hacen varias cosillas
				$query1 = "SELECT (id_materia) FROM grupo WHERE id_profesor='".$idProfe."'"; //Obtiene el ID de las materias con el id del profesor
				$idMaterias = ($this->db->query($query1)->result_array()); //Se hace el query y se guarda en un vector de vectores
				//Ahora que se tienen los id´s de las materias que da ese profe, hay que obtener el nombre de las materias
				//Como los id´s estan en un vector: se hace un cichlo para que en cada ieracion obtenga el nombre de una materia, con un id del vector.
				$nomMaterias[]=array();
				for ($i=0; $i < count($idMaterias); $i++) {
					$query2 = "SELECT nom_materia FROM materia WHERE id_materia = '".$idMaterias[$i]['id_materia']."'";
					$resultado2 = ($this->db->query($query2)->row_array());
					$nomMaterias[$i] = $resultado2['nom_materia'];
				}
			}
		}

		public function ObtenMateria($grupo){ //Obtiene la materia de un grupo
			$query = "SELECT materia."."id_materia, materia."."nom_materia FROM grupo, materia WHERE grupo."."id_materia = materia."."id_materia AND grupo."."id_grupo = '".$grupo."' ";
			$resultado = ($this->db->query($query)->row_array());
			return $resultado;
		}

		public function ObtenCalifAlumnos($grupo, $periodo){
			$query = "SELECT alumno."."id_alumno, alumno."."nom_alumno, tipo_examen."."tipo_examen, calificacion."."calificacion FROM alumno, ins_alu_grupo, calificacion, tipo_examen WHERE tipo_examen."."id_tipo_examen = calificacion."."id_tipo_examen AND alumno."."id_alumno = ins_alu_grupo."."id_alumno AND ins_alu_grupo."."id_inscripcion = calificacion."."id_inscripcion AND ins_alu_grupo."."id_grupo = '".$grupo."' AND  ins_alu_grupo."."periodo = '".$periodo."' ";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}

		public function obtenMaterias2($idProfe){
			$query = "SELECT grupo."."id_materia, id_grupo, materia."."nom_materia FROM grupo, materia WHERE grupo."."id_profesor ='".$idProfe."'and materia.id_materia = grupo.id_materia ";
			$resultado = ($this->db->query($query)->result_array());
			return $resultado;

		}

		public function obtenAlumnos(){ //Funcion para obtener los Alumnos
			$query = "SELECT * FROM alumno";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function ObtenIdMateria($materia){ //Función para obtener el id de una materia(Entra su nombre)
			$query = "SELECT (id_materia) FROM materia WHERE nom_materia = '".$materia."'";
			$resultado = ($this->db->query($query)->row_array());
			$idMate = $resultado['id_materia'];
			return $idMate;
		}

		public function ObtenNomMateria($materia){ //Funcion para obtener el nombre de una materia (Entra id)
			$query = "SELECT (nom_materia) FROM materia WHERE id_materia = '".$materia."'";
			$resultado = ($this->db->query($query)->row_array());
			$nomMate = $resultado['nom_materia'];
			return $nomMate;
		}

		public function ObtenSalon($grupo){ //Funcion para obtener el salon (Le entra el id de grupo)
			$query = "SELECT (id_salon) FROM horario WHERE id_grupo = '".$grupo."'";
			$resultado = ($this->db->query($query)->row_array());
			$nomMate = $resultado['id_salon'];
			return $nomMate;

		}

		public function LastId($nomTabla, $nomAtributo){ //Funcion que retorna el ultimo Id de la columna y tabla especificada
			$query = "SELECT MAX(".$nomAtributo.") FROM (".$nomTabla.")";
			$resultado = ($this->db->query($query)->row_array());
			$LastId = $resultado['MAX('.$nomAtributo.')'];
			return $LastId;
		}

		public function InsertaGrupo($lastIdGroup, $idProfe, $idMateria){ //Funcion para insertar un grupo
			$query="INSERT INTO grupo (id_grupo, id_profesor, id_materia) VALUES('".$lastIdGroup."','".$idProfe."','".$idMateria."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function InsertaHorario($idSalon, $dias, $lastIdGroup, $H_I, $H_F){ //Insertar horario
			$query="INSERT INTO horario (id_salon, dia, id_grupo, h_i, h_f) VALUES('".$idSalon."','".$dias."','".$lastIdGroup."','".$H_I."','".$H_F."')";
			$resultado = $this->db->query($query);
			return $resultado;
		}

		public function obtenInfoGrupos(){ //Funcion para obtener la info  de los grupos (o sea todo de la tabla "grupo xD")
			$query = "SELECT * FROM grupo";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenInfoGruposProfe($nomProfe){ //Funcion para obtener la info  de los grupos (SOLO DEL PROFE INDICADO)
			$query = "SELECT grupo."."id_grupo FROM grupo, profesor WHERE ( profesor."."id_profesor = grupo."."id_profesor AND profesor."."nom_profesor = '".$nomProfe."' )";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}


		public function ObtenDiasH($idGrupo){ //Funcion para obtener los dias en los que se da clase en cierto grupo
			$query = "SELECT (dia) FROM horario WHERE id_grupo = '".$idGrupo."'";
			$resultado = ($this->db->query($query)->row_array());
			$dias= $resultado['dia'];
			return $dias;
		}

		public function ObtenH_I($idGrupo){ //Funcion para obtener los dias en los que se da clase en cierto grupo
			$query = "SELECT (h_i) FROM horario WHERE id_grupo = '".$idGrupo."'";
			$resultado = ($this->db->query($query)->row_array());
			$hi = $resultado['h_i'];
			return $hi;
		}

		public function ObtenH_F($idGrupo){ //Funcion para obtener los dias en los que se da clase en cierto grupo
			$query = "SELECT (h_f) FROM horario WHERE id_grupo = '".$idGrupo."'";
			$resultado = ($this->db->query($query)->row_array());
			$hf = $resultado['h_f'];
			return $hf;
		}

		public function ObtenIdAlumno($nom){ //Función para obtener el Id de un alumno (con su nombre)
			$query = "SELECT (id_alumno) FROM alumno WHERE nom_alumno = '".$nom."'";
			$resultado = ($this->db->query($query)->row_array());
			$idAlu = $resultado['id_alumno'];
			return $idAlu;
		}

		public function AgregaInscriAlu($idGrupo, $idAlu, $periodo){ //Función para agregar la Inscripción de un alumno
			$query="INSERT INTO ins_alu_grupo (id_grupo, id_alumno, periodo) VALUES('".$idGrupo."','".$idAlu."','".$periodo."')";
			$resultado = $this->db->query($query);
		}

		public function ObtenMasInfo($nom){ //Obtiene más informacion necesaria para los reportes del alumno (PLaN ESTUDIO, CARRERA)
			$query = "SELECT plan_estudio, nom_carrera FROM plan_estudio, alumno, carrera WHERE (carrera."."id_carrera = plan_estudio."."id_carrera AND plan_estudio."."id_plan = alumno."."id_plan AND alumno."."nom_alumno = '".$nom."')";
			$resultado = ($this->db->query($query)->row_array());
			return $resultado;
		}

		public function ObtenTiraMaterias($nom){ //Obttiene la tira de Materias de un alumno (POR PERIODO)
			$query = "SELECT horario."."id_salon, nom_materia, grupo."."id_grupo, nom_profesor FROM horario, materia, grupo, alumno, ins_alu_grupo, profesor WHERE (horario."."id_grupo = grupo."."id_grupo AND materia."."id_materia = grupo."."id_materia AND alumno."."id_alumno = ins_alu_grupo."."id_alumno AND ins_alu_grupo."."id_grupo = grupo."."id_grupo AND profesor."."id_profesor = grupo."."id_profesor AND ins_alu_grupo."."periodo = '".$_SESSION['S_period']."' AND alumno."."nom_alumno = '".$nom."')";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}

		public function ObtenAllTiraMaterias($nom){ //Obttiene la tira de Materias de un alumno (TODAS)
			$query = "SELECT calificacion."."calificacion, tipo_examen."."tipo_examen ,ins_alu_grupo."."periodo, horario."."id_salon, nom_materia, grupo."."id_grupo, nom_profesor FROM calificacion, tipo_examen, horario, materia, grupo, alumno, ins_alu_grupo, profesor WHERE ( ins_alu_grupo."."id_inscripcion = calificacion."."id_inscripcion AND tipo_examen."."id_tipo_examen = calificacion."."id_tipo_examen AND horario."."id_grupo = grupo."."id_grupo AND materia."."id_materia = grupo."."id_materia AND alumno."."id_alumno = ins_alu_grupo."."id_alumno AND ins_alu_grupo."."id_grupo = grupo."."id_grupo AND profesor."."id_profesor = grupo."."id_profesor AND alumno."."nom_alumno = '".$nom."')";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}

		public function ObtenAllMateriasProfe($nom){ //Obtiene todas las materias de un profesor
			$query = "SELECT materia."."id_materia, horario."."id_salon, nom_materia, grupo."."id_grupo FROM horario, materia, grupo, profesor WHERE (profesor."."id_profesor = grupo."."id_profesor AND horario."."id_grupo = grupo."."id_grupo AND materia."."id_materia = grupo."."id_materia AND profesor."."nom_profesor = '".$nom."')";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}

		public function ObtenMateriasPorfes($period){ //Funcion par obtener las materias_profes (De un periodo)
			$query = "SELECT materia."."id_materia, materia."."nom_materia, profesor."."nom_profesor, grupo."."id_grupo FROM materia, profesor, grupo, ins_alu_grupo WHERE ( ins_alu_grupo."."id_grupo = grupo."."id_grupo AND profesor."."id_profesor = grupo."."id_profesor AND materia."."id_materia = grupo."."id_materia AND ins_alu_grupo."."periodo = '".$period."')";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}

		public function ObtenInfoSalones($period){ //Funcion para obtener la ingo de los salones (por periodo) (Salon, materia, grupo, profesor, horario :C)
			$query = "SELECT salon."."id_salon, materia."."nom_materia, profesor."."nom_profesor, grupo."."id_grupo FROM salon, ins_alu_grupo, materia, profesor, grupo, horario WHERE ( salon."."id_salon = horario."."id_salon AND profesor."."id_profesor = grupo."."id_profesor AND materia."."id_materia = grupo."."id_materia AND horario."."id_grupo = grupo."."id_grupo AND ins_alu_grupo."."id_grupo = grupo."."id_grupo AND ins_alu_grupo."."periodo = '".$period."')";

			$resultado = ($this->db->query($query)->result_array());
			return $resultado;

		}

		public function buscaidGrupo($nombreGrupo,$idProfe){
			$query = "SELECT id_materia FROM materia WHERE nom_materia = '".$nombreGrupo."'"; 
			$resultado = ($this->db->query($query)->row_array());
			$resultado = $resultado['id_materia'];
			$query = "SELECT id_grupo FROM grupo WHERE id_materia = '".$resultado."'AND id_profesor = '".$idProfe."'"; 
			$resultado = ($this->db->query($query)->row_array());
			$resultado = $resultado['id_grupo'];
			return $resultado;
		}

		public function buscaIdAlumnos($id_grupo){
			$query ="SELECT id_alumno FROM ins_alu_grupo WHERE id_grupo = '".$id_grupo."'"; 
			$resultado = ($this->db->query($query)->result_array());
			
			return $resultado;
		}

		public function buscaAlumosGrupo($idProfe,$id_grupo){
<<<<<<< HEAD
			$query ="SELECT alumno."."nom_alumno, alumno."."id_alumno, grupo."."id_grupo FROM alumno, ins_alu_grupo, grupo, profesor WHERE alumno."."id_alumno = ins_alu_grupo."."id_alumno AND grupo."."id_profesor = profesor."."id_profesor AND grupo."."id_grupo = ins_alu_grupo."."id_grupo AND profesor."."id_profesor = '".$idProfe."'AND ins_alu_grupo."."id_grupo = '".$id_grupo."'";
=======
			$query ="SELECT alumno."."nom_alumno, alumno."."id_alumno, grupo."." FROM alumno, ins_alu_grupo, grupo, profesor WHERE alumno."."id_alumno = ins_alu_grupo."."id_alumno AND grupo."."id_profesor = profesor."."id_profesor AND grupo."."id_grupo = ins_alu_grupo."."id_grupo AND profesor."."id_profesor = '".$idProfe."' AND ins_alu_grupo."."id_grupo = '".$id_grupo."'";
>>>>>>> 2a59c71d2f152b826c21e52284d0355e0a005e40
			$resultado = ($this->db->query($query)->result_array());
			return $resultado;


		}


		}

		public function ObtenAlumnosGrupo($grupo){ //Obtiene los alumnos de un grupo especifico
			$query ="SELECT alumno."."nom_alumno, alumno."."id_alumno FROM alumno, ins_alu_grupo, grupo, profesor WHERE alumno."."id_alumno = ins_alu_grupo."."id_alumno AND  AND grupo.id_grupo = ins_alu_grupo.id_grupo AND grupo."."nom_grupo = '".$grupo."'";
			$resultado = ($this->db->query($query)->result_array());

			var_dump($query);
			die();
			return $resultado;
			
		}
		
<<<<<<< HEAD
=======

>>>>>>> 2a59c71d2f152b826c21e52284d0355e0a005e40
		/**public function buscaAlumosGrupo($idProfe){
			$query ="SELECT alumno.nom_alumno, alumno.id_alumno FROM alumno, ins_alu_grupo, grupo, profesor WHERE alumno.id_alumno = ins_alu_grupo.id_alumno AND grupo.id_profesor = profesor.id_profesor AND grupo.id_grupo = ins_alu_grupo.id_grupo AND profesor.id_profesor = '".$idProfe."'";
			$resultado = ($this->db->query($query)->row_array());

			
			return $resultado;
		}*/
<<<<<<< HEAD

=======
>>>>>>> 2a59c71d2f152b826c21e52284d0355e0a005e40

		public function buscaIdInscripcion($id_alumno,$id_grupo){
			$query = "select id_inscripcion FROM ins_alu_grupo WHERE id_alumno = '".$id_alumno."' and id_grupo = '".$id_grupo."'";
			$resultado = ($this->db->query($query)->row_array());
			$resultado = $resultado['id_inscripcion'];
			return $resultado;
		}

		public function ingresaCalificacion($calificacion,$tipo_examen,$id_inscripcion){
			
			$query = "INSERT INTO calificacion (id_calificacion, calificacion, id_tipo_examen, id_inscripcion) VALUES (NULL, '".$calificacion."', '".$tipo_examen."', '".$id_inscripcion."')";
			$this->db->query($query);
			
		}
	}
?>
