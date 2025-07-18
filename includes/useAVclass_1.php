<?php

class useAVclass{

var $db;

function useAVclass(){
//$this->db = sqlite_open("PhotoSQL");
}



function connection(){

//Storing the information

include("connection.php");
       
}





function insertQuery($tableName,$tableFieldsName,$tableFieldsValues){

$cnt_tableFieldsName=count($tableFieldsName);
$str_tableFieldsName=implode("," , $tableFieldsName);
$str_tableFieldsValues = "'" .implode ("','",$tableFieldsValues)."'";
$sql= "insert into " .$tableName. "(". $str_tableFieldsName.")". " values ( ".$str_tableFieldsValues.")"; 

 mysql_query($conn, $sql) or die('Error, insert query failed');

}




function UpdateQuery($tablename, $whereclause, $old, $new) {


   $changedvalues = "";
   foreach($old as $key => $oldvalue) {
      $newvalue = $new[$key];
      if($oldvalue != $newvalue) {
         if($changedvalues != "")
             $changedvalues .= ", ";         
            $changedvalues .= "".$oldvalue." = ";
           // if(!is_numeric($newvalue))
                $changedvalues .= "'".$newvalue."'";
            //else
              //  $changedvalues .= $newvalue;
        }
    }

	
    
$sql= "UPDATE ".$tablename. " SET ".$changedvalues." WHERE ".$whereclause; 


echo $sql;
exit;

	if($changedvalues!= "")
	{
mysql_query($sql) or die('Error, Update query failed');

    }
 
}


function deleteQuery($tableName,$whereclause){
$sql= "delete from " .$tableName." WHERE ".$whereclause; 
echo $sql;
mysql_query($sql) or die('Error, insert query failed');
}





}







?>