<?php 
    $title = "Dashboard";
    require_once ('functions.php');
    
    $user = GetUserSession();
    
    if (!isset($user['userid'])){
        header('Location:index.php');
        exit();
    }

    $menuhidden = true;
    include_once("header.php");
    
    require_once("subscription.php");

    $organisationid = $user['organisationid'];
    
    $subscription = new subscription();
    $subscription = $subscription->GetSubcription($organisationid);
    if (!$subscription){
        $found = "
        <div style ='margin-top: 10%; text-align: center; !important; font-size:30px; font-weight: bold; !important; float:left; width:100%'>
            Subscription not found please contact to administrator
	</div>
        ";       
         echo $found;
         exit();                                           
    }
    
    $county = $subscription['CountyID'];
    $country = $subscription['CountryID'];
    $town = $subscription['TownID'];
    $industryid =  $subscription['IndustryID'];
    
?>
<body>

    <div class="section_article" style = "float:left; padding-top: 0% !important">
	<div class="content content-with-progress">
  	    <div class=" medium">
              <form  role="form" method="post" name="frmSubscription" id="frmSubscription" accept-charset="utf-8" style="text-align:left;" >

				<div class="formsubscriber">
					<div class = "labelform">BUSINESS NAME*</div>
					<div class = "controlform" >
						<input type = "text" name="txtBusinessName" id="txtBusinessName" class="inputform" value ="<?php echo $subscription['businessname'] ?>" maxlength="59"> 
						<div class = "messagesform"><span id = "spanBusinessName" ></span></div>
					</div>
				</div>
                  
				<div class="formsubscriber">
					<div class = "labelform">INDUSTRY*</div>
					<div class = "controlform" >
                                            <select name="industrylist" id="industrylistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanIndustryRegister')" >
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"><span id = "spanIndustryRegister"></span></div>
					</div>
				</div>
                  
				
				<div class="formsubscriber">
					<div class = "labelform">STREET ADDRESS*</div>
					<div class = "controlform" >
						<input type = "text" name="txtStreet" id="txtStreet" class="inputform" value ="<?php echo $subscription['address'] ?>" maxlength="59">
                                                <div class = "messagesform"><span id = "spanStreetRegister"></span></div>
					</div>
				</div>
				
				<div class="formsubscriber2col">
					<div class = "labelform">CITY*</div>
					<div class = "controlform" >
                                            <select name="townlistregister" id="townlistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanTownRegister')" >
                                                <option value="">Select</option>
                                            </select>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">COUNTY*</div>
					<div class = "controlform" >
                                            <select name="countylistregister" id="countylistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanCountyRegister')" >
                                                <option value="">Select</option>
                                            </select>                  
					</div>
				</div>
                                      <div class="formsubscriber" style="height: 0px !important;">        
                                          
                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanTownRegister" ></span></div>
                                                            </div>
                                                </div>


                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanCountyRegister" ></span></div>
                                                            </div>
                                                </div>
                                             </div>  
                  
				<div class="formsubscriber2col">
					<div class = "labelform">POSTAL CODE</div>
					<div class = "controlform" >
						<input type = "text" name="txtPostal" id="txtPostalRegister" class="inputform" value ="<?php echo $subscription['postalcode'] ?>" maxlength="8">
                                                <div class = "messagesform"><span id = "spanPostalregister"></span></div>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">COUNTRY*</div>
					<div class = "controlform" >
                                            <select name="countrylistregister" id="countrylistregister" class="inputform inputaddbusiness">
                                                <option value="">Select</option>
                                            </select>                  
					</div>
				</div>

                                <div class="formsubscriber">
					<div class = "labelform">CONTACT NAME*</div>
					<div class = "controlform" >
						<input type = "text" name="txtContactName" id="txtContactName" class="inputform" value ="<?php echo $subscription['contactname'] ?>" >
					</div>
				</div>

				<div class="formsubscriber">
					<div class = "labelform">CONTACT EMAIL*</div>
					<div class = "controlform" >
						<input type = "text" name="txtContactEmail" id="txtContactEmail" class="inputform" onblur= "SubscriptionEmailChange()" value ="<?php echo $subscription['contactemail'] ?>" maxlength="100">
						<div class = "messagesform"><span id = "spanContactEmail" ></span></div>
					</div>
				</div>
                  
				<div class="formsubscriber2col">
					<div class = "labelform">TELEPHONE</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtPhone" id="txtPhone" class="inputform" value = "<?php echo $subscription['TelephoneNumber'] ?>" maxlength="15">
                                            <div class = "messagesform"><span id = "spanPhoneregister"></span></div>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">WEBSITE</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtWebsite" id="txtWebsite" class="inputform" value = "<?php echo $subscription['WebsiteAddress'] ?>" maxlength="59">
                                        </div>
				</div>
  	    </div>
			
			<div class="formsubscriber">
			    <div id= "ajaxiconsubscription" class="ajaxicon" >
                                    
                            </div>
			</div>
			
			<input type = "hidden" id= "txtValid" name = "txtValid" value = "1">
			<input type = "hidden" id= "typecard" name = "typecard" >
			<input type = "hidden" id= "planpaid" name = "planpaid" >
			<input type = "hidden" id= "type" name = "type" value = "trial" >
			<input type = "hidden" id= "paidPlanAmount" name = "paidPlanAmount" >
                        <input type = "hidden" id= "town" value ="<?php echo $town ?>">
                        <input type = "hidden" id= "country" value ="<?php echo $country ?>">
                        <input type = "hidden" id= "county" value ="<?php echo $county ?>">
                        <input type = "hidden" id= "industryid" value ="<?php echo $industryid ?>">
                        

			<div class="formsubscriber" style = "text-align: center; padding-top: 20px">
			   <a id = "cmdUpdateSubscription" href="#" onclick = "updateBusiness();return false;" class="button button-next"><span>Save</span></a>
			</div>
			
		 </form>  
		 
		 			
		</div>
		
		
	</div>
	<?php 
	    include_once("modalmessages.php");
		
	?>
<script>
    fillDropdownRegions('countrylistregister', 'country', $("#country").val());
    fillDropdownRegions('countylistregister', 'county',$("#county").val());
    fillDropdownRegions('townlistregister', 'town',$("#town").val());
    fillDropdownOrganisationIndustries('industrylistregister', $("#industryid").val());
    
    removeErrorMessage('txtBusinessName', 'spanBusinessName');
    removeErrorMessage('txtStreet', 'spanStreetRegister');
    removeErrorMessage('txtPhone', 'spanPhoneregister');
    removeErrorMessage('txtPostalRegister', 'spanPostalregister');    
</script>    
</body>

</html>
