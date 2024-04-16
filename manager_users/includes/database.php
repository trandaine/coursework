<?php
if(!defined('_CODE')){
    die('Access denied...');
}

function query($sql, $data=[]){
    global $conn;
    $result = false;
    try{
        $statement = $conn -> prepare($sql);
        if(!empty($data)){
            $result = $statement -> execute($data);
        }
        else{
            $result = $statement -> execute();
        }
        
    }catch(Exception $exp){
        echo $exp -> getMessage(). '<br>';
        echo 'File: '. $exp -> getFile().'<br>';
        echo 'Line: '. $exp -> getLine();
        die();
    }
    return $result;
}


function insert($table, $data){
    $key = array_keys($data);
    $truong = implode(',', $key);
    $valuetb = ':'.implode(',:', $key);
    $sql = 'INSERT INTO ' .$table. '('.$truong.')'. 'VALUES('. $valuetb.')';
    $rl = query($sql, $data);
    return $rl;
}


function update($table, $data, $condition=''){
    $update ='';
    foreach($data as $key => $value){
        $update .= $key .'= :' . $key .',';
    }
    $update = trim($update, ',');
    if(!empty($condition)){
        $sql = 'UPDATE '. $table . ' SET ' .$update . ' WHERE ' .$condition;
     } else {
        $sql = 'UPDATE'. $table . ' SET ' .$update ;
    }
    $rl = query($sql, $data);
    return $rl;
};
// Update function