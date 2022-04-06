<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataInsert {
var $_errorList,$querylog,$datasave;
//error found start	
function isEmpty($field, $msg)
	{
		$value = $field;
		if (trim($value) == "")
		{
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		} else {
			return true;
		}
	}
	
	//Password Policy
function pwdPolicy($pwd,$msg){
   //$policy = "/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
   $policy = "/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\!\@\#\$\%\*\?\+]).*$/";

   if(!preg_match($policy, $pwd, $matches)){
			$this->_errorList[] = array("field" => $pwd, "value" => $pwd, "msg" => $msg);
      return false;
   } else  {
   return true;
   }
   //return false;
}

//Value Compare
function isCompare($field, $field1, $msg)
	{
		$value = $field;
		if (trim($value) != trim($field1))
		{
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		} else {
			return true;
		}
	}

//Date Maximum Check
function isCompareDate($field, $field1, $msg)
	{
		$field = date("Y-m-d",strtotime($field));
		$field1 = date("Y-m-d",strtotime($field1));
		$value = $field;
		if ($field < $field1)
		{
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		} else {
			return true;
		}
	}

function isEqual($field, $field1, $msg)
	{
		$value = $field;
		if (trim($value) == trim($field1))
		{
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		} else {
			return true;
		}
	}

// check whether input is a valid email address
	function isEmailAddress($field, $msg)
	{
		$value = $field;
		$pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
		if(preg_match($pattern, $value))
		{
			return true;
		} else {
			$this->_errorList[] = array("field" => $field, "value" => $value, "msg" => $msg);
			return false;
		}
	}

//check primary key exist
function isExistsKey($tablename,$fields,$values,$msg,$conn){
	$sql="select $fields from $tablename where $fields='$values'";
	$result = sqlsrv_query($conn,$sql,array(),array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
	if (sqlsrv_num_rows($result)==1){
		$this->_errorList[] = array("field" => $sql, "value" => $values, "msg" => $msg);
		return false;
	} else {
	return true;
	}
sqlsrv_free_stmt( $result);		
}

function isExistsKeyWhere($tablename,$where,$msg,$conn){
	$sql="select * from " . $tablename ." where " . $where;
	//echo $sql;
	$result = sqlsrv_query($conn,$sql,array(),array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
	//echo sqlsrv_num_rows($result);
	if (sqlsrv_num_rows($result)>=1){
		//$this->_errorList[] = array("field" => $sql, "value" => $value, "msg" => $msg);
		$this->_errorList[] = array("field" => $sql, "msg" => $msg);

		return false;
	} else {
	return true;
	}
sqlsrv_free_stmt( $result);		
}

//check primary key not exist
function isNotExistsKey($tablename,$where,$msg,$conn){
	$sql="select * from " . $tablename ." where " . $where;
	$result = sqlsrv_query($conn,$sql,array(),array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
	if (sqlsrv_num_rows($result)!=1){
		//$this->_errorList[] = array("field" => $sql, "value" => $value, "msg" => $msg);
		$this->_errorList[] = array("field" => $sql, "msg" => $msg);

		return false;
	} else {
	return true;
	}
sqlsrv_free_stmt( $result);		
}

function isError()
	{
		if (sizeof($this->_errorList) > 0)
		{
		return true;
		} else {
			return false;
		}
	}

// return the current list of errors
	function getErrorList()
	{
			if ($this->isError()){
			$errors= $this->_errorList;
			echo "<span class=error><ul>";
			foreach ($errors as $e) {
			echo "<li>" . $e['msg'];
			}   
			echo "</ul></span>";
			//return true;
			}  else {
			return false;
		}
	}
//error found end

	function insert_user_data($branchcode,$fields,$values,$arrays,$tablename,$gloginid,$chkmenu,$user,$currdate,$conn,$conn_jbsol){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}
			$query="insert into $tablename ($fields) values ($values)";
			//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			//menu permission start
  			if (strlen($chkmenu)>0) {
			$query="delete from tblapps_permission where loginID='".$gloginid."'";
			$stmt2 = sqlsrv_query($conn_jbsol,$query);
				if ( $stmt2  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}
			
			$menuarray=explode(",",$chkmenu);
			for ($m=0;$m < count($menuarray); $m++) {
			$query="insert into tblapps_permission (apps_id,branch_code,loginID,createBy,createDate) values ('$menuarray[$m]','$branchcode','$gloginid','$user','$currdate')";
			$stmt3 = sqlsrv_query($conn_jbsol,$query);
			}
				if ( $stmt3  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}

			} 
 		//menu permission end
			
if (($stmt1) && ($stmt2) && ($stmt3)) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
sqlsrv_free_stmt( $stmt1);
sqlsrv_free_stmt( $stmt2);
sqlsrv_free_stmt( $stmt3);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}

	function update_user_data($user,$currdate,$userid,$chkmenu,$conn)
	{
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}



			
			//menu permission start
  			if (strlen($chkmenu)>0) {
			$query="delete from tblpermission where loginID='".$userid."'";
			$stmt2 = sqlsrv_query($conn,$query);
				if ( $stmt2  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}
			
			$menuarray=explode(",",$chkmenu);
			for ($m=0;$m < count($menuarray); $m++) {
			$query="insert into tblpermission (loginID,ckey,createBy,createDate) values ('$userid','$menuarray[$m]','$user','$currdate')";
			//echo $query;
			$stmt3 = sqlsrv_query($conn,$query);
			}
				if ( $stmt3  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}

			} 
 		//menu permission end
			
if (($stmt2) && ($stmt3)) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
//sqlsrv_free_stmt( $stmt1);
sqlsrv_free_stmt( $stmt2);
sqlsrv_free_stmt( $stmt3);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}

			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}

/*

	function update_user_data($branchcode,$tablename,$values,$where,$user,$currdate,$userid,$chkmenu,$conn,$conn_jbsol)
	{
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
/*	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		foreach ($values as $key => $val)
		{
			$valstr[] = $key." = '".$val."'";
		}
		$query = "UPDATE ".$tablename." SET ".implode(', ', $valstr) ." where ". $where;
		
			//$query="insert into $tablename ($fields) values ($values)";
			$stmt1 = sqlsrv_query( $conn, $query, array());
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			//menu permission start
  			if (strlen($chkmenu)>0) {
			$query="delete from tblapps_permission where loginID='".$userid."'";
			$stmt2 = sqlsrv_query($conn_jbsol,$query);
				if ( $stmt2  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}
			
			$menuarray=explode(",",$chkmenu);
			for ($m=0;$m < count($menuarray); $m++) {
			//$query="insert into tblapps_permission (loginID,apps_id,createBy,createDate) values ('$userid','$menuarray[$m]','$user','$currdate')";
			$query="insert into tblapps_permission (apps_id,branch_code,loginID,createBy,createDate) values ('$menuarray[$m]','$branchcode','$userid','$user','$currdate')";

			$stmt3 = sqlsrv_query($conn_jbsol,$query);
			}
				if ( $stmt3  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}

			} 
 		//menu permission end
			
if (($stmt1) && ($stmt2) && ($stmt3)) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
sqlsrv_free_stmt( $stmt1);
sqlsrv_free_stmt( $stmt2);
sqlsrv_free_stmt( $stmt3);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}

			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}
*/
	function insert_data($fields,$values,$arrays,$tablename,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}
			$query="insert into $tablename ($fields) values ($values)";
			//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			
if ($stmt1) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}




