<?php

require_once 'db.php';


class funcionesGenerales {

    
    /**
     * Función para búsqueda genérica según tabla de base de datos a utilizar.
     *
     * @param string $nombreTabla Nombre de la tabla em la base de datos MySQL. Atributo obligatorio
     * @param integer $identificador Identificador cualquiera que se quiera consultar a la tabla en cuestión atributo opcional.
     * @param string $campoBusqueda Nombre del campo a buscar en la tabla en cuestión.
     * @return array $arreglo Se devuelve el conjunto de filas según criterio buscado.
    */

    function getFilas($nombreTabla, $identificador = null, $campoBusqueda = null) {
        global $conn;

        if ( !$identificador == null) {

            $resultado = $conn->prepare("SELECT * FROM $nombreTabla WHERE $campoBusqueda = ?");
            

            $resultado->bind_param("i", $identificador);

            $resultado->execute();
            $puntero = $resultado->get_result();

        }else{
            $puntero = $conn->query("SELECT * FROM $nombreTabla");
        }

        
        $arreglo = array();
        while ($fila = $puntero->fetch_assoc()) {
            $arreglo[] = $fila;
        }

        return json_encode($arreglo);
    }

    /**
     * Función para la búsqueda del RUT según tabla votantes.
     *
     * @param string $RUT Parámetro que se utiliza para saber si existe el votante y para envitar laduplicidad. Atributo obligatorio
     
     * @return string $respuesta Se devuelve la respuesta 'true' o 'false' en modo string para su verificación en la librería jquery validate.
    */

    function validarExistenciaRUT($RUT) {
        global $conn;

        if ( !$RUT == null) {

            $resultado = $conn->prepare("SELECT * FROM votantes WHERE rut = ?");
                        
            $resultado->bind_param("s", $RUT);

            $resultado->execute();
            $puntero = $resultado->get_result();

            if ( $puntero->num_rows > 1 ) {
                $respuesta = 'false';
            }else{
                $respuesta =  'true';
            }
        }

        return $respuesta;
    }

    /**
     * Función para la sanitización de variables de entrada y prevenir SQL injection.
     *
     * @param string $entrada Variable de entrada proveniente desde un formulario. Atributo obligatorio
     
     * @return string mysqli_real_escape_string($GLOBALS['conn'], $entrada); Se devuelve limpia la entrada para su posterior inserción.
    */

    function limpiarEntrada($entrada) {
        // Utilizar mysqli_real_escape_string para escapar y prevenir SQL injection
        return mysqli_real_escape_string($GLOBALS['conn'], $entrada);
    }


    /**
     * Función para la inserción datos en tabla votantes desde un formulario de entrada .
     *
     * @param string "$formulario" Variable de entrada proveniente desde un formulario. Atributo obligatorio
     
     * @return string  Devuelve mensaje exitoso de inserción.
    */

    function insertarDatosVotacion(&$formulario){

        global $conn;
        
   
            $idRegion = $this->limpiarEntrada($formulario['slcRegion']);
            $idComuna = $this->limpiarEntrada($formulario['slcComuna']);
            $idCandidato = $this->limpiarEntrada($formulario['slcCandidato']);
            $nombreApellido = $this->limpiarEntrada($formulario['nombreApellido']);
            $alias = $this->limpiarEntrada($formulario['alias']);
            $email = $this->limpiarEntrada($formulario['email']);
            $rut = $this->limpiarEntrada($formulario['rut']);
        
            // Consulta preparada para la inserción
            $sqlVotantes = "INSERT INTO votantes (`id_region`, `id_comuna`, `id_candidato`, `nombre_apellido`, `alias`, `rut`, `email`) 
                    VALUES (?, ?, ?, ? , ?, ?, ?)";
            
            $stmt = $conn->prepare($sqlVotantes);
        
            
            if ($stmt) {
                // Vincular parámetros y ejecutar la consulta
                $stmt->bind_param("iiissss", $idRegion, $idComuna, $idCandidato, $nombreApellido, $alias, $rut, $email);
                $stmt->execute();
        
                
                if ($stmt->affected_rows > 0) {
                    $idVotante = $stmt->insert_id;
                    $stmt->close();
                    foreach($formulario['optInformacion'] as $idTipoMedioInformacion){

                        $sqlInsertRelVotantesTipoInformativo = "INSERT INTO rel_votantes_tipo_medio (id_votante, id_tipo_medio_informativo) VALUES(?, ?)"; 

                        $stmt = $conn->prepare($sqlInsertRelVotantesTipoInformativo);
                        $valorNuevoIdTipoMedio = intval($idTipoMedioInformacion);
                        $stmt->bind_param("ii", $idVotante, $valorNuevoIdTipoMedio);
                        $stmt->execute();
                    }

                    echo "1";
                } else {
                    echo "Error al insertar datos";
                }
        
                // Cerrar la consulta preparada
                $stmt->close();
            } else {
                // Manejar el error de preparación
                echo "Error en la preparación de la consulta";
            }
    
        


    }


}
?>