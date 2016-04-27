<?php 
   $title= "Register";
   include_once("header.php");
   
  $usercity = "";
  $ip = $_SERVER["REMOTE_ADDR"];
  $location = GetGeolocation($ip);
  if (!empty($location['cityName']))
    $usercity = $location['cityName'];    

?>

<body onload= "loadRegisterPage()">

	<div id="start" style="text-align: center">
		<div class="content content-with-footer" style="padding-top: 10px; width: 80%;  margin: 0 auto" >
                    <div class="gridContainer clearfix content-with-footer" style = "margin-bottom: 700px;">

                        <h1 align="center"><em>Subscribe</em> here</h1>

                        <h3 align="center" class="wide">By subscribing, we'll ensure you receive notifications of complaints straight away with the complainer's email address so you can resolve directly or send us an objection which we can review before deciding whether to broadcast the complaint or not.</h3>
                        <p class="buttons"><a id = "step1" href="#plans" class="button button-next"><span>Subscribe</span></a></p>
                    </div>
                </div>
	</div>

    <div  class = "section_article" >
    	<div id="plans" class="content content-with-progress wide section_page_register" style = "margin-top: -80px; margin-bottom: 500px">
            <div class="medium header_package">
              <h2>Choose the appropriate package for your business</h2>
            </div>
            <div class="buttons plans" style = "margin-top: -20px;">
                
                <label for="smallbu" class="instruction button plan_responsive" alt = "Small plan">
                    <span id="smallbuspan"></span>
                    <strong><input type="radio" id="smallbu" name="paidplans" value = "1" onchange = "paidPlanAmount()" /> Small</strong>
                    <h2>£9</h2>
                    <ul>
                        <div class = "paidplan_list" >Get notification of complaint</div>
                        <div class = "paidplan_list">Receive complainer's email</div>
                        <div class = "paidplan_list">Dispute complaint</div>
                        <div class = "paidplan_list">Resolve to prevent broadcast</div>
                    </ul>
                    <h4>less than 10 employees</h4>
                </label>
                
                <label for="mediumbu" class="instruction button plan_responsive" alt = "Medium plan">
                    <span></span>
                    <strong><input type="radio" id="mediumbu" name="paidplans" value = "2" onchange = "paidPlanAmount()"/> Medium</strong>
                    
                    <h2>£25</h2>
                      <ul>
                        <div class = "paidplan_list" >Get notification of complaint</div>
                        <div class = "paidplan_list">Receive complainer's email</div>
                        <div class = "paidplan_list">Dispute complaint</div>
                        <div class = "paidplan_list">Resolve to prevent broadcast</div>
                      </ul>  
                    
                    <h4>less than 50 employees</h4>
                </label>
                
                
                <label for="bigbu" class="instruction button plan_responsive" alt = "Large plan">
                    <span></span>
                    <strong><input type="radio" id="bigbu" name="paidplans" value = "3" onchange = "paidPlanAmount()"/> Large</strong>
                    <h2>£49</h2>
                    <ul>
                        <div class = "paidplan_list" >Get notification of complaint</div>
                        <div class = "paidplan_list">Receive complainer's email</div>
                        <div class = "paidplan_list">Dispute complaint</div>
                        <div class = "paidplan_list">Resolve to prevent broadcast</div>

                    </ul>
                    <h4>50 or more employees</h4>
                </label>
                <div>
		<div class = "messagesform"><span id = "spanPaidPlan" ></span></div>
		    <p ><a id = "step2" href="#payment" onclick= "return validatePaidPlan();" class="button button-next" style="margin-top:10px;"><span>Continue</span></a></p>
                </div>
        
    </div>