//Update Data
	function update_data($tablename,$values,$where,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		foreach ($values as $key => $val)
		{
			$valstr[] = $key." = '".$val."'";
		}
		$query = "UPDATE ".$tablename." SET ".implode(', ', $valstr) ." where ". $where;
		//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, array());
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			
if ($stmt1) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}
//Multi Update

	function update_data_multi($tablename,$values,$where,$user,$branch_code,$currdate,$userip,$multikey,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

			//menu permission start
  			if (strlen($multikey)>0) {
			$multikeyarray=explode(",",$multikey);
			

			for ($m=0;$m < count($multikeyarray); $m++) {
			$query="update tblwebttitem set tt_confirm='C',confirmdate='$currdate',confirm_user='$user',desc_user_ip='$userip' where jb_branchcode='".$branch_code."' and slttno=".$multikeyarray[$m]." and (tt_confirm='P' or tt_confirm='F' or tt_confirm='D');update tblbackwebttitem set tt_confirm='C',confirmdate='$currdate',confirm_user='$user',desc_user_ip='$userip' where jb_branchcode='".$branch_code."' and slttno=".$multikeyarray[$m]." and (tt_confirm='P' or tt_confirm='F' or tt_confirm='D')";
			//echo $query;
			$stmt = sqlsrv_query($conn,$query);
			
			}
				if ( $stmt  === false ) 
				{
					if( ($errors = sqlsrv_errors() ) != null)
					{
					foreach( $errors as $error)
					{
					$errmessage.= $error[ 'message']."\n<br>";
					}
					}
				}

			} 
 		//menu permission end
			
if ($stmt)  {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
	sqlsrv_free_stmt( $stmt);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


	function upload_data($fields,$values,$arrays,$tablename,$gloginid,$currdate,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}
			$query="insert into $tablename ($fields) values ($values)";
			//echo $query;
			//exit;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			
if ($stmt1) {
     sqlsrv_commit($conn );
//     $this->querylog .="Successfully Saved";
	sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


//Insert Parameter Data
	function insert_param_data($function,$valuedata,$arrays,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		$query = "exec ".$function." ".$valuedata;

//echo $query;
			//$query="insert into $tablename ($fields) values ($values)";
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
			if ( $stmt1  === false ) 
			{
	 			if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n<br>";
         		}
      			}
			}
			
			
if ($stmt1) {
     sqlsrv_commit($conn );
     $this->querylog .="Successfully Saved";
	sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage . "Transaction Failed<br />";
}
			// SQL END
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


//Insert Parameter Data
	function proc_param_data($function,$valuedata,$arrays,$conn){
		//print_r($arrays);
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		$query = "exec ".$function." ".$valuedata;
		//echo $query;
		//echo $arrays;
		//exit;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
			//echo $query;
if( $stmt1 === false)
	{
				if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n";
         		}
      			}
				//$errmessage = explode("(null):", $errmessage);
				//$errmessage = $errmessage[1];

	} else {
			$row= sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_BOTH);
			$this->querylog .= $row[0];
	}

