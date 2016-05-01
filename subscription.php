<?php

require_once 'db.php';
require_once 'functions.php';


if (isset($_GET['action'])){
    if (!isset($_SESSION['organisationid']))
        GetUserSession();
    
    $action = $_GET['action'];
    
    if (!empty($_POST)){
        $data = $_POST; 
	}
    
    switch ($action) {
		
        case 'insert':
                require_once 'payments.php';
                $active = true;
                $agreementid ="";
                $card ="";
                $payments = new payments();         
                $card = $payments->CreateCreditCard($data['txtCard'], $data['typecard'], $data['txtExp'],$data['txtCvc'], $data['txtContactEmail'], $data['txtBusinessName']);
                if ($card){
                    $cardid = $card->id;
                    $cardstate = $card->state;
                    $payment = $payments->CreatePayment($cardid, $data['paidPlanAmount'], GetPlanName($data['planpaid']));
                    $paymentstate = $payment->state;
                    $paymentid = $payment->id;
                }
                
                if ($paymentstate != "approved"){
                    $result = false;
                    break;
                }
            
	        $data['status'] = 'active';
                $subscription = new subscription();         
                
               $organisationid = $data['organisationid'];
               
               if ($organisationid == 0){     
                    $organisationid = $subscription->InsertOrganisation(
                                                                        $data['txtBusinessName'], 
                                                                        $data['txtStreet'], 
                                                                        $data['townlistregister'], 
                                                                        $data['countrylistregister'], 
                                                                        "0", 
                                                                        $data['countylistregister'], 
                                                                        $data['txtPhone'],
                                                                        $data['txtContactEmail'],
                                                                        "", 
                                                                        $data['txtWebsite'],                               
                                                                        $data['txtPostal'],
                                                                        $data['txtContactName'],
                                                                        $data['industrylist']    
                                                                        );
                    } 
                    
                $result = $subscription->InsertSubscription(
                                                     $data['type'],
                                                     $data['status'], 
                                                     $data['txtCard'], 
                                                     $data['txtExp'], 
                                                     $data['txtCvc'], 
                                                     $data['txtBusinessName'], 
                                                     $data['txtStreet'], 
                                                     $data['townlistregister'], 
                                                     "", 
                                                     $data['txtPostal'], 
                                                     $data['countrylistregister'], 
                                                     $data['txtContactName'], 
                                                     $data['txtContactEmail'],
						     $data['planpaid'],
						     $data['txtPasswordRegister'],
						     $data['paidPlanAmount'],
                                                     $agreementid,
                                                     $organisationid,
                                                     $cardid,
                                                     $paymentid   
                                                    );
                
                
                $result =  $payments->CreatePaymentDetail($organisationid, $paymentstate, $paymentid, $data['paidPlanAmount'],  "GBP");
                
            
            $result = json_encode($result);
            break;
        case 'checksubscriptionemail':
		    $email = $_GET['email'];
                    $subscription = new subscription();         
		    $result = $subscription->CheckSubscriptionEmail($email);
		    $result = json_encode($result);
            break;
         case 'subscriptionemailchange':
		    $email = $_GET['email'];
                    $userid = $_SESSION['userid'];
                    if (isset($_GET['userid']))
                        $userid = $_GET['userid'];
                    
                    $subscription = new subscription();         
		    $result = $subscription->CheckSubscriptionEmailChange($userid, $email);
		    $result = json_encode($result);
            break;       
        case 'login':
                    $subscription = new subscription();         
	    	    $result = $subscription->CheckLogin(
		  			   	        $data['txtUsername'],
							$data['txtPassword'],
                                                        $data['logintype']
        						);
		    $result = json_encode($result);
            break;
        case 'resetpassword':
                    $subscription = new subscription();         
	    	    $result = $subscription->EmailForgotPassword(
		  			   	        $data['txtEmailRecover']							
        						);
		    $result = json_encode($result);
            break;
        case 'resetpasswordpaneladmin':
                    $useremail = $_GET['email'];
                    $subscription = new subscription();         
	    	    $result = $subscription->EmailForgotPassword(
		  			   	        $useremail							
        						);
		    $result = json_encode($result);
            break;
        
        case 'recoverpassword':
                    $subscription = new subscription();         
	    	    $result = $subscription->RecoverPassword(
		  			   	        $data['txtPasswordRecover'],
							$data['txtHash'],
                                                        $data['txtEmailRecover']
        						);
		    $result = json_encode($result);
            break;
        
        case 'updateuser':
                    $subscription = new subscription();
                    $userid = $_SESSION['userid'];
	    	    $result = $subscription->UpdateUser($userid,
							$data['txtUserEmail'], 
                                                        $data['txtUserUsername'],
                                                        $data['txtCity']
        						);
		    $result = json_encode($result);
            break;
        
        case 'update':
                    $data['status'] = 'active';
                    $userid = $_SESSION['userid'];
                    $subscription = new subscription();         
                    $result = $subscription->updateSubscription(
                                                     $_SESSION['organisationid'],
                                                     $data['type'],
                                                     $data['status'], 
                                                     $data['txtBusinessName'], 
                                                     $data['txtStreet'], 
                                                     $data['townlistregister'], 
                                                     "", 
                                                     $data['txtPostal'], 
                                                     $data['countrylistregister'], 
                                                     $data['txtContactName'], 
                                                     $data['txtContactEmail'],
                                                     $data['countylistregister'],
                                                     $userid    
                                                    );
                        
                    if ($result){
                        $result = $subscription->updateOrganisation(
                                                                    $_SESSION['organisationid'],
                                                                    $data['txtBusinessName'], 
                                                                    $data['txtStreet'], 
                                                                    $data['townlistregister'], 
                                                                    $data['countrylistregister'],
                                                                    $data['countylistregister'],
                                                                    $data['txtPostal'], 
                                                                    $data['txtContactName'], 
                                                                    $data['txtContactEmail'],
                                                                    $data['txtPhone'],
                                                                    $data['txtWebsite'],
                                                                    $data['industrylist']
                                
                                                                    );
                    
                        
                    }
                    
                     $result = json_encode($result);
                     break;
        case 'checkcompanyname':
                    $businessname = $data['txtBusinessName'];
                    $organisationid = $data['organisationid'];
                    $type = "";
                    if (!empty($data['typebusiness']))
                        $type = $data['typebusiness'];
                    
                    if (empty($organisationid))
                        $organisationid = 0;
                    
                    $subscription = new subscription();         
                    $result = $subscription->CheckCompanyName($businessname, $organisationid, $type);
                     $result = json_encode($result);
                     break;
        case 'contact':
            $row['success'] = SendEmailContactUs($_POST['txtNameContact'], $_POST['txtEmailContact'], $_POST['txtSubjectContact'], $_POST['txtMessage'] );
            $result = json_encode($row);
            break;
        
	case 'showmoreusers':
            $subscription = new subscription();         
            $lastid = $_GET['lastid'];   
            $result = $subscription->ShowMoreUsers($lastid);
            $result = json_encode($result);
            break;        
	case 'showmorebusiness':
            $subscription = new subscription();         
            $lastid = $_GET['lastid'];   
            $result = $subscription->ShowMoreBusiness($lastid);
            $result = json_encode($result);
            break;        
        
	case 'approvebusiness':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->ApproveBusiness($organisationid);
            $result = json_encode($result);
            break;        
        
	case 'rejectbusiness':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->RejectBusiness($organisationid);
            $result = json_encode($result);
            break;        
        
	case 'blockuser':
            $subscription = new subscription();         
            $userid = $_GET['userid'];   
            $block = $_GET['block'];   
            $result = $subscription->BlockUser($userid, $block);
            $result = json_encode($result);
            break;        
        
	case 'deleteuser':
            $subscription = new subscription();         
            $userid = $_GET['userid'];   
            $result = $subscription->DeleteUser($userid);
            $result = json_encode($result);
            break;        
        
	case 'getneworganisation':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->GetNewOrganisation($organisationid);
            $result = json_encode($result);
            break;        
	case 'getorganisation':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->GetOrganisation($organisationid);
            $result = json_encode($result);
            break;            
        
	case 'updateneworganisation':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];
            $result = $subscription->updateNewOrganisation(
                                                            $organisationid,
                                                            $data['txtBusinessName'],
                                                            $data['txtStreet'], 
                                                            $data['townlistregister'], 
                                                            $data['countrylistregister'],
                                                            $data['countylistregister'],
                                                            $data['txtPostal'], 
                                                            $data['txtContactName'], 
                                                            $data['txtContactEmail'],
                                                            $data['txtPhone'],
                                                            $data['txtWebsite'],
                                                            $data['industrylist']
                    
                                                          );
            $result = json_encode($result);
            break;        
        
	case 'updateorganisation':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];
            $result = $subscription->updateOrganisation(
                                                            $organisationid,
                                                            $data['txtBusinessName'],
                                                            $data['txtStreet'], 
                                                            $data['townlistregister'], 
                                                            $data['countrylistregister'],
                                                            $data['countylistregister'],
                                                            $data['txtPostal'], 
                                                            $data['txtContactName'], 
                                                            $data['txtContactEmail'],
                                                            $data['txtPhone'],
                                                            $data['txtWebsite'],
                                                            $data['industrylist']
                                                          );
            $result = json_encode($result);
            break;                
        
	case 'getuser':
            $subscription = new subscription();         
            $userid = $_GET['userid'];   
            $result = $subscription->GetUser($userid);
            if ($result){
                $organisationid = $result["businessid"];
                $user = $result;
                if  ($organisationid > 0){
                    $row = $subscription->GetOrganisation($organisationid);
                    $row["email"] = $row["EmailAddresses"];
                    $row["name"] = $user["name"];
                    
                }else{
                    $row = $user;
                }
                
            } 
            $result = json_encode($row);
            break;        
            
        case 'updateuseredit':
                    $subscription = new subscription();
	    	    $result = $subscription->UpdateUser(
                                                        $data['userid'],
							$data['txtUserEmail'], 
                                                        $data['txtUserUsername'],
                                                        $data['txtCity'] 
        						);
		    $result = json_encode($result);
            break;
        
        case 'updateuserbusinessedit':
                    $userid = $data['userid'];
                    $subscription = new subscription();
                    $result = $subscription->updateSubscription(
                                                     $data['organisationid'],
                                                     "subscriber",
                                                     "active", 
                                                     $data['txtBusinessName'], 
                                                     $data['txtStreet'], 
                                                     $data['townlistregister'], 
                                                     "", 
                                                     $data['txtPostal'], 
                                                     $data['countrylistregister'], 
                                                     $data['txtContactName'], 
                                                     $data['txtContactEmail'],
                                                     $data['countylistregister'],
                                                     $userid    
                                                    );
                    if ($result){
                        $result = $subscription->updateOrganisation(
                                                                    $data['organisationid'],
                                                                    $data['txtBusinessName'], 
                                                                    $data['txtStreet'], 
                                                                    $data['townlistregister'], 
                                                                    $data['countrylistregister'],
                                                                    $data['countylistregister'],
                                                                    $data['txtPostal'], 
                                                                    $data['txtContactName'], 
                                                                    $data['txtContactEmail'],
                                                                    $data['txtPhone'],
                                                                    $data['txtWebsite'],
                                                                    $data['industrylist']
                                                                    );
                    }                    
		    $result = json_encode($result);
                    break;
                    
        case 'deletebusiness':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->DeleteNewOrganisation($organisationid);
            $result = json_encode($result);
            break;                     
        
	case 'showmoreorganisations':
            $subscription = new subscription();         
            $lastid = $_GET['lastid'];   
            $result = $subscription->ShowMoreOrganisations($lastid);
            $result = json_encode($result);
            break;        
        case 'deleteorganisation':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->DeleteOrganisation($organisationid);
            $result = json_encode($result);
            break;                     
        case 'showpaymentdetails':
            $subscription = new subscription();         
            $organisationid = $_GET['organisationid'];   
            $result = $subscription->ShowPaymentDetails($organisationid);
            $result = json_encode($result);
            break;                     
    }