</div>	
        
        
    <div class="section_article"  >
        <div  class="content content-with-progress section_page"  >
            <div  id="payment" class="medium" >
              <form  role="form"  method="post" name="frmSubscription" id="frmSubscription" accept-charset="utf-8" style="text-align:left;" >

				<div class="formsubscriber">
                                    <div class = "labelform">BUSINESS NAME*</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtBusinessName" id="txtBusinessName" class="inputform" onkeypress="businessList('txtBusinessName','organisationid')" onblur="checkCompanyName()" alt="Enter your business name">
				         <div class = "messagesform"><span id = "spanBusinessNameregister" ></span></div>
				    </div>
				</div>
                  
				<div class="formsubscriber">
					<div class = "labelform">INDUSTRY *</div>
					<div class = "controlform" >
                                            <select name="industrylist" id="industrylistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanIndustryregisters')" >
                                                <option value="">Select</option>
                                            </select>
                                            <div class = "messagesform"><span id = "spanIndustryregisters"></span></div>
					</div>
				</div>
				
				<div class="formsubscriber">
					<div class = "labelform">STREET ADDRESS *</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtStreet" id="txtStreet" class="inputform" alt="Enter address" >
                                            <div class = "messagesform"><span id = "spanStreetregister" ></span></div>
					</div>
				</div>
                  
				<div class="formsubscriber2col">
					<div class = "labelform">TOWN/CITY *</div>
					<div class = "controlform" >
                                            <select name="townlistregister" id="townlistregister" class="inputform inputaddbusiness " onclick="removeErrorMessageOnClick('spanTownRegister')" >
                                                <option value="">Select</option>
                                            </select>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">COUNTY *</div>
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
                                            <input type = "text" name="txtPostal" id="txtPostal" class="inputform" >
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
                  
                                            <div class="formsubscriber" style="height: 0px !important;">        
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
                  
                  
				<div class="formsubscriber">
					<div class = "labelform">CONTACT NAME</div>
					<div class = "controlform" >
						<input type = "text" name="txtContactName" id="txtContactName" class="inputform" alt="Enter your name" >
                                                <div class = "messagesform"><span id = "spanContactName" ></span></div>
					</div>
				</div>

				<div class="formsubscriber">
					<div class = "labelform">CONTACT EMAIL*</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtContactEmail" id="txtContactEmail" class="inputform" onblur= "CheckSubscriptionEmail()" alt="Enter your email" alt="Type your password">
					    <div class = "messagesform"><span id = "spanContactEmail" ></span></div>
					</div>
				</div>
				<div class="formsubscriber2col">
					<div class = "labelform">TELEPHONE</div>
					<div class = "controlform" >
                                                <input type = "text" name="txtPhone" id="txtPhone" class="inputform">	
                                                <div class = "messagesform"><span id = "spanPhoneregister" ></span></div>
					</div>
				</div>

				<div class="formsubscriber2col">
					<div class = "labelform">WEBSITE</div>
					<div class = "controlform" >
                                            <input type = "text" name="txtWebsite" id="txtWebsite" class="inputform">
                                            <div class = "messagesform"><span id = "spanWebsite" ></span></div>
                                        </div>
				</div>

				<div class="formsubscriber">
                                    <div class="formsubscriber2col">
                                            <div class = "labelform">PASSWORD*</div>
                                            <div class = "controlform" >
                                                    <input type = "password" name="txtPasswordRegister" id="txtPasswordRegister" class="inputform"  alt="Enter your credit card number">
                                                    <div class = "messagesform"><span id = "spanPasswordRegister" ></span></div>
                                            </div>
                                    </div>

                                    <div class="formsubscriber2col">
                                            <div class = "labelform">SELECT PAYPAL PAYMENT METHOD</div>
                                            <div class = "controlform" >
                                                <select name="paymentmethod" id="paymentmethod" class="inputform inputaddbusiness" onchange="paymentMethodChange()">
                                                    <option value="0">Credit Card</option>
                                                    <option value="1">Paypal</option>
                                                </select>                  
                                            </div>
                                    </div>
                                </div>    
				<div id="cardinfo">
                                    <div class="formsubscriber2col cardnumber_responsive">
                                            <div class = "labelform ">CARD NUMBER*</div>
                                            <div class = "controlform " >
                                                    <input type = "text" name="txtCard" id="txtCard" class="inputform" alt="Enter exp date MM/YYYY">

                                            </div>
                                    </div>

                                    <div class="formsubscriber2col cvc_register" style = "margin-left:5px;">
                                            <div class = "labelform">EXP* MM/YYYY</div>
                                            <div class = "controlform " >
                                                    <input type = "text" name="txtExp" id="txtExp" class="inputform" alt="Enter your CVV/CVC">

                                            </div>
                                    </div>

                                    <div class="formsubscriber2col cvc_register" style = "margin-left:5px;">
                                            <div class = "labelform">CVC*</div>
                                            <div class = "controlform" >
                                                <input type = "text" name="txtCvc" id="txtCvc" class="inputform" >
                                            </div>
                                    </div>
                                </div>    
                  
				<div class = "messagesform" style= "margin-top:5px" ><span id = "spanCard" ></span></div>
				<div class = "messagesform" style= "margin-left:50%;margin-top:0px" ><span id = "spanExp" ></span></div>
				<div class = "messagesform" style= "margin-left:76%;margin-top:5px"><span id = "spanCvc" ></span></div>
            </div>
			
			<div class="formsubscriber">
                            <div id= "ajaxiconsubscription" class="ajaxicon" >
                                    
                            </div>
			</div>
			
			<input type = "hidden" id= "txtValid" name = "txtValid" value = "1">
                        <input type = "hidden" id= "txtValidCompany" name = "txtValidCompany" value = "1">
			<input type = "hidden" id= "typecard" name = "typecard" >
			<input type = "hidden" id= "planpaid" name = "planpaid" >
			<input type = "hidden" id= "type" name = "type" value = "subscriber" >
			<input type = "hidden" id= "paidPlanAmount" name = "paidPlanAmount" >
                        <input type = "hidden" id= "usertype" name = "usertype" value ="b" >
                        <input type = "hidden" id= "usercity" value = "<?php echo $usercity ?>" >
                        <input type = "hidden" id= "organisationid" name = "organisationid" >
                        <input type = "hidden" id= "typebusiness" name = "typebusiness" value ="u" >
                        <input type = "hidden" id= "status" name = "status" value ="active" >
                        
                        <div class="formsubscriber" style="text-align: center" >
			   <a id = "cmdSaveSubscription" href="#" onclick = "registerBusiness();return false;" class="button button-next"><span>Submit</span></a>
			</div>
			
		 </form>  
		</div>
	</div>
	<?php 
	    include_once("modalmessages.php");
	?>