if ($stmt1) {
     sqlsrv_commit($conn );
     //$this->querylog .="Successfully Saved";
	 sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage ;
}
			// SQL END
		//$this->datasave = "T";
		//echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


	function proc_param_data_message($function,$valuedata,$arrays,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		$query = "exec ".$function." ".$valuedata;
		//echo $query;
		$stmt1 = sqlsrv_query( $conn, $query, $arrays);
if( $stmt1 === false)
	{
				if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n";
         		}
      			}
				//echo $errmessage;
				$errmessage = explode(":", $errmessage,2);
				$errmessage = $errmessage[1];

	} else {
			$row= sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_BOTH);
			$this->querylog .= $row[0];
	}

if ($stmt1) {
    sqlsrv_commit($conn );
	sqlsrv_free_stmt( $stmt1);
     //$this->querylog .="Successfully Saved";
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage ;
}
			// SQL END
		//$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


	function proc_insert_data_message($function,$valuedata,$arrays,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	if ( sqlsrv_begin_transaction( $conn ) === false ) {
		 die( print_r( sqlsrv_errors(), true ));
	}

		$query = "exec ".$function." ".$valuedata;
		//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
if( $stmt1 === false)
	{
				if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n";
         		}
      			}
				//echo $errmessage;
				$errmessage = explode("1:", $errmessage);
				$errmessage = $errmessage[1];

	} else {
			$row= sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_BOTH);
			$this->querylog .= $row[0];
	}

if ($stmt1) {
     sqlsrv_commit($conn );
     //$this->querylog .="Successfully Saved";
	 sqlsrv_free_stmt( $stmt1);
} else {
     sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage ;
}
			// SQL END
		$this->datasave = $this->querylog;
		//echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


	function proc_param_src_data_message($function,$valuedata,$arrays,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	//sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	//if ( sqlsrv_begin_transaction( $conn ) === false ) {
	//	 die( print_r( sqlsrv_errors(), true ));
	//}

		$query = "exec ".$function." ".$valuedata;
		//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
if( $stmt1 === false)
	{
				if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n";
         		}
      			}
				//echo $errmessage;
				//$errmessage = explode("1:", $errmessage);
				//$errmessage = $errmessage[1];

	} else {
			$row= sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_BOTH);
			$this->querylog .= $row[0];
	}

