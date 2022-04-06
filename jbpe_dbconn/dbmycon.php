<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
			//$database_hostname = "172.17.20.56";
			//$database_hostname = "172.17.0.62\wa";
		
	/*$database_hostname = "172.17.20.198";
	$database_name = "dbjbPassportEndorse";
	$database_username = "sa";
	//$database_password = "Janata@789";
        $database_password = "jbl123";*/



        $database_hostname = "172.17.20.77";
	$database_name = "dbjbPassportEndorse";
	$database_username = "sa";
	//$database_password = "Janata@789";
        $database_password = "Abc1234*";


        


//Jbl@#!17
			//$database_password = "Janata@789";
			//$database_password = "0x010061C74F850C78EEF8AD736097640D3B1E45463EA3B997D430";
			//$connectioninfo =array("UID"=>$database_username,"PWD" =>$database_password,"Database"=>$database_name, 'ReturnDatesAsStrings'=> true, "CharacterSet" => 'utf-8');
			//$connectioninfo =array("UID"=>$database_username,"PWD" =>$database_password,"Database"=>$database_name);
	$connectioninfo =array("UID"=>$database_username,"PWD" =>$database_password,"Database"=>$database_name,"ConnectionPooling"=>1);
	$conn = sqlsrv_connect($database_hostname,$connectioninfo);


	$jbrps_database_hostname = "172.17.20.77";
	$jbrps_database_name = "dbjbwebremitt";
	$jbrps_database_username = "sa";
	$jbrps_database_password = "Abc1234*";
		//$database_jbrps = "dbjbwebremitt";
	$connectioninfo_jbrps =array("UID"=>$jbrps_database_username,"PWD" =>$jbrps_database_password,"Database"=>$jbrps_database_name,"ConnectionPooling"=>1);
	$conn_jbrps = sqlsrv_connect($jbrps_database_hostname,$connectioninfo_jbrps);

		
if( $conn === false )
{
     print(htmlspecialchars("Unable to connect",  ENT_QUOTES,  "utf-8"));
     die( print_r( htmlspecialchars(sqlsrv_errors(),  ENT_QUOTES,  "utf-8"), true));
}

		


?>