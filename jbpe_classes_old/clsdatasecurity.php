<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DataEncSecurity {
public $mykeyhash;
//Start Class

//define('SALT_LENGTH', 7);
public function MyHashGenerate($plainText, $salt)
{
    //$plainText = $this->xss_clean($plainText);
	//$salt = $this->xss_clean($salt);
	
	if ($salt === null)
    {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else
    {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    //return $salt . sha1($salt . $plainText);
    //return $salt . hash("sha512", $salt . $plainText, false) ;
	//echo $salt;
	$this->mykeyhash = $salt . hash("sha512", $salt . $plainText, false) ;
	//$this->mykeyhash = $salt; //. hash("sha512", $salt . $plainText, false) ;
	
}


//End Class
}
?>