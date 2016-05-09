<?php 

    require_once ('functions.php');
    
    $user = GetUserSession();
    
    if (!isset($user['userid'])){
        header('Location:index.php');
        exit();
    }
    
?>
            <div id="modalUserBusiness" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                                        <div style="float:left; text-align: center; font-size: 200%; width: 100%">Edit User Business</div>
				</div>
	
                                <div class="modal-body" style = "float:left; width: 100%">                            
                                    
                                        <form  role="form" method="post" name="frmUserBusinessEdit" id="frmUserBusinessEdit" accept-charset="utf-8" style="text-align:left;" >
                                                <div class="formsubscriber">
                                                        <div class = "labelform">BUSINESS NAME*</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtBusinessName" id="txtBusinessNameEdit" class="inputform" maxlength="59">
                                                            <div class = "messagesform"><span id = "spanBusinessNameEdit" ></span></div>
                                                        </div>
                                                </div>
                                            
                                                <div class="formsubscriber">
                                                    <div class = "labelform">INDUSTRY<label style="color:red;">&nbsp;*</label></div>
                                                        <div class = "controlform" >
                                                            <select name="industrylist" id="industrylistedits" class="inputform inputaddbusiness" onclick="removeErrorMessageOnClick('spanIndustryEdits')">
                                                                <option value="">Select</option>
                                                            </select>
                                                            <div class = "messagesform"><span id = "spanIndustryEdits"></span></div>
                                                    </div>
                                                </div>                                

                                                <div class="formsubscriber">
                                                        <div class = "labelform">STREET ADDRESS</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtStreet" id="txtStreetEdit" class="inputform" maxlength="59">
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">CITY</div>
                                                        <div class = "controlform" >
                                                            <select name="townlistregister" id="townlistregisterEdit" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanCityEdit')" >
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">COUNTY</div>
                                                        <div class = "controlform" >
                                                            <select name="countylistregister" id="countylistregisterEdit" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanCountyEdit')">
                                                                <option value="">Select</option>
                                                            </select>                  
                                                        </div>
                                                </div>
                                            <div class="formsubscriber">        
                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanCityEdit" ></span></div>
                                                            </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform"></div>
                                                            <div class = "controlform" >
                                                                <div class = "messagesform"><span id = "spanCountyEdit" ></span></div>
                                                            </div>
                                                </div>
                                             </div>   

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">POSTAL CODE</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtPostal" id="txtPostalEdit" class="inputform" maxlength="8">
                                                                <div class = "messagesform"><span id = "spanPostalEdit" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">COUNTRY</div>
                                                        <div class = "controlform" >
                                                            <select name="countrylistregister" id="countrylistregisterEdit" class="inputform inputaddbusiness">
                                                                <option value="">Select</option>
                                                            </select>                  
                                                        </div>
                                                </div>

                                                <div class="formsubscriber">
                                                        <div class = "labelform">CONTACT NAME</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtContactName" id="txtContactNameEdit" class="inputform" maxlength="128">
                                                        </div>
                                                </div>

                                                <div class="formsubscriber">
                                                        <div class = "labelform">CONTACT EMAIL*</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtContactEmail" id="txtContactEmailEdit" class="inputform" onblur= "UserEditEmailChange('b')" maxlength="100">
                                                                <div class = "messagesform"><span id = "spanContactEmailEdit" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">TELEPHONE</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtPhone" id="txtPhoneEdit" class="inputform" maxlength="15">					
                                                            <div class = "messagesform"><span id = "spanPhoneEdit" ></span></div>
                                                        </div>
                                                </div>

                                                <div class="formsubscriber2col">
                                                        <div class = "labelform">WEBSITE</div>
                                                        <div class = "controlform" >
                                                            <input type = "text" name="txtWebsite" id="txtWebsiteEdit" class="inputform" maxlength="59">
                                                            <div class = "messagesform"><span id = "spanWebsiteEdit" ></span></div>
                                                        </div>
                                                </div>
                                
			
                                                <div class="formsubscriber">
                                                    <div id= "ajaxiconuserbusinessedit" class="ajaxicon" style =" margin-left: 40% " >

                                                    </div>
                                                </div>
			
                                                <input type = "hidden" id= "txtValidUserBusiness" name = "txtValidUserBusiness" value = "1">
                                                <input type = "hidden" id= "organisationidedit" name = "organisationid" >
                                                <input type = "hidden" id= "useridbusinessedit" name = "userid">
                                                <input type = "hidden" id= "emailrecoverbusiness" name = "emailrecoverbusiness">
                                        </form>  
		 		</div>	
                                <div class="modal-footer" style = "text-align: center; width: 100%;">
                                    <button type="button" class="btn btn-primary btn-default reponsivebutton" id = "cmdResetBusinessUser" onclick = "ResetPasswordEditUser('b');return false;">Reset Password</button>
                                    <button type="button" class="btn btn-primary btn-default reponsivebutton" id = "cmdUpdateOrganisation" onclick = "updateEditUser('b');return false;">Save</button>
				    <button type="button" class="btn btn-primary btn-default reponsivebutton" data-dismiss="modal" id = "myBtn" >Cancel</button>
				</div>
			</div>
		</div>
            </div>

            <div id="modalUser" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                                        <div style="float:left; text-align: center; font-size: 200%; width: 100%">Edit User</div>
				</div>
	
                            <div class="modal-body" style="float:left !important; width: 100% ">                            
                                    
                                        <form  method="post" name="frmUserEdit" id="frmUserEdit" accept-charset="utf-8" style="text-align:left;" >
                                                <div class="formsubscriber">
                                                        <div class = "labelform">NAME*</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtUserUsername" id="txtNameUser" class="inputform" >
                                                                <div class = "messagesform"><span id = "spanNameUser" ></span></div>
                                                        </div>
                                                </div>


                                                <div class="formsubscriber">
                                                        <div class = "labelform">EMAIL*</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtUserEmail" id="txtUserEmail" class="inputform" onblur= "UserEditEmailChange('u')">
                                                                <div class = "messagesform"><span id = "spanEmailUser" ></span></div>
                                                        </div>
                                                </div>
                                            
                                                <div class="formsubscriber">
                                                        <div class = "labelform">CITY</div>
                                                        <div class = "controlform" >
                                                                <input type = "text" name="txtCity" id="txtCity" class="inputform" >
                                                        </div>
                                                </div>
                                            
			
                                                <div class="formsubscriber">
                                                    <div id= "ajaxiconuseredit" class="ajaxicon" style =" margin-left: 40% " >

                                                    </div>
                                                </div>
			
                                                <input type = "hidden" id= "txtValidUser" name = "txtValidUser" value = "1">
                                                <input type = "hidden" id= "useridedit" name = "userid">
                                                <input type = "hidden" id= "emailrecoveruser" name = "emailrecoveruser" value =>
                                        </form>  
		 		</div>	
                                <div class="modal-footer" style = "text-align: center; width: 100% ">
                                    <button type="button" class="btn btn-primary btn-default reponsivebutton" id = "cmdResetUser" onclick = "ResetPasswordEditUser('u');return false;">Reset Password</button>
                                    <button type="button" class="btn btn-primary btn-default reponsivebutton" id = "cmdUpdateSubscription" onclick = "updateEditUser('u');return false;">Save</button>
				    <button type="button" class="btn btn-primary btn-default reponsivebutton" data-dismiss="modal" id = "myBtn" >Cancel</button>
				</div>
			</div>
		</div>
            </div>
	
	<?php 
	    include_once("modalmessages.php");
	?>
  
<script>
    	
$( document ).ready(function() {
    removeErrorMessage('txtUserEmail', 'spanEmailUser');
    removeErrorMessage('txtContactEmailEdit', 'spanContactEmailEdit');
    removeErrorMessage('txtWebsiteEdit', 'spanWebsiteEdit');
    removeErrorMessage('txtPhoneEdit', 'spanPhoneEdit');
    removeErrorMessage('txtPostalEdit', 'spanPostalEdit');
});
     
</script>