<?php
class RNT extends Conectar
{
    public function get_verificar_infraccion(
        $cod_infraccion
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_verificar_codigoinfraccion(:codigo)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":codigo", $cod_infraccion, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_rnt(
        $norma_decreto, 
        $calificacion_inf,
        $codigo_inf,
        $rnt_descripcion,
        $usua,
        $usua_nombre,
        $rnt_observacion,
        $rntd_sancion,
        $rntd_puntos,
        $rntd_medida_preventiva,
        $rntd_retencion_lic,
        $rntd_descuento,
        $rnt_dosaje_etilico,
        $rntd_monto_x_mes_venc,
        $rntd_respo_solidaria
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sancion_str = '{' . $rntd_sancion . '}';
        $sql = "CALL sc_transporte.pa_insertar_rnt(:norma,:calif_inf,:cod_inf,:descripcion,:usua,:usua_nombre,:observacion,
        :sancion,:puntos,:med_preventiva,:ret_lic,:descuento,:dosaje_etilico,:mont_x_mes_venc,:resp_solidaria)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":norma", $norma_decreto, PDO::PARAM_INT);
        $sql->bindParam(":calif_inf", $calificacion_inf, PDO::PARAM_INT);
        $sql->bindParam(":cod_inf", $codigo_inf, PDO::PARAM_STR);
        $sql->bindParam(":descripcion", $rnt_descripcion, PDO::PARAM_STR);
        $sql->bindParam(":usua", $usua, PDO::PARAM_INT);
        $sql->bindParam(":usua_nombre", $usua_nombre, PDO::PARAM_STR);
        $sql->bindParam(":observacion", $rnt_observacion, PDO::PARAM_STR);
        $sql->bindParam(":sancion", $sancion_str, PDO::PARAM_STR);
        $sql->bindParam(":puntos", $rntd_puntos, PDO::PARAM_INT);
        $sql->bindParam(":med_preventiva", $rntd_medida_preventiva, PDO::PARAM_STR);
        $sql->bindParam(":ret_lic", $rntd_retencion_lic, PDO::PARAM_STR);
        $sql->bindParam(":descuento", $rntd_descuento, PDO::PARAM_STR);
        $sql->bindParam(":dosaje_etilico", $rnt_dosaje_etilico, PDO::PARAM_STR);
        $sql->bindParam(":mont_x_mes_venc", $rntd_monto_x_mes_venc, PDO::PARAM_INT);
        $sql->bindParam(":resp_solidaria", $rntd_respo_solidaria, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_listar_rnt()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_listarrnt()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_listar_rnt_completo($id_rnt)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "SELECT * FROM sc_transporte.fn_visualizarnt_id(:identificador);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":identificador", $id_rnt, PDO::PARAM_INT);
            $stmt->execute();
            return $resultado = $stmt->fetchAll();
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la visualización: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'error_info' => $e->errorInfo,
            ];
        }
    }

    public function get_visualizar_rnt(
        $id_rnt
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_visualizarnt_completo(:identificador)";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":identificador", $id_rnt, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_rnt_desactivar(
        $rnt_id,
        $rnt_motivo,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_rntdesactivar(:identificador,:motivo);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":identificador", $rnt_id, PDO::PARAM_INT);
            $stmt->bindParam(":motivo", $rnt_motivo, PDO::PARAM_STR);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'error_info' => $e->errorInfo,
            ];
        }
    }

    public function update_rnt_activar(
        $rnt_id,
        $rnt_motivo,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_rntactivar(:identificador,:motivo);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":identificador", $rnt_id, PDO::PARAM_INT);
            $stmt->bindParam(":motivo", $rnt_motivo, PDO::PARAM_STR);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'error_info' => $e->errorInfo,
            ];
        }
    }

    public function update_rnt_anular(
        $rnt_id,
        $rnt_motivo,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_rntanular(:identificador,:motivo);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":identificador", $rnt_id, PDO::PARAM_INT);
            $stmt->bindParam(":motivo", $rnt_motivo, PDO::PARAM_STR);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'error_info' => $e->errorInfo,
            ];
        }
    }

    public function update_rnt_rntd(
        $rnt_id,
        $rntd_id,
        $descripcion,
        $observacion,
        $sancion,
        $puntos,
        $medida_preventiva,
        $retencion_lic,
        $descuento,
        $dosaje_etilico,
        $monto_x_mes_venc,
        $resp_solidaria,
        $motivo_cambio
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sancion_str = '{' . $sancion . '}';
        try {
            $sql = "CALL sc_transporte.pa_updated_rnt_id(:ident_rnt,:ident_rntd,:descrip,:observ,:sancion,
            :puntos,:med_prev,:ret_lic,:desc,:dosaje_etilico,:mont_x_mes_venc,:resp_solidaria,:motivo);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":ident_rnt", $rnt_id, PDO::PARAM_INT);
            $stmt->bindParam(":ident_rntd", $rntd_id, PDO::PARAM_INT);
            $stmt->bindParam(":descrip", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":observ", $observacion, PDO::PARAM_STR);
            $stmt->bindParam(":sancion", $sancion_str, PDO::PARAM_STR);
            $stmt->bindParam(":puntos", $puntos, PDO::PARAM_INT);
            $stmt->bindParam(":med_prev", $medida_preventiva, PDO::PARAM_STR);
            $stmt->bindParam(":ret_lic", $retencion_lic, PDO::PARAM_STR);
            $stmt->bindParam(":desc", $descuento, PDO::PARAM_STR);
            $stmt->bindParam(":dosaje_etilico", $dosaje_etilico, PDO::PARAM_STR);
            $stmt->bindParam(":mont_x_mes_venc", $monto_x_mes_venc, PDO::PARAM_INT);
            $stmt->bindParam(":resp_solidaria", $resp_solidaria, PDO::PARAM_STR);
            $stmt->bindParam(":motivo", $motivo_cambio, PDO::PARAM_STR);
            $stmt->execute();
    
            return [
                'status' => 'success',
                'message' => 'La actualización se realizó correctamente.',
            ];
    
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la actualización: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'error_info' => $e->errorInfo,
            ];
        }
    }

    public function get_listar_codigoinfraccion(
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_transporte.fn_codigosinfraccion()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    

}