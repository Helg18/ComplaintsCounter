<?php

require_once 'db.php';
require_once 'functions.php';
 
if (isset($_GET['action'])){
		
		$action = $_GET['action'];
				
		if (!empty($_POST)){
                    $data = $_POST; 
	}
		GetUserSession();
				
		switch ($action) {
				case 'deletecomplaint':
					
								$complaints = new complaints();         
								$complaintid = $_GET['complaintsid'];   
								$result = $complaints->DeleteComplaint($complaintid);
						
								$result = json_encode($result);
						break;
				case 'showmorecomplaints':
								$complaints = new complaints();         
								$lastid = $_GET['lastid'];   
								$userid = $_GET['userid'];   
                                                                $usertype = "";
                                                                if (isset($usertype))
                                                                    $usertype = $_SESSION['usertype'];   

                                                                $organisationid = "0";
                                                                if (isset($_SESSION['organisationid']))
                                                                    $organisationid = $_SESSION['organisationid'];   
                                                                
                                    $result = $complaints->ShowMoreComplaints($userid, $lastid, $usertype, $organisationid);
                                    $result = json_encode($result);
				    break;
				case 'explorerreviews':
                                                                
				    $complaints = new complaints();
				    $orderby = $_GET['orderby'];
	                            $lastreview = "";
	                            $viewed = "";
	                            $lastrating="";
	                            $starpoint = "";
	                            if (isset($_GET['list']))
	                                $viewed = $_GET['list'];
	                            if (isset($_GET['starpoint']))
	                                $starpoint = $_GET['starpoint'];                                         
	                            
								if (isset($_GET['lastreview']) && !empty($_GET['lastreview'])) {
									$lastreview = $_GET['lastreview'];
								}
								elseif (isset($_GET['lastrating']) && !empty($_GET['lastrating'])) {
									$lastreview = $_GET['lastrating'];
								}
								$result = $complaints->ExplorerReviews($lastreview, $orderby, $viewed, $starpoint);
						break;
						
				case 'actioncomplaint':
								$complaints = new complaints();         
								$actioncomplaint = $_GET['actionmode'];   
								$complaintid = $_GET['complaintsid'];   
								$result = $complaints->UpdateActionComplaint($complaintid, $actioncomplaint);
								$result = json_encode($result);
						break;
				case 'showpreviewcomplaint':
								$complaints = new complaints();         
								$complaintid = $_GET['complaintsid'];   
                                                                $lastid = $_GET['lastid'];   
								$result = $complaints->ShowPreviewComplaint($complaintid, $lastid);
								$result = json_encode($result);
						break;
				case 'showmoreresponse':
								$complaints = new complaints();         
								$complaintid = $_GET['complaintsid'];   
                                $lastid = $_GET['lastid'];   
								$result = $complaints->GetResponseByComplaintid($complaintid, $lastid);
								$result = json_encode($result);
						break;
				case 'loadcomplaintsforbusiness':
								$complaints = new complaints();
								$organisationid = $_GET['id'];
								if (isset($_GET['lastcomplaintviewed']) && !empty($_GET['lastcomplaintviewed'])) {
									$lastcomplaintbusiness = $_GET['lastcomplaintviewed'];
								}
								else{
									$lastcomplaintbusiness = 0;
								}
								if (isset($_GET['key']) && !empty($_GET['key']) && ($_GET['key'] != '' )) {
									$key = $_GET['key'];
								}
								else
								{
									$key = 0;
								}
								$result = $complaints->loadcomplaintsforbusiness($organisationid, $lastcomplaintbusiness, $key);
								break;
				case 'loadcomplaintsforusers':
								$lastcomplaint='';
								if (isset($_GET['lastcomplaint']) && !empty($_GET['lastcomplaint'] && ($_GET['lastcomplaint'] != '' )) ) {
									$lastcomplaint = $_GET['lastcomplaint'];
								}
								if (isset($_GET['userid']) && !empty($_GET['userid']) && ($_GET['userid'] != '') ) {
									$userid = $_GET['userid'];
										if(!is_numeric($userid)) {
											$row['response'] = "Is not numeric";
											$row['status'] = "Error, userid is not numeric.";
											print json_encode($row);
											break;
										}           
									$complaints = new complaints();
								}
								else
								{
									$userid = 0;
								}
								$result = $complaints->loadcomplaintsforusers($userid, $lastcomplaint);
								$result = json_encode($result);
						break;
                                                
				case 'getcomplaint':
								$complaints = new complaints();         
								$complaintid = $_GET['complaintsid'];   
								$result = $complaints->GetComplaintById($complaintid);
								$result = json_encode($result);
						break;
				case 'insertresponse':
								$complaints = new complaints();         
								$result = $complaints->InsertResponse(
                                                                                                      $data['complaintid'],
                                                                                                      EMAIL,
                                                                                                      $data['emailcomplainer'],
                                                                                                      $data['txtMessageResponse'],
                                                                                                      $data['txtFile'],
                                                                                                      $data['titlecomplaint']
                                                                                                      );
								$result = json_encode($result);
						break;
				case 'uploadfile':
								$complaints = new complaints();         
								$result = $complaints->uploadFileResponse();
								$result = json_encode($result);
						break;
				case 'deleteuploadfile':
                                                                $filename = $_GET['filename']; 
								$complaints = new complaints();         
								$result = $complaints->DeleteUploadFile($filename);
								$result = json_encode($result);
						break;
				case 'showsendletter':
								$complaints = new complaints();         
								$complaintid = $_GET['complaintsid'];   
								$result = $complaints->ShowSendLetter($complaintid);
								$result = json_encode($result);
                                                break;                    
				case 'sendletter':
								$complaints = new complaints();         
								$result = $complaints->SendLetter($data['txtEmailBusiness'], $data['txtSubjectLetter'], $data['txtMessageLetter'] );
								$result = json_encode($result);
                                                break;                
                                            
		}

echo $result;    

}

