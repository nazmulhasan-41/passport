<?PHP
//==============
$host= htmlentities($_SERVER['HTTP_HOST'],  ENT_QUOTES,  "utf-8");
//===============

$baseurl="http://".$host."/jbpe/index.php";
$baseroot="http://".$host."/jbpe";

//define('BASEPATH','');


//$baseurl="http://172.17.22.132/jbremittance/index.php";
//$baseroot="http://172.17.22.132/jbremittance";

//if (!isset($_SERVER['REQUEST_URI'])) {
//$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
//if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != "") {
//$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
//}
//}

	         $requestURI = explode('/', $_SERVER['REQUEST_URI']);
			 
             $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
                 for($i= 0;$i < sizeof($scriptName);$i++)
                           {
                          if ($requestURI[$i] == $scriptName[$i])
                             {
                             unset($requestURI[$i]);
                             }
                          }
                $commandArray = array_values($requestURI);




if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
$userip = htmlentities($_SERVER["HTTP_X_FORWARDED_FOR"],  ENT_QUOTES,  "utf-8");
} else {
$userip = htmlentities($_SERVER["REMOTE_ADDR"],  ENT_QUOTES,  "utf-8");
}


?>