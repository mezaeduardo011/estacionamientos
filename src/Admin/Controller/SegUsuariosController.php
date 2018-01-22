<?php
namespace APP\Admin\Controller;
use APP\Admin\Model;
use JPH\Core\Commun\Security;

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 25/09/2017
 * @version: 1.0
 * @namespace APP\Admin\Controller
 */ 

class SegUsuariosController extends Controller
{
    use Security;
    public $model;
    public $session;

    // Variables de Seguridad asociado a los roles
    private $apps;
    private $entidad;
    private $vista;
    private $permisos;
    public $comps;

   public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->hoSegUsuariosModel = new Model\SegUsuariosModel();
       $this->hoSegLogUsuariosModel = new Model\SegLogAutenticacionModel();
       $this->hoSegLogAccionesModel = new Model\SegLogAccionesModel();
       $this->hoSegPerfilsModel = new Model\SegPerfilModel();

       // Variables necesaria para el tema de seguridad de cada vista
       $this->valSegPerfils = new Model\SegUsuariosPerfilModel();
       $this->apps = $this->pathApps(__DIR__);
       $this->entidad = $this->hoSegUsuariosModel->tabla;
       $this->vista = $this->pathVista();
       $this->comps = $this->apps .' - '. $this->entidad .' - '. $this->vista;
   }

    /**
    * Listar registros de SegUsuarios
    * @param: GET $resquest
    */
   public function runSegUsuariosIndex($request)
   {
     $this->tpl->addIni();
     //$listado = $this->hoSegUsuariosModel->getSegUsuariosListar($request);
     $roles = $this->hoSegPerfilsModel->getSegPerfilListarCombo();
     $this->tpl->add('usuario', $this->getSession('usuario'));
     $this->tpl->add('roles', $roles);
     $this->tpl->renders('view::seguridad/segUsuarios/'.$this->pathVista().'/index');
   }

    /**
     * Perfil del SegUsuarios
     * @param: GET $resquest
     */
    public function runSegUsuariosPerfil($request)
    {
        $this->tpl->addIni();
        //$listado = $this->hoSegUsuariosModel->getSegUsuariosListar($request);
        $roles = $this->hoSegPerfilsModel->getSegPerfilListarCombo();
        $this->tpl->add('usuario', $this->getSession('usuario'));
        $this->tpl->add('roles', $roles);
        $this->tpl->renders('view::seguridad/segUsuarios/usuarios/perfil');
    }

    /**
    * Listar registros de SegUsuarios
    * @param: POST $resquest
    * @return: JSON $result
    */
   public function runSegUsuariosListar($request)
   {
       // Validar roles de acceso;
       $this->permisos = 'CONSULTA|CONTROL TOTAL';
       //$this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

       // Bloque de proceso de la grilla
       $result = $this->formatRows($request->getParameter('obj'));

       // Procesar los datos del modelo para el paginado
       $rows = $this->hoSegUsuariosModel->getSegUsuariosListar($request->getParameter(),$result);

       // Exportar el resultado en xml para mostrar los datos
       $this->xmlGridList($rows);
   }

    /**
     * Listar log de registro autenticacion
     * @param: POST $resquest
     * @return: JSON $result
     */
    public function runSegLogAutenticacion($request)
    {

        // Bloque de proceso de la grilla
        $result = $this->formatRows($request->getParameter('obj'));

        // Procesar los datos del modelo para el paginado
        $rows = $this->hoSegLogUsuariosModel->getSegLogUsuariosListar($request->getParameter(),$result);


        // Exportar el resultado en xml para mostrar los datos
        $this->xmlGridList($rows);
    }

    /**
     * Listar log de registro autenticacion
     * @param: POST $resquest
     * @return: JSON $result
     */
    public function runSegUsuariosShowAcciones($request)
    {


        // Bloque de proceso de la grilla
        $result = $this->formatRows($request->getParameter('obj'));

        // Procesar los datos del modelo para el paginado
        $rows = $this->hoSegLogAccionesModel->getSegLogUsuariosAccionesListar($request->getParameter(),$result);

        // Exportar el resultado en xml para mostrar los datos
        $this->xmlGridList($rows);
    }

    /**
    * Crear registros de SegUsuarios
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegUsuariosCreate($request)
   {
      //$this->hoSegPerfilsModel->getSegPerfilRelacionUser($request->roles);
      $result = $this->hoSegUsuariosModel->setSegUsuariosCrsegLogCreateLogineate($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='1';
        $dataJson['msj']='Error en procesar el registro';
      }else{;
        $dataJson['error']='0';
        $dataJson['msj'] = 'Registro efectuado exitosamente';
      }
      $this->json($dataJson);
   }

    /**
    * Ver registros de SegUsuarios
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegUsuariosShow($request)
   {
      $result = $this->hoSegUsuariosModel->getSegUsuariosShow($request->postParameter());
      $this->json($result);
   }

    /**
     * Ver registro
     * @param: POST $resquest
     * @return: JSON $result
     */
   public function runShowAccionesAuditoria($request)
   {
       $id = $this->validateRows('NUM', $request->postParameter('item'));
       if($id) {
           $result = $this->hoSegLogAccionesModel->showAcciones($request->postParameter('item'));
           $this->json($result);
       }else{
           // Non-Authoritative Information
           $dataJson['error']='1';
           $dataJson['msj'] = 'Error en procesar la actualizacion';
           $this->json($dataJson,203);
       }

   }
   
   /**
    * Methodo encargado de mostrar  la auditoria general del sistema el monitor
    * @return view de auditoria del todo el sistema
    */
   public  function runSegShowAuditoria($request){
       $this->tpl->addIni();
       $this->tpl->add('usuario', $this->getSession('usuario'));
       $this->tpl->renders('view::seguridad/segUsuarios/usuarios/auditoriaAll');
   }

   public  function runLogMetrica(){
       $metrica['navegador'] = $this->hoSegLogUsuariosModel->segLogMetricaNavegador();
       $metrica['host'] = $this->hoSegLogUsuariosModel->segLogMetricaHost();
       $metrica['accion'] = $this->hoSegLogUsuariosModel->segLogMetricaAccion();
       $this->json($metrica);
   }

    /**
    * Eliminar registros de SegUsuarios
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegUsuariosDelete($request)
   {
      $result = $this->hoSegUsuariosModel->remSegUsuariosDelete($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='0';
        $dataJson['msj']='Registro eliminado exitosamente';
      }else{
        $dataJson['error']='1';
        $dataJson['msj'] = 'Error en procesar la actualizacion';
      }
      $this->json($dataJson);
   }

    /**
    * Actualizar registros de SegUsuarios
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegUsuariosUpdate($request)
   {
      $result = $this->hoSegUsuariosModel->setSegUsuariosUpdate($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='0';
        $dataJson['msj']='Actualizacion efectuado exitosamente';
      }else{
        $dataJson['error']='1';
        $dataJson['msj'] = 'Error en procesar la actualizacion';
      }
        $this->json($dataJson);
   }

   public function runSegUsuariosAuditoria()
   {
       $this->tpl->addIni();
       //$listado = $this->hoSegUsuariosModel->getSegUsuariosListar($request);
       $roles = $this->hoSegPerfilsModel->getSegPerfilListarCombo();
       $this->tpl->add('usuario', $this->getSession('usuario'));
       $this->tpl->add('roles', $roles);
       $this->tpl->renders('view::seguridad/segUsuarios/usuarios/auditoria');
   }

    /**
     * Ver registros de SegUsuarios
     * @param: POST $resquest
     * @return: JSON $result
     */
    public function runSegUsuariosShowAuditoria($request)
    {
       $datos=explode('|',base64_decode($request->postParameter('getItemShow')));
       $valor['data']=$datos[0];
       $result = $this->hoSegUsuariosModel->getSegUsuariosShow((object)$valor);
       $this->json($result);

    }
}
?>
