<?php
	class ModelosP extends CI_Model{

		public function __construct(){
			$this->load->database();
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
				return $nomMaterias; //Regresa ya el vector con el nombre de las materias
			}
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

		public function AgregaInscriAlu($idGrupo, $idAlu){ //Función para agregar la Inscripción de un alumno
			$query="INSERT INTO ins_alu_grupo (id_grupo, id_alumno) VALUES('".$idGrupo."','".$idAlu."')";
			$resultado = $this->db->query($query);
		}

		public function ObtenMasInfo($nom){ //Obtiene más informacion necesaria para los reportes del alumno (PLaN ESTUDIO, CARRERA)
			$query = "SELECT plan_estudio, nom_carrera FROM plan_estudio, alumno, carrera WHERE (carrera."."id_carrera = plan_estudio."."id_carrera AND plan_estudio."."id_plan = alumno."."id_plan AND alumno."."nom_alumno = '".$nom."')";
			$resultado = ($this->db->query($query)->row_array());
			return $resultado;
		}

		public function ObtenTiraMaterias($nom){ //Obttiene la tira de Materias de un alumno (Materia)
			$query = "SELECT horario."."id_salon, nom_materia, grupo."."id_grupo, nom_profesor FROM horario, materia, grupo, alumno, ins_alu_grupo, profesor WHERE (horario."."id_grupo = grupo."."id_grupo AND materia."."id_materia = grupo."."id_materia AND alumno."."id_alumno = ins_alu_grupo."."id_alumno AND ins_alu_grupo."."id_grupo = grupo."."id_grupo AND profesor."."id_profesor = grupo."."id_profesor AND alumno."."nom_alumno = '".$nom."')";
			$resultado = ($this->db->query($query)->result_array());
			return $resultado;
		}
	}
?>
