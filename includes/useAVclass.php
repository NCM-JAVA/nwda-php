<?php
class useAVclass{
var $db;

function useAVclass(){
//$this->db = sqlite_open("PhotoSQL");
}



function connection()
{

 include("connection.php");

}





function insertQuery($tableName,$tableFieldsName,$tableFieldsValues){

 include("connection.php");
$cnt_tableFieldsName=count($tableFieldsName);
$str_tableFieldsName=implode("," , $tableFieldsName);
$str_tableFieldsValues = "'" .implode ("','",$tableFieldsValues)."'";
$sql= "insert into " .$tableName. "(". $str_tableFieldsName.")". " values ( ".$str_tableFieldsValues.")";



 mysqli_query($conn, $sql) or die('Error, insert query failed');

}


function UpdateQuery($tablename, $whereclause, $old, $new) {
 include("connection.php");
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
	if($changedvalues!= ""){
		$rs = $conn->query($sql);
		//mysqli_query($conn, $sql); //or die('Error, Update query failed');
    }
 
}

function deleteQuery($tableName,$whereclause){
echo $sql= "delete from " .$tableName." WHERE ".$whereclause; 
mysqli_query($conn, $sql) or die('Error, insert query failed');
}


}






?>