</body>

<script>
/*smooth scroll*/
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

function validatePaidPlan(){
   $("#step2").attr("href", "#")
   result = true
   if (!$('input:radio[name=paidplans]:checked').val()){
        $('#spanPaidPlan').html('Select a Payment Plan');
	$('#spanPaidPlan').addClass('error-messages ng-active');
       result = false;
	}else{
		$("#step2").attr("href", "#payment");
		$('#spanPaidPlan').html('');
                $('#spanPaidPlan').attr("class", "");
                 setTimeout(function (){
                     $("#txtBusinessName").focus();
                }, 600);                
	}
	
	return result;
}	 

    fillDropdownRegions('countrylistregister', 'country','');
    fillDropdownRegions('countylistregister', 'county','');
    
    fillDropdownOrganisationIndustries('industrylistregister','');  
    
    var usercity = $("#usercity").val();

        $("#townlistregister").html('<option value="0">Select</option>');
            //LOAD LIST OF towns
            $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'townlist'},
                dataType: 'json',
                error: function (data) {
                    alert('Error loading town list');
                    console.log(data);
                },
                success: function (data) {
                    option = "";
                    for (var i in data) {
                        Town = data[i].Town;
                        TownID = data[i].TownID;
                        selected = "";
                        if (TownID != 'undefined' && Town != 'undefined') {
                            if (Town.toLowerCase() == usercity.toLowerCase())
                                selected = "selected";

                            option = option + "<option value='" + TownID + "'" + selected + " >" + Town + "</option>";
                        }
                    }
                    $("#townlistregister").append(option);
                }
            });
            

$( "#smallbu" ).click(function() {
  $("#smallbuspan").css("background-image", "url(../img/check_radio_sheet.png");
});

function paymentMethodChange(){
    if ($('#paymentmethod').val() == 1){
        errorMessage('spanCard','', false);
        errorMessage('spanExp','', false);
        errorMessage('spanCvc','', false);
        $('#cardinfo').hide();
    }
    else
        $('#cardinfo').show();
        
}

</script>
</html>