if (!empty($result))
    echo $result;    

}

class subscription{
  
    
    var $agreementid;
    
    
/** 
 * save a subscription in table subscription
 * @param string type = 'trial' or 'subscriber'
 * @param string status = 'active' or 'inactive'
 * @param string status = 'active' or 'inactive'
 * @param integer cardno number of credicard
 * @param string expiration date of credicard format mm/yyyy
 * @param integer cvv security code of credicard
 * @param string business name 
 * @param string address of business
 * @param string city
 * @param string postal code
 * @param string country
 * @param string contact name
 * @param string contact email
 * @param integer paid plan
 * @param string password
 * @param decimal amount
 * @param string agreement id
 * @return array 
 */	
     

    public function InsertSubscription($type, $status, $cardno,$expirydate,$cvv, $businessname, $address, $city, $state, $postalcode, $country, $contactname, $contactemail, $paidplan, $password, $amount, $agreementid, $organisationid = 0, $cardid, $paymentid ){
        
            $businessname = addslashes($businessname);
            $address = addslashes($address);
            $contactname = addslashes($contactname);

        
            if (empty($expirydate))
                $expirydate = "01/2000";
            
            if (empty($cvv))
                $cvv = 0;
        
	    $pos = strpos($expirydate, '/');
	    $expmonth = substr($expirydate, 0, $pos ); 
            $expyear = substr($expirydate, $pos+1, strlen($expirydate)); 
            $cardno = substr($cardno, -4, 4); 
            $cardno = "XXXXXXXXXXXX". $cardno; 

            
            $expiration = $expyear."-".$expmonth."-01";
            $query = "INSERT INTO  subscriptions (organisationID, date, type, status, cardno, expirydate, cvv, businessname, address, city, state, postalcode, country, contactname, contactemail, paidplan, amount, agreementid, cardid, nextpaymentdate) ";
	    $query .= " values($organisationid, current_date,'$type','$status','$cardno','$expiration','$cvv','$businessname','$address','$city','$state','$postalcode','$country','$contactname','$contactemail','$paidplan', $amount, '$agreementid', '$cardid', DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH) )"; 
		
		 $mysqli = new mysqli(HOST, USER, PASS, DB, PORT);

		 $mysqli->query($query);

		 $subscriptionid = $mysqli->insert_id;
		 
		 $row["id"] = $subscriptionid ;
		 
                 if ($subscriptionid > 0){
			 $row["success"] = true;
			 $forename = "";
			 $surname = "";
			 $this->InsertUser( $subscriptionid, $contactemail, $password, $status, $forename, $surname);
                         
                         $this->SendSubscriptionEmail($contactemail, $paymentid, $agreementid);
                }else
                         $row["success"] = false;
		 
         return $row;
        
    }
    
/** 
 * check if a email exist in table users
 * @param string email to check
 * @return array 
 */	    
    public function CheckSubscriptionEmail($email){
        
        $query ="SELECT count(*) as count FROM users WHERE email = '$email' and status <> 'deleted' ";
        $result = phpmkr_query($query);
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) 
            $row["success"] = true;
        else
            $row["success"] = false;
            
