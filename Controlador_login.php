<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* Controladores de la base de datos
*/
class Controlador_login extends CI_Controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->model('Usuarios_model');
		$this->load->helper('url');
		$this->load->library('session');
	}
	//Controlador para el login 

	public function login (){
		$usuario=$this->input->post('nombre');
		$clave=$this->input->post('no_empleado');
		
		if ($usuario == NULL || $clave == NULL){
			redirect('Inicio');
		}

		
		$consultaR = $this->Usuarios_model->consulta_us($usuario); 
		
		if($consultaR!=null && $consultaR['no_empleado']==$clave){

			
			
			$this->session->set_userdata('clave_u',$consultaR['no_empleado']);

			$tipoAd=$this->Usuarios_model->consultaPerfil($usuario);
			
			$this->session->set_userdata("perfil", $tipoAd);
			$this->session->set_userdata("usuario", $usuario);


			if($tipoAd=="trabajador"){

				$this->solicitud($usuario);
			}
			if($tipoAd=="supervisor"){
				$this->agregar();
			}
		}elseif($consultaR==null or $consultaR['no_empleado']!=$clave){
			redirect('inicio');
		}		
		
	}


	public function logout(){
		$this->session->sess_destroy();
		redirect('Inicio');
	}

	public function solicitud($usuario){
		$data = $this->Usuarios_model->consulta_us($usuario);
		$data['num_folio'] = $this->Usuarios_model->obtenFolio();

		$data['num_folio'] = (int)$data['num_folio']['max(folio)'];
		
		if($data['num_folio'] == NULL){
			$data['num_folio'] = 1;			
		}else{
			$data['num_folio'] = $data['num_folio']+1;
		}
		$this->load->view('vistasP/vistaSolicitud', $data);
	}

	public function agregar(){
		redirect('vistaAdministrador');
	} 

	public function verConfirmar(){
		redirect('vistaConfirmar');
		//$this->load->view('vistasP/vistaConfirmar');
	}

	public function ConfirmarSoli(){
		$cve_sol=$this->input->post('clave');
		$claveS['registroT']=$this->Usuarios_model->busca_sol($cve_sol);
		if ($cve_sol == null){
			$this->load->view('vistasP/vistaConfirmar');
		}
		if($claveS["registroT"]!=null){
			$this->load->view('vistasP/vistaC',$claveS);			
			//redirect('vistaC');
		}else{
			redirect('vistaConfirmar');
			// lanzar una ventana emergente y regresar a la pagina de administrador
		}

	} 

	 	//$cve=$this->input->post('clave');
		//$data['clave'] = $this->Usuarios_model->busca_sol($cve_sol);
	public function confirmar_solicitud(){
		$cve_sol=$this->input->post('folio');
		$this->Usuarios_model->confirmar($cve_sol);
		$this->load->view('vistasP/exito');
	}

	public function regresar(){
		redirect('vistaAdministrador');
	}

	public function agregar_trabajador(){
		redirect('vistaAgregarT');

	}
	public function Cargar_VistaEditar(){
		redirect('vista_Busqueda');
	}

	public function agregarT(){
		if(!$_POST['n_empleado']  or !$_POST['nombre'] or !$_POST['a_paterno'] or !$_POST['a_materno'] or  !$_POST['direccion'] or !$_POST['telefono'] or !$_POST['email'] or !$_POST['fecha'] or !$_POST['t_empleado'] or !$_POST['cve_jefe']){
			redirect('vistaAgregarT');
			//agregar un warning para que el usuario agregue todo.

		}
		else {

			$no_empleado=$this->input->post('n_empleado');
			$nombre=$this->input->post('nombre');
			$a_paterno=$this->input->post('a_paterno');
			$a_materno=$this->input->post('a_materno');
			$direccion=$this->input->post('direccion');
			$telefono=$this->input->post('telefono');
			$email=$this->input->post('email');
			$fecha=$this->input->post('fecha');
			$t_empleado=$this->input->post('t_empleado');
			$Sindicalizado=$this->input->post('Sindicalizado');
			$cve_jefe=$this->input->post('cve_jefe');
			$a= $this->Usuarios_model->consulta_numero($no_empleado);
			if ($a!=null){
				// echo "trabajo ya existente";
				$this->load->view('vistasP/usuarioAgregado');				
			}else{
				//$data['insert_empleado']= 
				$ins=$this->Usuarios_model->ingresar_usuario($no_empleado,$nombre,$a_paterno,$a_materno,$direccion,$fecha,$email,$t_empleado,$Sindicalizado,$cve_jefe,$telefono);
				if ($ins){
					redirect('exito1.php');
					//$this->regresar();
				}else{
					redirect('fail.php');
				}

			}
		}
	}

	public function eliminar_trabajador(){
		redirect('vistaEliminarT');
	}

	public function funcionEliminarT(){
		$usuarioE=$this->input->post('nombre');
		$claveE=$this->input->post('n_empleado');
		$existe =$this->Usuarios_model->consulta_us($usuarioE);
		$tieneSolicitudes = $this->Usuarios_model->buscaSolicitud($claveE);


		if ($tieneSolicitudes==null && $existe!=null && $claveE==$existe['no_empleado']){
			$varAux = $existe['nombre'];
			$this->Usuarios_model->eliminaT($varAux);
			$this->load->view('vistasP/exito');
		}elseif (sizeof($tieneSolicitudes)>0 && $existe!=null && $claveE==$existe['no_empleado']) {
			//$arrayClave = array('clave' => $claveE,);
			$data['claveE'] = $claveE;
			$this->load->view('vistasP/vistaEliminarSolicitud',$data);
		}else{
			redirect('vistaEliminarT.php');
		}
	}


	public function agregaSol(){
		$folio = $this->input->post('num_folio');
		$fecha = $this->input->post('fecha_d_sol');
		$num_em = $this->input->post('num_empleado');
		$fechaSol = $this->input->post('fecha_a_sol');
		$cDias = $this->input->post('cantidad_dias');
		$motivo = $this->input->post('Motivo');
		$datos['nombre'] = $this->input->post('nombre_empleado');
		$datos['no_empleado'] = $this->input->post('num_empleado');
		$this->Usuarios_model->agregaSoli($folio, $fecha, $fechaSol, $cDias, $motivo, $num_em);
		$this->load->view('vistasP/exitoT');
	  
	}


	  public function enviar_vista_Listado(){
	  	$listado ['pos1']= array('titulo' => 'empleado','solicitud'=>$this->Usuarios_model->generar_solicitudes());
	  	$listado['pos2']= array('titulo' => 'empleado','jugador'=>$this->Usuarios_model->generar_nombres());
	  	$this->load->view('vistasP/muestra_empleados',$listado);
	  	//redirect('muestra_empleados');
	  }

	  public function eliminarSolicitud(){	
	  	$Num = $this->input->post('no_emp');
	  	$this->Usuarios_model->delete_sol($Num);
	  	$this->load->view('vistasP/exito');
	  }
	  public function buscar_empleado(){
	  	redirect('vista_Buscar');
	  }


	  	public function busca(){ //Tambien se usa para generar los reportes
	  	$n_empleado = $this->input->post('n_empleado'); 
	  	$fecha_actual=$this->input->post('fecha_actual');
	  	$numero = $this->input->post('n_empleado');
	  	$nombre=$this->input->post('nombre');
	  	$nombreAux = $this->Usuarios_model->consulta_us($nombre);
	  	$numeroAux = $this->Usuarios_model->consulta_numero($numero);
	  	if ($nombreAux !=null && $numeroAux!=null){
	  		$fecha_ingreso = $this->Usuarios_model->consulta_Fecha_Ingreso($nombre);
	  		$fechaAux = $fecha_ingreso['f_ingreso'];
	  		$fecha_total = $this->Usuarios_model->checa_Fecha($fechaAux,$fecha_actual);
	  		$FA = $fecha_total['age'];
	  		$nueva = (int)$FA;
	  		$Sindicalizado = $this->Usuarios_model->checaSindicalizado($nombre);
	  		$numero_solicitudes = $this->Usuarios_model->numeroSolicitudes($nombre);


	  		$aux = $numero_solicitudes['diego'];
	  		
	  		$nueva2=(int)$aux; //numero de solicitutdes NUEVA años trabajando
	  
	  		if($Sindicalizado['sindicalizado']==0){//0 es para no sindicalizado

	  			$datos['nombre']=$nombre; //ESTO ESTA SUPER RARO!!!!!
	  			$datos['n_sol'] = $nueva2;
	  			$datos['d_descanso'] = $nueva-$nueva2;
	  			$datos['n_empleado'] = $n_empleado;

	  			$this->load->view('vistasP/mostrar_dias_disponibles2', $datos);

	  		}elseif ($Sindicalizado['sindicalizado']==1){//1 es para sindicalizado
	  			$datos['nombre']=$nombre;
	  			$datos['n_sol']=$nueva2;
	  			$datos['d_descanso']=($nueva*2)-$nueva2;
	  			$datos['n_empleado'] = $n_empleado;
	 
	  			$this->load->view('vistasP/mostrar_dias_disponibles2',$datos);
	  		
	  		}
	  	}else{
	  		$this->buscar_empleado();

	  	}
	  	}
	  

	  public function EliminarSol(){
	  	$cve_sol=$this->input->post('clave');
	  	// Checar si existe la solicitud a borrar
	  	$resul = $this->Usuarios_model->checaSiExiste($cve_sol);

	  	if($resul != NULL){ //No existe el registro
	  		$this->Usuarios_model->deleteSol($cve_sol);
	  		$this->load->view('vistasP/exito');
	  	}else{
	  		$this->load->view('vistasP/noExiste');
	  	}
	  }

	  public function elimin_sol(){
		$this->load->view('vistasP/vistaEliminSol');		
	  }


	  public function Obtener_infoParaReporte(){
	  	$nombre = $this->input->post('nombre');
	  	$no_empleado = $this->input->post('n_empleado');
	  	$datos = $this->Usuarios_model->consulta_us($nombre);
	  	if($datos == NULL){
	  		redirect('vista_Buscar2');
	  	}
	  	$Sindicalizado = $this->Usuarios_model->checaSindicalizado($nombre);	  
	  	$fecha_actual=$this->input->post('fecha_actual'); //Obtiene la fecha actual para generar el reporte
	  	$fechaAux = $datos["f_ingreso"];
	  	$fecha_total = $this->Usuarios_model->checa_Fecha($fechaAux,$fecha_actual);
	  	$dias_dispo = $fecha_total['age'];
	  	$dias_disp = (int)$dias_dispo; //Dias Disponibles
	  	$numero_dias = $this->Usuarios_model->numeroDias($datos['no_empleado']);
	  	$numero_solicitudes = $this->Usuarios_model->numeroSolicitudes($datos['no_empleado']);
	  	$num_dias_sol = $numero_dias['SUM(cantidad_dias)']; //Dias Solicitados y aceptados
	  	//$numero_dias_sol tiene el numero de dias totales que ha solicitado y se han aceptado
	  	$dias_soli = (int)$num_dias_sol; //Se castea a entero, para poder operar
	  	$datos['n_sol'] = $numero_solicitudes['COUNT(*)'];
	  	$datos['dias_restantes'] = $dias_disp - $dias_soli;
	  	$datos['dias_soli'] = $dias_soli;

	  	if($datos['sindicalizado'] == 1){ //Si es sindicalizado, tiene el doble de dias restantes
	  		$datos['dias_restantes'] = ($dias_disp*2) - $dias_soli;
	  	}

	  	if($datos['dias_restantes'] < 0){ //Si pide más dias de los que tiene disponibles y  se los aceptan
	  		$datos['dias_restantes'] = "Debe ".($datos['dias_restantes']*-1)." días";
	  	}


	  	if ($datos != null && ($datos['no_empleado'] == $no_empleado)){
	  		$this->load->view('vistasP/despliega_InfoParaReporte', $datos);
	  	}else{
	  		redirect('vista_Buscar2');
	  	}

	  }


	  public function Obtener_info(){
	  	$no_empleado = $this->input->post('n_empleado');
	  	$nombre = $this->input->post('nombre');
	  	$datos['data'] = $this->Usuarios_model->consulta_us($nombre);
	  	if ($datos['data'] !=null && ($datos['data']['no_empleado'] == $no_empleado)){
	  		$this->load->view('vistasP/despliega_Info', $datos);
	  	}else{
	  		redirect('vista_Busqueda');
	  	}	  	
	  }


	  public function confirmar_SOLI(){
	  	//Se obtiene la informacion del formulario.
	  	$no_empleado = $this->input->post('n_empleado');
	  	$nombre = $this->input->post('nombre');
	   	$apellidoP = $this->input->post('apellidoP');
	  	$apellidoM = $this->input->post('apellidoM');
	  	$direccion = $this->input->post('direccion');
	  	$telefono = $this->input->post('telefono');
	  	$correo_e = $this->input->post('correo_e');
	  	$f_ingreso = $this->input->post('f_ingreso');
	  	$tipo_empleado = $this->input->post('tipo_empleado');
	  	$sindicalizado = $this->input->post('sindicalizado');



	  	$resul = $this->Usuarios_model->upDate($no_empleado, $nombre, $apellidoP,$apellidoM,$direccion,$telefono,$correo_e,$f_ingreso,$tipo_empleado,$sindicalizado);


	  	if ($resul){
	  		$this->load->view('vistasP/exito');
	  	}else{
	  			redirect('vistaAdministrador');
	  	}

	  	
	  }
	  public function Obtener_info2(){
	  	$no_empleado = $this->input->post('n_empleado');
	  	$nombre['name'] = $this->input->post('nombre');
	  	$existe= $this->Usuarios_model->consulta_numero($no_empleado);
	  	
	  
	  	if($existe!=null){
	  		$var['J'] = $this->Usuarios_model->sacarFechas($no_empleado) ;
	  		//var_dump($var['J'][1]['fecha_a_sol']);
	  		$i=0;
	  		$j=0;
	  		while ( $i< sizeof($var['J'])) {
	  			$Afechas[$i] = $var['J'][$j]['fecha_a_sol'];
	  			$i++;
	  			$j++;
	  		}
	  		if($var ==null){
	  			echo "El usuario ".$nombre." No tiene solicitudes";
	  			redirect('vistaAdministrador');
	  		}
	  		else{
	  			
  				
  				$fechasT['date'] = implode("       ", $Afechas);
  							
	  			$this->load->view('vistasP/carga_Datos', $fechasT);
	  		}
	 
	  	}else{
	  		$this->carga_vista2();
	  	}

	  }
	  public function carga_vista2(){
	  	redirect('vista_Buscar');
	  }

	  public function carga_vista3(){
	  	redirect('vista_Buscar2');
	  }

	  public function RespaldosBackUp(){ //Funcion para ir al menú de respaldos (Vista)
	  	$this->load->view('vistasP/RespaldosBackUpDos'); //Nos redirige a la vista para elegir respaldos	  	
	  }

	  public function restoreObackup(){ //Recibe el tipo de respaldo que se va a hacer
	  	$t_respaldo = $this->input->post('t_respaldo');
	  	if($t_respaldo == 'Total'){
	  		$this->RespaldoTotal();
	  	}elseif ('Restauracion') {
	  		$this->load->view('vistasP/Restauracion');
	  	}

	  }

	  public function RespaldoTotal(){ //Funcion para hacer un respaldo total de la base de datos
	  	$respuesta  = $this->Usuarios_model->backUpTotal(); //Llama a la funcion para el respaldo y regresa $Respuesta
	  	if($respuesta == 0){ //Si se regresa un 0 es exito
	  		redirect('exito1.php');	
	  	}else{  //En otro caso es un fail
	  		redirect('fail.php');
	  	}
	  }


	  public function RestoreBD(){
	  	$nameRespaldo = $this->input->post('file');
	  	if ($nameRespaldo != "") {
	  		$respuesta = $this->Usuarios_model->restore($nameRespaldo);
	  		if($respuesta == 0){ //Si se regresa un 0 es exito
	  			redirect('exito1.php');	
	  		}else{  //En otro caso es un fail
	  			redirect('fail.php');
	  		}
	  	}else{
	  		redirect('fail.php');
	  	}
	  }

	  public function DeleteDB(){
	  	$nombre = $_POST['nombreDB'];
	  	$respuesta = $this->Usuarios_model->DeleteDB($nombre);
	  	if($respuesta){ //Si se regresa un 0 es exito
	  		redirect('exito.php');	
	  	}else{  //En otro caso es un fail
	  		redirect('fail.php');
	  	}
	  }

	  public function Genera_reporteXML(){
	  	//Obtener los datos del formulario (Se guardan el vector "$datos")

	  	$datos['n_empleado'] = $this->input->post('n_empleado');
	  	$datos['nombre'] = $this->input->post('nombre');
	   	$datos['apellidoP'] = $this->input->post('apellidoP');
	  	$datos['apellidoM'] = $this->input->post('apellidoM');
	  	$datos['numero_sol'] = $this->input->post('numero_sol'); 
	  	$datos['dias_res'] = $this->input->post('dias_res');
	  	$datos['direccion'] = $this->input->post('direccion');
	  	$datos['telefono'] = $this->input->post('telefono');
	  	$datos['correo_e'] = $this->input->post('correo_e');
	  	$datos['f_ingreso'] = $this->input->post('f_ingreso');	  	
	  	$datos['sindicalizado'] = $this->input->post('sindicalizado');
	  	$datos['dias_sol'] = $this->input->post('dias_sol');

	  	$respuesta = $this->Usuarios_model->Genera_reporteXML($datos); //Le enviamos los datos a la funcion
	  	if($respuesta == 0){
	  		redirect('exito1.php');
	  	}else{
	  		redirect('fail.php');
	  	}
	  }

	  public function carga_buscarJefe(){
	  	redirect('buscarJefe');
	  }


	  public function Genera_XMLTotal(){
	  	$respuesta = $this->Usuarios_model->Genera_XMLTotal();
	  	if($respuesta == 0){
	  		redirect('exito1.php');
	  	}else{
	  		redirect('fail.php');
	  	}
	  }

	  public function recibeNoJefe(){
		$cve_jefe = $cve_jefe=$this->input->post('cve_jefe');

		//$cve_jefe = 1;
		if ($cve_jefe ==null){
			redirect('buscarJefe');

		}else{
			$resultado = $this->Usuarios_model->buscaPorJefe($cve_jefe);

			$respuesta = $this->generaXML2($resultado,$cve_jefe);
			if ($respuesta==0){
				$this->load->view('vistasP/exito.php');
			}else{
				$this->load->view('error');
			}			
		}

	}


	public function generaXML2($resultado,$cve_jefe){

			ob_clean(); //Se limpia el buffer para poder escribir 

			$reporte = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><ReporteJefe></ReporteJefe>');
			//Header('Content-type: text/xml'); //Se crea un XML
			

			//Se obtienen todos los datos del formulario para generar el XML
			

			for ($i=0; $i < count($resultado); $i++) {

			$Trabajador = $reporte->addChild('Empleado');
			$Trabajador->addAttribute('No_emp', $resultado[$i]['no_empleado']);
			$Nombre = $Trabajador->addChild('Nombre_Completo');
			$Nombre->addAttribute('Nombre', $resultado[$i]['nombre']);
			$ApellidoP = $Nombre->addChild('Nombre', $resultado[$i]['nombre']);
			$ApellidoP = $Nombre->addChild('Apellido_P', $resultado[$i]['apellidoP']);
			$ApellidoM = $Nombre->addChild('Apellido_M', $resultado[$i]['apellidoM']);
			//$Info = $Trabajador->addChild('Info');
			//$Direccion = $Info->addChild('Direccion', $resultado[$i]['direccion']);
			//$Telefono = $Info->addChild('Telefono', $resultado[$i]['telefono']);
			//$Correo_e = $Info->addChild('Correo_e', $resultado[$i]['correo_e']);
			/*
			$Fecha_Ingreso = $Info->addChild('Fecha_Ingreso', $cve_jefe[$i]['f_ingreso']);
			$No_Solicitudes = $Trabajador->addChild('No_Solicitudes', $cve_jefe[$i]['numero_sol']);
			$No_Solicitudes = $Trabajador->addChild('Días_solicitados', $cve_jefe[$i]['dias_sol']);
			$Dias_restantes = $Trabajador->addChild('Días_restantes', $cve_jefe[$i]['dias_res']);*/
			}


			//Se crea el nombre del archivo XML
			$name_file = ($cve_jefe. "_" .date("d-m-Y"). ".xml");
			//Se abre un archivo(Como no existe, se crea)

			//PARA WINDOWS		
			//$archivo = fopen('C:\Users\eco-4\Desktop\respaldosBase\XML\XML_'.$name_file, 'a');
			
			//PARA UBUNTU
			$archivo = fopen('/home/ubuntu/Desktop/respaldosBases/XML/XML_'.$name_file, 'a');

			fwrite($archivo, $reporte->asXML());
			fclose($archivo);
			return 0;
			 //Imprime el XML		


	}

  }  
?>