class complaints{

/**
 * Load Complaints for esepcific users
 * Show the complaints registered of especific user.
 * @param interger userid
 * @return array
 */

	public function loadcomplaintsforusers($userid = 0, $lastcomplaint = 0){
		if ($userid == 0) {
			$response = "userid is empty";
			$row['status'] = "warning";
			$row['response'] = $response;
			$row['userid'] = $userid;
		}
		else
		{
			$block ="";
			$full="";

			$sSql ="SELECT 
                                c.complaintsid, c.complaint, c.review, c.title, DATE_FORMAT(c.date, '%d-%m-%Y') as date, u.userid, 
                                u.username, o.CompanyName, o.WebsiteAddress, o.organisationID
                                FROM complaints as c
                                left join users as u on u.userid = c.userid
                                left join organisations as o on o.organisationID = c.organisationid
                                where c.userid = ".$userid." AND u.status ='active' ";
if ($lastcomplaint != 0) {
	$sSql.= " and c.complaintsid < ".$lastcomplaint;
}

$orderby = " order by complaintsid desc LIMIT 8;";
$sSql.= $orderby;


		$result = phpmkr_query($sSql);
		$numrows = phpmkr_num_rows($result);
		$withoutcomplaints = $numrows;
		
		while ($rs = $result->fetch_assoc()) {
			$row['username']          = $rs['username']; 
			$row['complaint']         = $rs['complaint']; 
			$row['CompanyName']       = $rs['CompanyName']; 
			$row['complaintsid']      = $rs['complaintsid']; 
			$row['review']            = $rs['review']; 
			$row['title']             = $rs['title']; 
			$row['dateformat']        = $rs['date']; 
			$row['WebsiteAddress']    = $rs['WebsiteAddress']; 
			$row['organisationid']    = $rs['organisationID'];
			$row['userid']            = $rs['userid'];
			$row['withoutcomplaints'] = $withoutcomplaints;
			$row['shortcomplaint']    = trim_text($row['complaint'], 110, true, true);
			$star1checked ="";
			$dirshowuser="explore.php?".$row['username']."&userid=".$row['userid'];
			for ($z=1; $z <= 5; $z++){
      		$checked = "";
		      if ($z == $row['review'])
		          $checked = "checked";

			      $star1checked .= " 
						<input type='radio'  class='star-$z' id='complaints-".$row['complaintsid']."' disabled='disabled' $checked  name='complaints-".$row['complaintsid']."''/>
						<label class='star-$z' for='complaints-".$row['complaintsid']."'>1</label>";
      	}


			$favicon = @file_get_contents("http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']);
		    $favicon = base64_encode($favicon);
		    $hash_favicon=hash('md5', $favicon);


		   if ( $hash_favicon == '99fd8ddc4311471625e5756986002b6b' || $hash_favicon == 'd41d8cd98f00b204e9800998ecf8427e' ) {
			$showlogo="";
			 }
		    else {
			 $showlogo="
			           <div class='user-info'>
			             <div class='user-review-picture'><a><img class='user-picture' src='http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']."' width='55px' height='auto'></a></div>
			           </div>";
		    }

		    $CompanyNamelink = '';
		    $CompanyNamelink = str_replace(' ', '', $row['CompanyName']);

			$row['vieworderby'] = 'lastcomplaints';

						$gotowebsite="";
			         	$ValidateWebsiteAddress = $row['WebsiteAddress'];
						if ($row['WebsiteAddress'] != '') {
							$Websitebusiness = $row['WebsiteAddress'];
							$findhttp   = 'http';
							$pos = strpos($Websitebusiness, $findhttp);
								$gotowebsite =" <a href='http://".$row['WebsiteAddress']."' target='_blank'>".$row['CompanyName']."</a>";
								$ValidateWebsiteAddress = "http://".$row['WebsiteAddress'];

							if ($pos === 0 && !filter_var($ValidateWebsiteAddress, FILTER_VALIDATE_URL) === false) {
								$gotowebsite =" <a href='".$row['WebsiteAddress']."' target='_blank'>".$row['CompanyName']."</a>";
								$ValidateWebsiteAddress = $row['WebsiteAddress'];
							}
						}
						if ($row['WebsiteAddress'] == '') {
							$comilla = '"';
							$gotowebsite =" <a href='#' onclick='alert(".$comilla."The company not has website registered.".$comilla."); return false;'>".$row['CompanyName']."</a>";
						}
			/**
			 * Recents Complaints of a especific user
			 */
				$block ="
				<div class='well-reviews'>
				  ".$showlogo."
				        <div class='review-info'>
				          <form id='ratingsForm' class='clearfix stars-rating'>
							<div class='stars-small-reviews' style='margin-top:15%;' >
			              	".$star1checked."
			              	<span></span>
			            	</div> <!--end stars-small-reviews -->
				      	  </form>
				      <div class='text-nomal-reviews-shortcomplaints'>				      
				      <p><label class='text-bold-reviews-shortcomplaints'><a href=".$dirshowuser." alt='See more complaints of this user'>".$row['username']."</a></label> complained about <label class='text-bold-reviews-shortcomplaints'><a href='explore.php?CompanyName=".$CompanyNamelink."&businessID=".$row['organisationid']."&key=yes' alt='See more complaints of this business'>".$row['CompanyName']."</a></label> on ".$row['dateformat']."</div></p>
				      <div class='complaint'>
				        <p id='title'>".$row['title']."</p>
				        <p id='Complaintsfull' class='cut.short-complaints'>".$row['shortcomplaint']."
                                           <a href='#' class='complaint link-clean' onclick='previewComplaint(".$row['complaintsid']."); return false;'>more</a></p>
				      </div><p align='right'>
				      </p>

				    </div> <!--end review-info-->
				  </div> <!--end review-->
				";				
		$full.=$block;
		}

			$row['numrows'] = $numrows;
			$row['block'] = $full;

		}

		return $row;
	}

/**
 * End method loadcomplaintsforusers
 */




 
/**
* 
* Load Complaints for Business Especific
* Show the average of reviews of complaint by business 
* @param integer organisarionid
* @return array

*/
	public function loadcomplaintsforbusiness($organisationid = 0, $lastcomplaintbusiness = 0, $key = 0){
		$reviews="";
		$star1checked="";
		$full="";
		$sSql="SELECT review as average, username, complaint, CompanyName, complaintsid, review, title, 
		DATE_FORMAT(c.date, '%d-%m-%Y') as date, WebsiteAddress, c.organisationID, u.userid 
FROM complaints as c
left join users as u on u.userid = c.userid
left join organisations as o on o.organisationID = c.organisationid
where o.organisationid = ".$organisationid." AND u.status = 'active' ";

if ($lastcomplaintbusiness != 0) {
$where  = " and complaintsid < ".$lastcomplaintbusiness;
	$sSql.= $where;
}

$orderby = " order by complaintsid desc LIMIT 8;";
$sSql.= $orderby;


		$result = phpmkr_query($sSql);
		$numrows = phpmkr_num_rows($result);
		$withoutcomplaints = $numrows;
		
		while ($rs = $result->fetch_assoc()) {
			$row['username']          = $rs['username']; 
			$row['complaint']         = $rs['complaint']; 
			$row['CompanyName']       = $rs['CompanyName']; 
			$row['complaintsid']      = $rs['complaintsid']; 
			$row['review']            = $rs['review']; 
			$row['title']             = $rs['title']; 
			$row['dateformat']        = $rs['date']; 
			$row['WebsiteAddress']    = $rs['WebsiteAddress']; 
			$row['organisationid']    = $rs['organisationID'];
			$row['withoutcomplaints'] = $withoutcomplaints;
			$row['shortcomplaint']    = trim_text($row['complaint'], 110, true, true);
			$row['userid']            = $rs['userid'];

                        for ($z=1; $z <= 5; $z++   ){
                                $checked = "";
                                      if ($z == $row['review'])
                                          $checked = "checked";

                                              $star1checked .= " 
                                                                <input type='radio'  class='star-$z' id='complaints-".$row['complaintsid']."' disabled='disabled' $checked  name='complaints-".$row['complaintsid']."''/>
                                                                <label class='star-$z' for='complaints-".$row['complaintsid']."'>1</label>";
                        }   


			$favicon = @file_get_contents("http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']);
		    $favicon = base64_encode($favicon);
		    $hash_favicon=hash('md5', $favicon);


		   if ( $hash_favicon == '99fd8ddc4311471625e5756986002b6b' || $hash_favicon == 'd41d8cd98f00b204e9800998ecf8427e' ) {
			$showlogo="";
			 }
		    else {
			 $showlogo="
			           <div class='user-info'>
			             <div class='user-review-picture'><a><img class='user-picture' src='http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']."' width='55px' height='auto'></a></div>
			           </div>";
		    }

		    $CompanyNamelink='';
		    $CompanyNamelink = str_replace(' ', '', $row['CompanyName']);


			$row['vieworderby'] = 'lastcomplaints';
			$dirshowuser="explore.php?username=".$row['username']."&userid=".$row['userid'];
				$block ="
							<div class='well-reviews'>
				  ".$showlogo."
				        <div class='review-info'>
				          <form id='ratingsForm' class='clearfix stars-rating'>
				              <div class='stars-small-reviews'>
				        ".$star1checked."
				          <span></span>
				      </div> <!--end stars-small-reviews -->
				      </form>
				      <div class='text-nomal-reviews-shortcomplaints'>
				      <p><label class='text-bold-reviews-shortcomplaints'><a href=".$dirshowuser.">".$row['username']."</a></label> complained about <label class='text-bold-reviews-shortcomplaints'><a href='explore.php?CompanyName=".$CompanyNamelink."&businessID=".$row['organisationid']."&key=yes'>".$row['CompanyName']."</a></label> on ".$row['dateformat']."</div></p>				      <div class='complaint'>
				        <p id='title'>".$row['title']."</p>
				        <p id='Complaintsfull' class='cut.short-complaints'>".$row['shortcomplaint']."
				           <a href='#' class='complaint link-clean' onclick='previewComplaint(".$row['complaintsid']."); return false;'>more</a></p>
				      </div><p align='right'>
				      </p>

				    </div> <!--end review-info-->
				  </div> <!--end review-->
				";				
		$full.=$block;
		}
		$without = "";
		if ($key == 'yes' && $withoutcomplaints == 0) {
			$sSql = "SELECT CompanyName, WebsiteAddress FROM organisations where organisationid =".$organisationid;
			$result= phpmkr_query($sSql);
				while($row_rs = $result->fetch_assoc()){
					$favicon = @file_get_contents("http://www.google.com/s2/favicons?domain=".$row_rs['WebsiteAddress']);
			    $favicon = base64_encode($favicon);
			    $hash_favicon=hash('md5', $favicon);
		   		if ( $hash_favicon == '99fd8ddc4311471625e5756986002b6b' || $hash_favicon == 'd41d8cd98f00b204e9800998ecf8427e' ) {
						$showlogo="";
			 		} else {
			 			$showlogo="
			           <div class='user-info'>
			             <div class='user-review-picture'><a><img class='user-picture' src='http://www.google.com/s2/favicons?domain=".$row_rs['WebsiteAddress']."' width='55px' height='auto'></a></div>
			           </div>";
			         }
					$gotowebsite="";
			         	$ValidateWebsiteAddress = $row_rs['WebsiteAddress'];
						if ($row_rs['WebsiteAddress'] != '') {
							$Websitebusiness = $row_rs['WebsiteAddress'];
							$findhttp   = 'http';
							$pos = strpos($Websitebusiness, $findhttp);
								$gotowebsite =" <a href='http://".$row_rs['WebsiteAddress']."' class='linkclean' target='_blank'>".$row_rs['CompanyName']."</a>";
								$ValidateWebsiteAddress = "http://".$row_rs['WebsiteAddress'];

							if ($pos === 0 && !filter_var($ValidateWebsiteAddress, FILTER_VALIDATE_URL) === false) {
								$gotowebsite =" <a href='".$row_rs['WebsiteAddress']."' class='linkclean' target='_blank'>".$row_rs['CompanyName']."</a>";
								$ValidateWebsiteAddress = $row_rs['WebsiteAddress'];
							}
						}
						if ($row_rs['WebsiteAddress'] == '') {
							$comilla = '"';
							$gotowebsite =" <a href='#' class='linkclean' onclick='alert(".$comilla."The company not has website registered.".$comilla."); return false;'>".$row_rs['CompanyName']."</a>";
						}
/**
 * No complaints registered.
 */						
					$without ="
	<div align='center' style='width:100%; text-align:center; float:left;'>
		<div class='well-small-no-complaint'>
			".$showlogo."
			<div align='center'>
        		<div>
		          <div align='center' class='show-details-full-complaints'>
		            <p class='name-business-review-avg' style='text-align:center; float: left; width:100%' id='BusinessComplainer'> ".$gotowebsite."</p>
		          </div>
        		</div> <!--end review-info-->
          		<p align='center' style='font-size:14px; float: left; width:100%'>No registered complaints. </p>
  			</div> <!--end review-->
		</div>
	</div>";
				}

		}
			$row['block'] = $full;
			$row['without'] = $without;
			$row['numrows'] = $numrows;
			$row['withoutflag'] = 'no';
		
		print json_encode($row);		

	}
	/**
	 * End load Complaints for business especific.
	 */