        return $row;
    }
/** 
 * insert a user in table users
 * @param string business if businessid > 0 = Business User, businessid = 0 regular user  
 * @param string email  
 * @param string password
 * @param string status = active or inactive
 * @param string $forename useless for the moment 
 * @param string $surname useless for the moment
 * @return array 
 */    
    public function InsertUser($businessid, $email,$password, $status, $forename = "", $surname = ""){
         $pos = strpos($email, '@');
         $username = substr($email, 0, $pos ); 
         $query  = " INSERT INTO users ( businessid, email,username, password, status, forename, surname, date) ";
         $query .= " VALUES('$businessid','$email','$username',md5('$password'), '$status', '$forename', '$surname', CURRENT_DATE)";
		 
        $result = phpmkr_query($query);
        $row["success"] = true;
    }    
/** 
 * login of user 
 * @param string username or email
 * @param string password
 * @param string logintype b = business login, u = user login  
 * @return array 
 */	
    public function CheckLogin($username,$password, $logintype){
	$where = "";	
        $decripted = $password;
        $password = md5($password);
    
    if ($logintype == 'b')
        $where = " businessid > 0 ";
        else    
        $where = " businessid = 0 ";
    
    $query ="SELECT * FROM users WHERE (". $where. " and password = '$password' )  and (username = '$username' or  email = '$username' ) and (status = 'active' or status = 'blocked' )";
    $result = phpmkr_query($query);
    $row = $result->fetch_assoc();
        $row["success"] = "";
        if (empty($row['username'])){ 
            $row["success"] = false;
            $row["emailadmin"] = EMAIL;
        
            $query ="SELECT userid, status, coalesce(failed,0) as failed FROM users WHERE ". $where. "   and (username = '$username' or  email = '$username' ) and (status = 'active' or status = 'blocked')";
            $user = phpmkr_query($query);
            if ($user){
                $rowuser = $user->fetch_assoc();
                $row['blocked'] = $rowuser["status"];
                $userid = $rowuser["userid"];
                if ($userid > 0 ){
                    $failed = $rowuser['failed'] + 1;
                    $query = "UPDATE users set failed = $failed where userid = $userid ";
                    $user = phpmkr_query($query);
                        
                    if ($failed >= 5){
                        $query = "UPDATE users set status = 'blocked' where userid = $userid ";
                        $user = phpmkr_query($query);
                    }
                }
            }
        }
        
        else{
                $row["success"] = true;

                $_SESSION['userid']  = $row["userid"];
                $_SESSION['username']  = $row["username"];
                $_SESSION['email']  = $row["email"];
                $_SESSION['usertype'] = "u";
                $_SESSION['name'] = $row["name"];
                $_SESSION['organisationid']  = $row["businessid"];
                $row["emailadmin"] = EMAIL;

                $row["blocked"] = false;
                
                if ($row["status"] == 'blocked'){
                    $row["success"] = false;
                    $row["blocked"] = $row["status"];
                }
                if ($row["businessid"] > 0){
                    $_SESSION['usertype'] = "b";
                }    

                if ($row["username"] == "admin"){
                    $_SESSION['usertype'] = "a";
                }    


                if (isset($_POST['rememberuser'])){
                    $year = time() + 31536000;
                    setcookie('remember_me', $row["username"], $year, '/');
                    setcookie('rememberpassword', $decripted, $year, '/');
                }

                $query ="SELECT organisationID as id, contactemail,status, type FROM subscriptions WHERE organisationID = '".$row["businessid"]."'" ;
                $result = phpmkr_query($query);
                $subscription = $result->fetch_assoc();

                if (isset($subscription["id"])){

                    $row['organisationid'] = $subscription["id"];;
                    $row['contactemail']  = $subscription["contactemail"];
                    $_SESSION['contactemail']  = $subscription["contactemail"];
                    $_SESSION['status']  = $subscription["status"];
                    $_SESSION['type']  = $subscription["type"];
                }
                
                $query = "UPDATE users set failed = 0 where userid = ".$_SESSION['userid'];
                $user = phpmkr_query($query);

            }
        return $row;
    }	
