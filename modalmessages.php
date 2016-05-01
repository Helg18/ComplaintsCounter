	<!-- MODAL MESSAGES  -->				

	<div id="mgInformacion" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
				</div>
				<div class="modal-body">
					<p id ="pmessages" class= "modalmessage"> </p>
				</div>
				<div class="modal-footer">
				   <button type="button" class="btn btn-primary btn-default" data-dismiss="modal" id = "myBtn" >OK</button>
				</div>
			</div>
		</div>
	</div>

	<!-- ADD BUSINESS -->
	<div id="myModalB" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h3 class="modal-title" id="myModalLabel" align="center">Add Business</h3>
	            </div>
	            <div class="modal-body">
                        <form role="form" onsubmit = "return false;" id="frmAddBusiness">
                            
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">NAME <label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <input type="text" id="txtBusinessNameAdd" name = "txtBusinessName" class="inputform inputaddbusiness" tabindex="30" onblur="checkCompanyNameAddBussiness()">
				         <div class = "messagesform"><span id = "spanBusinessNameAdd"></span></div>
				    </div>
				</div>                            
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">INDUSTRY<label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <select name="industrylist" id="industrylist" class="inputform inputaddbusiness inputregions" tabindex="31" onclick="removeErrorMessageOnClick('spanIndustryAdd')" >
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"><span id = "spanIndustryAdd"></span></div>
				    </div>
				</div>                                
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">ADDRESS <label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <input type= "text" id="address" class="inputform inputaddbusiness" tabindex="32">
				         <div class = "messagesform"><span id = "spanAddressAdd"></span></div>
				    </div>
				</div>  
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">TOWN/CITY <label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <select name="townlist" id="townlist" class="inputform inputaddbusiness inputregions" tabindex="33" onclick="removeErrorMessageOnClick('spanTownAdd')">
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"><span id ="spanTownAdd"></span></div>
				    </div>
				</div>                                
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">COUNTY <label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <select  name="countylist" id="countylist" class="inputform inputaddbusiness inputregions" tabindex="34" onclick="removeErrorMessageOnClick('spanCountyAdd')">
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"><span id ="spanCountyAdd"></span></div>
				    </div>
				</div>                                
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">COUNTRY <label style="color:red;">&nbsp;*</label></div>
					<div class = "controlform-inline" >
                                            <select name="countryid" id="countrylist" class="inputform inputaddbusiness inputregions" tabindex="35">
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"></div>
				    </div>
				</div>  
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">TELEPHONE</div>
					<div class = "controlform-inline" >
                                            <input type="text" id="phone" class="inputform inputaddbusiness" tabindex="36">
                                            <div class = "messagesform"><span id ="spanPhoneAdd"></span></div>
                                        </div>
                                        
				</div>                          
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">POSTCODE</div>
					<div class = "controlform-inline" >
                                            <input type="text" id="postcode" class="inputform inputaddbusiness" tabindex="37">
                                            <div class = "messagesform"><span id ="spanPostcodeAdd"></span></div>
                                        </div>
				</div>                          
                               
				<div class="formsubscriber">
                                    <div class = "labelform-inline">EMAIL</div>
					<div class = "controlform-inline" >
                                            <input type = "text" id='email'class="inputform inputaddbusiness" tabindex="38">
                                            <div class = "messagesform"><span id ="spanEmailAdd"></span></div>
                                        </div>
				</div>                          
                            
				<div class="formsubscriber">
                                    <div class = "labelform-inline">WEBSITE</div>
					<div class = "controlform-inline" >
                                            <input type="text"  id='website'class="inputform inputaddbusiness" tabindex="39">
                                            <div class = "messagesform"><span id ="spanWebsiteAdd"></span></div>
                                        </div>
				</div>                          
                        <div id= "ajaxiconaddbusiness" class="ajaxicon" style="margin-left: 40%" ></div>         
                        <div class="action_btns" style="text-align: center; padding-top: 10px;" >
                            <input type="submit"  class="btn btn-primary btn-default" name = "cmdAddBusiness" id = "cmdAddBusiness"  value ="Save" onclick="addB()" >
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id = "myBtn" >Cancel</button>
                        </div>
                            <input type = "hidden" id= "organisationid" name = "organisationid" >
                            <input type = "hidden" id= "txtValidCompany" name = "txtValidCompany" value = "1">
                            <!--input type = "hidden" id= "txtBusinessNameAddhidden" name = "txtBusinessName"-->
                            <input type = "hidden" id= "typebusiness" name = "typebusiness" value ="o" >
	            </form>
                        
	                  
	            </div>
	        </div>
	    </div>
	</div>
	<!-- End ADDBUSINESS -->

	<!-- Start login with facebook -->
	<div id = "loginfb" class="modal fade loginfb" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" align="center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="myModalLabel">Login with Facebook</h3>
				</div>
				<div class="modal-body">
					
						<div class="user_login">
								<form action = "javascript:addS('F');" >
									<label class="button-small">Email Facebook<label style="color:red;">&nbsp;*</label></label> 
									<input id='username_f' type="text" class="login" onfocus="fbuserclean();" autocomplete="off">
									<label style="font-size:14px;" id="fbmsgerroremail"></label>
									<br>
									<label class="button-small">Password<label style="color:red;">&nbsp;*</label></label> 
									<input id='password_f' type="password" class="login" onfocus="fbpassclean();">
									<label style="font-size:14px;" id="fbmsgerror"></label>
									<br>

                                                                        <div class="checkbox-simple" style="margin-bottom: 10px;">
										<input id="rememberfb" type="checkbox">
										<label class="rememberme" for= "rememberfb">Remember me on this computer</label>
									</div>
                                                                        <div class="action_btns" style="text-align: center;">
                                                                            <input type="submit" name = "cmdSaveFacebook" id = "cmdSaveFacebook" class="savebutton" value ="Login" >
                                                                         </div>

								</form>
						</div>
					
				</div>    
			</div>
		</div>
	</div>
	<!-- End login with facebok -->

	<!-- Start login with google -->
	<div id = "logingplus" class="modal fade logingplus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" align="center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="myModalLabel">Login with Google</h3>
				</div>
				<div class="modal-body">
					
						<div class="user_login">
								<form action = "javascript:addS('G');">
									<label class="button-small">Email Google<label style="color:red;">&nbsp;*</label></label> 
									<input id='username_g' type="text" class="login" onfocus="gplususerclean();" autocomplete="off">
									<label style="font-size:14px;" id="gplusmsgerroremail"></label>
									<br>

									<label class="button-small">Password<label style="color:red;">&nbsp;*</label></label> 
									<input id='password_g' type="password" class="login" onfocus="gpluspassclean();">
									<label style="font-size:16px;" id="gplusmsgerror"></label>
									<br>

									<div class="checkbox-simple" style="margin-bottom: 10px;" >
										<input id="remembergplus" type="checkbox">
										<label class="rememberme" for= "remembergplus">Remember me on this computer</label>
									</div>

									<div class="action_btns">
                                                                            <input type="submit" name = "cmdSaveGmail" id = "cmdSaveGmail" class="savebutton" value ="Login" >
									</div>
								</form>
						</div>
					
				</div>    
			</div>
		</div>
	</div>
	<!-- End login with google -->
        
<script>
    removeErrorMessage('txtBusinessNameAdd', 'spanBusinessNameAdd');
    removeErrorMessage('address','spanAddressAdd');
    removeErrorMessage('email','spanEmailAdd');
    removeErrorMessage('phone','spanPhoneAdd');
    removeErrorMessage('postcode','spanPostcodeAdd');
    removeErrorMessage('website','spanWebsiteAdd');
    
</script>        

        
       