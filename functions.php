<?php
    require_once('db.php');
    
 /** 
 * Logout()
 * destroy user session and redirect to index page
 */     
function Logout(){
    session_start(); //to ensure you are using same session
    session_destroy(); //destroy the session
    
    header("location:/index.php"); //to redirect back to "index.php" after logging out
    exit();
}

 /** 
 * GetUserSession()
 * get current session of logged user
 */ 
function GetUserSession(){
    if (!isset($_SESSION)){
        @session_start();
    }
    if (isset( $_SESSION['userid'])){
       //echo $_SESSION['username'];    
    }
    
    return $_SESSION; 
    
}


/**
 * url_exists()
 * check if a url exist
 * @param string $url 
 * @return boolean 
 */
function url_exists( $url = NULL ) {
    if(( $url == '' ) ||( $url == NULL ) ){
        return false;
    }
    $handle= "";
    $ch = curl_init($url);
 
    curl_setopt($ch,CURLOPT_TIMEOUT,5);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);

    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    $data = curl_exec($ch);

    $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);

    $accepted_response = array(200,301,302);
    if( in_array( $httpcode, $accepted_response ) ) {
        return true;
    } else {
        return false;
    }

}

/**
 * trim_text()
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string 
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true, $url = "") {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        if ($url) {
            $trimmed_text .= "<a href='".$url."' target = '_blank'>...</a>";
        }else
            $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}

/**
 * SendEmail()
 * Send a Email 
 * @param string email address to send
 * @param string email subject 
 * @param string email body
 * @return boolean 
 */

function SendEmail($to = "", $subject = "" , $body = ""){

    if (empty($body)){
        $body = "NONE";
    }
    
	// send email
    $result = mail($to, $subject, $body);

    if($result){
        return true;
    }
    else{
        return false;
    }
 }
 
 /**
 * SendEmail()
 * Send a Email 
 * @param string email address to send
 * @param string email subject 
 * @param string email body
 * @return boolean 
 */

function SendEmailContactUs($name = "", $email = "" , $subject = "",  $body = ""){
    $to = EMAIL;
    
    if (empty($body)){
        $body = "NONE";
    }
    $subjectbody = " Message from $name on Contact Us screen at complaintblaster \r\n\r\n"; 
    $name = "Name : ".$name. " \r\n\r\n"; 
    $subject = "Subject: ".$subject. " \r\n\r\n"; 
    $email = "Email: ".$email. " \r\n\r\n"; 
    $message = "Message : ".$body. " \r\n\r\n"; 
    
    $body = $name.$subject.$email.$message;

    $result = mail($to, $subjectbody, $body);

    if($result){
        return true;
    }
    else{
        return false;
    }
 }

 
 
/**
 * generateRandomString()
 * Generate ramdon string 
 * @param integer character length 
 * @return string 
 */ 
function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-@[]{},.!#$%&/()';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * load on var sessions data from users
 * @param string username or email 
 * @param string password
 * @param string logintype
 * @return array 
 */
function DoLogin($username,$password, $logintype){
   GetUserSession(); 
	$where = "";	
	
	if ($logintype == 'b')
		$where = " businessid > 0 ";
    else	
		$where = " businessid = 0 ";
	
    $query ="SELECT * FROM users WHERE (". $where. " and password = '$password' )  and (username = '$username' or  email = '$username' ) and status = 'active'";
	$result = phpmkr_query($query);
	$row = $result->fetch_assoc();
        if (empty($row['username'])) 
            $row["success"] = false;
        else{
            $row["success"] = true;
		
	    $_SESSION['userid']  = $row["userid"];
            $_SESSION['username']  = $row["username"];
            $_SESSION['email']    = $row["email"];
	    $_SESSION['usertype'] = "u";
           
            if ($row["businessid"] > 0){
                $_SESSION['usertype'] = "b";
            }    

            if ($row["username"] == "admin"){
                 $_SESSION['usertype'] = "a";
            }    
			
            if (isset($_POST['rememberuser'])){
                $year = time() + 31536000;
                setcookie('remember_me', $row["username"], $year, '/');
            }
            
            $query ="SELECT organisationID as id, contactemail,status, type FROM subscriptions WHERE organisationID = '".$row["businessid"]."'" ;
	    $result = phpmkr_query($query);
	    $subscription = $result->fetch_assoc();
            if (isset($subscription["id"])){
                $row['organisationid'] = $subscription["id"];
                $row['contactemail']  = $subscription["contactemail"];

                $_SESSION['organisationid']  = $subscription["id"];
                $_SESSION['contactemail']  = $subscription["contactemail"];
                $_SESSION['status']  = $subscription["status"];
                $_SESSION['type']  = $subscription["type"];
            }
            
        return @$row;
        }
}