/** 
 * get all fields of subscription by id 
 * @param integer if of subscription
 * @return array 
 */    
    public function GetSubcription($id){
        $row = "";
        
        $query ="SELECT  a.*, b.TownID, b.CountyID, b.CountryID, b.WebsiteAddress, b.TelephoneNumber, b.IndustryID FROM subscriptions AS a  LEFT JOIN organisations AS b  ON b.organisationID =  a.organisationID  where a.organisationID = $id" ;
        $result = phpmkr_query($query);
        if ($result){ 
            $row = $result->fetch_assoc();
            if ($row['organisationID'] > 0){ 
                $row['success'] = true;
                return $row; 
            }
         }    
         return false;
    }       

/** 
 * update the field of a subscription
 * @param integer organisationid
 * @param type = 'subscription' or 'trial'
 * @param status = 'active' or 'inactive'
 * @param string business name 
 * @param string address
 * @param string city
 * @param string state
 * @param string postale code
 * @param string country
 * @param string contact name
 * @param string contact email
 * @return array 
 */  
    
    public function updateSubscription($organisationid,  $type, $status, $businessname, $address, $city, $state, $postalcode, $country, $contactname, $contactemail, $county, $userid = 0 ){
         
         $query =  " UPDATE subscriptions SET  type = '$type', businessname = '$businessname' , address = '$address', city = '$city', state = '$state', ";
         $query .= " postalcode = '$postalcode', country = '$country', contactname = '$contactname', contactemail = '$contactemail'";
         $query .= " WHERE organisationID = $organisationid ";  
         
         
         $result = phpmkr_query($query);
         if ($result){
             if ($userid == $_SESSION['userid'])
                $_SESSION['organisationid'] = $organisationid;   
            
         $this->UpdateUser($userid, $contactemail, "", true);
         
         $row["success"] = true;
         return $row;
        
        }
     }
   /** 
 * update username and email from table users
 * @param string userid 
 * @param string $email
 * @param string $name
 * @param string $sessionupdate (optional)
 * @return array 
 */  
    public function UpdateUser($userid, $email, $name = "", $city = "",  $sessionupdate = false){
         $pos = strpos($email, '@');
         $username = substr($email, 0, $pos ); 
         if (empty($name))
            $query ="UPDATE users SET username = '$username', email = '$email', usercity = '$city' WHERE userid = '$userid'  ";
         else
             $query ="UPDATE users SET username = '$username', email = '$email', name = '$name', usercity = '$city'  WHERE userid = '$userid' ";
             
         $result = phpmkr_query($query);
         $row["success"] = false;
         
         if ($_SESSION['userid'] == $userid){
            if ($result){
                   $row["success"] = true;
                   $row["email"] = $email;
                   $row["username"] = $username;
                   $row["name"] = $name;
                   $_SESSION['username']  = $username;
                   $_SESSION['email']  = $email;
               }
         }
            return $row;
    }
   
 /** 
 * check when user email changes is not been registered by another user
 * @param string userid 
 * @param string $email
 * @return array 
 */      
    public function CheckSubscriptionEmailChange($userid, $email){
        $query ="SELECT count(*) as count FROM users WHERE email = '$email' and  userid <> $userid and status <> 'deleted' ";
        $result = phpmkr_query($query);
        
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) 
            $row["success"] = true;
        else
            $row["success"] = false;
            
        return $row;
    }
 
 /** 
 * send a email to user with instruccions to recover the password
 * @param string $email
 * @return array 
 */        
    public function EmailForgotPassword($email){
        $query ="SELECT concat(md5(md5(username)), md5(password)) as hash, userid,  email FROM users WHERE trim(email)  = trim('$email') and status <> 'deleted'";
        $result = phpmkr_query($query);
        
        if ($result){ 
            
            $row = $result->fetch_assoc();
            if (!empty($row['email'])){
                $host= $_SERVER['HTTP_HOST'];
                $root= $_SERVER['PHP_SELF'];
                
                $pos = strpos($root, 'subscription.php');        
                $root = substr($root, 0, $pos ); 

                $hash = $row['hash'];
                $headers = "From:Password Recover <".EMAIL.". >\r\n";  
				$message  = "to recover you password should click in the url below\r\n";
                $message .= "http://".$host.$root."recoverpass.php?id=".$hash."&email=".$row['email'];
		
		$sent = mail($email,"Complaints Counter Password Recover",$message);
                        
		if ($sent)
                    $row["success"] = true;  
		else
                    $row["success"] = false;  
		}
            else{
		$row["success"] = false;
			}	
		}    
	    return $row;			
    }
 /** 
 * change old password and replace for the new when receive a email from forgot password
 * @param string password
 * @param string $hash
 * @param string $email
 * @return array 
 */  
    public function RecoverPassword($password, $hash, $email){
        
        $query = " UPDATE users SET password = MD5('$password'), status = 'active' "; 
        $query .= " WHERE CONCAT(MD5(MD5(username)), MD5(password)) = '$hash' AND email = '$email' ";  

        $result = phpmkr_query($query);
        
        if ($result){ 
            $row["success"] = true;  
        }
        else{
            $row["success"] = false;
        }
		return $row;
    }    
 /** 
 * get user fields by id
 * @param integer userid
 * @return array 
 */  
    public function GetUser($userid){
        $query ="SELECT * FROM users WHERE userid = $userid ";
	$result = phpmkr_query($query);
	$row = $result->fetch_assoc();
        if (empty($row['username'])) 
            $row["success"] = false;
        else{
            $row["success"] = true;
            return $row;	
            }
    }	
    

 /** 
 * send a email after business user subscribed
 * @param string email
 * @param string agreementid from paypal
 */       
    public function SendSubscriptionEmail($email, $paymentid, $agreementid = "") {
        $pos = strpos($email, '@');
        $username = substr($email, 0, $pos ); 

        $to = $email;
	$subject = "Register in ComplaintsCounter";
	$welcome_email = "Thank you for registering with ComplaintsBlaster. Your account is now set up.\r\n\r\n"; 
         
        $welcome_email .= "For future reference your username is: ".$username." \r\n\r\n";
        
        if (!empty($agreementid))
            $welcome_email .= "Your paypal agreement is: $agreementid. \r\n\r\n";
        else
            $welcome_email .= "Your paypal payment is: $$paymentid. \r\n\r\n";
        
        $welcome_email .="As a member of ComplaintsCounter you will now be able to:\r\n\r\n";
	$welcome_email .="- Create and send out complaints quickly";
	$welcome_email .="- Read reviews of other companies\r\n";

	$welcome_email .="If you need to get in touch please email us at info@complaintscounter.co.uk. You can follow us on Facebook at @facebookdir and on Twitter at @twitteruser\r\n Kind Regards";
        $welcome_email .= "Zak\r\nCommunity Manager";
        
        $headers = EMAIL . "\r\n";

	$sent = mail($to,$subject, $welcome_email);      
        
    }    
 /** 
 * insert a new organisation
 * @param string  Company Name
 * @param string  Address 
 * @param integer Id of town
 * @param integer Id of country
 * @param integer Id of region
 * @param string  Phone number
 * @param string  Email 
 * @param string  Location 
 * @param string  Url website 
 * @param string  Postcode
 * @param string  contactname
 * @return integer  return last organisation id
 */
  public function InsertOrganisation($companyname, $address, $townid, $countryid, $regionid, $countyid, $phone, $email, $locality, $website, $postcode, $contactname, $industryid = 0){
      
        $companyname = addslashes($companyname);
        $address = addslashes($address);
        $contactname = addslashes($contactname);
        
        $query = "insert into organisations(CompanyName, Address, Address2, TownID, CountryID, RegionID, CountyID, TelephoneNumber,EmailAddresses, Locality, WebsiteAddress, Postcode, ContactFullName, industryid ) "
                . "values('$companyname','$address','','$townid','$countryid','$regionid','$countyid','$phone','$email','$locality','$website', '$postcode','$contactname', $industryid) ";
	$mysqli = new mysqli(HOST, USER, PASS, DB, PORT);
	$result = $mysqli->query($query);
        if ($result){
            $id = $mysqli->insert_id;
        } 
        
	return $id;
 }
 
  /** 
 * insert a new organisation by user in neworganisations table
 * @param string  Company Name
 * @param string  Address 
 * @param integer Id of town
 * @param integer Id of country
 * @param integer Id of region
 * @param string  Phone number
 * @param string  Email 
 * @param string  Url website 
 * @param string  Postcode
 * @return integer  return last organisation id
 */
  public function InsertNewOrganisation($companyname, $address, $townid, $countryid, $regionid, $countyid, $phone, $email, $website, $postcode, $industryid){
        $query = "insert into neworganisations(CompanyName, Address, TownID, CountryID, RegionID, CountyID, TelephoneNumber,EmailAddresses, WebsiteAddress, Postcode, date, ContactFullName, industryid ) "
                . "values('$companyname','$address','$townid','$countryid','$regionid','$countyid','$phone','$email','$website', '$postcode', current_timestamp(), '', $industryid ) ";
	$mysqli = new mysqli(HOST, USER, PASS, DB, PORT);
	$result = $mysqli->query($query);
        if ($result){
            $id = $mysqli->insert_id;
        } 
        
	return $id;
 }
 
