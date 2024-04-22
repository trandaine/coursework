<?php
if(!defined('_CODE')){
    die('Access denied...');
}

function query($sql, $data=[], $check = false){
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

    if($check){
        return $statement;
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

function delete($table, $condition=''){
    if(empty($condition)){
        $sql = 'DELETE FROM ' .$table;
    }else{
        $sql = 'DELETE FROM '.$table . ' WHERE '.$condition;
    }
    $rl = query($sql);
    return $rl;
};

// Lay nhieu dong du lieu
function getRaw($sql){
    $kq = query($sql, '', true);
    if(is_object($kq)){
        $dataFetch = $kq -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
};
// Get multiple rows but specific
function getMultipleRows($table, $condition=''){
    $sql = 'SELECT * FROM ' . $table;
    if(!empty($condition)){
        $sql .= ' WHERE ' . $condition;
    }
    $kq = query($sql, '', true);
    if(is_object($kq)){
        $dataFetch = $kq -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Get one data row
function getSingleRow($sql){
    $kq = query($sql, '', true);
    if(is_object($kq)){
        $dataFetch = $kq -> fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
};


// Count for data rows
function countRows($sql){
    $kq = query($sql, '', true);
    if(!empty($kq)){
        return $kq ->rowCount();
    }
}
