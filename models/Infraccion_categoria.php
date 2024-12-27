<?php
class Infraccion_categoria extends Conectar
{
    public function get_infraccion_categoria()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_infraccion_categoria()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function verificar_categoria_infraccion(
        $cat_codigo
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_categoriainf(:cat_codigo);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":cat_codigo", $cat_codigo, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_categoria_infraccion(
        $cat_codigo,
        $cat_categoria
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_categoriainf(:cat_codigo,:cat_nombre);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":cat_codigo", $cat_codigo, PDO::PARAM_STR);
        $sql->bindParam(":cat_nombre", $cat_categoria, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function verificar_categoria_infraccion_id(
        $cat_id
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_categoriainf_id(:cat_id);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_categoria_infraccion(
        $cat_id,
        $cat_codigo,
        $cat_categoria
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_updated_categoriainf(:cat_id,:cat_codigo,:cat_nombre);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $sql->bindParam(":cat_codigo", $cat_codigo, PDO::PARAM_STR);
        $sql->bindParam(":cat_nombre", $cat_categoria, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_categoria_infraccion_activar($cat_id) {
        $conectar = parent::conexion();
        parent::set_names();
    
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try {
            $sql = "CALL sc_transporte.pa_updated_catactivar(:cat_id);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
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

    public function update_categoria_infraccion_desactivar(
        $cat_id,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_catdesactivar(:cat_id);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
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