/** 
 * check if a Company name  exist in table organisations
 * @param string Company Name to  check
 * @param integer id organisation 
 * @param string type = u check if company is register from user, type = o if Business is register in organisations table 
 * @return array 
 */	    
    public function CheckCompanyName($companyname, $organisationid = 0, $type = "o"){
        $companyname = addslashes($companyname);
        $success = false;
        
        if ($type == "u")
            $query ="SELECT COUNT(*) AS count FROM users a JOIN  organisations b ON a.businessid = b.organisationID WHERE b.CompanyName = '$companyname' or a.businessid = $organisationid";
        else
            $query ="SELECT COUNT(*) AS count FROM organisations b WHERE b.CompanyName = '$companyname' or b.organisationID = $organisationid";
        
        $result = phpmkr_query($query);
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) 
            $success = true;
        else
            $success = false;
        
        if ($success){ 
            if ($type == "o"){
                $query ="SELECT COUNT(*) AS count FROM neworganisations b WHERE b.CompanyName = '$companyname' or b.organisationID = $organisationid";

                $result = phpmkr_query($query);
                $row = $result->fetch_assoc();
                if ($row['count'] == 0) 
                    $success = true;
                else
                    $success = false;
                }
            }
            
        $row["success"] = $success;
        return $row;
    } 
    
    
