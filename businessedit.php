<?php 

    require_once ('functions.php');
    
    $user = GetUserSession();
    
    if (!isset($user['userid'])){
        header('Location:index.php');
        exit();
    }
    
    
    
?>
            <div id="modalBusiness" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                                        <div style="float:left; text-align: center; font-size: 200%; width: 100%">Edit Business</div>
				</div>
	
                                <div class="modal-body" style="float:left; width: 100%">                            
                                    
                                        <form  role="form" method="post" onsubmit = "return false;" name="frmSubscription" id="frmSubscription" accept-charset="utf-8" style="text-align:left;" >
                                                <div class="formsubscriber">
                                                        <div class = "labelform">BUSINESS NAME*</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtBusinessName" id="txtBusinessName" class="inputform"  maxlength="59" >
                                                                <div class = "messagesform"><span id = "spanBusinessNameEdit" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber">
                                                    <div class = "labelform">INDUSTRY<label style="color:red;">&nbsp;*</label></div>
                                                        <div class = "controlform" >
                                                            <select name="industrylist" id="industrylistedit" class="inputform inputaddbusiness" onclick="removeErrorMessageOnClick('spanIndustryEdit')">
                                                                <option value="">Select</option>
                                                            </select>
                                                            <div class = "messagesform"><span id = "spanIndustryEdit"></span></div>
                                                    </div>
                                                </div>                                
                                            
                                                <div class="formsubscriber">
                                                        <div class = "labelform">STREET ADDRESS</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtStreet" id="txtStreet" class="inputform" maxlength="59">
                                                                <div class = "messagesform"><span id = "spanStreetregister" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">TOWN/CITY</div>
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
                                            <div class="formsubscriber">        
                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanCity" ></span></div>
                                                            </div>
                                                </div>


                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanCounty" ></span></div>
                                                            </div>
                                                </div>
                                             </div>   

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">POSTAL CODE</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtPostal" id="txtPostal" class="inputform" maxlength="8">
                                                                <div class = "messagesform"><span id = "spanPostalregister" ></span></div>
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
                                                                <input type = "text" name="txtContactName" id="txtContactName" class="inputform" maxlength="128">
                                                        </div>
                                                </div>

                                                <div class="formsubscriber">
                                                        <div class = "labelform">CONTACT EMAIL*</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtContactEmail" id="txtContactEmail" class="inputform" onblur= "SubscriptionEmailChange()" maxlength="100">
                                                                <div class = "messagesform"><span id = "spanContactEmail" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">TELEPHONE</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtPhone" id="txtPhone" class="inputform" maxlength="15">					
                                                            <div class = "messagesform"><span id = "spanPhoneregister" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">WEBSITE</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtWebsite" id="txtWebsite" class="inputform" maxlength="59">
                                                            <div class = "messagesform"><span id = "spanWebsite" ></span></div>
                                                        </div>
                                                </div>
                                
			
                                                <div class="formsubscriber">
                                                    <div id= "ajaxiconsubscription" class="ajaxicon" >

                                                    </div>
                                                </div>
			
                                                <input type = "hidden" id= "txtValid" name = "txtValid" value = "1">
                                                <input type = "hidden" id= "town">
                                                <input type = "hidden" id= "country">
                                                <input type = "hidden" id= "county">
                                                <input type = "hidden" id= "organisationid" name = "organisationid" >
                                                <input type = "hidden" id= "organisationtype" name = "organisationtype" >
                                                <input type = "hidden" id= "cityname" name = "cityname" >
                                                
                                        </form>  
		 		</div>	
                                <div class="modal-footer" style = "text-align: center">
                                    <button type="button" class="btn btn-primary btn-default" id = "cmdUpdateOrganisation" >Save</button>
				   <button type="button" class="btn btn-primary" data-dismiss="modal" id = "myBtn" >Cancel</button>
				</div>
			</div>
		</div>
            </div>
	
	<?php 
	    include_once("modalmessages.php");
	?>
  
<script>
    
    $("#modalBusiness").keydown(function (event) {
        if (event.keyCode == 13) {
             $('#cmdUpdateOrganisation').click();
            return true;
        }
    });
    
    	
$( document ).ready(function() {
    removeErrorMessage('txtBusinessName', 'spanBusinessNameEdit');
    removeErrorMessage('txtWebsite', 'spanWebsite');
    removeErrorMessage('txtWebsite', 'spanWebsite');
    removeErrorMessage('txtContactEmail', 'spanContactEmail');
    removeErrorMessage('txtStreet', 'spanStreetregister');
    removeErrorMessage('txtPostal', 'spanPostalregister');
    removeErrorMessage('txtPhone', 'spanPhoneregister');
});
     
</script>