 /** 
 * 
 * Show the average of reviews of complaint by business 
 * @param integer lastid of review
 * @param integer order by ( 0 = recent , 1 = average )  
 * @param integer viewed   
 * @param integer starpoint   
 * @return array
 */
	public function ExplorerReviews($lastreview = 0, $orderby = 0, $viewed = 0, $starpoint = 0)
		{	
			$totalcomplaints = "";
			$viewcomplaints ="";
			if ($viewed != 0) {
				$lists = $viewed;
			} else {
				$lists = "";
			}
		    $reviews = "";
		    if ($orderby == 0) {
				$sSql="SELECT   c.review as average , username, complaint, CompanyName, complaintsid, review, title, DATE_FORMAT(c.date, '%d-%m-%Y') as date, WebsiteAddress, organisations.organisationID, c.userid
						FROM complaints as c
						left join users on users.userid = c.userid
						left join organisations on organisations.organisationID = c.organisationid 
						WHERE c.organisationid > 0 AND users.status ='active' 
                                                 ";
                                
				if ($lastreview > 0 && $orderby == 0){
						$where = "  AND complaintsid < $lastreview " ;
						$sSql.= $where; 
				}

				$orderby=" ORDER BY complaintsid DESC LIMIT 8";
				$sSql.=$orderby;
				
		    } else if ($orderby == 1) {
		    	if ($viewed == 0) {
		    	$sSql="SELECT 
avg(c.review) as average ,  COUNT(*) as totalcomplaints,
o.organisationID, o.CompanyName, o.WebsiteAddress, 
u.username, c.complaint, c.complaintsid, c.review, u.userid,
c.title, c.date, o.Address AS Address, o.Address2 AS Address2
FROM complaints AS c 
JOIN 
( 	SELECT cc.organisationid AS organisationid , AVG(cc.review) AS average 
	FROM complaints AS cc
	GROUP BY cc.organisationid) AS t ON c.organisationid = t.organisationid 
JOIN organisations o ON o.organisationID = c.organisationid
JOIN users u on u.userid = c.userid  
where u.status = 'active' 
GROUP BY o.CompanyName
ORDER BY totalcomplaints  DESC
LIMIT 8
						";
		    	}
		    	else
		    	{ 
		    		$ready = substr ($lists, 0, strlen($lists) - 1);
		    		$ready = str_replace('-', ", ", $ready);
		    		$sSql="SELECT 
AVG(c.review) as average, o.organisationID, o.CompanyName, o.WebsiteAddress,  COUNT(*) as totalcomplaints,
o.Address AS Address, o.Address2 AS Address2, u.username, c.complaintsid, 
c.complaint, DATE_FORMAT(c.date, '%d-%m-%Y') as date, c.title, c.review,
u.userid
FROM complaints AS c 
JOIN 
(SELECT cc.organisationid AS organisationid , AVG(cc.review) AS average 
FROM complaints AS cc
GROUP BY cc.organisationid) AS t
ON c.organisationid = t.organisationid 
JOIN organisations as o ON o.`organisationID` = c.`organisationid`
JOIN users as u on u.userid = c.userid
WHERE c.organisationid NOT IN (".$ready.") and u.status ='active'
GROUP BY o.`CompanyName`
ORDER BY totalcomplaints DESC

LIMIT 8";
                        $lists = $viewed;
		    	}//end if exist viewed
		    }//end order by
                    
			$result = phpmkr_query($sSql);
				$numrows = phpmkr_num_rows($result);
				while($row_rs = $result->fetch_assoc()){
				$row['username']        = $row_rs['username'];
				$row['userid']          = $row_rs['userid'];
				$row['complaint']       = $row_rs['complaint'];
				$row['CompanyName']     = $row_rs['CompanyName'];
				$row['complaintsid']    = $row_rs['complaintsid'];
				$row['review']          = $row_rs['review'];
				$row['title']           = $row_rs['title'];
				$row['dateformat']      = $row_rs['date'];
				$row['WebsiteAddress']  = $row_rs['WebsiteAddress'];
				$row['shortcomplaint']  = trim_text($row['complaint'], 110, true, true);
				$row['organisationid']  = $row_rs['organisationID'];
				$row['average']         = floor($row_rs['average']);
				$list                   = $row_rs['organisationID'];
				$lists                  .=$list."-";
				$row['lastreview']      = $row_rs['complaintsid'];
				$star1checked           = "";

        

        for ($z=1; $z <= 5; $z++   ){

            $checked = "";
            if ($z == $row['average'])




                $checked = "checked";
            
            $star1checked .= " 
						<input type='radio'  class='star-$z' id='complaints-".$row['complaintsid']."' disabled='disabled' $checked  name='complaints-".$row['complaintsid']."''/>
						<label class='star-$z' for='complaints-".$row['complaintsid']."'>1</label>";

                                		}
                                

				 $favicon = @file_get_contents("http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']);
				    $favicon = base64_encode($favicon);
				    $hash_favicon=hash('md5', $favicon);


				   if ( $hash_favicon == '99fd8ddc4311471625e5756986002b6b' || $hash_favicon == 'd41d8cd98f00b204e9800998ecf8427e' ) {
					$showlogo="";
					 }
				    else {
					 $showlogo="
					           <div class='user-info'>
					             <div class='user-review-picture'><a><img class='user-picture' src='http://www.google.com/s2/favicons?domain=".$row['WebsiteAddress']."' width='55px' height='auto'></a></div>
					           </div>";
				    }
 
				if ($orderby == 0) {
					$CompanyNamelink = "";
					$CompanyNamelink = str_replace(' ', '', $row['CompanyName']);
					$row['vieworderby'] = 'lastcomplaints';
					$dirshowuser="explore.php?user=".$row['username']."&userid=".$row['userid'];
				$block ="
                                    <div class='well-reviews' >
				  ".$showlogo."
				        <div class='review-info'>
				          <form id='ratingsForm' class='clearfix stars-rating'>
				              <div class='stars-small-reviews'>
				        ".$star1checked."
				          <span></span>
				      </div> <!--end stars-small-reviews -->
				      </form>
				      <div class='text-nomal-reviews-shortcomplaints'>
				      <p><label class='text-bold-reviews-shortcomplaints'><a href=".$dirshowuser.">".$row['username']."</a></label> complained about <label class='text-bold-reviews-shortcomplaints'><a href='explore.php?CompanyName=".$CompanyNamelink."&businessID=".$row['organisationid']."&key=yes'>".$row['CompanyName']."</a></label> on ".$row['dateformat']."</div></p>
				      <div class='complaint'>
				        <p id='title'>".$row['title']."</p>
				        <p id='Complaintsfull'>".$row['shortcomplaint']."
				           <a href=\"#\" class='link-clean' onclick='previewComplaint(".$row['complaintsid']."); return false;'>&nbsp;more</a></p>
                                               
				      </div>
				    </div> <!--end review-info-->
				  </div> <!--end review-->

						
	";				
            		$reviews .=$block;
				$row['vieworderby'] = 1;
				$row['numrows'] = $numrows;
				 } 
				 else if ($orderby == 1){
				 	
						$row['average']  = $row_rs['average'];
						$row['Address']  = $row_rs['Address'];
						$row['Address2'] = $row_rs['Address2'];
						$viewcomplaints = "explore.php?businessID=".$row['organisationid']."&key=yes";
						$row['totalcomplaints'] = $row_rs['totalcomplaints'];

						$gotowebsite="";
			         	$ValidateWebsiteAddress = $row['WebsiteAddress'];
						if ($row['WebsiteAddress'] != '') {
							$Websitebusiness = $row['WebsiteAddress'];
							$findhttp   = 'http';
							$pos = strpos($Websitebusiness, $findhttp);
								$gotowebsite =" <a href='http://".$row['WebsiteAddress']."' target='_blank'>".$row['CompanyName']."</a>";
								$ValidateWebsiteAddress = "http://".$row['WebsiteAddress'];

							if ($pos === 0 && !filter_var($ValidateWebsiteAddress, FILTER_VALIDATE_URL) === false) {
								$gotowebsite =" <a href='".$row['WebsiteAddress']."' target='_blank'>".$row['CompanyName']."</a>";
								$ValidateWebsiteAddress = $row['WebsiteAddress'];
							}
						}
						if ($row['WebsiteAddress'] == '') {
							$comilla = '"';
							$gotowebsite =" <a href='#' onclick='alert(".$comilla."The company not has website registered.".$comilla."); return false;'>".$row['CompanyName']."</a>";
						}
			/**
			 * Worst Business
			 */
			$block ="
				<div class='well-sm-reviews'>
				".$showlogo."
	        <div class='review-info' style='margin-top:-5px;'>
	          <div align='center' class='show-details-full-complaints'>
	            <p class='name-business-review-avg' style='margin-top:-25px; text-align:center; margin-top:-6%;' id='BusinessComplainer'>".$gotowebsite."</p>
	          <a href='".$viewcomplaints."'>".$row['totalcomplaints']." Complaints</a></p>
	          <form id='ratingsForm' class='clearfix stars-rating'>
	            <div class='stars-small-reviews' style='margin-top:-7%;'>
	              ".$star1checked."
	              <span></span>
	            </div> <!--end stars-small-reviews -->
	          </form>
	          <p align='center' style='font-size:14px; font-weight: normal; margin-top:3%;'>".$row['Address']." ".$row['Address2']."</p>
	          <p align='center' style='font-size:14px; font-weight: normal; margin-bottom:auto; margin-top:-2%;'>
	          </div>
	        </div> <!--end review-info-->
      </div> <!--end review-->
      
                              ";
                                $reviews .=$block;
				$row['vieworderby'] = 0;
				 }
                                $starpoint = $row['average'];

			}//end while
						$row['starpoint'] = $starpoint;
						$row['list']      = $lists;
						$row['block']     = $reviews;
						$row['numrows']   = $numrows;
			print json_encode($row);
		}
/**
 * End function Explorer reviews
 */ 

                
/** 
 * 
 * delete a complaint by id
 * @param integer id of complaint to delete from database
 * @return boolean 
 */	
    public function DeleteComplaint($complaintid){
	$query = "DELETE FROM complaints where complaintsid = $complaintid";
	$result = phpmkr_query($query);
	if ($result)
            $row['success'] = true; 
	else
            $row['success'] = false; 
			
	return $row;			
   }
 
 /** 
 * 
 * Set field action of table complaint pause or r resume, 
 * @param integer id of complaint to delete from database
 * @param action action of complaint  p=pause, r= resume, 
 * @return array
 */	
  public function UpdateActionComplaint($complaintid = 0, $action = ""){
        if (empty($action))
            $action = "p";
						
	$query = "update complaints set status = '$action' where complaintsid = $complaintid";
        $result = phpmkr_query($query);
	$actionmode = "";
	switch ($action) {
            case "p":
                $actionmode = "Resume"; 
		$action = "a";
                $status = "Paused";
		break;
            case "a":
                $actionmode = "Pause"; 
		$action = "p";
                $status = "Awaiting broadcast";
		break;

            default:
                $actionmode = "Pause"; 
		$action = "p";
                $status = "Awaiting broadcast";
		break;
        }
        
        if ($result)
            $row['success'] = true; 
        else
            $row['success'] = false; 
				
            $row['status'] = $status;
            $row['actionmode'] = $actionmode;
            $row['action'] = $action;
			
        return $row;			
  }
  
  
 /** 
 * Show the list of complaints created by user order by lastid 
 * @param integer userid of users
 * @param lastid the lastid that was display on the screen
 * @return array
 */	
  public function ShowMoreComplaints($userid = 0, $lastid = 0, $usertype = "", $organisationid = 0){
    $where = "";
    $exist = false;
    $query  = "SELECT a.complaintsid, DATE_FORMAT(a.date, '%d-%m-%Y') as date, a.broadcastdays, u.email,   ";
    $query .= " DATE_FORMAT(a.broadcastdate,'%d-%m-%Y') AS broadcastdate, a.title, b.CompanyName, ";
    $query .= " CASE a.status  WHEN 'a' THEN 'Awaiting broadcast'  WHEN 'b' THEN 'Broadcasted' ";
    $query .= " WHEN 'e' THEN 'Emailed'  WHEN 's' THEN 'Suspended' WHEN 'p' THEN 'Paused'  END AS status, ";
    $query .= " a.status as broadcast, coalesce((SELECT correspondenceid FROM correspondence c WHERE c.complaintsid = a.complaintsid LIMIT 1),0) AS correspondenceid  ";
    $query .= " FROM complaints as a join organisations as b on a.organisationid = b.organisationID join users as u  on u.userid = a.userid ";
    
    if ($usertype != "a")
        $where .= " WHERE a.userid = $userid ";

    if ($organisationid > 0 )
        $where = " WHERE a.organisationid =". $organisationid;
    

				
    if ($lastid > 0){
        $where .= "  and a.complaintsid < $lastid " ;
    }
				
    $orderby  =  " ORDER BY a.complaintsid DESC LIMIT 6";
    
    $query = $query.$where.$orderby;  
				
    $result = phpmkr_query($query);
    $complaints = "";
    if ($result){
        $i = 0;
        while ($row  = $result->fetch_assoc()){
            $correspondenceid = $row['correspondenceid'];
            if ($correspondenceid > 0)
                $response = "Yes";
            else
                $response = "No";
                    
            $i++; 
            $exist = true;
            $id = $row['complaintsid'];
            $actionlink = $row['broadcast'];
            switch ($actionlink) {
                case 'p':
                    $action = "Resume";
                    $actionlink = "a";
                    break;
                case 'r':
                    $action = "Pause";
                    $actionlink = "p";
                    break;
                default:
                    $action = "Pause";
                    $actionlink ="p"; 
                    break;
             }

             $param = "'".$id."','".$actionlink."'";
             $broadcastlink = "";
             $onclick = "";
             $pauselink = "";
             $broadcasttext = "";

                     
             if ($row['broadcast'] != "b" && $row['broadcast'] != "e" ){
                 if ($row['broadcastdays'] > 1){
                     $onclick = "broadcastComplaintUser(".$id.");";
                     $broadcasttext = "Broadcast"; 
                     $href = "href=\"#\"";
                     $pauselink = "<a id = 'actionlink".$id."' class = 'actionlinks' a href=\"#\" onclick=\"actionComplaint(".$param.");return false;\"><span id = 'action".$id."'>".$action."</a>";
                     
                 }else
                 {
                    $pauselink = "";
                    $href = "";
                    $onclick = "";
                    $broadcasttext = ""; 
                     
                 }
                if ($_SESSION['usertype'] == "a"){
                    if ($row['broadcast'] == "a"){
                        $onclick = "broadcastComplaint(".$id.");";
                        $broadcasttext = "Broadcast"; 
                        $href = "href=\"#\"";
                        
                     }
                } 
                $pauselink = "<a id = 'actionlink".$id."' class = 'actionlinks' a href=\"#\" onclick=\"actionComplaint(".$param.");return false;\"><span id = 'action".$id."'>".$action."</a>";                    
                 
                $broadcastlink = "<a id = 'broadcast".$id."'class = 'actionlinks' $href onclick= '$onclick return false;'>".$broadcasttext."</a>";    
                if ($organisationid > 0){
                    $onclick = "showResponse(".$id.");";
                    $broadcasttext = "Response"; 
                    $broadcastlink = "<a id = 'response".$id."'class = 'actionlinks' href = '#' onclick= '$onclick return false;'>".$broadcasttext."</a>";    
                }    
                
             }
             
             $linkemail = "<a id = 'sendemail".$id."'class = 'actionlinks' href = '#' onclick= 'showEmailLetter($id); return false;'>Letter</a>"; 

             $option ="                     
                <tr id = 'complaintrow".$id."' class = 'trcomplaint'>
                    <td>". $row['date']."</td>
                    <td>". $row['CompanyName']."</td>
                    <td>". $row['complaintsid']."</td>
                    <td>". $row['title']."</td>
                    <td>". $row['email']."</td>
                    <td id = 'status$id'>". $row['status']."</td>
                    <td class = 'broadcastdate' style='text-align: center' id = 'broadcastdate".$id."'>". $row['broadcastdate']."</td>
                    <td id = 'responded$id' class = 'businessresponded' style='text-align: center'>$response</td>
                    <td  ><a class = 'actionlinks' href=\"#\" onclick='deleteComplaint(".$row['complaintsid']."); return false;'>Delete</a>  $pauselink
                    <a class = 'actionlinks' href=\"#\" onclick='previewComplaint(".$row['complaintsid']."); return false;'>Preview</a>
                    ".$broadcastlink."   
                    ".$linkemail."   
                    </td>
                    <td id= 'imageajax".$id."' ></td>
                </tr>\n";
                $complaints .= trim($option);
                $lastid = $row['complaintsid'];
        }
    }
            
    $row['success'] = $exist;		
    $row['complaints'] = $complaints;
    $row['lastid'] = $lastid;
    $row['rows'] = $i;
		
    return $row;
  }
  
 /** 
 * 
 * Show the details from a complaint that appears en list of complaints 
 * @param integer complaintid
 * @return array
 */		
 public function ShowPreviewComplaint($complaintid = 0){
    $where = "";
    $exist = false;
    $query  = "SELECT  a.complaintsid, DATE_FORMAT(a.date, '%d-%m-%Y') as date, a.review as review,  "
                       . " DATE_FORMAT(a.broadcastdate,'%d-%m-%Y')  AS broadcastdate ,  a.title, a.complaint, b.CompanyName,  ";
    $query .= " CASE a.status  WHEN 'a' THEN 'Awaiting broadcast'  WHEN 'b' THEN 'Broadcasted'   END AS status ";
    
    $query .= " FROM complaints as a join organisations as b on a.organisationid = b.organisationID  WHERE a.complaintsid = $complaintid";
				
    $query = $query.$where;  
				
    $result = phpmkr_query($query);
    $complaints = "";

    if ($result){
        $row  = $result->fetch_assoc();
        $exist = true;
        $id = $row['complaintsid'];
        $lastid = $row['complaintsid'];
        $complaint = $row;
        $complain['success'] = $exist;		
        $complain['complaints'] = $complaints;
                                    
        $response = $this->GetResponseByComplaintid($id);
        if ($response){
            $complaint['response'] = $response['response'];    
            $complaint['lastidresponse'] = $response['lastidresponse'];    
            $complaint['responsesuccess'] = $response['responsesuccess'];    
            $complaint['responserows'] = $response['responserows'];    
        }
    }
                                
    return $complaint;
}

/** 
 * 
 * Show the list of responses of each complaint on preview compplaint screen
 * @param integer complaintid
 * @param lastid the lastid of response that was display on the screen* 
 * @return array
 */
                
 public function GetResponseByComplaintid($complaintid = 0, $lastid = 0){                
    $where = "";
    $exist = false;
    $query = "SELECT a.correspondenceid, DATE_FORMAT(a.date, '%d-%m-%Y') AS date, a.message, a.from, a.to FROM correspondence AS a WHERE a.complaintsid  = $complaintid  "; 
    if ($lastid > 0){
        $where = "  and a.correspondenceid < $lastid " ;
    }
            
    $orderby = "ORDER BY a.correspondenceid DESC limit 3";         
    $query = $query.$where.$orderby;  
				
    $result = phpmkr_query($query);
    $response = "";
    if ($result){
        $i = 0;
            
        $option = "";
        while ($row  = $result->fetch_assoc()){
            $option .= "
              <thead>
                <tr>
                    <th class = 'table_response_th'><img src = 'img/calendar.png'>Date</th>
                    <th class = 'table_response_th'><img src = 'img/name.png'>From</th>
                    <th class = 'table_response_th'><img src = 'img/email.png'>To</th>
                </tr>
               </thead>                                         
                <tr  class = 'trresponse'>
                    <td class = 'table_response_td'>".$row['date']."</td>
                    <td class = 'table_response_td'>".$row['from']."</td>
                    <td class = 'table_response_td'>".$row['to']."</td>
                </tr>
               
               
                <tr>
                    <td class = 'response_preview'  style='font-weight:bold;'>Response</td>
                    <td></td>
                    <td></td>
                </tr>
               
                <tr>
                    <td colspan='3' class= 'table_response_td preview_complaint_paragraph '>".$row['message']."</td>
                        <td></td>
                        <td></td>
                </tr>";       
            $i++; 
            $exist = true;
            $id = $row['correspondenceid'];
            $lastid = $id;
                                    
        } 
        if (!empty($option)){
            $option = "<div class='table-responsive'>
                <table class = 'preview_table'>".$option."</table>
                </div>";
        }
    }
    
    $response['responsesuccess'] = $exist;
    $response['response'] = $option;
    $response['lastidresponse'] = $lastid;  
    $response['responserows'] = $i;  
                                
    return $response;
 }
 
/** 
 * 
 * Get the complaints by id 
 * @param integer complaintid
 * @return array
 */		
 public function GetComplaintById($complaintid){
    $success = false;
    
    $query  = "SELECT  a.complaintsid, DATE_FORMAT(a.date, '%d-%m-%Y') as date, a.review as review,  ";
    $query .= " DATE_FORMAT(a.broadcastdate,'%d-%m-%Y')  AS broadcastdate ,  a.title, a.complaint, b.CompanyName,  ";
    $query .= "  u.email ";
    $query .= " FROM complaints as a join organisations as b on a.organisationid = b.organisationID  ";
    $query .= " JOIN users as u on u.userid = a.userid ";
    $query .= " WHERE a.complaintsid = $complaintid";
				
    $result = phpmkr_query($query);
    $row = "";
    if ($result){
        $row  = $result->fetch_assoc();
        $success = true;
    }
    $row['success'] = $success;		                        
    return $row;
}


/** 
 * 
 * Insert response of a complaint made by user
 * @param integer complaintid
 * @return array
 */		
 public function InsertResponse($complaintid,$from, $to, $response, $file="", $complainttitle = ""){
     
    $attachmentid = 0;      
    if (!empty($file)){
        $file = str_replace("\\", "/", $file);
        $filepath = UPLOAD_DIR."/".$file;
        $mysqli = new mysqli(HOST, USER, PASS, DB, PORT);
        $query = " INSERT INTO correspondenceattachments (attachment) VALUES ('$file')";
        $mysqli->query($query);
        $attachmentid = $mysqli->insert_id;
    }
    
    $success = false;
    $query  = " INSERT INTO correspondence (`from`, `to` ,`date`, `message`, `attachmentsid`, `complaintsid`) ";
    $query .= " VALUES ('$from','$to', CURRENT_TIMESTAMP,'$response', $attachmentid, $complaintid)";
    
    $subject = "Re: ". $complainttitle;    
    $message = $response;    
    
    $result = phpmkr_query($query);
    $row = "";
    if ($result){
        $success = true;
        if (!empty($file)){
            mail_attachment($filepath, $file, $to, $from, $from, "", $subject, $message); 
        }else{
            $sent = mail($to,$subject,$message);
            $row['emailsent'] = $sent;
        }
    }
    $row['success'] = $success;	
    $row['complaintsid'] = $complaintid;
    return $row;
} 

public function uploadFileResponse(){  

    header('Vary: Accept');
    if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-type: application/json');
    } else {
        header('Content-type: text/plain');
    }

    $upload_dir = 'uploads/';
    $file = $_FILES['uploadbtn']['name'];
    $file_tmp = $_FILES['uploadbtn']['tmp_name'];
    $fileuploaded = $upload_dir . basename($file);

    if (move_uploaded_file($file_tmp, $fileuploaded)) {
        $success = true;
    } else {
        $success = false;
    }
        return  $row["success"] = $success;
}

public function DeleteUploadFile($filename){  
    if (empty($file))
        return false;
    
    $filepath = UPLOAD_DIR."/".$filename;              
    unlink($filepath);
    $row['success'] = true;
}


/** 
 * 
 * Get the complaints by id 
 * @param integer complaintid
 * @return array
 */		
 public function ShowSendLetter($complaintid){
    $success = false;
    
    $query  = "SELECT  a.complaintsid, DATE_FORMAT(a.date, '%d-%m-%Y') as date, a.review as review,  ";
    $query .= " DATE_FORMAT(a.broadcastdate,'%d-%m-%Y')  AS broadcastdate ,  a.title, a.complaint, b.CompanyName, b.EmailAddresses, ";
    $query .= "  u.email ";
    $query .= " FROM complaints as a join organisations as b on a.organisationid = b.organisationID  ";
    $query .= " JOIN users as u on u.userid = a.userid ";
    $query .= " WHERE a.complaintsid = $complaintid";
    
    date_default_timezone_set('UTC');
    
    $date = date("d-m-Y");
    
    $body = "Date:" .$date."\r\n\r\n";
    $body .="Dear Sir or Madam,\r\n\r\n";

    $body .="ComplaintBlaster is a web site that empowers customers. It not only lists customer business complaints, but also disseminates them across numerous websites focusing on those visited most frequently by customers of that business. This increases a customer’s complaint visibility and ensures future customers are made aware of concerns raised by previous customers. \r\n\r\n"; 
    $body .="The ultimate aim is to help businesses improve their products and services and deliver on their promises. A happy customer will come back again and again. It’s a win-win for everyone. \r\n\r\n";
    $body .="In this context, we are therefore sorry to inform you that we have received a complaint (shown below) regarding your business. The customer has asked us to post their complaint on 50 plus websites within the next 5 days. \r\n\r\n";
    $body .="You have the opportunity to turn this customer from a detractor to a supporter by registering with our site. We will provide you with a dashboard that allows you to communicate with the customer as well as any future complainants. If you cannot resolve the complaint with the customer, we can help you reach a resolution by reviewing the communication and making a final decision. \r\n\r\n"; 
    $body .="We recommend you try to understand what went wrong from the customer’s perspective and how they want things put right. We understand this can take time, however it does make the customer feel valued and often that is enough for them to retract their complaint. \r\n\r\n"; 
    $body .="Alternatively, you can simply let us have your reply to the complaint below via email and we will review and make a decision whether to disseminate the complaint or request the user retract it. Our decision in this case will be final and is binding. \r\n\r\n";
    $body .="Finally, whichever way you choose to deal with the issue, via our dashboard or by email, we look forward to hearing from you soon. \r\n\r\n";
    $body .="Best Regards, \r\n\r\n";
    $body .="The Complaintblaster team \r\n\r\n";
    $body .="COMPLAINT \r\n\r\n";
        
	
    $result = phpmkr_query($query);
    $row = "";
    if ($result){
        $row  = $result->fetch_assoc();
        $complainttitle = "Complaint title: ".$row['title'].".\r\n\r\n";
        $complaint = "Description: ". $row['complaint'].".\r\n\r\n";
        
        $body .= $complainttitle; 
        $body .= $complaint; 
        
        $row['body'] = $body; 
        $success = true;
    }
    $row['success'] = $success;		                        
    return $row;
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
	    $name = "Name : ".$name. " \r\n\r\n"; 
	    $email = "Email: ".$email. " \r\n\r\n"; 
	    $message = "Message : ".$body. " \r\n\r\n"; 
	    
	    $body = $name.$email.$message;

	    $result = mail($to, $subject, $body);

	    if($result){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
 
 
	function SendLetter($to = "", $subject = "" , $body = ""){
	    
	    $result = SendEmail($to, $subject , $body);
	    
	    $row['success'] = $result; 
	    return $row;
	}
 

}//end class       