/** 
 * update the fields of a organisations table
 * @param integer organisationid
 * @param string business name 
 * @param string address
 * @param integer city
 * @param integer country 
 * @param integer county 
 * @param string postale code
 * @param string contact name
 * @param string contact email
 * @param string phone
 * @param string Website
 * @return array 
 */  
    
    public function updateOrganisation($organisationid,  $businessname, $address, $city, $country, $county, $postalcode,  $contactname, $contactemail, $phone, $website, $industryid){
            $businessname = addslashes($businessname);
            $address = addslashes($address); 
            
            $query = "UPDATE organisations SET CompanyName = '$businessname', Address = '$address', Address2 = '', TownID = '$city', CountyID = '$county', CountryID = '$country', ";
            $query .= " Postcode = '$postalcode', WebsiteAddress = '$website', ContactFullName = '$contactname', EmailAddresses = '$contactemail', TelephoneNumber = '$phone', IndustryID = '$industryid' ";
            $query .= "WHERE organisationID = $organisationid";
        
         $result = phpmkr_query($query);
         if ($result){
            $row["success"] = true;
            return $row;
        }
     }
     
     
 /** 
 * Show the list of users
 * @param integer userid of users
 * @param lastid the lastid that was display on the screen
 * @return array
 */	
  public function ShowMoreUsers($lastid = 0 ){
    $where = "";
    $exist = false;
    $query  = " SELECT a.userid, a.email, a.username, a.status, a.businessid, a.name,  IF(a.businessid >0 ,'Business','User') AS usertype, ";
    $query .= " DATE_FORMAT(a.date, '%d-%m-%Y') as date, (select count(*) from complaints b where b.userid = a.userid ) as complaintscount ";
    $query .= " FROM users a Where a.status <> 'deleted' ";
 				
    if ($lastid > 0){
        $where .= "  and a.userid < $lastid " ;
    }
				
    $orderby  =  " ORDER BY a.userid DESC LIMIT 6";
    
    $query = $query.$where.$orderby;  
				
    $result = phpmkr_query($query);
    $users = "";
    if ($result){
        $i = 0;
        while ($row  = $result->fetch_assoc()){
                    
            $i++; 
            $exist = true;
            $id = $row['userid'];
            $status = $row['status'];
            $deletelink = "";
            if ($status != "deleted"){
                $deletelink = "<a id = 'deleteuser".$id."' class = 'actionlinks' a href=\"#\" onclick=\"deleteUser(".$id.");return false;\">Delete</a>";
            }
            
            $blocked = "Block";
            $blockparam = "'$id',1";
            if ($status == "blocked"){
                $blocked = "Unblock";
                $blockparam = "'$id',0";
            }
            $editparam = "'$id','u' ";
            if ($row["usertype"] == "Business")
                $editparam = "'$id','b' ";
            
            $blocklink = "<a id = 'blockuser".$id."' class = 'actionlinks' a href=\"#\" onclick=\"blockUser(".$blockparam.");return false;\">$blocked</a>";
            
            $editlink = "<a id = 'edituser".$id."' class = 'actionlinks' a href=\"#\" onclick=\"showEditUser(".$editparam.");return false;\">Edit</a>";

            
             $option ="                     
                <tr id = 'usersrow".$id."' class = 'trusers'>
                    <td>".$id."</td>
                    <td id = 'username$id'>".$row['username']."</td>
                    <td id = 'useremail$id'>".$row['email']."</td>
                    <td>".$row['usertype']."</td>
                    <td class = 'registered'style='text-align: center'>".$row['date']."</td>
                    <td class = 'ncomplaints' style='text-align: center'>".$row['complaintscount']."</td>
                    <td id = 'statususer$id'>".$row['status']."</td>
                    <td>".$editlink." ".$deletelink." ".$blocklink."</td>
                    <td id= 'imageajaxusers".$id."' ></td>
                </tr>";
                $users .= trim($option);
                $lastid = $id;
        }
    }
            
    $row['success'] = $exist;		
    $row['users'] = $users;
    $row['lastid'] = $lastid;
    $row['rows'] = $i;
		
    return $row;
  }
  
/** 
 * Show the list of users
 * @param integer userid of users
 * @param lastid the lastid that was display on the screen
 * @return array
 */	
  public function ShowMoreBusiness($lastid = 0 ){
    $where = "";
    $exist = false;
    $query  = "SELECT organisationID, CompanyName,Address,TownID,CountyID,Postcode,RegionID,CountryID,TelephoneNumber,WebsiteAddress,ContactFullName,EmailAddresses, DATE_FORMAT(date, '%d-%m-%Y') as date, "  ;
    $query .= " CASE trim(status)  WHEN '' THEN 'Awaiting Approval'  WHEN 'd' THEN 'Rejected'   END AS currentstatus, status  ";
    $query .=  "from neworganisations ";        
 				
    if ($lastid > 0){
        $where .= "  WHERE organisationID < $lastid " ;
    }
				
    $orderby  =  " ORDER BY organisationID DESC LIMIT 6";
    
    $query = $query.$where.$orderby;  
				
    $result = phpmkr_query($query);
    $business = "";
    if ($result){
        $i = 0;
        while ($row  = $result->fetch_assoc()){
                    
            $i++; 
            $exist = true;
            $id = $row['organisationID'];
            $status = $row['status'];
            
            $rejectlink = "";
            if ($status != "d"){
                $rejectlink = "<a id = 'rejectbusiness".$id."' class = 'actionlinks' a href=\"#\" onclick=\"rejectBusiness(".$id.");return false;\">Reject</a>";
            }
            $approvelink = "<a id = 'approvebusiness".$id."' class = 'actionlinks' a href=\"#\" onclick=\"approveBusiness(".$id.");return false;\">Approve</a>";
            
            $editlink = "<a id = 'editbusiness".$id."' class = 'actionlinks' a href=\"#\" onclick=\"showEditBusiness(".$id.");return false;\">Edit</a>";
            
            $deletelink = "<a id = 'deletebusiness".$id."' class = 'actionlinks' a href=\"#\" onclick=\"deleteBusiness(".$id.");return false;\">Delete</a>";

             $option ="                     
                <tr id = 'businessrow".$id."' class = 'trbusiness'>
                    <td>".$row['date']."</td>
                    <td>".$id."</td>
                    <td id = 'namebusiness$id'>".$row['CompanyName']."</td>
                    <td id = 'addressbusiness$id'>".$row['Address']."</td>
                    <td id = 'status$id'>".$row['currentstatus']."</td>
                    <td id = 'actionbusiness$id'>".$editlink." ".$rejectlink." ".$approvelink." ".$deletelink."</td>
                    <td id= 'imageajaxbusiness".$id."' ></td>
                        
                </tr>";
                $business .= trim($option);
                $lastid = $id;
        }
    }
            
    $row['success'] = $exist;		
    $row['business'] = $business;
    $row['lastid'] = $lastid;
    $row['rows'] = $i;
		
    return $row;
  }  
  
