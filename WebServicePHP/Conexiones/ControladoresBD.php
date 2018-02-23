<?php

require 'Database.php';

class Controlador
{
    function __construct()
    {
    }

    //Registro de un nuevo usuario por parte de un administrador
     public static function registrar(
            $cedula, $id_razon_social, $nombre_conductor, $apellido_conductor)
        {
            // Sentencia INSERT

            $comando = "insert into conductores values (?,?,?,?,'',now())";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array(
                    $cedula, $id_razon_social, $nombre_conductor, $apellido_conductor
                    )
            );
            }catch(PDOException $e){
                    return null;
            }
    }


    public static function consultar($parametro){
        
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "select * from usuarios where nombre_usuario = ?";
        try{
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($parametro));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }

    /* Funcion que realiza el cambio de la contraseña del usuario*/

    public static function modificar(
            $nombre, $cedula)
        {
            // Sentencia INSERT
            $comando = "update conductores set nombre_conductor = ? where cedula_conductor = ?";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array(
                    $nombre,
            $cedula)
            );
            }catch(PDOException $e){
                    return null;
            }
        }

    public static function eliminar(
            $cedula)
        {
            // Sentencia DELETE
            $comando = "delete from conductores where cedula_conductor = ?";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array(
                    $cedula)
            );
            }catch(PDOException $e){
                    return null;
            }
        }
    
    
    public static function getNotify(){
        
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "select conductores.nombre_conductor as name , conductores.apellido_conductor as apellido, conductores.cedula_conductor as cedula ,vehiculos.placa_vehiculo as placa,
cargues.consecutivo_cargue as consecutivo,estados_cargues.estado_cargue as estado , DATE_FORMAT(estados_cargues.fecha_hora_cargue , '%r') as hourSatrt
from estados_cargues 
join cargues on estados_cargues.consecutivo_cargue = cargues.consecutivo_cargue
join conductores_vehiculos on conductores_vehiculos.id_conductor_vehiculo = cargues.id_conductor_vehiculo
join conductores on conductores_vehiculos.cedula_conductor = conductores.cedula_conductor
join vehiculos on  conductores_vehiculos.placa_vehiculo = vehiculos.placa_vehiculo
WHERE estados_cargues.estado_cargue =1 or estados_cargues.estado_cargue = 4;";
        try{
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }
    public static function PostDriverAcepto($valorImagen,$valorIdFactura,$valorIdConductor){
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "INSERT INTO declaracion_conductor
        (consecutivo_cargue,
          id_conductor_vehiculo,
          imagen_firma_declaracion_conductor) VALUES (?,?,?)";
        try{
            // Preparar sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($consulta);
            return $sentencia->execute(
            array($valorIdFactura,$valorIdConductor,$valorImagen)
        );
        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }
    
     public static function PosImageEvidencia($valorImagen,$valorIdFactura,$tipoTiempo){
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "INSERT INTO evidencias_fotograficas
        (consecutivo_cargue,
          tiempo_evidencia_fotografica,
          imagen_evidencia_fotografica) VALUES (?,?,?)";
        try{
            // Preparar sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($consulta);
            return $sentencia->execute(
            array($valorIdFactura,$tipoTiempo,$valorImagen)
        );
        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }
    
         public static function registrarIspection(
            $id_factura_cargue,$aspecto_verificado,$estado,$observaciones)
         {
            // Sentencia INSERT

            $comando ="INSERT INTO calidad_inocuidad_puntos_susceptibles (consecutivo_cargue, aspecto_verificado, estado, observaciones) VALUES (?,?,?,?)";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array(
                    $id_factura_cargue,$aspecto_verificado,$estado,$observaciones
                    )
            );
            }catch(PDOException $e){
                    return null;
            }
             
         }


          public static function registrarInocuida(
            $id_factura_cargue,$aspecto_verificado_calidad_inocuidad,$estado_calidad_inocuidad)
         {
            // Sentencia INSERT

            $comando ="INSERT INTO calidad_inocuidad (consecutivo_cargue, aspecto_verificado_calidad_inocuidad, estado_calidad_inocuidad) VALUES (?,?,?)";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array(
                    $id_factura_cargue,$aspecto_verificado_calidad_inocuidad,$estado_calidad_inocuidad
                    )
            );
            }catch(PDOException $e){
                    return null;
            }
             
         }

          public static function getConductorId($factura){
        
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "select conductores.nombre_conductor as name , conductores.apellido_conductor as apellido, conductores.cedula_conductor as cedula ,vehiculos.placa_vehiculo as placa,
cargues.consecutivo_cargue as consecutivo,estados_cargues.estado_cargue as estado , DATE_FORMAT(estados_cargues.fecha_hora_cargue , '%m %d %Y') as fecha
,DATE_FORMAT(estados_cargues.fecha_hora_cargue , '%r') as hourStart
from estados_cargues 
join cargues on estados_cargues.consecutivo_cargue = cargues.consecutivo_cargue
join conductores_vehiculos on conductores_vehiculos.id_conductor_vehiculo = cargues.id_conductor_vehiculo
join conductores on conductores_vehiculos.cedula_conductor = conductores.cedula_conductor
join vehiculos on  conductores_vehiculos.placa_vehiculo = vehiculos.placa_vehiculo
WHERE cargues.consecutivo_cargue = ? ";
        try{
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($factura));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }
    
    public static function  getFacturaProductos($factura){
        
        // Consulta con where para consultar los usuarios con el nombre de usuario guardado en el parametro
        $consulta = "SELECT factura_despacho.id_factura_despacho  as consecutivo,factura_despacho.url_documento as factura, factura_despacho.tipo_documento as tipo, cargues.destino as destino  from factura_despacho 
        join cargues on cargues.consecutivo_cargue =  factura_despacho.consecutivo_cargue where factura_despacho.consecutivo_cargue = ?";
        try{
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($factura));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        }catch (PDOException $e) {
            // Aqui puedes clasificar el error dependiendo de la excepcion
            // para presentarlo en la respuesta Json
            return null;
        }
    }
    
    //modificar cargue cuando se esta en el proceso de despacho
    public static function modificarCargueDespachando($consecutivo)
        {
            // Sentencia INSERT
            $comando = "update  estados_cargues set estado_cargue = 4 where consecutivo_cargue = ?";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array($consecutivo)
            );
            }catch(PDOException $e){
                    return null;
            }
        }

        public static function modificarCargueDespachado($consecutivo)
        {
            // Sentencia INSERT
            $comando = "update  estados_cargues set estado_cargue = 2 where consecutivo_cargue = ?";

            // Preparar la sentencia
            try{

            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute(
                array($consecutivo)
            );
            }catch(PDOException $e){
                    return null;
            }
        }
    
            
    
            
    
    
}

    
?>
