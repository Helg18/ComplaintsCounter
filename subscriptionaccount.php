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
    
    $county = $subscription['CountyID'];
    $country = $subscription['CountryID'];
    $town = $subscription['TownID'];
    
?>
<body>

    <div class="section_article" style = "float:left; padding-top: 0% !important">
	<div class="content content-with-progress">
  	    <div class=" medium">
              <form  role="form" method="post" name="frmSubscription" id="frmSubscription" accept-charset="utf-8" style="text-align:left;" >

				<div class="formsubscriber">
					<div class = "labelform">BUSINESS NAME*</div>
					<div class = "controlform" >
						<input type = "text" name="txtBusinessName" id="txtBusinessName" class="inputform" value ="<?php echo $subscription['businessname'] ?>" >
						<div class = "messagesform"><span id = "spanBusinessName" ></span></div>
					</div>
				</div>
				
				<div class="formsubscriber">
					<div class = "labelform">STREET ADDRESS</div>
					<div class = "controlform" >
						<input type = "text" name="txtStreet" id="txtStreet" class="inputform" value ="<?php echo $subscription['address'] ?>" >
					</div>
				</div>
				
				<div class="formsubscriber2col">
					<div class = "labelform">CITY</div>
					<div class = "controlform" >
                                            <select name="townlistregister" id="townlistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageCity()" >
                                                <option value="">Select</option>
                                            </select>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">COUNTY</div>
					<div class = "controlform" >
                                            <select name="countylistregister" id="countylistregister" class="inputform inputaddbusiness " >
                                                <option value="">Select</option>
                                            </select>                  
					</div>
				</div>
				
				<div class="formsubscriber2col">
					<div class = "labelform">POSTAL CODE</div>
					<div class = "controlform" >
						<input type = "text" name="txtPostal" id="txtPostal" class="inputform" value ="<?php echo $subscription['postalcode'] ?>">
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">COUNTRY</div>
					<div class = "controlform" >
                                            <select name="countrylistregister" id="countrylistregister" class="inputform inputaddbusiness">
                                                <option value="">Select</option>
                                            </select>                  
					</div>
				</div>

                                <div class="formsubscriber">
					<div class = "labelform">CONTACT NAME</div>
					<div class = "controlform" >
						<input type = "text" name="txtContactName" id="txtContactName" class="inputform" value ="<?php echo $subscription['contactname'] ?>" >
					</div>
				</div>

				<div class="formsubscriber">
					<div class = "labelform">CONTACT EMAIL*</div>
					<div class = "controlform" >
						<input type = "text" name="txtContactEmail" id="txtContactEmail" class="inputform" onblur= "SubscriptionEmailChange()" value ="<?php echo $subscription['contactemail'] ?>">
						<div class = "messagesform"><span id = "spanContactEmail" ></span></div>
					</div>
				</div>
                  
				<div class="formsubscriber2col">
					<div class = "labelform">TELEPHONE</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtPhone" id="txtPhone" class="inputform" value = "<?php echo $subscription['TelephoneNumber'] ?>">					
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">WEBSITE</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtWebsite" id="txtWebsite" class="inputform" value = "<?php echo $subscription['WebsiteAddress'] ?>">
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
</script>    
</body>

</html>