/** 
 * activate a business added by user
 * @param integer organisation id
 * @return array
 */	
  public function ApproveBusiness($organisationid){
    $success = false;
    $query  = " INSERT INTO organisations(CompanyName,Address, Address2,TownID,CountyID,Postcode,RegionID,CountryID,TelephoneNumber,WebsiteAddress,ContactFullName,EmailAddresses, Locality, IndustryID) ";
    $query .= " SELECT CompanyName,Address,'',TownID,CountyID,Postcode,RegionID,CountryID,TelephoneNumber,WebsiteAddress,ContactFullName,EmailAddresses, '', IndustryID FROM neworganisations WHERE organisationID = $organisationid ";   
    
    $mysqli = new mysqli(HOST, USER, PASS, DB, PORT);

    $result = $mysqli->query($query);
    if ($result){
        $id = $mysqli->insert_id;
    } 

         
    $oldid =  ( $organisationid * -1);        
    if ($result){
        $query = "UPDATE complaints SET organisationid = $id WHERE  organisationid = $oldid";
        $result = phpmkr_query($query); 
                
        $query = "delete from neworganisations where organisationID = $organisationid";
        $result = phpmkr_query($query);
        if ($result)
            $success = true;		
    }
            
    $row['success'] = $success;		
    return $row;
  }
  
  /** 
 * Reject a business added by users
 * @param integer organisation id
 * @return array
 */
  public function RejectBusiness($organisationid){
    $success = false;
    $query  = " UPDATE neworganisations SET status = 'd' where organisationID = $organisationid ";
    $result = phpmkr_query($query);
    if ($result){
        $success = true;		
    }
            
    $row['success'] = $success;		
    return $row;
  }
  
 /** 
 * Block a user in admin panel
 * @param integer user id
 * @param boolean block = 1(blocked), block = 0 (unblock) 
 * @return array
 */
 public function BlockUser($userid, $block = "1"){
    $success = false;
    $text = "Block";
    if ($block == "1")
        $status = "blocked";
    else
        $status = "active";    
        
    $query  = " UPDATE users SET status = '$status' where userid = $userid ";
    $result = phpmkr_query($query);
    
    
    if ($result){
        $success = true;		
        if($status == "active"){    
            $query  = " UPDATE users SET failed = 0 where userid = $userid ";
            $result = phpmkr_query($query);
        }
    }
    $row['success'] = $success;		
    return $row;
  }
  
  
  /** 
 * mark status as delete in users table
 * @param integer user id
 * @return array
 */
 public function DeleteUser($userid){
    $success = false;
        
    $query  = " UPDATE users SET status = 'deleted' where userid = $userid ";
    $result = phpmkr_query($query);
    if ($result){
        $query  = "SELECT businessid FROM users WHERE userid = $userid ";
        $result = phpmkr_query($query);
        if ($result){
            $row = $result->fetch_assoc();
            if ($row['businessid'] > 0 ){
                $organisationid = $row['businessid'];
                $query  = "UPDATE subscriptions SET  status = 'udeleted' WHERE organisationID = $organisationid ";
                $result = phpmkr_query($query);
            } 
        }    
        $success = true;		
    }
    $row['success'] = $success;		
    return $row;
  }
  
  
/** 
 * get all fields of neworganisation table by id 
 * @param integer if of subscription
 * @return array 
 */    
    public function GetNewOrganisation($id){
        $row = "";
        $query =" SELECT organisationID,CompanyName,Address, TownID, Postcode, RegionID, CountryID, CountyID, TelephoneNumber,ContactFullName, EmailAddresses, WebsiteAddress, IndustryID ";
        $query .= " FROM neworganisations ";
        $query .= " WHERE organisationID = $id ";
        
        $result = phpmkr_query($query);
        if ($result){ 
            $row = $result->fetch_assoc();
            $success = false;
            $row['success'] = true;
            return $row; 
         }    
         return $row['success'] = false;
    }       
    
/** 
 * get all fields of organisation table by id 
 * @param integer if of subscription
 * @return array 
 */    
    public function GetOrganisation($id){
        $row = "";
        $query =" SELECT organisationID,CompanyName,Address, TownID, Postcode, RegionID, CountryID, CountyID, TelephoneNumber,ContactFullName, EmailAddresses, WebsiteAddress, IndustryID ";
        $query .= " FROM organisations ";
        $query .= " WHERE organisationID = $id ";
        
        $result = phpmkr_query($query);
        if ($result){ 
            $row = $result->fetch_assoc();
            $success = false;
            $row['success'] = true;
            return $row; 
         }    
         return $row['success'] = false;
    }       
    
    
