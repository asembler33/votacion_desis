
<?php

  // Importa el archivo funcionesGenerales.php que contiene la clase funcionesGenerales
  require_once 'funcionesGenerales.php';

  $utilidad = new funcionesGenerales();  


  // Verifica el método de la solicitud HTTP
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Si la solicitud es GET

    // Verifica la ruta especificada en la solicitud
    if ( $_REQUEST['ruta'] === 'regiones'){

      echo $utilidad->getFilas('regiones');

    }else if ( $_REQUEST['ruta'] === 'candidatos'  ){

      echo $utilidad->getFilas('candidatos');

    }else if ( $_REQUEST['ruta'] === 'medios_informativos'  ){

      echo $utilidad->getFilas('medios_informativos');

    
    }else if ( $_REQUEST['ruta'] === 'validarRUT'  ){

      echo $utilidad->validarExistenciaRUT($_REQUEST['rut']);

    }else if ( $_REQUEST['ruta'] === 'comunas' && isset( $_REQUEST['idRegion'] ) ){

      echo $utilidad->getFilas('comunas',$_REQUEST['idRegion'], 'id_region', 'entero');

    }
    
  }else{

    
    if (isset( $_POST ) ){
  
      $utilidad->insertarDatosVotacion($_POST);
  
    } 

  }



?>