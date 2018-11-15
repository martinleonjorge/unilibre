<?php

include_once 'database.php';

function validateSession($user, $password) {
    $return = array();
    
    
    $db = new database();
    $result = $db->select(
            "usuarios", array("id", "usuario", "contrasena","perfil"), array("usuario" => $user, "contrasena" => $password)
    );

    if (mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $condicion1 = strcasecmp($rows['usuario'], $user) == 0;
        $condicion2 = strcasecmp($rows['contrasena'], $password) == 0;
        
        $return['usridxxx'] = $rows['id'];
        $return['perfilxx'] = $rows['perfil'];
        
        $return['result'] = ($condicion1 && $condicion2) ? 0 : 1;
    } else {
        $return['result'] =  1;
    }
    
    return $return;
}

function createStudent($cedula, $name, $lname, $email, $phone, $user, $pwd){
    $return = array();
    $return['usridxx'] = $cedula;
    $return['usrnomxx'] = $name . " " . $lname;
    $db = new database();
    $valida = $db->select(
            "alumnos", 
            array("cedula"), 
            array("cedula" => $cedula)
    );
     
    if (mysqli_num_rows($valida) == 0) {
        $reg_usr = createUser($cedula, $user, $pwd);
        if($reg_usr!=0){
            $return['result'] = $reg_usr;
            return $return;
        }
        
        $result = $db->insert(
            "alumnos",
            array(
                "cedula" => $cedula, 
                "nombres" => $name, 
                "apellidos" => $lname,
                "email" => $email,
                "telefono" => $phone
            )
        );

        $return['result'] =  (!$result) ? 1 : 0;
        
    }else{
        $return['result'] = 2;
    }
    return $return;
}

/*
        data.append("placa", placa);
    data.append("marca", marca);
    data.append("serie", serie);
    data.append("modelo", modelo);
    data.append("kilometraje", kilometraje);
    data.append("capacidad", capacidad);
         *          */

function createAuto($placa, $marca, $serie, $modelo, $kilometraje, $capacidad){
    $return = array();
    $db = new database();
    $valida = $db->select(
            "autos", 
            array("placa"), 
            array("placa" => $placa)
    );
     
    if (mysqli_num_rows($valida) == 0) {        
        $result = $db->insert(
            "autos",
            array(
                "placa" => $placa, 
                "marca" => $marca, 
                "serie" => $serie,
                "modelo" => $modelo,
                "kilometraje" => $kilometraje,
                "capacidad" => $capacidad,
            )
        );

        $return['result'] =  (!$result) ? 1 : 0;
        
    }else{
        $return['result'] = 2;
    }
    return $return;
}
function editAuto($id, $placa, $marca, $serie, $modelo, $kilometraje, $capacidad){
    $return = array();
    $db = new database();
    $valida = $db->update(
            "autos", 
            "placa = '$placa', marca= '$marca', serie = '$serie', modelo = $modelo, kilometraje = $kilometraje, capacidad= $capacidad", 
            array("id" => $id)
    );
    
    $return['result'] = $valida?0:1;
    
    return $return;
}

function createUser($cedula, $user, $password){
    $db = new database();
    $valida = $db->select(
            "usuarios", 
            array("id"), 
            array("usuario" => $user)
    );
     
    if (mysqli_num_rows($valida) == 0) {
        $result = $db->insert(
            "usuarios",
            array(
                "id" => $cedula, 
                "usuario" => $user, 
                "contrasena" => $password
            )
        );

        return (!$result) ? 3 : 0;
        
    }else{
        return 4;
    }
}

function listusers(){
    $db = new database();
    $tabla = '<table class="info-table">
    <tr>
        <th>Cedula</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Telefono</th>
    </tr>';
    
    $campos = array("cedula","nombres","apellidos","email","telefono");
    $datos = $db->select(
            "alumnos", 
            $campos
    );
    
    if(mysqli_num_rows($datos)>0){
        $tabla = "";
        while($data = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
            $tabla.="<tr>";
            $tabla.="<td>{$data['cedula']}</td>";
            $tabla.="<td>{$data['nombres']}</td>";
            $tabla.="<td>{$data['apellidos']}</td>";
            $tabla.="<td>{$data['email']}</td>";
            $tabla.="<td>{$data['telefono']}</td>";
            $tabla.="</tr>";
        }
    }else{
        $tabla.="<tr><td style='text-align:center' colspan=".sizeof($campos).">No se encontraron registros</td></tr>";
    }
    
    $tabla.="</table>";
    return $tabla;
}
function listautos($id=null){
    $db = new database();
    
    $campos = array("id","placa","marca","serie","modelo","kilometraje","capacidad");
    $datos = $db->select(
            "autos", 
            $campos
    );
    
    $options = "<select class='menu_options'>";
    $options.= "<option value=''></option>";
    $options.= "<option value='UPDATE'>EDITAR</option>";
    $options.= "<option value='DELETE'>ELIMINAR</option>";
    $options.= "</select>";
    if(mysqli_num_rows($datos)>0){
        $tabla = "";
        while($data = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
            $tabla.="<tr>";
            $tabla.="<td data-id='{$data['id']}'>$options</td>";
            $tabla.="<td>{$data['placa']}</td>";
            $tabla.="<td>{$data['marca']}</td>";
            $tabla.="<td>{$data['serie']}</td>";
            $tabla.="<td>{$data['modelo']}</td>";
            $tabla.="<td>{$data['kilometraje']}</td>";
            $tabla.="<td>{$data['capacidad']}</td>";
            $tabla.="</tr>";
        }
    }else{
        $tabla.="<tr><td style='text-align:center' colspan=".sizeof($campos).">No se encontraron registros</td></tr>";
    }
    
    return $tabla;
}
function listDataAutos($where=array()){
    $db = new database();
    
    $campos = array("id","placa","marca","serie","modelo","kilometraje","capacidad");
    $datos = $db->select(
            "autos", 
            $campos,
            $where
    );
    
    $result = array();
    if(mysqli_num_rows($datos)>0){
        while($data = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
            array_push($result, $data);
        }
    }
    
    return json_encode($result);
}

function getLabsByBlockId($blockId = 0){
    $db = new database();
    $return = array();
    $campos = array("id","description");
    $result = $db->select(
            "labs", 
            $campos,
            array("id_block"=>$blockId)
    );
    
    
    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        array_push($return, $data);
    }
    
    return json_encode($return);
}

function getProductsByLab($labId = 0){
    $db = new database();
    $return = array();
    $campos = array("id_product","name");
    $result = $db->select(
            "inventory", 
            $campos,
            array("lab_id"=>$labId, array("stock_quantity>taken_quantitiy")),
            array(),
            array(),
            array("products", "products.id", "id_product", "left")
    );
    
    
    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        array_push($return, $data);
    }
    
    return json_encode($return);
}

function deleteRegister($id, $type){
    $db = new database();
    $transaction = $db->delete($type, $id);
    return ($transaction) ? 0 : 1;
}