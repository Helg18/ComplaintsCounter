<?php
require_once '../db.php';
require_once  '../functions.php';
$action = "";


    if (isset($_GET['action'])){
        $action = $_GET['action'];

    } 
    
    switch ($action) {
    case 'broadcastcomplaint':
            GetUserSession();
            $id = $_GET['complaintsid'];
            $usertype = $_SESSION['usertype'];
            $broadcast = new broadcast();
            $result = $broadcast->BroadcastComplaint($id, "", $usertype);
            echo json_encode($result);
            break;
    case 'broadcastcomplaintuser':
            $id = $_GET['complaintsid'];
            $broadcast = new broadcast();
            $result = $broadcast->BroadcastComplaintUser($id);
            echo json_encode($result);
            break;

    default:
        break;
}

class broadcast{
    
/**
 * 
 * broadcast complaint with 24 hour or less of created
 */    
    function broadcast24(){
        date_default_timezone_set('UTC');
        $now = date("YYYY-MM-DDTHH:MM:SS");
        $limit = 500;
        $success = 0;
        $fail = 0;
        
         echo "<br>";
         echo "Starting Broadcast ";
         echo "<br>";

        
        $query = "SELECT DATE_FORMAT(a.broadcastdate, '%d-%m-%Y') as date, a.complaintsid, a.title, a.complaint, a.review, b.CompanyName ,b.EmailAddresses,  CONCAT(COALESCE(b. Address,''), ' ' ,COALESCE(b. Address2,'') ) as  address, c.name, c.email
                    FROM complaints AS a
                    JOIN organisations AS b 
                      ON a.organisationid = b.organisationID 
                    JOIN users c
                      ON a.userid = c.userid  
                   WHERE broadcastdate < CURRENT_TIMESTAMP
                     AND a.status = 'a'
                ORDER BY broadcastdate ASC
                    LIMIT $limit";

         $result = phpmkr_query($query);
         if ($result){
            $i = 0;
            while ($row  = $result->fetch_assoc()){
                $complaintid = $row['complaintsid'];
                $broadcast = $this->BroadcastComplaint($complaintid, $row);
                echo "<br>";
                $sent = $broadcast['sent'];
                if ($broadcast['success']){
                    echo "sending broadcast id $complaintid, success";
                    $success++;
                }else{
                    $fail++;
                    echo "error sending broadcast id $complaintid, error".$sent;
                }
            }                                         
         }  
         
         echo "<br>";
         echo "<br>";
         echo "End of Broadcasting ";
         echo "<br>";
         echo "<br>";
         echo "Broadcasted ". $success++;
         echo "<br>";
         echo "Failed ". $fail++;
    }

/**
 * 
 * broadcast a complaint by id and sent a email with the details of the complaint
 * @param integer complaintid
 * @param array complaint details, if array is empty get fill inside the method
 * @param string logintype
 * @param string usertype b = user business, usertype a = admin , usertype c = cron, usertype = u user
 * @return array 
 */    
function BroadcastComplaint($complaintid, $complaintdetail = array(), $usertype = ""){
    
        $sucess = false;
        date_default_timezone_set('UTC');
        $currentdate = date("d-m-Y");
        if (empty($complaintdetail)){
            
            $query = "SELECT DATE_FORMAT(a.date, '%d-%m-%Y') AS date, a.complaintsid, a.title, a.complaint, a.review, b.CompanyName ,b.EmailAddresses,  CONCAT(COALESCE(b. Address,''), ' ' ,COALESCE(b. Address2,'') ) AS  address, c.name, c.email
                                FROM complaints AS a
                                JOIN organisations AS b 
                                  ON a.organisationid = b.organisationID 
                                JOIN users c
                                  ON a.userid = c.userid  
                               WHERE  a.complaintsid = $complaintid";  
            $result = phpmkr_query($query);
            if ($result){
                $complaintdetail  = $result->fetch_assoc();
            }else{
                return $row['success'] = false;
            }
        }
        
        $businessname = $complaintdetail['CompanyName']; 
        $address = $complaintdetail['address']; 
        $companyemail = $complaintdetail['EmailAddresses']; 
        
        $date = $complaintdetail['date']; 
        $complainttile = $complaintdetail['title']; 
        $review = $complaintdetail['review']; 
        $complaint = $complaintdetail['complaint']; 
        
        $name = $complaintdetail['name']; 
        $email = $complaintdetail['email']; 
       
        $listurl = "";
        
	$to = BROADCASTEMAIL;
	$subject = "New complaint for $businessname";
        
	$welcome_email = "Business Name: $businessname.\r\n\r\n"; 
        $welcome_email .= "Address: $address.\r\n\r\n"; 
        $welcome_email .= "Company Email: $companyemail.\r\n\r\n"; 
        
        $welcome_email .= "Complainer: $name ,Complainer Email: $email.\r\n\r\n";
        
        $welcome_email .= "Date: $date - id: $complaintid \r\n\r\n"; 
        
        $welcome_email .= "Complaint: $complainttile.\r\n\r\n"; 

        $welcome_email .= "Review: $review.\r\n\r\n"; 
        
        $welcome_email .= "Description: $complaint.\r\n\r\n"; 
        
        $headers = EMAIL . "\r\n";

	$sent = mail($to,$subject, $welcome_email);
        
        if ($usertype == "a")
            $status = "b";
        else
            $status = "e";
            
        if ($sent){
            $query = "UPDATE complaints SET STATUS = '$status', broadcastdate = current_date WHERE complaintsid = $complaintid";
            $result = phpmkr_query($query);
            $sucess = $result; 
            $row['success'] = true;
            $row['broadcastdate'] = $currentdate;
            
        }else
        {
            $row['success'] = false; 
        }
            
        
        $row['sent'] = $sent;
        $row['broadcast'] = 'Broadcasted';

        return $row; 
    }
    
/**
 * 
 * broadcast a complaint by id and sent a email with the details of the complaint
 * @param integer complaintid
 * @param array complaint details, if array is empty get fill inside the method
 * @param string logintype
 * @return array 
 */    
function BroadcastComplaintUser($complaintid){
        $success = false;
        
        $query = "UPDATE complaints SET broadcastdays = 1,  status = 'a', broadcastdate = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 DAY) WHERE complaintsid = $complaintid ";
        $result = phpmkr_query($query);
        if ($result){
            $success = true; 
        
            date_default_timezone_set('UTC');        
            $date = date("d-m-Y");
            $date = date("d-m-Y",strtotime("$date +1 days"));
            $row['broadcast'] = 'Broadcasted';
        }
        $row['success'] = $success; 
        $row['broadcastdate'] = $date;

        return $row; 
}
    
    
}//end class