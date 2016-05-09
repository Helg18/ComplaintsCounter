<?php 
$title ="User Account";

    require_once ('functions.php');
    
    $user = GetUserSession();
    
    if (!isset($user['userid'])){
        header('Location:index.php');
        exit();
    }

    $menuhidden = true;
    include_once("header.php");
    
    require_once("subscription.php");

    $userid = $user['userid'];
    
    $subscription = new subscription();
    $subscription = $subscription->GetUser($userid);

    
?>

<body>

    <div class="section_article" style = "float:left; padding-top: 5% ">
	<div class="content content-with-progress" >
  	    <div class="medium">
                <form  role="form" method="post" name="frmUserAccount" id="frmUserAccount" accept-charset="utf-8" style="text-align:left;" >
                  <div class="formsubscriber">
                      <div class = "labelform">NAME*</div>
                      <div class = "controlform" >
                          <input type = "text" name="txtUserUsername" id="txtUserUsername" class="inputform" value ="<?php echo $subscription['name'] ?>" maxlength="50">
                          <div class = "messagesform"><span id = "spanUsername" ></span></div>
                      </div>
                  </div>

                  <div class="formsubscriber">
                       <div class = "labelform">EMAIL*</div>
                       <div class = "controlform" >
                          <input type = "text" name="txtUserEmail" id="txtUserEmail" class="inputform" value ="<?php echo $subscription['email'] ?>" onblur ="UserEmailChange()" maxlength="100"> 
                           <div class = "messagesform"><span id = "spanUserEmail" ></span></div>
                      </div>
                  </div>
                    
                  <div class="formsubscriber">
                       <div class = "labelform">CITY</div>
                       <div class = "controlform" >
                          <input type = "text" name="txtCity" id="txtCity" class="inputform" value ="<?php echo $subscription['usercity'] ?>" maxlength="40">
                      </div>
                  </div>


                  <div class="formsubscriber">
                      <div id= "ajaxiconsubscription" class="ajaxicon" style ="margin-left: 20% " >

                      </div>
                  </div>

                          <input type = "hidden" id= "txtValid" name = "txtValid" value = "1">

                   </form>  
		</div> 
            
                        <div class="formsubscriber" style="padding-top: 40px">
			   <a id = "cmdSaveUser" href="#" onclick = "updateUser();return false;" class="button button-next"><span>Save</span></a>
			</div>
		 			
		</div>
		
		
	</div>
	<?php 
	    include_once("modalmessages.php");
		
	?>
</body>
</html>
