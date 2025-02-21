<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function openapi_get_company($cif) {

    $cif = trim($cif);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.openapi.ro/api/companies/".$cif,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            //"x-api-key: Q2HaBsymuJap8izZp-A6eLsCa7EoFj3J6dWPBg8exEshqAoN8g"
            "x-api-key:  cvm22fAtuxCsKRhpZxxZsJzN5U-6C-r7MhP-zBC1mdMQ2nxotg"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    if ($err) {
        return FALSE;
    } else {
        $data = json_decode($response, TRUE);

        if(isset($data['denumire'])) {
            return $data;
        } else {
            return FALSE;
        }

    }
}





function update_supplier($id) {
    $CI =& get_instance();
    $supplier = $CI->db->get_where('app_suppliers', array('id' => $id))->row_array();

    $openapi_data = openapi_get_company( preg_replace("/[^0-9]/", "", $supplier['company_taxid']) );

    if($openapi_data) {
        if($openapi_data['tva'] != "") $openapi_data['cif'] = "RO" . $openapi_data['cif'];
        $db_data = [
            'name' => $openapi_data['denumire'],
            'company_id' => $openapi_data['numar_reg_com'],
            'company_taxid' => $openapi_data['cif'],
            'phone' => $openapi_data['telefon'],
            'address' => $openapi_data['adresa'],
            'state' => $openapi_data['judet'],
            'zip_code' => $openapi_data['cod_postal'],
            'country' => "Romania",
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $CI->db->where('id', $id);
        $CI->db->update('app_suppliers', $db_data);

        return TRUE;
    } else {
        return FALSE;
    }

}



function update_client($id) {
    $CI =& get_instance();
    $client = $CI->db->get_where('app_clients', array('id' => $id))->row_array();

    $openapi_data = openapi_get_company( preg_replace("/[^0-9]/", "", $client['company_taxid']) );

    if($openapi_data) {
        if($openapi_data['tva'] != "") $openapi_data['cif'] = "RO" . $openapi_data['cif'];
        $db_data = [
            'name' => $openapi_data['denumire'],
            'company_id' => $openapi_data['numar_reg_com'],
            'company_taxid' => $openapi_data['cif'],
            'phone' => $openapi_data['telefon'],
            'address' => $openapi_data['adresa'],
            'state' => $openapi_data['judet'],
            'zip_code' => $openapi_data['cod_postal'],
            'country' => "Romania",
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $CI->db->where('id', $id);
        $CI->db->update('app_clients', $db_data);

        return TRUE;
    } else {
        return FALSE;
    }

}
