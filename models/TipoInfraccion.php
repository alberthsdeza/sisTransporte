<?php
class TipoInfraccion extends Conectar
{
    public function get_infraccion_tipo()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_infraccion_tipo()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function verificar_tipo_infraccion(
        $tipo_codigo
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_tipoinf(:tipo_codigo);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":tipo_codigo", $tipo_codigo, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_tipo_infraccion(
        $tipo_codigo,
        $tipo_nombre
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_tipoinf(:tipo_codigo,:tipo_nombre);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":tipo_codigo", $tipo_codigo, PDO::PARAM_STR);
        $sql->bindParam(":tipo_nombre", $tipo_nombre, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function verificar_tipo_infraccion_id(
        $tipo_id
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_tipoinf_id(:tipo_id);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":tipo_id", $tipo_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_tipo_infraccion(
        $tipo_id,
        $tipo_codigo,
        $tipo_nombre
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_updated_tipoinf(:tipo_id,:tipo_codigo,:tipo_nombre);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":tipo_id", $tipo_id, PDO::PARAM_INT);
        $sql->bindParam(":tipo_codigo", $tipo_codigo, PDO::PARAM_STR);
        $sql->bindParam(":tipo_nombre", $tipo_nombre, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_tipo_infraccion_activar($tipo_id) {
        $conectar = parent::conexion();
        parent::set_names();
    
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try {
            $sql = "CALL sc_transporte.pa_updated_tipoactivar(:tipo_id);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":tipo_id", $tipo_id, PDO::PARAM_INT);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
            ];
        }
    }

    public function update_tipo_infraccion_desactivar(
        $tipo_id,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_tipodesactivar(:tipo_id);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":tipo_id", $tipo_id, PDO::PARAM_INT);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
            ];
        }
    }
}