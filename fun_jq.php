<?php
include ("db.php");
include ("functions.php");

error_reporting(E_ALL & ~E_NOTICE);

//class encrypt and decrypt
include_once("lib/EasyCry.php");

$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);

    if (isset($_POST['action']))
        $var_action = $_POST['action'];
    if (isset($_GET['action']))
        $var_action = $_GET['action'];

if ($var_action == 'searchcountry') {
    require_once('lib/geoplugin.class.php');
    $geoplugin = new geoPlugin();
	

	$ip = $_SERVER["REMOTE_ADDR"];
	
	$geoplugin->locate($ip);

	$country = $geoplugin->countryCode;

        if ($country == "GB") {
		$row['success'] = true;
		$row['code'] = $geoplugin->countryCode;
		$row['name'] = $geoplugin->countryName;
		$row['ip'] = $ip;
		
	} else {
		$row['success'] = false;
		$row['code'] = $geoplugin->countryCode;
		$row['name'] = $geoplugin->countryName;
		$row['ip'] = $ip;
	}
	print json_encode($row);
}

if ($var_action == 'detailbusiness') {
	$id = $_POST['id'];
	$sSql = "select AVG( c.review ) AS average, o.CompanyName as CompanyName, o.Address as address
		   FROM complaints AS c JOIN organisations AS o ON c.organisationid = o.organisationID
		   WHERE c.organisationid = $id ";
	$rs = phpmkr_query($sSql, $conn) or die("fail executing line" . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
	while ($row_rs = $rs->fetch_assoc()) {
		$row['average'] = number_format($row_rs['average'], 1, '.', '');
		$row['CompanyName'] = $row_rs['CompanyName'];
		$row['address'] = $row_rs['address']; 
	}
	phpmkr_db_close($conn);

	print json_encode($row);
}

if ($var_action == 'raiting-business') {
	$id = $_POST['id'];

        $sSql = "SELECT
        FLOOR(AVG(review)) AS average,
        o.CompanyName AS CompanyName,
        coalesce(o.Address,'') AS Address,
        coalesce(o.Address2,'') AS Address2
        FROM organisations AS o
        LEFT JOIN complaints AS comp ON o.organisationID = comp.organisationid 
        where o.organisationID = $id";
        
        
         
	$rs = phpmkr_query($sSql);
	while ($row_rs = $rs->fetch_assoc()) {
		$row['average']     = $row_rs['average'];
		$row['CompanyName'] = $row_rs['CompanyName'];
		$row['Address']     = $row_rs['Address'];
		$row['Address2']    = $row_rs['Address2'];
	}
	phpmkr_db_close($conn);
	print json_encode($row);
}


if ($var_action == 'addSocial') {
	$type = $_POST['type'];
	$name = $_POST['name'];
	$password = $_POST['password'];
	$EasyCry = new EasyCry();

	$password = $EasyCry->encode($password,"ComplaintsBlaster");
        $sSql = "select coalesce(iduserssocialmedia,0) as iduserssocialmedia  from userssocialmedia where user = '$name' and type = '$type' "; 
        $result = phpmkr_query($sSql);
        if ($result){
            $row = $result->fetch_assoc();
            $id =  $row['iduserssocialmedia'];
        
            if ( $id > 0){
                    $sSql = "UPDATE userssocialmedia SET PASSWORD = '$password' WHERE iduserssocialmedia = $id "; 
                    $result = phpmkr_query($sSql);
                }
            else{
                $sSql = "insert into userssocialmedia (type, user, password) values('$type','$name','$password')";
                phpmkr_query($sSql, $conn) or die("Error adding social in lines" . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
            }

        }

	phpmkr_db_close($conn);

	$row['0'] = 1;
	print json_encode($row);
}

if($var_action == 'sendmail_conf')
{
	$name = $_POST['name'];
	$email = $_POST['email'];

	$to = $email;
	$subject = "Register in ComplaintsCounter";
	$txt = "Confirmation register ComplaintsCounter";
	$headers = $email . "\r\n";


	mail($to,$subject,$txt,$headers);
	$row['0'] = 1;

	print json_encode($row);


}

if ($var_action == 'sendmail') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	$to = EMAIL;
	$subject = "Contact us";
	$txt = $message;
	$headers = $email . "\r\n";

	mail($to,$subject,$txt,$headers);

	$row['0'] = 1;
	print json_encode($row);
}

if ($var_action == 'regionsCountys') {
	$sSql = "SELECT geo.organisationsgeoid, geo.CountyID, co.County, geo.RegionID, r.Region, geo.CountryID 	FROM organisationsgeo AS geo 
	JOIN organisationcountys AS co  ON geo.CountyID = co.countyid JOIN  organisationregions AS r  ON r.RegionID = geo.RegionID";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
        if ($con > 0){
            while ($row_rs = $rs->fetch_array()) {
                    $row[] = $row_rs;
            }
        }

	print json_encode($row);
}

if ($var_action == 'loadregions') {
	$sSql = "SELECT  DISTINCT a.RegionID, Region, b.countryid  FROM   organisationregions a  JOIN organisationsgeo b  ON a.RegionID =  b.RegionID ";
	
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
        if ($con > 0){
            while ($row_rs = $rs->fetch_array()) {
                    $row[] = $row_rs;
            }
        }

	print json_encode($row);
}


if ($var_action == 'countrylist') {

	$sSql = "select * FROM country order by Country";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
	while ($row_rs = $rs->fetch_array()) {
		$row[] = $row_rs;
	}

	print json_encode($row);
}

if ($var_action == 'countylist') {

	$sSql = "select * FROM organisationcountys order by County";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
	while ($row_rs = $rs->fetch_array()) {
		$row[] = $row_rs;
	}

	print json_encode($row);
}

if ($var_action == 'townlist') {

	$sSql = "SELECT * FROM organisationtowns ORDER BY Town";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
	while ($row_rs = $rs->fetch_array()) {
		$row[] = $row_rs;
	}

	print json_encode($row);
}


if ($var_action == 'regionlist') {

	$sSql = "SELECT * FROM organisationregionss ORDER BY Region";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
	while ($row_rs = $rs->fetch_array()) {
		$row[] = $row_rs;
	}

	print json_encode($row);
}

if ($var_action == 'businesslist') {
	
                $businessname = $_GET['term'];
    
                $sSql = "SELECT o.CompanyName, CONCAT(COALESCE(o.Address,''), ' ' ,COALESCE(o.Address2,'')) AS address, COALESCE(ct.County,'') AS county, COALESCE(c.Country,'') AS country, o.CompanyName as name, o.organisationID AS id, o.IndustryID 
                           FROM organisations AS o 
                           LEFT JOIN country AS c ON o.CountryID = c.CountryID
                           LEFT JOIN organisationcountys AS ct 
                             ON o.CountyID = ct.CountyID
                          where o.CompanyName like '".$businessname."%' order by o.CompanyName  limit 10";

		$rs = phpmkr_query($sSql);
		$con = phpmkr_num_rows($rs);
                        $county = "";
                        $country = "";
                        $row = "";
			while ($row_rs = $rs->fetch_array()){
			   $address = trim($row_rs[1]); 
			   
			   $county = trim($row_rs[2]); 	
			   $country = trim($row_rs[3]); 	
			   if ((!empty($county))){
                               if ((!empty($address)))
                                    $county = ", ". $county;  
			   }
			   
			   if ((!empty($country))){
                                if ((!empty($address)) || (!empty($county) ))
                                     $country = ", ". $country;
                           }
                           
			   $row_rs[0] = $row_rs[0]." (".$address.$county.$country.")"  ;
                           $row[] = array("Label" => $row_rs[5], "value" => $row_rs[0], "CompanyName" => $row_rs[4], "IndustryID"=> $row_rs[6]);
			}
			
		echo  json_encode($row);
                
}

if ($var_action == 'addB') {
        
	$name = addslashes($_POST['name']); 
	$address = addslashes($_POST['address']);
	$city = $_POST['city'];
	$country = $_POST['countryid'];
	//$region = $_POST['regionid'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
        $countyid = $_POST['countyid'];
	$website = $_POST['website'];
        $postcode = $_POST['postcode'];
        $industryid = $_POST['industryid'];
        $contactname = $_POST['contactname'];
        include_once ("subscription.php");
	$subscription = new subscription();
        $organisationid = $subscription->InsertNewOrganisation($name, $address, $city, $country, 0, $countyid, $phone, $email, $website, $postcode, $industryid );
        $row['idBusiness'] =  $organisationid * -1;
	$row['success'] = true;
	print json_encode($row);
}

/**
 * 
 * check for e-mail in the database
 * @var trigger [userverifyexist]
 */
if ($var_action == 'userverifyexist') {

	$name  = $_POST['name'];
	$email = $_POST['email'];

	$sSql="SELECT * FROM users Where email = '$email'";
	$rs = phpmkr_query($sSql, $conn) or die 
	("Error reading users in lines" . __LINE__ . ": " . phpmkr_error($conn) . "<br>SQL: " . $sSql);
	$row[0]=0;
		while ($row_rs = $rs->fetch_assoc()) {
		$row_rs['email']    = $row['email'];
			if ($row_rs['email'] == $row['email']) {
                            $row[0] = 1;
			}
			else
			{
                            $row[0] = 0;
			}
		}

	phpmkr_db_close($conn);
	print json_encode($row);
}

/**
 * Verificate token before activate account
 */
if ($var_action == 'verifytoken') {

	$email = $_POST['email'];
	$token = $_POST['token'];
	$flag=0;

	$sSql = "SELECT email, password FROM users where email = '$email' AND status = 'inactive';";
	$rs = phpmkr_query($sSql, $conn);
	while ($row_rs = $rs->fetch_assoc()) {
            $verify['password'] = $row_rs['password'];
	}
	if ($token == $verify['password']) {
            $flag=1;
	}
	else
	{
		$flag=0;
	}
        
	$row["success"] = $flag;
        
	//phpmkr_db_close($conn);
	echo json_encode($row);
}

if ($var_action == "activateuser") {
    
        $flag = 0;	
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_conf= $_POST['pass_conf'];
	$newpass = md5($pass);
        $token = $_POST['token'];
        
	$sSql = "SELECT email, password, userid FROM users where email = '$email' and status <> 'deleted';";
	$rs = phpmkr_query($sSql);
        if ($rs){
            $row = $rs->fetch_assoc();
            $row["validtoken"] = false;
            $userid = $row['userid'];
            if ($token == $row['password']){
                $row["validtoken"] = true; 
                $sSql = "UPDATE users SET status='active', password='$newpass' WHERE userid='$userid';";
                $rs = phpmkr_query($sSql);
                if ($rs){
                    $flag = 1 ;
                    DoLogin($email, $newpass, 'u'); 

                }
            }
	}

        $row['success'] = $flag; 
	
	print json_encode($row);
        
}


/**
 * Change the first password
 * @var trigger [changefirstpass]
 */
if ($var_action == 'changefirstpass') {
	$flag=0;

	if (isset($_POST['pass']) && !empty($_POST['pass']) &&
		isset($_POST['pass_conf']) && !empty($_POST['pass_conf']) &&
		isset($_POST['email']) && !empty($_POST['email']) ) {
			$email = $_POST['email'];
			$pass = $_POST['pass'];
			$pass_conf= $_POST['pass_conf'];
			$newpass = md5($pass);


			$sSql = "UPDATE users SET password='$newpass' WHERE email='$email';";
			$rs = phpmkr_query($sSql, $conn) 
			or die ("fail executing line" . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
			$flag=1;

	}
	else
	{
		$flag=0;
	}
	
	$row[0]=$flag;
	
	print json_encode($row);
	
}

 /** 
 * 
 * Create a user inactive and send a email link to activate the account
 * @param integer Business id
 * @param string Email of user
 * @param string Status active or inactive
 * @param string Name 
 * @param string Forname
 * @param string Surname
 * @return array 
 */   

function CreateUser($businessid, $email, $status, $name, $forename = "", $surname = ""){
    
    require_once('lib/geoplugin.class.php');
    
    $ip = $_SERVER["REMOTE_ADDR"];
    
    $usercity = ""; 
    $location = GetGeolocation($ip);
    
    if (!empty($location['cityName']))
        $usercity = $location['cityName']; 

	$password = generateRandomString();
        $passencr = md5( $password );
	$detail_name= preg_split("/[\s]+/", $name);

        $forname = "" ;
	$surname = "" ;

        $pos = strpos($email, '@');
        $username = substr($email, 0, $pos ); 

        $query  = " SELECT userid, email, status from users where email = '$email' and status <> 'deleted' ";
        $result = phpmkr_query($query); 

        if ($result){
            $row  = $result->fetch_assoc();
            if ($row['userid'] > 0){
                return $row['userid']; 
            }
        }

       $query  = " INSERT INTO users ( businessid, email,username, password, status, forename, surname, name, ipaddress, usercity, date) ";
       $query .= " VALUES('$businessid','$email','$username',md5('$password'), '$status', '$forename', '$surname', '$name','$ip','$usercity', CURRENT_DATE)";
		 
	$mysqli = new mysqli(HOST, USER, PASS, DB, PORT);

	$mysqli->query($query);

	$userid = $mysqli->insert_id;
		 
	if (!$userid > 0)
            return false; 
                
        $host= $_SERVER['HTTP_HOST'];
        $root= $_SERVER['PHP_SELF'];
                
        $pos = strpos($root, 'fun_jq.php');        
        $root = substr($root, 0, $pos ); 
		 
	$to = $email;
	$subject = "Register in ComplaintsCounter";
	$welcome_email = "Thank you for registering with ComplaintsBlaster. Your account is now set up.\r\n\r\n"; 
         
        $welcome_email .= "For future reference your username is: ".$username." and you password is: " .$password."\r\n\r\n";
                    
	$welcome_email .="You must activate your account by clicking on the link below.\r\n\r\n";
        $welcome_email .="http://".$host.$root."activate.php?us=".$email."&token=".$passencr."\r\n\r\n";

	$welcome_email .="\r\n\r\nWe would recommend that you change your password when you login.\r\n\r\n";

        $welcome_email .="As a member of ComplaintsCounter you will now be able to:\r\n";
	$welcome_email .="- Create and send out complaints quickly";
	$welcome_email .="- Read reviews of other companies\r\n";

	$welcome_email .="If you need to get in touch please email us at info@complaintscounter.co.uk. You can follow us on Facebook at @facebookdir and on Twitter at @twitteruser\r\n Kind Regards";
        $welcome_email .= "Zak\r\nCommunity Manager";
        
        $headers = EMAIL . "\r\n";

	$sent = mail($to,$subject, $welcome_email);
        
    return $userid;
        
}    
	

if ($var_action == "insertcomplaint") {
		$row['success'] = false;
		$data = $_POST;
		$organsationid = $data['organisationid'];
		$name = $data['name'];
		$email = $data['email'];
		$title = addslashes($data['title']);
		$complaints = addslashes($data['complaint']);
		$review = $data['review'];
		$broadcast = $data['broadcast'];
                $industryid = $data['industryid'];
		
		$userid = CreateUser(0, $email, 'inactive', $name, $forename = "", $surname = "", "u" );			
                $status = "a";
                
		$query  = " INSERT INTO complaints (organisationid, review, complaint, date, userid, title, broadcastdays, status, broadcastdate) ";
		$query .= "  VALUES ($organsationid, $review, '$complaints', CURRENT_TIMESTAMP, $userid, '$title', $broadcast, '$status', DATE_ADD(CURRENT_TIMESTAMP,INTERVAL $broadcast DAY) ) ";
		
		$result = phpmkr_query($query );
		
		if ($result){
                    if ($industryid > 0){
                        $query = "SELECT a.url, COALESCE(a.email), a.description   
                                    FROM complaintsites AS a
                                    JOIN organisationindustriescomplaintsites AS b
                                      ON a.complaintsiteid = b.complaintsiteid
                                    WHERE b.IndustryID = $industryid ";

                        if ($result )    
                            $result = phpmkr_query($query );
                            $url =""; 
                            while ($row = $result->fetch_array()) {
                                $url .= $row['url']."\r\n\r\n";
                            }

                            $to = $email;
                            $subject = " Best urls that match with your complaint \"$title\" ";
                            $body = "This a list of websites that match with your complaints \"$title\".\r\n\r\n."
                                    . "  This are the best business of the industry.\r\n\r\n"; 
                            $body .= $url;  

                            $sent = mail($to,$subject, $body);

                    }
                    
                    $row['success'] = true;
		}
		echo json_encode($row);
		
}

if ($var_action == "feedback") {
	$to = EMAIL;
	$subject = '';
	$subject = "ComplaintBlaster feedback received - ";
	$txt ="";
	$name = $_POST['name'];
	$email = $_POST['email'];
        if (!empty($name)){
            $txt = "$name( $email ) wrote the following message: \r\n\r\n ";
        }

	
            
        $message = $txt . $_POST['content'];    
        
	if (isset($_POST['title']) && !empty($_POST['title'])) {
		$subject .= $_POST['title'];
	} else {
		$subject = "ComplaintBlaster feedback received";
	}

	if (isset($_POST['content']) && !empty($_POST['content'])) {
		$txt = trim($message);
	} else {
		$row['success'] = 0;
		print json_encode($row);
		return false;
	}
	
	$headers = $email . "\r\n";

        
	mail($to, $subject, $txt);
	$row['success'] = 1;

	print json_encode($row);
}

if ($var_action == 'industrylist') {

	$sSql = "select * FROM organisationindustries order by Industry";
	$rs = phpmkr_query($sSql);
	$con = phpmkr_num_rows($rs);
	while ($row_rs = $rs->fetch_array()) {
		$row[] = $row_rs;
	}

	print json_encode($row);
}


if ($var_action == 'complaintcaptcha') {
    $success = false;
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            //your site secret key
            $secret = CAPTCHASECRET;
            //get verify response data
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success){
                //contact form submission code
                //$succMsg = 'Your contact request have submitted successfully.';
                $success = true;;
            }
            else{
                //$errMsg = 'Robot verification failed, please try again.';
                $success = false;
            }
    }    
    else{
        $success = false;
    }
    $row["success"] = $success; 
   echo json_encode($row);

}




?>