/**
 * Detect the location by the ip address
 * @param string ip address format xxxx.xxxx.xxxx.xxxx
 * @return object
 */
function LocateIp($ip = ""){
    require_once('/lib/geoplugin.class.php');
    $geoplugin = new geoPlugin();
	
    if (empty($ip)) 
        $ip = $_SERVER["REMOTE_ADDR"];
    //$ip = '94.23.158.49'; //uk ip 
    //$ip = '201.209.46.174'; //venezuela ip 
	
    return @$geoplugin->locate($ip);
    
}

/**
 * Send a email with attachacment
 * @param string filepath  
 * @param string mailto email to send  
 * @param string from email
 * @param string from name   
 * @param string email to reply  
 * @return object
 */
function mail_attachment($filepath, $filename, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $filepath;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";


    $nmessage = "--".$uid."\r\n";
    $nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $nmessage .= $message."\r\n\r\n";
    $nmessage .= "--".$uid."\r\n";
    $nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 
    $nmessage .= "Content-Transfer-Encoding: base64\r\n";
    $nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $nmessage .= $content."\r\n\r\n";
    $nmessage .= "--".$uid."--";
    error_reporting(E_ALL);
    if (mail($mailto, $subject, $nmessage, $header)) {
        return true;
    } else {
        return false;
    }

}
/**
 * get the plan name with the select planid
 * @param integer planid
 * @return string
 */
function GetPlanName($planid){
    $planname = "";
    
                switch ($planid) {
                case 1:
                     $planname = 'Small Plan (Less Than 10 Employees)';    
                    break;
                case 2:
                     $planname = 'Medium Plan (Less Than 50 Employees)';    
                    break;
                case 3:
                     $planname = 'Large Plan (50 Or More Employees)';    
                    break;
            }
    return $planname;
}

function GetPlanIdBraintree($planid){
    $plan = "";
                switch ($planid) {
                case 1:
                     $plan = 'complaintblastersmall)';    
                    break;
                case 2:
                     $plan = 'complaintblastermedium';    
                    break;
                case 3:
                     $plan = 'complaintblasterlarge';    
                    break;
            }
    return $plan;
}

/**
 * return geolocation by ip address
 * @param string ip address
 * @return array
 */
function GetGeolocation($ip){
    require_once('lib/ip2locationlite.class.php');

    //Load the class
    $ipLite = new ip2location_lite;
    $ipLite->setKey('dc82a3413819a4c292379897e3ff44141c1c17054662cc332c8c66f3969b5375');

    //Get errors and locations
    $locations = $ipLite->getCity($ip);
    $errors = $ipLite->getError();
    
    return $locations;
    
}


/**
 * Return Base url
 * @return string
 */
function getBaseUrl() {

	$protocol = 'http';
	if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
		$protocol .= 's';
		$protocol_port = $_SERVER['SERVER_PORT'];
	} else {
		$protocol_port = 80;
	}

	$host = $_SERVER['HTTP_HOST'];
	$port = $_SERVER['SERVER_PORT'];
	$request = $_SERVER['PHP_SELF'];
	return dirname($protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request);
}

