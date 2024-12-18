<?php
class Empresa extends Conectar
{

    public function verificar_empresa(
        $ruc
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM public.fn_consultar_empresa(:ruc);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":ruc", $ruc, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertar_emtr(
        $empr_ruc,
        $empr_razon_social,
        $empr_ubigeo,
        $empr_direccion,
        $empr_categoria,
        $sunat_estado,
        $sunat_condicion,
        $ciud_tipo,
        $ciud_numero_doc,
        $ciud_nombre,
        $ciud_ap_paterno,
        $ciud_ap_materno,
        $ciud_celular,
        $ciud_correo,
        $ciud_direccion,
        $ciud_foto
    ){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_empr_rele(:ruc,:razon_social,:ubigeo,:empr_direccion,:categoria,:sunat_estado,
        :sunat_condicion,:tipodoc,:num_doc,:nombre,:appaterno,:apmaterno,:celular,:correo,:direccion,:foto);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":ruc", $empr_ruc, PDO::PARAM_STR);
        $sql->bindParam(":razon_social", $empr_razon_social, PDO::PARAM_STR);
        $sql->bindParam(":ubigeo", $empr_ubigeo, PDO::PARAM_STR);
        $sql->bindParam(":empr_direccion", $empr_direccion, PDO::PARAM_STR);
        $sql->bindParam(":categoria", $empr_categoria, PDO::PARAM_STR);
        $sql->bindParam(":sunat_estado", $sunat_estado, PDO::PARAM_STR);
        $sql->bindParam(":sunat_condicion", $sunat_condicion, PDO::PARAM_STR);
        $sql->bindParam(":tipodoc", $ciud_tipo, PDO::PARAM_INT);
        $sql->bindParam(":num_doc", $ciud_numero_doc, PDO::PARAM_STR);
        $sql->bindParam(":nombre", $ciud_nombre, PDO::PARAM_STR);
        $sql->bindParam(":appaterno", $ciud_ap_paterno, PDO::PARAM_STR);
        $sql->bindParam(":apmaterno", $ciud_ap_materno, PDO::PARAM_STR);
        $sql->bindParam(":celular", $ciud_celular, PDO::PARAM_STR);
        $sql->bindParam(":correo", $ciud_correo, PDO::PARAM_STR);
        $sql->bindParam(":direccion", $ciud_direccion, PDO::PARAM_STR);
        $sql->bindParam(":foto", $ciud_foto, PDO::PARAM_STR);
        $sql->execute();
        $resultado = $sql->fetchAll();
        return $resultado;
    }

    public function insertar_emtr1(
        $usua_id,
        $usua_nombre,
        $empr_ruc,
        $ciud_numero_doc,
        $empr_tipo_servicio,
    ){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL sc_transporte.pa_insertar_emtr(:id,:usua_nombre,:ruc,:ciud_num,:tiposervicio);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(":id", $usua_id, PDO::PARAM_INT);
        $sql->bindParam(":usua_nombre", $usua_nombre, PDO::PARAM_STR);
        $sql->bindParam(":ruc", $empr_ruc, PDO::PARAM_STR);
        $sql->bindParam(":ciud_num", $ciud_numero_doc, PDO::PARAM_STR);
        $sql->bindParam(":tiposervicio", $empr_tipo_servicio, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        return $resultado;
    }


}