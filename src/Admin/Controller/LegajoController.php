<?php
namespace APP\Admin\Controller;
use JPH\Core\Commun\Security;
use APP\Admin\Model AS Model;

/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 26/01/2018
 * @version: 2.0
 */ 

class LegajoController extends Controller
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
       $this->hoLegajoModel = new Model\LegajoModel();
       $this->valSegPerfils = new Model\SegUsuariosPerfilModel();
       $this->apps = $this->pathApps(__DIR__);
       $this->entidad = $this->hoLegajoModel->tabla;
       $this->vista = $this->pathVista();
       $this->comps = $this->apps .' - '. $this->entidad .' - '. $this->vista;
   }

    /**
    * Mostrar el index de la vistaLegajo
    * @param: GET $resquest
    */ 
   public function runLegajoIndex($request)
   {
     $this->permisos = 'CONSULTA|CONTROL TOTAL';
     $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos));

     $this->tpl->addIni();
     $this->tpl->add('usuario', $this->getSession('usuario'));
     $this->tpl->renders('view::vistas/legajo/'.$this->pathVista().'/index');
   }

    /**
    * Listar registros de Legajo
    * @param: POST $resquest
    * @return: XML $result
    */ 
   public function runLegajoListar($request)
   {
      // Validar roles de acceso;
      $this->permisos = 'CONSULTA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Bloque de proceso de la grilla
      $result = $this->formatRows($request->getParameter('obj'));

      // Procesar los datos del modelo para el paginado
      $rows = $this->hoLegajoModel->getLegajoListar($request->getParameter(),$result);

      // Exportar el resultado en xml para mostrar los datos
      $this->xmlGridList($rows);
   }

    /**
    * Crear registros de Legajo
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runLegajoCreate($request)
   {
      // Verificar permisologia
      $this->permisos = 'ALTA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Verificar las mascaras
      parent::runValidarMascarasVista('vistas/legajo/', $this->pathVista(),$request->postParameter());

      $result = $this->hoLegajoModel->setLegajoCreate($request->postParameter());
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
    * Ver registros de Legajo
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runLegajoShow($request)
   {
      // Verificar permisologia
      $this->permisos = 'CONSULTA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      $result = $this->hoLegajoModel->getLegajoShow($request->postParameter());
      $this->json($result);
   }

    /**
    * Eliminar registros de Legajo
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runLegajoDelete($request)
   {
      // Verificar permisologia
      $this->permisos = 'BAJA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      $result = $this->hoLegajoModel->remLegajoDelete($request->postParameter());
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
    * Actualizar registros de Legajo
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runLegajoUpdate($request)
   {
      // Verificar permisologia
      $this->permisos = 'MODIFICACION|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Verificar las mascaras
      parent::runValidarMascarasVista('vistas/legajo/',$this->pathVista(),$request->postParameter());

      $result = $this->hoLegajoModel->setLegajoUpdate($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='0';
        $dataJson['msj']='Actualizacion efectuado exitosamente';
      }else{
        $dataJson['error']='1';
        $dataJson['msj'] = 'Error en procesar la actualizacion';
      }
        $this->json($dataJson);
   }
}
?>
