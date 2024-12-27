<?php
class FormPapeleta extends Conectar
{
    public function insertar_papeleta(
        $visto,
        $numpapeleta,
        $placa,
        $fecha_impuesta,
        $select_tipodoc_infrac,
        $infdni,
        $infapellidopat,
        $infapellidomat,
        $infnombre,
        $infdomicilio,
        $infdomicilio_papeleta,
        $select_tipodoc_solidario,
        $soldni,
        $solapellidopat,
        $solapellidomat,
        $solnombre,
        $razon_social,
        $soldomicilio,
        $soldomicilio_seg,
        $select_tipoinf,
        $sancion_uit,
        $evaluacion,
        $n_vez,
        $monto,
        $pers
    ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL sc_transporte.pa_insertar_papeleta(:visto,:numpapeleta,:fecha_impuesta,:placa,:select_tipodoc_infrac,
            :infdni,:infapellidopat,:infapellidomat,:infnombre,:infdomicilio,:infdomicilio_papeleta,:select_tipodoc_solidario,
            :soldni,:solapellidopat,:solapellidomat,:solnombre,:razonsocial,:soldomicilio,:soldomicilio_seg,
            :select_tipoinf,:sancion_uit,:evaluacion,:n_vez,:monto,:pers)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(":visto", $visto, PDO::PARAM_STR);
            $sql->bindParam(":numpapeleta", $numpapeleta, PDO::PARAM_STR);
            $sql->bindParam(":fecha_impuesta", $fecha_impuesta, PDO::PARAM_STR);
            $sql->bindParam(":placa", $placa, PDO::PARAM_STR);
            $sql->bindParam(":select_tipodoc_infrac", $select_tipodoc_infrac, PDO::PARAM_INT);
            $sql->bindParam(":infdni", $infdni, PDO::PARAM_STR);
            $sql->bindParam(":infapellidopat", $infapellidopat, PDO::PARAM_STR);
            $sql->bindParam(":infapellidomat", $infapellidomat, PDO::PARAM_STR);
            $sql->bindParam(":infnombre", $infnombre, PDO::PARAM_STR);
            $sql->bindParam(":infdomicilio", $infdomicilio, PDO::PARAM_STR);
            $sql->bindParam(":infdomicilio_papeleta", $infdomicilio_papeleta, PDO::PARAM_STR);
            $sql->bindParam(":select_tipodoc_solidario", $select_tipodoc_solidario, PDO::PARAM_INT);
            $sql->bindParam(":soldni", $soldni, PDO::PARAM_STR);
            $sql->bindParam(":solapellidopat", $solapellidopat, PDO::PARAM_STR);
            $sql->bindParam(":solapellidomat", $solapellidomat, PDO::PARAM_STR);
            $sql->bindParam(":solnombre", $solnombre, PDO::PARAM_STR);
            $sql->bindParam(":razonsocial", $razon_social, PDO::PARAM_STR);
            $sql->bindParam(":soldomicilio", $soldomicilio, PDO::PARAM_STR);
            $sql->bindParam(":soldomicilio_seg", $soldomicilio_seg, PDO::PARAM_STR);
            $sql->bindParam(":select_tipoinf", $select_tipoinf, PDO::PARAM_INT);
            $sql->bindParam(":sancion_uit", $sancion_uit, PDO::PARAM_INT);
            $sql->bindParam(":evaluacion", $evaluacion, PDO::PARAM_STR);
            $sql->bindParam(":n_vez", $n_vez, PDO::PARAM_INT);
            $sql->bindParam(":monto", $monto, PDO::PARAM_INT);
            $sql->bindParam(":pers", $pers, PDO::PARAM_INT);
            $sql->execute();
            if ($sql->errorCode() == '00000') {
                return ['status' => 'success', 'message' => 'Papeleta insertada correctamente'];
            } else {
                return ['status' => 'error', 'message' => 'Error al insertar la papeleta'];
            }
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Ya existe el registro') !== false) {
                return ['status' => 'error', 'message' => 'Ya existe el registro'];
            }
            return ['status' => 'error', 'message' => 'Error en el servidor:'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error desconocido:'];
        }
    }
    
    public function get_listar_papeletas($estado = null)
    {
        $conectar = parent::conexion();
        parent::set_names();
    
        // Comenzamos la consulta base
        $sql = "SELECT * FROM sc_transporte.vista_papeletas";
    
        // Si se pasa un estado, agregar la condición WHERE con ILIKE
        if ($estado) {
            $sql .= " WHERE estado ILIKE :estado";
        }
    
        // Preparamos la consulta
        $sql = $conectar->prepare($sql);
    
        // Si hay estado, vinculamos el parámetro
        if ($estado) {
            $sql->bindParam(':estado', $estado, PDO::PARAM_STR);
        }
    
        // Ejecutamos la consulta
        $sql->execute();
    
        // Retornamos el resultado
        return $resultado = $sql->fetchAll();
    }

    public function update_papeleta_anular(
        $papeleta_id,
        $papeleta_motivo,
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = "CALL sc_transporte.pa_updated_papeletaanular(:identificador,:motivo);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(":identificador", $papeleta_id, PDO::PARAM_INT);
            $stmt->bindParam(":motivo", $papeleta_motivo, PDO::PARAM_STR);
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
}