/** 
 * update the fields of a organisations table
 * @param integer organisationid
 * @param string business name 
 * @param string address
 * @param integer city
 * @param integer country 
 * @param integer county 
 * @param string postale code
 * @param string contact name
 * @param string contact email
 * @param string phone
 * @param string Website
 * @return array 
 */  
    public function updateNewOrganisation($organisationid,  $businessname, $address, $city, $country, $county, $postalcode,  $contactname, $contactemail, $phone, $website, $industryid ){
         $businessname = addslashes($businessname);
         $address = addslashes($address); 
        
         $query = "UPDATE neworganisations SET CompanyName = '$businessname', Address = '$address', TownID = '$city', CountyID = '$county', CountryID = '$country', ";
         $query .= " Postcode = '$postalcode', WebsiteAddress = '$website', ContactFullName = '$contactname', EmailAddresses = '$contactemail', TelephoneNumber = '$phone', IndustryID = '$industryid' ";
         $query .= "WHERE organisationID = $organisationid";
         
         $result = phpmkr_query($query);
         if ($result){
            $row["success"] = true;
            return $row;
        }
     }
     
     
  /** 
 * delete a new organisation (new organisation table) before approval 
 * @param integer organisationid
 * @return array
 */
 public function DeleteNewOrganisation($organisationid){
    $success = false;
        
    $query  = " delete from neworganisations where organisationID = $organisationid ";
    $result = phpmkr_query($query);
    if ($result){
        $success = true;		
    }
    $row['success'] = $success;		
    return $row;
  }
  
/** 
 * Show the list of registered organisation
 * @param lastid the lastid that was display on the screen
 * @return array
 */	
  public function ShowMoreOrganisations($lastid = 0 ){
    $where = "";
    $exist = false;
    $query  = "SELECT a.organisationID, a.CompanyName, a.Address,a.TownID,a.CountyID,a.Postcode,a.RegionID,a.CountryID,a.TelephoneNumber,a.WebsiteAddress,a.ContactFullName,a.EmailAddresses, b.Town, "  ;
    $query .=  "(select COUNT(*) from complaints as c where a.organisationID = c.organisationid) as complaintcount, ";        
    $query .=  "COALESCE((SELECT cardid FROM subscriptions d WHERE d.organisationID =  a.organisationID LIMIT 1  ),'') AS cardid, ";
    $query .=  "COALESCE((SELECT e.agreementid FROM subscriptions e WHERE e.organisationID =  a.organisationID LIMIT 1  ),'') AS agreementid ";
    $query .=  "from organisations as a LEFT JOIN organisationtowns as b on a.TownID = b.TownID ";        
 				
    if ($lastid > 0){
        $where .= "  WHERE organisationID < $lastid " ;
    }
				
    $orderby  =  " ORDER BY organisationID DESC LIMIT 6";
    
    $query = $query.$where.$orderby;  
				
    $result = phpmkr_query($query);
    $business = "";
    if ($result){
        $i = 0;
        while ($row  = $result->fetch_assoc()){
                    
            $i++; 
            $exist = true;            
            $id = $row['organisationID'];
            $idajax = $id;
            $cardid = $row['cardid'];
            $agreementid = $row['agreementid'];
            $address = $row['Address'];
            if (empty($address)){
                $address = "<p><br></p>";
            }
            
            $editlink = "<a id = 'editorganisation".$id."' class = 'actionlinks' a href=\"#\" onclick=\"showEditOrganisation(".$id.");return false;\">Edit</a>";
            
            $deletelink = "<a id = 'deleteorganisation".$id."' class = 'actionlinks' a href=\"#\" onclick=\"deleteOrganisation(".$id.");return false;\">Delete</a>";
            $exclamation = "";
            
            if (!empty($cardid)){
                $query = "SELECT e.status FROM subscriptions as d join subscriptionpayments as e on e.organisationID = d.organisationID WHERE d.organisationID =  $id ORDER BY e.subscriptionpaymentsid DESC LIMIT 1 ";
                $pay = phpmkr_query($query);
                
                if ($pay){
                    $paymenttype = 'c';
                    $pay  = $pay->fetch_assoc();
                    $paymentstatus = $pay['status'];
                            
                    if  ($paymentstatus != "approved"){
                        $exclamation  = "<div class='tooltipcp' style = 'padding-left:5px'><img src = 'img/exclamation.png'/><span class='tooltiptext'>recurring payment problem. Click here to see details</span> </div>";
                    }else
                        $payments = "<a id = 'paymentid$id' class = 'actionlinks' a href=\"#\" onclick=\"showPaymentDetails('".$id."','$paymenttype');return false;\"><span style='float:left'>Payment Details</span> $exclamation</a><span id='imageajaxiconpayment$id' style = 'float:right; margin-right: 20%'></span>";    
                }           
            }
            else if (!empty($agreementid)){
                    $paymenttype = 'p';
                    $payments = "<a id = 'paymentid$id' class = 'actionlinks' a href=\"#\" onclick=\"showPaymentDetails('".$agreementid."','$paymenttype');return false;\"><span style='float:left'>Payment Details</span> $exclamation</a><span id='imageajaxiconpayment$agreementid' style = 'float:right; margin-right: 20%'></span>";    
                    $idajax = $agreementid; 
           }
           if (empty($payments))
               $payments = "No Details";
           

             $option ="                     
                <tr id = 'organisationrow".$id."' class = 'trorganisations'>
                    <td>".$id."</td>
                    <td id = 'nameorganisation$id'>".$row['CompanyName']."</td>
                    <td id = 'addressorganisation$id'>".$address."</td>
                    <td id = 'townorganisation$id'>".$row['Town']."</td>
                    <td style = 'text-align:center' class= 'ncomplaints'>".$row['complaintcount']."</td>
                    <td id = 'paymentstatus$id'>".$payments."</td>
                    <td id = 'actionorganisation$id'>".$editlink." ".$deletelink."</td>
                    <td id= 'imageajaxorganisation".$id."' ></td>
                        
                </tr>";
                $business .= trim($option);
                $lastid = $id;
        } 
    } 
        
            
    $row['success'] = $exist;		
    $row['business'] = $business;
    $row['lastid'] = $lastid;
    $row['rows'] = $i;
		
    return $row;
  }  
  
 /** 
 * delete a organisation 
 * @param integer organisationid
 * @return array
 */
 public function DeleteOrganisation($organisationid){
    $success = false;
        
    $query  = " delete from organisations where organisationID = $organisationid ";
    $result = phpmkr_query($query);
    if ($result){
        $query  = " delete from complaints where organisationid = $organisationid ";
        $result = phpmkr_query($query);
        if ($result)
            $success = true;		
    }
    $row['success'] = $success;		
    return $row;
  }
 
    
}//end class