if ($stmt1) {
     //sqlsrv_commit($conn );
	 sqlsrv_free_stmt( $stmt1);
} else {
     //sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage ;
}

			// SQL END
		//$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}

	function proc_param_src_data_message_old($function,$valuedata,$arrays,$conn){
	$errmessage='';
		if (sizeof($this->_errorList)==0){
			// SQL START
			//echo $chkmenu;
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true ));
	}
	
	//sqlsrv_query($conn,"SET NOCOUNT ON");
				
	/* Begin the transaction. */
	//if ( sqlsrv_begin_transaction( $conn ) === false ) {
	//	 die( print_r( sqlsrv_errors(), true ));
	//}

		$query = "exec ".$function." ".$valuedata;
		//echo $query;
			$stmt1 = sqlsrv_query( $conn, $query, $arrays);
if( $stmt1 === false)
	{
				if( ($errors = sqlsrv_errors() ) != null)
      			{
         		foreach( $errors as $error)
         		{
            	$errmessage.= $error[ 'message']."\n";
         		}
      			}
				
				//$errmessage = explode("1:", $errmessage);
				//$errmessage = $errmessage[1];

	} else {
			$row= sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_BOTH);
			$this->querylog .= $row[0];
	}

if ($stmt1) {
     //sqlsrv_commit($conn );
	 sqlsrv_free_stmt( $stmt1);
} else {
     //sqlsrv_rollback( $conn );	 
     $this->querylog .= $errmessage ;
}

			// SQL END
		//$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	
	}


	function proc_param_data_old($function,$valuedata){
		if (sizeof($this->_errorList)==0){
			// SQL START
			$commit = "commit";
			//sqlsrv_query($conn,"begin transaction");
			$query = "exec ".$function." ".$valuedata;
			//echo $query;
			//echo "nnn";
			$result = sqlsrv_query($conn,$query);
			if(!$result)
			{
			$commit = "rollback";
			$this->querylog .= "error in query: " . $query . "<br />";
			}
			

			if($commit == "rollback")
			{
				$this->querylog .= "ERROR IN TRANSACTION<br />Try Again<br />";
			} //else {
			
			
			//}
			$row = sqlsrv_fetch_array($result);
			
			$this->datasave = $row[0];
//echo $commit;
			//sqlsrv_query($conn,$commit);
			// SQL END
		//$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	}


	function delete_data($tblname,$where,$conn){
		if (sizeof($this->_errorList)==0){
			// SQL START
			$commit = "commit";
			//sqlsrv_query($conn,"begin transaction");
			$query = "delete from  ".$tblname." where ".$where;
			//echo $query;
			//echo "nnn";
			$result = sqlsrv_query($conn,$query);
			if(!$result)
			{
			$commit = "rollback";
			$this->querylog .= "error in query: " . $query . "<br />";
			}
			

			if($commit == "rollback")
			{
				$this->querylog .= "ERROR IN TRANSACTION<br />Try Again<br />";
			} //else {
			
			
			//}
			//$row = sqlsrv_fetch_array($result);
			
			//$this->datasave = $row[0];
//echo $commit;
			//sqlsrv_query($conn,$commit);
			// SQL END\
	    $this->querylog .="Successfully Deleted";
		$this->datasave = "T";
		echo $this->querylog;
		} else {
		$this->getErrorList();
		}
	}


function submitmail($rmail,$smail,$sname,$subject,$body){
	if (sizeof($this->_errorList)==0){
	$headers='';
	$headers .= "MIME-Version: 1.0  \n" ;
	$headers .= "From:$sname<$smail>\n";
	$headers .= "X-Sender:$sname<$smail>  \n";
	$headers .= "X-Mailer:Web Auto Responder v1.250  \n";
	$headers .= "X-Priority:1  \n";
	$headers .= "Return-Path:$sname<$smail> \n";
	$headers .= "Content-Type:text/html;charset=utf-8  \n";
	//ini_set("SMTP","smtp.gmail.com" ); 
	//ini_set("SMTP_PORT", 465); 
	//ini_set('sendmail_from', 'jahurjb@gmail.com'); 
	mail($rmail, $subject, $body, $headers);
	$this->datasave = "T";
	} else {
	$this->getErrorList();
	}
}


}
?>