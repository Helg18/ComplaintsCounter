var arrayautocomplete = new Array();
var arrayautocompleteid = new Array();
var allvalid = false;

/** 
 * Trim a text
 * @param string text to trim
 * @return string
 */
function trim(s){
    var l=0; var r=s.length -1;
    while(l < s.length && s[l] == ' ')
    {   l++; }
    while(r > l && s[r] == ' ')
    {   r-=1;   }
    return s.substring(l, r+1);
}
/** 
 * Trim the left side of text
 * @param string text to trim
 * @return string */
function ltrim(s){
    var l=0;
    while(l < s.length && s[l] == ' ')
    {   l++; }
    return s.substring(l, s.length);
}

/** 
 * Trim the right side of text
 * @param string text to trim
 * @return string
 */
function rtrim(s){
    var r=s.length -1;
    while(r > 0 && s[r] == ' ')
    {   r-=1;   }
    return s.substring(0, r+1);
}     

/** 
 * get the value of a parameter from url
 * @param string name of the parameter
 * @param string url
 * @return string
 */
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

/** 
 * allows only number in a input 
 * @param string id of input
 */
function onlyNumbers(selector) {
    $('#'+selector).bind('keypress', function(e) {
    return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
    })
}
/** 
 * blocks key input
 * @param string id of input
 */
function disableKeys(selector) {
    $('#'+selector).bind('keypress', function(e) {
    return false ;
    })
}

/** 
 * Count the characters that remains when a user type in a input
 * @param string id of input
 * @return integer
 */
 function countChar(val, car, element, info) {
    var len =  val.value.length;
    
    if (len > car) {
        val.value = val.value.substring(0, car);
        val.append(info);
    } else {
        $(element).text(car - len);
        $(element).append(info);
                
    }
}
/** 
 * get base url
 * @return string
 */  
function getBaseUrl() {
    var re = new RegExp(/^.*\//);
    return re.exec(window.location.href);
}

/**
 * check if a date is valid in mm/dd/yyyy format.
 * @param string txtDate in mm/dd/yyyy format.'
 * @return boolean 
 */
function isDate(txtDate){
  var currVal = txtDate;
  if(currVal == '')
    return false;
   
  //Declare Regex 
  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
  var dtArray = currVal.match(rxDatePattern);

  if (dtArray == null)
     return false;
  //Checks for mm/dd/yyyy format.
  
  dtDay= dtArray[3];
  dtMonth = dtArray[1];
  dtYear = dtArray[5];
  if (dtMonth < 1 || dtMonth > 12)
      return false;
  else if (dtDay < 1 || dtDay> 31)
      return false;
  else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
      return false;
  else if (dtMonth == 2)
  {
     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
     if (dtDay> 29 || (dtDay ==29 && !isleap))
          return false;
  }
  return true;
}

/**
 * check if the format of expiration date from a credit card is valid
 * @param string txtDate in mm/dd/yyyy format.'
 * @return boolean
 */
function CheckExpirationDate(txtExp){
        var dateexp = new Date();
        var year = dateexp.getFullYear();
        var month = dateexp.getMonth() + 1;
        exp = txtExp;
        pos = exp.lastIndexOf('/');
        
        if (pos == -1){
            return false;
        }else
        {
            expmonth = exp.substring(0, pos);
            expyear = exp.substring(pos+1, exp.length);
            

            if (expmonth > 12 ){
                return false;
            } 
            
            if (expyear < year){
                return false;
            }
            
            if ((expyear == year) && (expmonth < month))
                
                return false;
            } 
            return true;     
}


/**
 * check if emai hava a valid format
 * @param string email
 * @return boolean
 */
function validEmail(email) {
    var pattern=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if(email.search(pattern)==0)
        return true;
    else
        return false;
}

/**
 * check is url website is valid
 * @param string url
 * @return boolean
 */
function validUrl(url){
    var pattern = /^[a-z0-9\.-]+\.[a-z]{2,4}/gi;

    
    if(url.match(pattern))
        valid =  true;
    else
        valid = false;
    
    return valid;
}
/**
 * remove error messages when users click on input or select 
 * @param string id of span to remove error
 * @return boolean
 */

function removeErrorMessageOnClick(selectorSpan){
    selectorSpan = '#'+selectorSpan;
    $(selectorSpan).attr("class", "");
    $(selectorSpan).html('');
}

/**
 * Funcion return the text of reviews
 * @param integer  
 * return string    
 */
    
function reviewText(value){
    if (value > 1)
        return value + ' points of 5';
    else
        return value + ' point of 5';
}    

/**
 * Function validate postcode
 * @param string  
 * return boolean    
 */
function validatepostcode(cp) {
    /* validate  C0DP0STAL*/
    var patron = ' ';
    cp=cp.replace(patron,'');
                
    //var ercp=/(^([0-9a-zA-z]{6,6})|^)$/;
    var ercp=/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/gi;
    if (!(ercp.test(cp))) { 
        return false; }
    /* if all is OK -> return TRUE */
    return true;           
}

/**
 * Function validate phone number
 * @param string  
 * return boolean    
 */

function validatephone(number){
  /*Validate Phone Number*/
  var patron = ' ';
  number = number.replace(patron, '');
  var phone =/(^([0-9]{10,12})|^)$/;
    return phone.test(number);
}

/**
 * Function validate field check if a field is blank
 * @param selector id
 * return boolean    
 */

function checkIfBlank(selector){
    var blank = false;
    selector = selector.replace('#', ''); 
    selector = '#'+selector;
    value = $(selector).val().trim();
    if (value === '' )
        blank = true;
    
    return blank;
    
}
/** 
 * check if browser is internet explorer version 6,7,8
 * @return boolean
 */
function CheckInternetExplorer(){
    var rv = -1;  //to prevent fails the pointer should be null
      if (navigator.appName == 'Microsoft Internet Explorer'){
         var ua = navigator.userAgent;
         var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
         if (re.exec(ua) != null)
                  rv = parseFloat( RegExp.$1 );
         if(rv > -1){
             switch(rv){
                 case 8.0:
                   return true
                    break;
                 case 7.0: 
                    return true;
                     break;
                 case 6.0: 
                    return true;
                     break;
                 default:
                     return false
                     //"Default";
                      break;                  
             }
         }
    }
    
}



/**
 * Show modal message when browser is < 9 
 */
 function internetExplorerMessage(){
     if (CheckInternetExplorer()){
        $("#pmessages").html('It was detected that you are using an old version of internet explorer, this browser is not compatible with the site, for a better experience you should use internet explorer 9, Chrome, Firefox, Opera or Safari.');
        $('#mgInformacion').modal('show');
    }
 }


/**
 * call ajax function to register a business
 * @return boolean
 */   
function registerBusiness() {
    
    errorMessage('spanPasswordRegister','',false);
    errorMessage('spanCard','',false);
    errorMessage('spanExp','',false);
    errorMessage('spanCvc','',false);
    errorMessage('spanWebsite', '', false);
    errorMessage('spanContactEmail', '', false);
    errorMessage('spanPhoneregister', '', false);
    errorMessage('spanCounty', '', false);
    errorMessage('spanCity', '', false);
    errorMessage('spanPostalregister', '', false);
    errorMessage('spanCountyRegister', '', false);
    errorMessage('spanTownRegister', '', false);
    errorMessage('spanStreetregister', '', false);
    errorMessage('spanIndustryregisters', '', false);
    errorMessage('spanBusinessNameregister', '', false);    

    pattern = validEmail($('#txtContactEmail').val())
    
    if (!$('input:radio[name=paidplans]:checked').val()){
        $('#spanPaidPlan').html('Should select a Payment Plan');
        $('#spanPaidPlan').addClass('error-messages ng-active');
        $('#step1').get(0).click();
        return false;
    
    }
    
    if (checkIfBlank('txtBusinessName')){
            errorMessage('spanBusinessNameregister','Field Business Name should not be blank', true);
            return false;
    }    
    
    if ($('#industrylistregister').val() == 0){
        errorMessage('spanIndustryregisters','You must select a Industry', true);
        return false;
    }   
    
    if (checkIfBlank('txtStreet')){
            errorMessage('spanStreetregister','Field Address Should not be blank', true);
            return false;
    }    
    
    if (checkIfBlank('txtContactEmail')){
        errorMessage('spanContactEmail','Field E-mail should not be blank', true);
        return false;
    }    
    
    
    if ($('#townlistregister').val() == 0){
        errorMessage('spanTownRegister','You must select a city', true);
        return false;
    }    

    if ($('#countylistregister').val() == 0){
        errorMessage('spanCountyRegister','You must select a County', true);
        return false;
    }   

    if (checkIfBlank('txtPasswordRegister')){
        errorMessage('spanPasswordRegister','Field Password should not be blank', true);
        return false;
    }    
    
    if (!pattern){
        errorMessage('spanContactEmail','Email not valid!', true);
        return false;
    }  
        
    url = $('#txtWebsite').val();
    if (url.length > 0){
        valid = validUrl(url);
        if (!valid){
           errorMessage('spanWebsite','Website is not valid', true);
            return false;
        }    
    }       
    
    var postcode = $('#txtPostal').val();
    if (postcode.length > 0){
        var validate = validatepostcode(postcode);

        if (!validate) {
            errorMessage('spanPostalregister','Postal Code is not valid', true);
            return false;
        }
    }
    
    var phone = $('#txtPhone').val();
    if (phone.length > 0){    
        var validatenophone = validatephone(phone);
        if (!validatenophone) {
            errorMessage('spanPhoneregister','Phone Number is not valid', true);
            return false;
        }
    }	
    
    if ($('#txtValid').val()  == 0 ){
        errorMessage('spanContactEmail','Email is not valid or already registered', true);
        return false;
    }    
    
    if ($('#txtValidCompany').val()  == 0 ){
        errorMessage('spanBusinessName','Business Name already registered', true);
        return false;
    }    
    
    if ($('#paymentmethod').val() == 0){
        if (checkIfBlank('txtCard')){
            errorMessage('spanCard','Field Number Card should not be blank', true);
            return false;
        }    
        
        if (checkIfBlank('txtExp')){
            errorMessage('spanExp','Field Expiration Date should not be blank', true);
            return false;
        }    
        if (checkIfBlank('txtCvc')){
            errorMessage('spanCvc','Field CVC should not be blank', true);
            return false;
        }    
        

        valid = true;
        $('#txtCard').validateCreditCard(function(result) {
            if (!result.luhn_valid){
                valid = false;
                return false;
            } 

         $('#typecard').val(result.card_type.name);

        });


        if (!valid){
            errorMessage('spanCard','Card number invalid', true);
            return false;
        }

        valid = true;
        valid = CheckExpirationDate($('#txtExp').val());

        if (!valid){
                errorMessage('spanExp','Expiration date invalid!', true);
            return false;
        }
    }//end credicard   
    
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      $("#ajaxiconsubscription").html('<img src="'+path +'"/>');
        
      $("#cmdSaveSubscription").attr("disabled", "disabled");        
      
      
      $("#planpaid").val($('input:radio[name=paidplans]:checked').val());
      
      if ($('#paymentmethod').val() == 0){
            
            //credicard payment
            $.ajax({
                   url: 'subscription.php?action=insert',
                   type: "POST",
                   data:$('#frmSubscription').serialize(), 
                   dataType: 'json',
                   //timeout: 60000,
                   success:function(data){
                       $("#ajaxiconsubscription").html('');
                       $("#cmdSaveSubscription").removeAttr("disabled");

                        $('#frmSubscription').trigger("reset");
                        window.top.location = 'register_success.php';
                   },
                       error: function(data) {
                           console.log(data)
                           $("#ajaxiconsubscription").html('');
                           $("#cmdSaveSubscription").removeAttr("disabled");
                           alert('An error occurred');
                   }

               });
        }
        else{
            //paypal payment
            $.ajax({
                
                   url: 'payments.php?action=createagreementwithpaypal',
                   type: "POST",
                   data:$('#frmSubscription').serialize(), 
                   dataType: 'json',
                   //timeout: 60000,
                   success:function(data){
                            window.top.location = data.approvalurl;
                   },
                       error: function(data) {
                           $("#ajaxiconsubscription").html('');
                           alert('Error procesing payment');
                           console.log(data)
                   }

               }); 
        }    
}     

/*/**
 * call ajax function to check if a subscription email already exist in subscription screen
 * @return boolean
 */   
         
function CheckSubscriptionEmail() {
    
    var pattern = validEmail($('#txtContactEmail').val())
    
    if (!pattern)
        return;
    
    $('#spanContactEmail').removeClass('error-messages ng-active');
    
    if ($('#txtContactEmail').val().length == 0)
       return false;
    
    $.ajax({
            method  : 'POST',
            url     : 'subscription.php?action=checksubscriptionemail&email='+$('#txtContactEmail').val(),
            data    :  $('#frmSusbscription').serialize(),
            dataType: 'json',
            error: function (data) {
                            console.log(data);
                        },
            success:function(data){
            if (!data.success ) {
                
                 $('#spanContactEmail').html('Email already registered');       
                 $('#spanContactEmail').addClass('error-messages ng-active');
         $('#txtValid').val(0);
                 

            }else {
                  $('#spanContactEmail').html('');       
                  $('#spanContactEmail').removeClass('error-messages ng-active');
          $('#txtValid').val(1);
                  }     
            }
       });//end ajax      
} 

/**
*loadRegisterPage
*/    
function loadRegisterPage(){
    removeErrorMessage('txtBusinessName', 'spanBusinessNameregister');                                         
    removeErrorMessage('txtContactEmail', 'spanContactEmail');
    removeErrorMessage('txtCard', 'spanCard');
    removeErrorMessage('txtExp', 'spanExp');
    removeErrorMessage('txtCvc', 'spanCvc');
    removeErrorMessage('txtWebsite', 'spanWebsite');
    removeErrorMessage('txtPasswordRegister', 'spanPasswordRegister');
    removeErrorMessage('txtStreet', 'spanStreetregister');
    removeErrorMessage('txtPhone', 'spanPhoneregister');
    removeErrorMessage('txtPostal', 'spanPostalregister');

    onlyNumbers('txtCard');
    onlyNumbers('txtCvc');
}
/**
* remove error message of a span when input activate keypress event
* @param strind id of input selector
* @param strind id of span selector to remove message
*/    
function removeErrorMessage(selector, spanSelector){
    selector = selector.replace('#', ''); 
    spanSelector = spanSelector.replace('#', ''); 
    selector = '#'+selector;
    spanSelector = '#'+spanSelector;
    $(selector).on('keypress', function() {
       if ($(selector).val().length >= 0 ){
               $(spanSelector).attr("class", "");
               $(spanSelector).html('');
       }
    });
}


/**
* show spell check
* @param strind id of input selector
* @param strind id of div selector to show
*/    
function showSpellCheck(selector, divSelector){
    
    selector = selector.replace('#', ''); 
    divSelector = divSelector.replace('#', ''); 
    selector = '#'+selector;
    divSelector = '#'+divSelector;
    $(selector).on('keydown', function(e) {
       $(divSelector).hide();
       if ($(selector).val().length >= 15 ){
          $(divSelector).show();
       }
    });
}

/**
* Call ajax function to check login
* @return boolean
*/  
 function CheckLogin(){
   if (checkIfBlank('txtUsername'))      
       return false;
   
   if (checkIfBlank('txtPassword'))
       return false;
   
     var path = getBaseUrl()+'img/ajax-loader.gif';
     $("#ajaxiconlogin").html('<img src="'+path +'"/>');
    
    $('#spanmsg').html('');
        $('#spanmsg').removeClass('ng-msgbox ');
             $.ajax({
                url: 'subscription.php?action=login',
                type: "POST",
                data:$('#frmLogin').serialize(),
                dataType: 'json',
                success:function(data){
                    //console.log(data)
                    $("#ajaxiconlogin").html('');
                    if (data.success){
                            window.top.location = 'userlog.php';
                    } 
                    else{
                        
                        var msg = 'Please, verify your credentials and try again..';
                        if (data.blocked == 'blocked'){
                            msg = 'User is blocked please send a email to '+ data.emailadmin;
                        }
                        
                        $("#spanmsg").html(msg);
                        $('#spanmsg').addClass('error-messages ng-active');
                    }
                },
                    error: function(data) {
                        $("#ajaxiconlogin").html('');
                        $('#spanmsg').html('Username or password invalid!'); 
                        $('#spanmsg').addClass('ng-msgbox ');
                        alert('An error occurred');
                        console.log(data)
                }                
            });
}

/**
 * Show modal form login
 * @param string type of screen to show  "b" = business login or "u" = user login;
 */
 function showLogin(type){
     
  $("#spanmsg").html('');
  $('#spanmsg').removeClass('error-messages ng-active');

    //errorMessage('spanmsg','', false);
    $('#frmLogin').trigger("reset");
    //$('#spanmsg').html('');
    //errorMessage('spanUserEmail','', true);
    
    
    
    $('#logintype').val(type);
        $('#usertype').val(type);
    
    $('#registerlogin').hide();
    $('#modalLoginTitle').html('User Login'); 
    if (type == 'b'){
        $('#modalLoginTitle').html('Business Login'); 
        $('#registerlogin').show();
                
    }
 
 
    $('#myModalbusinneslogin').modal('show');
            setTimeout(function (){
             $("#txtUsername").focus();
             }, 600);
             
             

 
 }
 
/**
 * Set the value of Paiplan in subscription screen
 * @param string type of screen to show  "b" = business login or "u" = user login;
 */ 
function paidPlanAmount(){
    var value = $('input:radio[name=paidplans]:checked').val();
    switch (value) {
        
        case '1':
            $('#paidPlanAmount').val(9);
            break;
        case '2':
            $('#paidPlanAmount').val(25);
            break;
        case '3':
            $('#paidPlanAmount').val(49);
            break;
    }

}

/**
 * call ajax function to update a business 
 * @param string type of screen to show  "b" = business login or "u" = user login;
 * @return boolean
 */
function updateBusiness(){

   $('#spanBusinessname').removeClass();
   $('#spanContactemail').removeClass();
   
   errorMessage('spanBusinessName','', false);
   
   errorMessage('spanTownRegister','', false);
   errorMessage('spanCountyRegister','', false);
   errorMessage('spanStreetRegister','', false);
   errorMessage('spanTownRegister','', false);
   errorMessage('spanContactEmail','', false);
   errorMessage('spanPostalregister','', false);
   errorMessage('spanPhoneregister','', false);
   

   
    pattern = validEmail($('#txtContactEmail').val())
    
    if (checkIfBlank('txtBusinessName')){
        errorMessage('spanBusinessName','Field Business Name should not be blank', true);
        return false;
    }    
    
    if ($('#industrylistregister').val() == 0 ){
        
        $('#spanIndustryRegister').html('You must select a Industry');
        $('#spanIndustryRegister').addClass('error-messages ng-active');
        return false;
    }        
    
    if (checkIfBlank('txtStreet')){
        errorMessage('spanStreetRegister','Field Street Adddress should not be blank', true);
        return false;
    }    
    
    if ($('#townlistregister').val()  == 0){
        errorMessage('spanTownRegister','You must select a city', true);
        return false;
    }    
    
    if ($('#countylistregister').val()  == 0){
        errorMessage('spanCountyRegister','You must select a county', true);
        return false;
    }            
    
    if (checkIfBlank('txtContactEmail')){
        errorMessage('spanContactEmail','Field E-mail should not be blank', true);
        return false;
    }    
    
    
    if (!pattern){
        errorMessage('spanContactEmail','Email not valid!', true);
        return false;
    }  
    
    if ($('#txtValid').val()  == 0 ){
        errorMessage('spanContactEmail','Email is not valid or already registered', true);
        return false;
    }    
    
    
    var postcode = $('#txtPostalRegister').val();
    if (postcode.length > 0){
        var validate = validatepostcode(postcode);
        if (!validate) {
            errorMessage('spanPostalregister','Postal Code is not valid', true);
            return false;
        }
    }
    
    var phone = $('#txtPhone').val();
    if (phone.length > 0){    
        var validatenophone = validatephone(phone);
        if (!validatenophone) {
            errorMessage('spanPhoneregister','Phone Number is not valid', true);
            return false;
        }
    }    
    
    
    url = $('#txtWebsite').val();
    if (url.length > 0){
        valid = validUrl(url);
        if (!valid){
           errorMessage('spanWebsite','Website is not valid', true);
            return false;
        }    
    }      
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      
      $("#ajaxiconsubscription").html('<img src="'+path +'"/>');
      
      $("#cmdUpdateSubscription").attr("disabled", "disabled");   
        
        $.ajax({
                url: 'subscription.php?action=update',
                type: "POST",
                data:$('#frmSubscription').serialize(),
                dataType: 'json',
                success:function(data){
                    $("#cmdUpdateSubscription").removeAttr("disabled");
                    $("#ajaxiconsubscription").html('');
                    
                    $("#pmessages").html('Updated subscribe successfully');
                    $('#mgInformacion').modal('show');
                    
                    $("#myBtn").click(function(){
                        window.location.reload(); 
                   });
                },
                    error: function(data) {
                     console.log(data)
                    $("#ajaxiconsubscription").html('');
                    alert('An error occurred');
                }
                
            });
            
            
}

/**
 * call ajax function to check, when email is changed is not registered by another user in subscribe screen
 * @return boolean
 */
function SubscriptionEmailChange() {
    var pattern = validEmail($('#txtContactEmail').val());
    if ($('#txtContactEmail').val().length == 0 || !pattern)
       return false;
       
    $('#spanContactEmail').removeClass();
    
    $.ajax({
                url: 'subscription.php?action=subscriptionemailchange&email='+$('#txtContactEmail').val(),
                type: "POST",
                data:$('#frmSusbscribe').serialize(),
                dataType: 'json',
                success:function(data){
                     
                    if (!data.success){
                        $('#spanContactEmail').html('Email already registered')
                        $('#spanContactEmail').addClass('error-messages ng-active');
                        $('#txtValid').val(0);
                    }else{
                         $('#spanContactEmail').html('');
                         $('#txtValid').val(1);
                         $('#spanContactEmail').removeClass();
                    }
                },
                    error: function(data) {
                        console.log(data)
                        alert('An error occurred');
                    }
                
            });
}  

/**
 * call ajax function to check, when user email change is not already register by another user.
 * @param string type of screen to show  "b" = business login or "u" = user login;
 * @return boolean
 */

function UserEmailChange() {
    var pattern = validEmail($('#txtUserEmail').val());
   
    if ($('#txtUserEmaill').val().length == 0 || !pattern)
       return false;
       
        $('#spanUserEmail').removeClass();
    
        $.ajax({
                url: 'subscription.php?action=subscriptionemailchange&email='+$('#txtUserEmail').val(),
                type: "POST",
                data:$('#frmUserAccount').serialize(),
                dataType: 'json',
                success:function(data){
                     
                    if (!data.success){
                        errorMessage('spanUserEmail','Email already registered', true);
                        $('#txtValid').val(0);
                    }else{
                         errorMessage('spanUserEmail','', false);
                         $('#txtValid').val(1);
                    }
                },
                    error: function(data) {
                        alert('Error '+ data );
                    }
                
            });
}  

/**
 * call ajax function to send a email with instruccion to recover the password that user forgot
 * @return boolean
 */
function ResetPassword(){
 var pattern = validEmail($('#txtEmailRecover').val())
   $('#spanEmailRecover').html('');
   $('#spanEmailRecover').removeClass('ng-msgbox ');
   
    if (checkIfBlank('txtEmailRecover')){
        errorMessage('spanEmailRecover','Field should not be blank', true);
        return false; 
    } 

    
   if (!pattern){
       errorMessage('spanEmailRecover','Email not valid', true);
        return false;
    }  

          var path = getBaseUrl()+'img/ajax-loader.gif';
          $("#ajaxiconpassword").html('<img src="'+path +'"/>');
        
          $("#cmdResetPassword").attr("disabled", "disabled");   
   
             $.ajax({
                url: 'subscription.php?action=resetpassword',
                type: "POST",
                data:$('#frmReset').serialize(),
                dataType: 'json',
                success:function(data){
                    
                        $("#ajaxiconpassword").html('');
            
            $("#cmdResetPassword").removeAttr("disabled");

                    if (data.success){
                        window.top.location  = 'reset_success.php';
                    }else
                    {
                        $('#spanEmailRecover').html('Email not registered')
                        $('#spanEmailRecover').addClass('error-messages ng-active');
                        
                    }
                },
                    error: function(data) {
                     console.log(data)
                     $("#ajaxiconpassword").html('');
                     $('#spanmsg').html('Username or password invalid!'); 
                     $('#spanmsg').addClass('ng-msgbox ');
                     alert('An error occurred');
                }
                
            });
}
/**
 * call ajax function to recover user password 
 * @return boolean
 */
function RecoverPassword(){

    if (checkIfBlank('txtPasswordRecover')){
        $('#spanPasswordRecover').html('Field Password should not be blank');
        $('#spanPasswordRecover').addClass('error-messages ng-active');
        return false; 
    } 
    
    if ($('#txtPasswordRecover').val() != $('#txtRepeatPasswordRecover').val() ){
        $('#spanRepeatPasswordRecover').html('Password not match');
        $('#spanRepeatPasswordRecover').addClass('error-messages ng-active');
        return false; 
    } 
          var path = getBaseUrl()+'img/ajax-loader.gif';
          
          $("#ajaxiconpassword").html('<img src="'+path +'"/>');
          
          $("#cmdRecoverPassword").attr("disabled", "disabled");        
          
             $.ajax({
                url: 'subscription.php?action=recoverpassword',
                type: "POST",
                data:$('#frmReset').serialize(),
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $("#cmdRecoverPassword").removeAttr("disabled");
                        $('#frmReset').trigger("reset");
                        $("#ajaxiconpassword").html('');
                        $("#pmessages").html('Password Updated Successfully');
                        $('#mgInformacion').modal('show');
                        $("#mgInformacion").on('hidden.bs.modal', function () {
                            window.top.location = 'index.php';
                        });

                    } else
                    {
                        $("#cmdRecoverPassword").removeAttr("disabled");
                        $("#ajaxiconpassword").html('');
                        alert('An error occurred');                        
                    }
                },
                    error: function(data) {
                     console.log(data)
                     alert('An error occurred');
                }
                
            });
}
/**
 * call ajax function to check if a ip address belongs to uk
  */
    function SearchCountryIp(){
            
          $.ajax({
                url: 'fun_jq.php?searchcountry=1',
                type: "POST",
                data: {action: 'searchcountry'},
                dataType: 'json',
                success:function(data){
                        if (!data.success){
                            window.location.replace("comingsoonto.html?name="+data.name);
                        }
                    },
                    error: function(data) {
                     console.log(data)
                     alert('An error occurred');
                }
                });
}

/**
 * call ajax function to insert a complaint
 * @return boolean
 */
function insertComplaint() {
    var successful = false;
        
    var organisationid = $('#exist').val();
    var title = $('#myComplaints').val(); 
    var complaint = $('#complaintscomplete').val(); 
    var review = $('input:radio[name=star]:checked').val();
    var broadcast = $('input:radio[name=broadcast]:checked').val();
    var name = $('#name_config').val(); 
    var email = $('#email_conf').val(); 
    var industryid = $('#industryid').val(); 
    
    if ($('#txtValid').val() == 0){
        alert('You should complete all the steps before broadcast');
        return false;
    }
    
        $("#gotodone").attr("href", "#done");   
        
       var path = getBaseUrl()+'img/ajax-loader.gif';
       $("#ajaxiconcomplaintinsert").html('<img src="'+path +'"/>');
             
         //CAPTCHA
         $.ajax({
                //async:false,
                cache:false,
                url: 'fun_jq.php?action=complaintcaptcha',
                type: "POST",
                data:$('#frmCaptcha').serialize(), 
                dataType: 'json',
                success:function(data){
                    
                    if (data.success){
                        $.ajax({
                            //async:false,
                            cache:false,
                            url: 'fun_jq.php',
                            type: "POST",
                            data:{action:'insertcomplaint',organisationid:organisationid,  name: name, email:email, title:title, complaint:complaint, review:review, broadcast:broadcast, industryid:industryid},
                            dataType: 'json',
                            success:function(data){
                                
                                successful = true;
                              //  setTimeout(function (){
                                   $("#ajaxiconcomplaintinsert").html('');
                                    //$('#feedbacklink').focus();
                                    var doneb = $('#businessname').val();
                                    
                                    cleanComplaintsFields();
                                    $('#doneb').html(doneb);
                                    grecaptcha.reset();
                                    
                                  // }, 100);                                
                                  
                                    
                            },
                                error: function(data) {
                                    console.log(data)
                                    $("#botonextsend").get(0).click();
                                    $("#ajaxiconcomplaintinsert").html('');
                                    alert('An error occurred inserting complaint');
                                    successful = false;                        
                            }

                        });
                    }        
                    else{
                        $("#ajaxiconcomplaintinsert").html('');
                        successful = false;       
                        showPopupMessage('Captcha is not valid!');
                        $("#botonextsend").get(0).click();
                        
                    }
                 
                },
                    error: function(data) {
                        $("#gotodone").attr("href", "#send");
                        $("#ajaxiconcomplaintinsert").html('<img src="'+path +'"/>');
                        alert('An error occurred with captcha');
                        successful = false;
                        console.log(data)
                }
                
            });
         /**/   

       
        return successful;
}     


/**
 * clear all input fields from index page
 */
function cleanComplaintsFields(){
    $('#businessname').val(''); 
    $('#exist').val(''); 
    $('#myComplaints').val(''); 
    $('#complaintscomplete').val(''); 
    //I commented those fields, because. if users add another complaint their not have to type name and email again 
    //$('#name_config').val(''); 
    //$('#email_conf').val(''); 
    $("#detailsbusiness").attr("hidden", true);
    $("#raitingvalues").attr("hidden", true);
    $("#nocomplaintsbusiness").attr("hidden", false);
    $("#detailsbusiness").hide();
    $("#detailsbusiness").hide();
    $("#divspelltitle").hide();
    $("#divspellcomplaint").hide();
    $('input[name="star"]').prop('checked', false);
}

/**
 * call ajax function to delete a complaint from userlog.php screen
  */
function deleteComplaint(id){
var complaintid = parseInt(id);


        $('#pmessagesconfirm').html('Are you sure that you want delete this complaint?');
        $('#mgConfirmation').modal('show');
        $("#btn_confirm").click(function(){
                     
                    var path = getBaseUrl()+'img/ajax-loader.gif';

                     $("#imageajax"+complaintid).html('<img src="'+path +'"/>');

                             $.ajax({
                                url: 'complaints.php?action=deletecomplaint&complaintsid='+ complaintid,
                                type: "POST",

                                dataType: 'json',
                                success:function(data){
                                    $('#complaintrow'+complaintid).remove();
                                    $("#imageajax"+complaintid).html('');
                                },
                                    error: function(data) {
                                     console.log(data)
                                     $("#imageajax"+complaintid).html('');
                                     alert('An error occurred');
                                }

                            });                     
                        
                   });       
}
/**
 * call ajax function to broadcast a complaint by admin user
 * @param integer id of complaint
 */
function broadcastComplaint(id){
var complaintid = parseInt(id);
var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajax"+complaintid).html('<img src="'+path +'"/>');
     $('#broadcast'+complaintid).html('broadcasting');
             $.ajax({
                url: 'cron/broadcast.php?action=broadcastcomplaint&complaintsid='+ complaintid,
                type: "POST",                
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $('#status'+complaintid).html(data.broadcast);
                        $("#imageajax"+complaintid).html('');
                        $('#broadcast'+complaintid).remove();
                        $('#actionlink'+complaintid).remove();
                        $('#broadcastdate'+complaintid).html(data.broadcastdate);
                    }
                    
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajax"+complaintid).html('');
                     alert('An error occurred');
                }
                
            });
}

/**
 * call ajax function to broadcast a complaint by user
 * @param integer id of complaint
 */
function broadcastComplaintUser(id){
    
var complaintid = parseInt(id);
var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajax"+complaintid).html('<img src="'+path +'"/>');
     $('#broadcast'+complaintid).html('broadcasting');
             $.ajax({
                url: 'cron/broadcast.php?action=broadcastcomplaintuser&complaintsid='+ complaintid,
                type: "POST",
                
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $("#imageajax"+complaintid).html('');
                        $('#broadcast'+complaintid).removeAttr("href");
                        $('#broadcast'+complaintid).html('Broadcasted');
                        $('#broadcastdate'+complaintid).html(data.broadcastdate);
                        $('#actionlink'+complaintid).remove();                        
                }
                    
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajax"+complaintid).html('');
                     alert('An error occurred');
                }
                
            });
}

/**
 * call ajax function to load the list of complaints by user
 * @param integer id of complaint
 */
function showMoreComplaints(){
    var lastid = $('#lastid').val();
    var userid = $('#userid').val();
      
    var path = getBaseUrl()+'img/ajax-loader.gif';
      $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');
    
             $.ajax({  
                url: 'complaints.php?action=showmorecomplaints&lastid='+ parseInt(lastid) + '&userid='+parseInt(userid),
                type: "POST",
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $("#ajaxiconmorecomplaints").html('');
                        $('#showmorecomplaints').append(data.complaints);
                        $('#lastid').val(data.lastid);
                        if (data.rows < 6) {
                            $('#complaintshowmore').hide();
                        }else
                            $('#complaintshowmore').show();
                        
                        
                    }else
                    {
                        $('#complaintshowmore').hide();
                        $("#ajaxiconmorecomplaints").html('');
                    }
                },
                    error: function(data) {
                     console.log(data)
                     $("#ajaxiconmorecomplaints").html('');
                     alert('An error occurred');
                }
                
            });
}


/**
 * call ajax function to check, when user change email is not already registered 
 */
function UserEmailChange() {
    var pattern = validEmail($('#txtUserEmail').val());
   
    if ($('#txtUserEmail').val() == 0 || !pattern)
       return false;
       
    $('#spanUserEmail').removeClass();
    
    $.ajax({
                url: 'subscription.php?action=subscriptionemailchange&email='+$('#txtUserEmail').val(),
                type: "POST",
                data:$('#frmUserAccount').serialize(),
                dataType: 'json',
                success:function(data){
                    if (!data.success){
                        errorMessage('spanUserEmail','Email already registered', true); 
                        $('#txtValid').val(0);
                    }else{
                         errorMessage('spanUserEmail','', false); 
                         $('#txtValid').val(1);
                    }
                },
                    error: function(data) {
                        alert('An error occurred');
                    }
                
            });
}  

/**
 * Show messages of error o delete message of error
 * @param string id of span that show message
 * @param string message to show
 * @boolean identifies if messages if show or delete
 */
function errorMessage(idSpan, message, show){
    idSpan = idSpan.replace('#', '');
    idSpan = '#'+idSpan;
    if (show){
        $(idSpan).show();
        $(idSpan).html(message);
        $(idSpan).addClass('error-messages ng-active');
    }else {
        $(idSpan).html('');
        $(idSpan).removeClass();
        $(idSpan).attr("class", "");
        $(idSpan).hide();
    }
}

/**
 * call ajax function to update a user
 */
function updateUser(){

    errorMessage('spanUsername','', false);
    errorMessage('spanUserEmail','', false);

    pattern = validEmail($('#txtUserEmail').val())

    if (checkIfBlank('txtUserUsername')){
        errorMessage('spanUsername','Field Name should not be blank', true);
        return false;
    }    
    
    if (checkIfBlank('txtUserEmail')){
        errorMessage('spanUserEmail','Field E-mail should not be blank', true);
        return false;
    }    
    
    if (!pattern){
        errorMessage('spanUserEmail','Email not valid!', true);
        return false;
    }  
    
    if ($('#txtValid').val()  == 0 ){
        errorMessage('spanUserEmail','Email is not valid or already registered!', true);
        return false;
    }    
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      $("#ajaxiconsubscription").html('<img src="'+path +'"/>');
        
        $.ajax({
                url: 'subscription.php?action=updateuser',
                type: "POST",
                data:$('#frmUserAccount').serialize(),
                dataType: 'json',
                success:function(data){
                    $("#ajaxiconsubscription").html('');
                    
                    $("#pmessages").html('Updated subscribe successfully');
                    $('#mgInformacion').modal('show');
                    
                    $("#myBtn").click(function(){
                        window.location.reload(); 
                   });
                },
                    error: function(data) {
                     console.log(data)
                    $("#ajaxiconsubscription").html('');
                    alert('An error occurred');
                }
            });
}
/**
 * call ajax function to change the status of a complaint
 * @param integer id of complaint
 * @param string p = Pause, r = Resume
 */
function actionComplaint(id, action){
var complaintid = parseInt(id);
var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajax"+complaintid).html('<img src="'+path +'"/>');
                    
             $.ajax({
                url: 'complaints.php?action=actioncomplaint&complaintsid='+ complaintid+'&actionmode='+action,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    $('#action'+complaintid).html(data.actionmode);
                    $("#imageajax"+complaintid).html('');
                    $('#status'+complaintid).html(data.status);
                    
                    $("#actionlink"+complaintid).removeAttr("onclick");
                    $("#actionlink"+complaintid).attr('onclick',"actionComplaint('"+id+"','"+data.action+"');return false;");
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajax"+complaintid).html('');
                     alert('An error occurred');
                }
                
            });
}


/**
 * Show modal form add new business to list of complaints
 */
 function showAddBusiness(){
     
        $('#frmAddBusiness').trigger("reset");
        $("#txtBusinessNameAdd").val($("#businessname").val());
        
        errorMessage('spanBusinessNameAdd','', false);
        errorMessage('spanAddressAdd','', false);
        errorMessage('spanEmailAdd','', false);
        errorMessage('spanAddressAdd','', false);
        errorMessage('spanCountyAdd','', false);
        errorMessage('spanTownAdd','', false);
        errorMessage('spanPhoneAdd','', false);
        errorMessage('spanPostcodeAdd','', false);
        errorMessage('spanWebsiteAdd','', false);
        errorMessage('spanIndustryAdd','', false);
        
        
        $('#myModalB').modal('show');
         setTimeout(function (){
             $("#txtBusinessNameAdd").focus();
             }, 600);
        
        $("#countrylist").html('');
        
        fillDropdownRegions('countrylist', 'country','');
        fillDropdownRegions('countylist', 'county','');
        fillDropdownRegions('townlist', 'town','');
        
        fillDropdownOrganisationIndustries('industrylist', '');
            
 }
 
/**
 * show popup preview with detailed complaints and responses 
 * @param integer id of complaint
  */ 
function previewComplaint(id){
var complaintid = parseInt(id);
var lastid = $('#lastid').val();
$('#showmoreresponse').hide();

var path = getBaseUrl()+'img/ajax-loader.gif';

             $.ajax({
                url: 'complaints.php?action=showpreviewcomplaint&complaintsid='+ complaintid +'&lastid='+lastid ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    
                    $('#complaintdate').html(data.date);
                    $('#complaintcompany').html(data.CompanyName);
                    $('#complainttitle').html(data.title);
                    $('#complaintcomplaint').html(data.complaint);
                    if (!CheckInternetExplorer())
                        checkReviewByVal('starpreview',data.review);
                    else
                        $("#reviewpreview").html(reviewText(data.review));
                    
                    if (data.responsesuccess){
                        
                        $('#responseheader').html('Responses');
                        $('#divresponse').html(data.response);
                            if (data.responserows < 3) {
                                $('#showmoreresponse').hide();
                            }else
                                $('#showmoreresponse').show();
                        
                    }else{
                        $('#lastidresponse').val(0); 
                        $('#lastidresponse').val(0); 
                        
                    }
                        $('#ModalPreviewComplaint').modal('show');
                        $('#lastidresponse').val(data.lastidresponse);
                        $('#lastidcomplaint').val(complaintid);
                    
                },
                    error: function(data) {
                     console.log(data)
                     $('#complaintcomplaint').html(data.complaint);
                     alert('error')
                }
                
            });
}
/**
 * call ajax function to show more responses in preview screen
 */
function showMoreResponse(){
var complaintid = $('#lastidcomplaint').val();
var lastid = $('#lastidresponse').val();

var path = getBaseUrl()+'img/ajax-loader.gif';
     
             $.ajax({
                url: 'complaints.php?action=showmoreresponse&complaintsid='+ complaintid +'&lastid='+lastid ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    if (data.responsesuccess){
                            $('#divresponse').append(data.response);
                            $('#lastidresponse').val(data.lastidresponse);
                            
                            if (data.responserows < 3) {
                                $('#showmoreresponse').hide();
                            }else
                                $('#showmoreresponse').show();
                        }else
                        {
                            $('#showmoreresponse').hide();
                            alert('No more responses');
                        }
                },
                    error: function(data) {
                     console.log(data)
                     alert('error response')
                }
                
            });
}

/**
 * call ajax function register a new business
 */
 function addB() {
        var name = $("#txtBusinessNameAdd").val().trim();
        var address = $("#address").val().trim();
        var city = $("#townlist").val();
        var country = $("#countrylist").val().trim();

        var phone = $("#phone").val().trim();
        var email = $("#email").val().trim();
        var countyid = $("#countylist").val();
        var website  = $("#website").val().trim();
        var postcode = $("#postcode").val().trim();
        var industryid = $("#industrylist").val();

        errorMessage('spanBusinessNameAdd','',false);
        errorMessage('spanIndustryAdd','',false);
        errorMessage('spanTownAdd','',false);
        errorMessage('spanCountyAdd','',false);
        errorMessage('spanEmailAdd','',false);
        errorMessage('spanWebsiteAdd','',false);
        errorMessage('spanPostcodeAdd','',false);

        
        if (name.length == 0 ){
            errorMessage('spanBusinessNameAdd','Field Business Name should not be blank', true);
            return false;
        }    
        
        if (industryid == 0 ){
            errorMessage('spanIndustryAdd','You must select a industry', true);
            return false;
        }    

        if (address.length == 0 ){
            errorMessage('spanAddressAdd','Field Address should not be blank', true);
            return false;
        }    
        
        if (city == 0 ){
            errorMessage('spanTownAdd','You must select a city', true);
            return false;
        }    
        
        if (countyid == 0 ){
            errorMessage('spanCountyAdd','You must select a city', true);
            return false;
        }          
        
                if (email != ""){
                    pattern = validEmail(email)
                    if (!pattern){
                    errorMessage('spanEmailAdd','Email is not valid!', true);
                    return false;
                    }
                }
                
                
                if ($('#txtValidCompany').val() == 0 ){
                       errorMessage('spanBusinessNameAdd','Company already registered', true);
                       return false;
                    }
                    
                url = website;
                if (url.length > 0){
                    valid = validUrl(url);
                    if (!valid){
                        errorMessage('spanWebsiteAdd','Website is not valid', true);
                        return false;
                    }    
                }   
				
                if (postcode.length > 0){
                    var validate = validatepostcode(postcode);
                    if (!validate) {
                      errorMessage('spanPostcodeAdd','Verify your postcode', true);
                      return false;
                    }
                }
                
                if (phone.length > 0){    
                    var validatenophone = validatephone(phone);
                    if (!validatenophone) {
                      errorMessage('spanPhoneAdd','Please, verify your phone', true);
                      return false;
                    }
                }	
                    
                $("#cmdAddBusiness").attr("disabled", "disabled");   
                var path = getBaseUrl()+'img/ajax-loader.gif';
                $("#ajaxiconaddbusiness").html('<img src="'+path +'"/>');
                
        
                        
                        $.ajax({
                        url: 'fun_jq.php',
                        type: 'POST',
                        global: false,
                        data: {action: 'addB', name: name, address: address, city: city, countryid: country, phone: phone, email: email, countyid: countyid, website:website, postcode: postcode, industryid:industryid  },
                        dataType: 'json',
                        error: function (data) {
                        $("#ajaxiconaddbusiness").html('');    
                        alert('Error saving business');
                        console.log(data);
                       },
                       success: function (data) {
                           if (data.success){
                            $("#ajaxiconaddbusiness").html('');
                            $("#cmdAddBusiness").removeAttr("disabled");
                            $('#myModalB').modal('hide');
                            $("#pmessages").html('Business saved');
                            $('#mgInformacion').modal('show');
                    
                            $('#myModalB').modal('hide');
                             window.location.href = "#who";
                             clearFieldsRegister();
                             $("#businessname").val(name);
                             $("#businesslist").html();
                             $("#exist").val(data['idBusiness']);

                            //set the values of twon region and country
                            $("#AddressBusinessReputation").html(data.Address);
                            $("#Address2BusinessReputation").html(data.Address2);
                            $("#TwonBusinessReputation").html(data.twon);
                            $("#CountybusinessReputation").html(data.county);
                            $("#RegionBusinessReputation").html(data.region);
                            $("#PostCodeBusinessReputation").html(data.Postcode);

                                //compare twon and region
                                if(data.region == data.twon ){
                                    $("#RegionbusinessReputation").css("visibility", "hidden")
                                }

                                // show rating complaints
                                $("#raitingvalues").attr("hidden", true);
                                $("#nocomplaintsbusiness").attr("hidden", false);
                                $("#detailsbusiness").attr("hidden", false);

                                //enable button next
                                $("#nextOne").attr("href", "#what");
                            }
                        }
            });
}

/**
 * set the radiobutton of reviews by value
 * @param string radiobutton name
 * @param string value of radiobutton to check
 */
function checkReviewByVal(selectorName, value){
    
    
    $('input[name='+selectorName+'][value="'+value+'"]').attr('checked', 'checked');
}

/**
 * Fill a dropdown with values of countries, cities, regions or towns
 * @param string selectorid of select control
 * @param string type = country, county, region or town
 * @param string value(optional) default value to select 
 */
function fillDropdownRegions(selectorid, type, value){
    var value = trim(String(value));
    switch (type) {
        
        case 'country':
             //LOAD LIST OF countries
            $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'countrylist'},
                dataType: 'json',
                error: function (data) {
                    alert('Error country list');
                },
                success: function (data) {
                    option = "";
                    for (var i in data) {
                        Country = data[i].Country;
                        CountryID = data[i].CountryID;
                        selected = ''
                        if (CountryID != 'undefined' && Country != 'undefined') {
                            if (CountryID.toLowerCase() == value.toLowerCase())
                                selected = "selected";
                            option = option + "<option value='" + CountryID + "' "+ selected+" >" + Country + "</option>";
                        }
                    }
                    $("#"+selectorid).html(option);
                     
                    
                }
            });
            break;
        case 'county':
            $("#"+selectorid).html('<option value="0">Select</option>');
            //LOAD LIST OF countys
            $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'countylist'},
                dataType: 'json',
                error: function (data) {
                    alert('Error county list');
                    console.log(data);
                },
                success: function (data) {
                    option = "";
                    for (var i in data) {
                        County = data[i].County;
                        CountyID = data[i].CountyID;
                        selected = "";
                        if (CountyID != 'undefined' && County != 'undefined') {
                            if (CountyID.toLowerCase() == value.toLowerCase() )
                                selected = "selected";
                            
                            option = option + "<option value='" + CountyID + "'"+ selected +" >" + County + "</option>";
                        }
                    }
                    $("#"+selectorid).append(option);
                }
            });
            break;
        case 'town':
        $("#"+selectorid).html('<option value="0">Select</option>');
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
                            if (TownID.toLowerCase() == value.toLowerCase())
                                selected = "selected";

                            option = option + "<option value='" + TownID + "'" + selected + " >" + Town + "</option>";
                        }
                    }
                    $("#"+selectorid).append(option);
                }
            });
            break;
        case 'region':
        $("#"+selectorid).html('<option value="0">Select</option>');
            //LOAD LIST OF countys
            $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'regionlist'},
                dataType: 'json',
                error: function (data) {
                    alert('Error loading town list');
                    console.log(data);
                },
                success: function (data) {
                    option = "";
                    for (var i in data) {
                        Region = data[i].Town;
                        RegionID = data[i].TownID;
                        selected = "";
                        if (RegionID != 'undefined' && Region != 'undefined') {
                            if (RegionID.toLowerCase() == value.toLowerCase())
                                selected = "selected";
                            
                            option = option + "<option value='" + RegionID + "'" + selected + ">" + Region + "</option>";
                        }
                    }
                    $("#"+selectorid).append(option);
                }
            });
            break;
    }
    
}

/**
 * call ajax function to check if a company name already exist
 * return boolean
 */
function checkCompanyName() {
    
    selectorId = '#txtBusinessName';
    selectorOrganisation = '#organisationid';
    spanSelector = '#spanBusinessNameregister';
    selectorValid = '#txtValidCompany';
    var companyName =  $(selectorId).val().trim();   
    var organisationid =  $(selectorOrganisation).val();   
    
    if (companyName.length == 0)
        return false;
    
    $.ajax({
            method  : 'POST',
            url     : 'subscription.php?action=checkcompanyname',
            data:$('#frmSubscription').serialize(), 
            dataType: 'json',
            error: function (data) {
                console.log(data);
            },
            success:function(data){
                if (!data.success ) {
                    errorMessage(spanSelector,'Business name already registered', true);
                    $(selectorValid).val(0);
                    $(selectorOrganisation).val(data.organisationID);   
                }else{
                    errorMessage(spanSelector,'', false);
                    $(selectorValid).val(1);
                }
            }
       });//end ajax 
}


function checkCompanyNameAddBussiness( ) {
    selectorId = '#txtBusinessNameAdd';
    selectorOrganisation = '#organisationid';
    spanSelector = '#spanBusinessNameAdd';
    selectorValid = '#txtValidCompany';
    var companyName =  $(selectorId).val().trim();   
    var organisationid =  0;   
    if (companyName.length == 0)
        return false;
    
    $.ajax({
            method  : 'POST',
            url     : 'subscription.php?action=checkcompanyname',
            data:$('#frmAddBusiness').serialize(), 
            dataType: 'json',
            error: function (data) {
                console.log(data);
            },
            success:function(data){
                if (!data.success ) {
                    errorMessage(spanSelector,'Business name already registered', true);
                    $(selectorValid).val(0);
                    $(selectorOrganisation).val(data.organisationID);   
                }else{
                    errorMessage(spanSelector,'', false);
                    $(selectorValid).val(1);
                }
            }
       });//end ajax 
}


/**
 * call ajax function to response a complaint made  by users
 * @param integer id of complaint
 */
function responseComplaint(id){
var complaintid = parseInt(id);
var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajax"+complaintid).html('<img src="'+path +'"/>');
     $('#broadcast'+complaintid).html('broadcasting');
             $.ajax({
                url: 'complaint.php?action=responsecomplaint&complaintsid='+ complaintid,
                type: "POST",
                
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $('#status'+complaintid).html(data.broadcast);
                        $("#imageajax"+complaintid).html('');
                        $('#broadcast'+complaintid).html('Broadcasted');
                        $('#actionlink'+complaintid).remove();                        
                    }                
                },
                error: function(data) {
                 console.log(data)
                 $("#imageajax"+complaintid).html('');
                  alert('An error occurred');
                }
            });
}

/**
 * call ajax function to send email on Contact Us screen
 */
function contactUs() {
    
    errorMessage('spanNameContact','', false);
    errorMessage('spanEmailContact','', false);
    errorMessage('spanMessageContact','', false);
    errorMessage('spanSubjectContact','', false);
    
    
    
    if (checkIfBlank('txtNameContact')){
        errorMessage('spanNameContact','Field name should not be blank', true);
        return false;
    }    
    
    if (checkIfBlank('txtEmailContact')){    
        errorMessage('spanEmailContact','Field E-mail should not be blank ', true);
        return false;
    }    
    

    var pattern = validEmail($('#txtEmailContact').val())
    if (!pattern){
        errorMessage('spanEmailContact','Email is not valid ', true);
        return false;
    }    
    
    if (checkIfBlank('txtSubjectContact')){    
        errorMessage('spanSubjectContact','Field Subject should not be blank ', true);
        return false;
    }    
    
    if (checkIfBlank('txtMessage')){    
        errorMessage('spanMessageContact','Field Subject should not be blank ', true);
        return false;
    }    
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      
        $("#ajaxiconcontact").html('<img src="'+path +'"/>');
        
         $("#cmdContact").attr("disabled", "disabled");   
                
         $.ajax({
                url: 'subscription.php?action=contact',
                type: "POST",
                data:$('#frmContact').serialize(),
                dataType: 'json',
                success:function(data){
                    if (data.success){  
                        $("#cmdContact").removeAttr("disabled");
                        $("#ajaxiconcontact").html('');
                        $("#pmessages").html('Email Sent Successfully');
                        $('#mgInformacion').modal('show');
                        $('#frmContact').trigger("reset");
                    }
                    else
                    {
                        $('#ajaxiconcontact').html('');
                        alert('An Error Ocurred');
                        
                    }
                },
                    error: function(data) {
                        console.log(data)
                        $('#ajaxiconcontact').html('');
                        alert('An Error Ocurred');
                        
                }
                
            });
    }

/**
 * show the list of business when user press a key
 * @param string id of input 
 * @param string id of selector to asign the id of the result business if the list is selected
 */
               
function businessList(selectorId, selectedId){  
    
    selectorId = '#'+selectorId;
    selectedId = '#'+selectedId;
    $(selectedId).val('')
    $( selectorId ).autocomplete({
      source: "fun_jq.php?action=businesslist",
      minLength: 2,
      select: function( event, ui ) {
          item = ui;
          event.preventDefault();
      $(selectorId).val(ui.item.CompanyName);
          $(selectedId).val(ui.item.Label);
      }
    });
}


/**
 * call ajax function to load the list of users on admin panel
 */
function showMoreUsers(){
    var lastid = $('#userlastid').val();
    var path = getBaseUrl()+'img/ajax-loader.gif';
    $('#usersshowmore').hide();    
      $("#ajaxiconmoreusers").html('<img src="'+path +'"/>');
    
             $.ajax({
                url: 'subscription.php?action=showmoreusers&lastid='+ parseInt(lastid),
                type: "POST",
                dataType: 'json',
                success:function(data){
                    
                    if (data.success){
                        $("#ajaxiconmoreusers").html('');
                        $('#showmoreusers').append(data.users);
                        $('#userlastid').val(data.lastid);
                        if (data.rows < 6) {
                            $('#usersshowmore').hide();
                        }else
                            $('#usersshowmore').show();
                        
                    }else
                    {
                        $('#usersshowmore').hide();
                        $("#ajaxiconmoreusers").html('');
                    }
                },
                    error: function(data) {
                     $("#ajaxiconmoreusers").html('');
                     alert('An error occurred load users');
                     console.log(data)
                }
                
            });
}

/**
 * call ajax function to load the list of business added by users  on admin panel
 */
function showMoreBusiness(){
    var lastid = parseInt($('#businesslastid').val());
    var path = getBaseUrl()+'img/ajax-loader.gif';
    $('#businessshowmore').hide();
    
      $("#ajaxiconmorebusiness").html('<img src="'+path +'"/>');
    
             $.ajax({
                url: 'subscription.php?action=showmorebusiness&lastid='+ parseInt(lastid),
                type: "POST",
                dataType: 'json',
                success:function(data){
                   if (data.success){
                        $("#ajaxiconmorebusiness").html('');
                        $('#showmorebusiness').append(data.business);
                        $('#businesslastid').val(data.lastid);
                        if (data.rows < 6) {
                            $('#businessshowmore').hide();
                        }else
                            $('#businessshowmore').show();
                        
                    }else
                    {
                        $('#businessshowmore').hide();
                        $("#ajaxiconmorebusiness").html('');
                    }
                },
                    error: function(data) {
                        alert('An error occurred load business list');
                        $("#ajaxiconmorebusiness").html('');
                        console.log(data)
             
                }
                
            });
}


/**
 * call ajax function to approve a business added by users
  */
function approveBusiness(id){
id = parseInt(id);

    $('#pmessagesconfirm').html('Are you sure that you want approve this business?');
    $('#mgConfirmation').modal('show');
    $("#btn_confirm").click(function(){

    var path = getBaseUrl()+'img/ajax-loader.gif';

      
     $("#imageajaxbusiness"+id).html('<img src="'+path +'"/>');
     $('#approvebusiness'+id).html('Processing... ');
     
             $.ajax({
                url: 'subscription.php?action=approvebusiness&organisationid='+ id,
                type: "POST",
                
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $("#imageajaxbusiness"+id).html('');
                        $("#status"+id).html('Approved');
                        $('#approvebusiness'+id).removeAttr("href");
                        $('#approvebusiness'+id).removeAttr("onclick");
                        $('#rejectbusiness'+id).remove();
                        $("#actionbusiness"+id).html('');
                    }
                    
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajaxbusiness"+id).html('');
                     alert('An error occurred');
                }
                
            });
        });            
}


/**
* call ajax function to reject a business from admin panel
*/
function rejectBusiness(id){
id = parseInt(id);

    $('#pmessagesconfirm').html('Are you sure that you want reject this business?');
    $('#mgConfirmation').modal('show');
    $("#btn_confirm").click(function(){


     var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajaxbusiness"+id).html('<img src="'+path +'"/>');

             $.ajax({
                url: 'subscription.php?action=rejectbusiness&organisationid='+ id,
                type: "POST",
                
                dataType: 'json',
                success:function(data){
                    $("#imageajaxbusiness"+id).html('');
                    $('#rejectbusiness'+id).html('Rejected');
                    $('#status'+id).html('Rejected');
                    $('#rejectbusiness'+id).remove();
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajaxbusiness"+id).html('');
                     alert('An error occurred');
                }
                
            });
    });            
}


/**
* call ajax function to block a user from admin panel
*/
function blockUser(id, block){
    id = parseInt(id);
    block = parseInt(block);
    var path = getBaseUrl()+'img/ajax-loader.gif';
      
     $("#imageajaxusers"+id).html('<img src="'+path +'"/>');
             $.ajax({
                url: 'subscription.php?action=blockuser&userid='+ id+'&block='+block,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    $("#imageajaxusers"+id).html('');
                    $('#blockuser'+id).removeAttr("onclick");
                    
                    if (block == 1){
                        block = 0;
                        $('#blockuser'+id).html('Unblock');
                        $('#statususer'+id).html('blocked');
                        
                    }else{
                        block = 1;
                        $('#blockuser'+id).html('Block');
                        $('#statususer'+id).html('active');
                        
                    }
                    $('#blockuser'+id).attr('onclick','blockUser('+id+','+block+')');
                },
                    error: function(data) {
                     console.log(data)
                     $("#imageajaxusers"+id).html('');
                     alert('An error occurred');
                }
                
            });
}

/**
* call ajax function to delete a user from admin panel
*/
function deleteUser(id){
id = parseInt(id);

$('#pmessagesconfirm').html('Are you sure that you want delete this user?');
$('#mgConfirmation').modal('show');

$("#btn_confirm").click(function(){
    var path = getBaseUrl()+'img/ajax-loader.gif';

         $("#imageajaxusers"+id).html('<img src="'+path +'"/>');
                 $.ajax({
                    url: 'subscription.php?action=deleteuser&userid='+ id,
                    type: "POST",
                    dataType: 'json',
                    success:function(data){
                        $("#imageajaxusers"+id).html('');
                        $('#usersrow'+id).remove();
                    },
                        error: function(data) {
                         console.log(data)
                         $("#imageajaxusers"+id).html('');
                        alert('An error occurred');
                    }

                });
        });            
}


/**
 * show popup to edit business field from admin panel
 * @param integer organisation id
*/ 
function showEditBusiness(id){
 id = parseInt(id);
 
 errorMessage('spanBusinessName','',false); 
 errorMessage('spanIndustryEdit','',false); 
 errorMessage('spanStreetregister','',false); 
 errorMessage('spanCity','',false); 
 errorMessage('spanCounty','',false); 
 errorMessage('spanPostalregister','',false);  
 errorMessage('spanContactEmail','',false);  
 errorMessage('spanWebsite','',false);  


var path = getBaseUrl()+'img/ajax-loader.gif';

             $.ajax({
                url: 'subscription.php?action=getneworganisation&organisationid='+ id ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    console.log(data)
                    if (data.success){
                        $('#txtBusinessName').val(data.CompanyName)
                        $('#txtStreet').val(data.Address)
                        $('#town').val(data.TownID)
                        $('#county').val(data.CountryID)
                        $('#txtPostal').val(data.Postcode)
                        $('#country').val(data.CountryID)
                        $('#txtContactName').val(data.ContactFullName)
                        $('#txtPhone').val(data.TelephoneNumber)
                        $('#txtWebsite').val(data.WebsiteAddress)
                        $('#organisationid').val(data.organisationID);
                        $('#txtContactEmail').val(data.EmailAddresses);
                        $('#organisationtype').val('n');
                        $("#cmdUpdateOrganisation").removeAttr("onclick");
                        $("#cmdUpdateOrganisation").attr('onclick',"updateNewOrganisation()");
                        
                        fillDropdownRegions('countrylistregister', 'country', data.CountryID);
                        fillDropdownRegions('countylistregister', 'county', data.CountyID);
                        fillDropdownRegions('townlistregister', 'town',data.TownID);
                        
                        fillDropdownOrganisationIndustries('industrylistedit', data.IndustryID);
                        
                        
                        $('#modalBusiness').modal('show');
                    
                    }else{
                        alert('no organisation')
                    }
                },
                    error: function(data) {
                     console.log(data)
                     alert('error showing business edit')
                }
            });
}


/**
 * call ajax function to update field of neworganisations table
 */
function updateNewOrganisation(){
   id = $('#organisationid').val();
   $('#spanBusinessname').removeClass();
   $('#spanContactemail').removeClass();
   
   var address = $('#txtStreet').val().trim();
   var businessName =  $('#txtBusinessName').val().trim();

   
    pattern = validEmail($('#txtContactEmail').val())
    
 errorMessage('spanBusinessName','',false); 
 errorMessage('spanIndustryEdit','',false); 
 errorMessage('spanStreetregister','',false); 
 errorMessage('spanCity','',false); 
 errorMessage('spanCounty','',false); 
 errorMessage('spanPostalregister','',false);  
 errorMessage('spanContactEmail','',false);  
 errorMessage('spanWebsite','',false);      
    
    if(checkIfBlank('txtBusinessName')){
        errorMessage('spanBusinessName','Field Business Name should not be blank', true);
        return false;
    }    
    
    if ($('#townlistregister').val()  == 0){
        errorMessage('spanCity','You must select a city', true);
        return false;
    }    
    
    if ($('#countylistregister').val()  == 0){
        errorMessage('spanCounty','You must select a county', true);
        return false;
    }    
    
    if ($('#industrylistedit').val() == 0){
            errorMessage('spanIndustryEdit','You must select a industry', true);
            return false;
    } 
    
    if(checkIfBlank('txtStreet')){
        errorMessage('spanStreetregister','Field Street Address should not be blank', true);
        return false;
    }    
    
    
    
    if (!pattern && $('#txtContactEmail').val().length > 0 ){
        errorMessage('spanContactEmail','Email not valid!', true);
        return false;
    }  
    
    
    if ($('#txtValid').val()  == 0 ){
        errorMessage('spanContactEmail','Email is not valid or already registered', true);
        return false;
    }    
    
    var postcode = $('#txtPostal').val().trim();
    if (postcode.length > 0){
        var validate = validatepostcode(postcode);

        if (!validate) {
            errorMessage('spanPostalregister','Postal Code is not valid', true);
            return false;
        }
    }
    
    var phone = $('#txtPhone').val().trim();
    if (phone.length > 0){    
        var validatenophone = validatephone(phone);
        if (!validatenophone) {
            errorMessage('spanPhoneregister','Phone Number is not valid', true);
            return false;
        }
    }	
    
    
    url = $('#txtWebsite').val().trim();
    if (url.length > 0){
        valid = validUrl(url);
        if (!valid){
            errorMessage('spanWebsite','Website is not valid', true);
            return false;
        }    
    }
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      
      $("#ajaxiconsubscription").html('<img src="'+path +'"/>');
      
      $("#cmdUpdateSubscription").attr("disabled", "disabled");   
        
        $.ajax({
                url: 'subscription.php?action=updateneworganisation&organisationid='+id,
                type: "POST",
                data:$('#frmSubscription').serialize(),
                dataType: 'json',
                success:function(data){
                    
                    $("#cmdUpdateSubscription").removeAttr("disabled");
                    $("#ajaxiconsubscription").html('');
                    $("#namebusiness"+id).html(businessName);
                    $("#addressbusiness"+id).html(address);
                    $('#modalBusiness').modal('hide')
                    $("#pmessages").html('Updated Successfully');
                    $('#mgInformacion').modal('show');
                },
                    error: function(data) {
                     console.log(data)
                    $("#ajaxiconsubscription").html('');
                    alert('An error occurred');
                }
                
            });
}


/**
* show popup to edit business field from admin panel
* @param integer organisation id
*/ 
function showEditUser(id, usertype){
 id = parseInt(id);
 
var path = getBaseUrl()+'img/ajax-loader.gif';

             $.ajax({
                url: 'subscription.php?action=getuser&userid='+ id ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        if (usertype == 'b'){
                            
                            $('#txtBusinessNameEdit').val(data.CompanyName);
                            $('#txtStreetEdit').val(data.Address);
                            $('#town').val(data.TownID);
                            $('#county').val(data.CountryID);
                            $('#txtPostalEdit').val(data.Postcode);
                            $('#country').val(data.CountryID);
                            $('#txtContactNameEdit').val(data.ContactFullName);
                            $('#txtPhoneEdit').val(data.TelephoneNumber);
                            $('#txtWebsiteEdit').val(data.WebsiteAddress);
                            $('#organisationid').val(data.organisationID);
                            $('#txtContactEmailEdit').val(data.EmailAddresses);
                            $('#useridbusinessedit').val(id);
                            $('#organisationidedit').val(data.organisationID);
                            $('#emailrecoverbusiness').val(data.EmailAddresses);
                            
                            fillDropdownRegions('countrylistregisterEdit', 'country', data.CountryID);
                            fillDropdownRegions('countylistregisterEdit', 'county', data.CountyID);
                            fillDropdownRegions('townlistregisterEdit', 'town',data.TownID);
                            
                            fillDropdownOrganisationIndustries('industrylistedits',data.IndustryID)
                            
                            $('#modalUserBusiness').modal('show');
                        }else{
                            $('#txtNameUser').val(data.name);
                            $('#txtUserEmail').val(data.email);
                            $('#useridedit').val(id);
                            $('#txtCity').val(data.usercity);
                            $('#emailrecoveruser').val(data.email);
                            $('#modalUser').modal('show');
                            
                        }
                                                
                    }else{
                        alert('no organisation')
                    }
                },
                error: function(data) {
                 console.log(data)
                 alert('error showing business edit')
                }
            });
}

/**
 * call ajax function to update a user in edit screen from admin panel
 * @param string usertype = u user, b = business user 
 */

function updateEditUser(usertype){

      if (usertype == 'u'){
            url = 'subscription.php?action=updateuseredit';   
            form = '#frmUserEdit'; 
            ajaxicon = '#ajaxiconuseredit';
            modal = '#modalUser';
          
            pattern = validEmail($('#txtUserEmail').val().trim())
            
            if(checkIfBlank('txtNameUser')){
                errorMessage('spanNameUser','Field Name should not be blank', true);
                return false;
            }    

            if(checkIfBlank('txtUserEmail')){
                errorMessage('spanEmailUser','Field E-mail should not be blank', true);
                return false;
            }    

            if (!pattern){
                errorMessage('spanEmailUser','Email not valid!', true);
                return false;
            }  
                
            if ($('#txtValidUser').val()  == 0 ){
                errorMessage('spanEmailUser','Email is not valid or already registered!', true);
                return false;
            }    
      }
      else{
          url = 'subscription.php?action=updateuserbusinessedit';   
          form = '#frmUserBusinessEdit'; 
          ajaxicon = '#ajaxiconuserbusinessedit';
          modal = '#modalUserBusiness';
          
          pattern = validEmail($('#txtContactEmailEdit').val())
          
            if ($('#txtBusinessNameEdit').val().length == 0 ){
                errorMessage('spanBusinessNameEdit','Field Business Name should not be blank', true);
                return false;
            }    
            
            if ($('#industrylistedits').val() == 0 ){
                errorMessage('spanIndustryEdits','You must select a Industry', true);
                return false;
            }    
            
            if ($('#countylistregisterEdit').val() == 0 ){
                errorMessage('spanCountyEdit','You must select a county', true);
                return false;
            }    

            if ($('#townlistregisterEdit').val() == 0 ){
                errorMessage('spanCityEdit','You must select a city', true);
                return false;
            }    
            
            if ($('#txtContactEmailEdit').val().length == 0 ){
                errorMessage('spanContactEmailEdit','Field Contact Email should not be blank', true);
                return false;
            }    
            
            if (!pattern){
                errorMessage('spanContactEmailEdit','Email not valid!', true);
                return false;
            }  
            
            website = $('#txtWebsiteEdit').val();
            if (website.length > 0){
                valid = validUrl(website);
                if (!valid){
                   errorMessage('spanWebsiteEdit','Website is not valid', true);
                    return false;
                }    
            }              
                
                
        var postcode = $('#txtPostalEdit').val().trim();
            if (postcode.length > 0){
                var validate = validatepostcode(postcode);
                if (!validate) {
                    errorMessage('spanPostalEdit','Postal Code is not valid', true);
                    return false;
                }
            }
    
        var phone = $('#txtPhoneEdit').val().trim();
        if (phone.length > 0){    
            var validatenophone = validatephone(phone);
            if (!validatenophone) {
                errorMessage('spanPhoneEdit','Phone Number is not valid', true);
                return false;
            }
        }                    
                
                
        if ($('#txtValidUserBusiness').val()  == 0 ){
            errorMessage('spanContactEmailEdit','Email is not valid or already registered!', true);
            return false;
        }    
          
      }
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
        
      $(ajaxicon).html('<img src="'+path +'"/>');
        
        $.ajax({
                url: url,
                type: "POST",
                data:$(form).serialize(),
                dataType: 'json',
                success:function(data){
                    $(ajaxicon).html(''); 
                    $("#pmessages").html('Updated Successfully');
                    $(modal).modal('hide');
                    $('#mgInformacion').modal('show');
                    
                    $("#myBtn").click(function(){
                   });
                },
                    error: function(data) {
                     console.log(data)
                     $(ajaxicon).html('');
                     alert('An error occurred');
                }
            });
}


/**
 * call ajax function to check, when email is changed is not registered by another user in edit user in panel admin
 * @param integer usertype u = user, b = user business  
 * @return boolean
 */
function UserEditEmailChange(usertype) {
    var selectorEmail;    
    var selectorSpan;
    var selectorValid;
    var userId;
    
    if (usertype == 'u'){
        form = '#frmUserEdit';
        selectorEmail = '#txtUserEmail';
        selectorSpan = '#spanEmailUser';
        selectorValid = '#txtValidUser';
        userId  = $('#useridedit').val();
        
    }
    else{
        form = '#frmUserBusinessEdit';
        selectorEmail = '#txtContactEmailEdit';
        selectorSpan = '#spanContactEmailEdit';
        selectorValid = '#txtValidUserBusiness';
        userId  = $('#useridbusinessedit').val(); 
        
    }
    
    email = $(selectorEmail).val().trim();
    
    var pattern = validEmail(email);
   
    if (email.length == 0 || !pattern)
        return false;
       
    $(selectorEmail).removeClass();
    
    $.ajax({
                url: 'subscription.php?action=subscriptionemailchange&email='+email+'&userid='+userId,
                type: "POST",
                data:$(form).serialize(),
                dataType: 'json',
                success:function(data){
                    if (!data.success){
                        errorMessage(selectorSpan,'Email already registered' , true)
                        $(selectorValid).val(0);
                    }else{
                         errorMessage(selectorSpan,'' , false)
                         $(selectorValid).val(1);
                    }
                },
                    error: function(data) {
                        console.log(data)
                        alert('An error occurred');
                    }
                
            });
}  


/**
 * show popup to response a complaint from admin panel of business user
 * @param integer complaint id
*/ 
function showResponse(id){
 $('#frmResponse').trigger("reset");
 id = parseInt(id);
             $.ajax({
                url: 'complaints.php?action=getcomplaint&complaintsid='+ id ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $('#complaintid').val(data.complaintsid)
                        $('#rcomplaintdate').html(data.date);
                        $('#rcomplainttitle').html(data.title);
                        $('#rcomplaintcomplaint').html(data.complaint);
                        $('#rcomplaintuseremail').html(data.email);
                        $('#emailcomplainer').val(data.email);
                        $('#titlecomplaint').val(data.title);
                        if (!CheckInternetExplorer())
                            checkReviewByVal('starpreview',data.review);                        
                        else
                            $("#reviewresponse").html(reviewText(data.review));
                        
                        
                        $('#modalResponse').modal('show');
                        
                    }else{
                        alert('no organisation')
                    }
                },
                    error: function(data) {
                     console.log(data)
             alert('error showing business edit')
                }
            });
}

/**
 * call ajax function toinsert a response made by userbusiness
 */
function insertResponse() {
    
    if(checkIfBlank('txtMessageResponse')){
        errorMessage('spanMessageResponse','Field Message should not be blank', true);
        return false;
    }    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
        $("#ajaxiconresponse").html('<img src="'+path +'"/>');
        console.log($('#uploadbtn').prop('files')); 
         $("#cmdResponse").attr("disabled", "disabled");   
         $("#txtFile").removeAttr("disabled");
        
         $.ajax({
                 url: 'complaints.php?action=insertresponse',
                type: "POST",
                data:$('#frmResponse').serialize(),
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $("#cmdResponse").removeAttr("disabled");
                        $("#txtFile").attr("disabled", "disabled");   
                        $("#ajaxiconresponse").html('');
                        $("#pmessages").html('Response Sent Successfully');
                        $('#modalResponse').modal('hide');
                        $('#mgInformacion').modal('show');
                        $("#responded"+data.complaintsid).html('Yes');
                    }
                    else
                    {
                        $("#cmdResponse").removeAttr("disabled");
                        $('#ajaxiconresponse').html('');
                        alert('An Error Ocurred');
                        
                    }
                },
                    error: function(data) {
                        console.log(data)
                        $("#ajaxiconresponse").html('');
                        alert('An Error Ocurred');
                        
                }
                
            });
    }

/**
 * call ajax function toinsert a response made by userbusiness
 */
function ResetPasswordEditUser(usertype) {
  if (usertype == 'b'){
    selector = '#emailrecoverbusiness';
    ajaxicon = '#ajaxiconuserbusinessedit';
    resetbutton = 'cmdResetUser';
    formuser = 'frmUserBusinessEdit';
  }
  else{
    selector = '#emailrecoveruser';
    ajaxicon = '#ajaxiconuseredit';
    resetbutton = 'cmdResetBusinessUser';
    formuser = 'frmUserEdit';
  }
    
  email = $(selector).val();
  
  if (email.lenght == 0){
      alert('Email is no valid!');
      return false;
  }
  
  
    var op = confirm("Are you sure that you want reset the password of this user?");
    if (op == true)
    {
               var path = getBaseUrl()+'img/ajax-loader.gif';
               $(ajaxicon).html('<img src="'+path +'"/>');

               $(resetbutton).attr("disabled", "disabled");   

                  $.ajax({
                     url: 'subscription.php?action=resetpasswordpaneladmin&email='+email,
                     type: "POST",
                     data:$(formuser).serialize(),
                     dataType: 'json',
                     success:function(data){

                        $(ajaxicon).html('');

                        $(resetbutton).removeAttr("disabled");

                         if (data.success){
                             alert('Email was sent to user ');
                             
                         }else{
                             alert('Email is not registered');
                         }
                     },
                         error: function(data) {
                          console.log(data)
                          $(ajaxicon).html('');
                          $(resetbutton).removeAttr("disabled");
                          alert('An error occurred');
                     }
                 });
    }    
}


/**
 * call ajax function to delete a organisation in neworganisations table before approval
  */
function deleteBusiness(id){
    id = parseInt(id);
      
    $('#pmessagesconfirm').html('Are you sure that you want delete this business?');
    $('#mgConfirmation').modal('show');
    $("#btn_confirm").click(function(){
                     
        var path = getBaseUrl()+'img/ajax-loader.gif';

        $("#imageajaxbusiness"+id).html('<img src="'+path +'"/>');

                $.ajax({
                   url: 'subscription.php?action=deletebusiness&organisationid='+ id,
                   type: "POST",

                   dataType: 'json',
                   success:function(data){
                       $('#businessrow'+id).remove();
                       $("#imageajaxbusiness"+id).html('');
                   },
                       error: function(data) {
                        console.log(data)
                        $("#imageajaxbusiness"+id).html('');
                        alert('An error occurred');
                   }

               });
    });
    }    


/**
 * call ajax function to load the list of organisation that already registered in organisations table on admin panel
 */
function showMoreOrganisations(){
    var lastid = parseInt($('#organisationlastid').val());
    var path = getBaseUrl()+'img/ajax-loader.gif';
    $('#orgsanisationshowmore').hide();
    
      $("#ajaxiconmoreorganisation").html('<img src="'+path +'"/>');
    
             $.ajax({
                url: 'subscription.php?action=showmoreorganisations&lastid='+ parseInt(lastid),
                type: "POST",
                dataType: 'json',
                success:function(data){
                   if (data.success){
                        $("#ajaxiconmoreorganisation").html('');
                        $('#showmoreorganisations').append(data.business);
                        $('#organisationlastid').val(data.lastid);
                        if (data.rows < 6) {
                            $('#organisationshowmore').hide();
                        }else
                            $('#organisationshowmore').show();
                        
                    }else
                    {
                        $('#ajaxiconmoreorganisation').hide();
                        $("#ajaxiconmoreorganisations").html('');
                    }
                },
                    error: function(data) {
                        alert('An error occurred load organisations list');
                        $("#ajaxiconmoreorganisation").html('');
                        console.log(data)
             
                }
                
            });
}


/**
 * call ajax function to delete a organisation in neworganisations table before approval
  */
function deleteOrganisation(id){
        id = parseInt(id);
        
        $('#pmessagesconfirm').html('Are you sure that you want delete this business?');
        $('#mgConfirmation').modal('show');
        
        $("#btn_confirm").click(function(){

            var path = getBaseUrl()+'img/ajax-loader.gif';

            $("#imageajaxorganisation"+id).html('<img src="'+path +'"/>');

                    $.ajax({
                       url: 'subscription.php?action=deleteorganisation&organisationid='+ id,
                       type: "POST",

                       dataType: 'json',
                       success:function(data){
                           $('#organisationrow'+id).remove();
                           $("#imageajaxorganisation"+id).html('');
                       },
                           error: function(data) {
                            console.log(data)
                            $("#imageajaxorganisation"+id).html('');
                            alert('An error occurred');
                       }

                   });
        });            
}



/**
 * show popup to edit organisation field from admin panel
 * @param integer organisation id
*/ 
function showEditOrganisation(id){
 id = parseInt(id);
 $('#frmSubscription').trigger("reset");
 
 errorMessage('spanBusinessName','',false); 
 errorMessage('spanIndustryEdit','',false); 
 errorMessage('spanStreetregister','',false); 
 errorMessage('spanCity','',false); 
 errorMessage('spanCounty','',false); 
 errorMessage('spanPostalregister','',false);  
 errorMessage('spanContactEmail','',false);  
 errorMessage('spanWebsite','',false);  

var path = getBaseUrl()+'img/ajax-loader.gif';
    
             $.ajax({
                url: 'subscription.php?action=getorganisation&organisationid='+ id ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    console.log(data)
                    if (data.success){
                        $('#txtBusinessName').val(data.CompanyName)
                        $('#txtStreet').val(data.Address)
                        $('#town').val(data.TownID)
                        $('#county').val(data.CountryID)
                        $('#txtPostal').val(data.Postcode)
                        $('#country').val(data.CountryID)
                        $('#txtContactName').val(data.ContactFullName)
                        $('#txtPhone').val(data.TelephoneNumber)
                        $('#txtWebsite').val(data.WebsiteAddress)
                        $('#organisationid').val(data.organisationID);
                        $('#txtContactEmail').val(data.EmailAddresses);
                        $('#organisationtype').val('o');
                        fillDropdownRegions('countrylistregister', 'country', data.CountryID);
                        fillDropdownRegions('countylistregister', 'county', data.CountyID);
                        fillDropdownRegions('townlistregister', 'town',data.TownID);
                        
                        fillDropdownOrganisationIndustries('industrylistedit', data.IndustryID);
                        
                        $("#cmdUpdateOrganisation").removeAttr("onclick");
                        $("#cmdUpdateOrganisation").attr('onclick',"updateOrganisation()");

                        
                        $('#modalBusiness').modal('show');
                        
                    }else{
                        alert('no organisation')
                    }
                },
                    error: function(data) {
                     console.log(data)
                     alert('error showing organisation edit')
                    }
            });
}


/**
 * call ajax function to update field of neworganisations table
 */
function updateOrganisation(){
    
   id = $('#organisationid').val();
   
   $('#spanBusinessname').removeClass();
   $('#spanContactemail').removeClass();
   
 errorMessage('spanBusinessName','',false); 
 errorMessage('spanIndustryEdit','',false); 
 errorMessage('spanStreetregister','',false); 
 errorMessage('spanCity','',false); 
 errorMessage('spanCounty','',false); 
 errorMessage('spanPostalregister','',false);  
 errorMessage('spanContactEmail','',false);  
 errorMessage('spanWebsite','',false);   
   
   var cityName = $('#townlistregister option:selected').html();
   var address = $('#txtStreet').val().trim();
   var businessName =  $('#txtBusinessName').val().trim();

    pattern = validEmail($('#txtContactEmail').val())
    
    if(checkIfBlank('txtBusinessName')){
        errorMessage('spanBusinessName','Field Business Name should not be blank', true);
        return false;
    }    
    
    if ($('#townlistregister').val()  == 0){
        errorMessage('spanCity','You must select a city', true);
        return false;
    }    
    
    if ($('#countylistregister').val()  == 0){
        errorMessage('spanCounty','You must select a county', true);
        return false;
    }    
    
    
    if ($('#industrylistedit').val() == 0){
            errorMessage('spanIndustryEdit','You must select a industry', true);
            return false;
    } 
     
    if (address.length == 0 ){
            errorMessage('spanStreetregister','Field Address Should not be blank', true);
            return false;
    }    
    
    if (!pattern && $('#txtContactEmail').val().length > 0){
        errorMessage('spanContactEmail','Email not valid!', true);
        return false;
    }  
    
    if ($('#txtValid').val()  == 0 ){
            errorMessage('spanContactEmail','Email is not valid or already registered', true);
        return false;
    }    
    
    var postcode = $('#txtPostal').val().trim();
    if (postcode.length > 0){
        var validate = validatepostcode(postcode);
        if (!validate) {
            errorMessage('spanPostalregister','Postal Code is not valid', true);
            return false;
        }
    }
    
    var phone = $('#txtPhone').val().trim();
    if (phone.length > 0){    
        var validatenophone = validatephone(phone);
        if (!validatenophone) {
            errorMessage('spanPhoneregister','Phone Number is not valid', true);
            return false;
        }
    }	
    
    
    url = $('#txtWebsite').val().trim();
    if (url.length > 0){
        valid = validUrl(url);
        if (!valid){
            errorMessage('spanWebsite','Website is not valid', true);
            return false;
        }    
    }
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      
      $("#ajaxiconsubscription").html('<img src="'+path +'"/>');
      
      $("#cmdUpdateSubscription").attr("disabled", "disabled");   
        
        $.ajax({
                url: 'subscription.php?action=updateorganisation&organisationid='+id,
                type: "POST",
                data:$('#frmSubscription').serialize(),
                dataType: 'json',
                success:function(data){
                    $("#cmdUpdateSubscription").removeAttr("disabled");
                    $("#ajaxiconsubscription").html('');
                    $('#nameorganisation'+id).html(businessName);
                    $('#addressorganisation'+id).html(address);
                    $('#townorganisation'+id).html(cityName);
                    
                    $('#modalBusiness').modal('hide')
                    $("#pmessages").html('Updated Successfully');
                    $('#mgInformacion').modal('show');
                },
                    error: function(data) {
                     console.log(data)
                    $("#ajaxiconsubscription").html('');
                    alert('An error occurred');
                }
                
            });
}


/**
 * show popup preview with business payment
 * @param integer organisation id 
 * @param string type c = payments details with creditcard, p = payments agreements with paypal
 * 
  */ 
function showPaymentDetails(id, type){
var path = getBaseUrl()+'img/ajax-loader.gif';
$("#imageajaxiconpayment"+id).html('<img src="'+path +'" class = "ajaxiconpayment"/>');
        
    if (type == 'c'){
                     $.ajax({
                        url: 'payments.php?action=showpaymentdetails&organisationid='+ id,
                        type: "POST",
                        dataType: 'json',
                        success:function(data){
                            $('#paymentdate').html(data.paymentdate);
                            $('#paymentpaymentid').html(data.paymentid);
                            $('#paymentstatus').html(data.status);
                            $('#paymentvalue').html(data.amount +' '+ data.currency);
                            $('#paymentnextpayment').html(data.nextpaymentdate);
                            $('#ModalPreviewPayment').modal('show');
                            $("#imageajaxiconpayment"+id).html('');

                        },
                            error: function(data) {
                             console.log(data)
                             $("#imageajaxiconpayment"+id).html('');
                             alert('error')
                        }
                    });
        }
    
    
    if (type == 'p'){
                     $.ajax({
                        url: 'payments.php?action=showagreementdetails&agreementid='+ id,
                        type: "POST",
                        dataType: 'json',
                        success:function(data){
                            $('#agreementdate').html(data.start_date);
                            $('#agreementpaymentid').html(data.agreementid);
                            $('#agreementstatus').html(data.state);
                            $('#agreementvalue').html(data.value +' '+ data.currency);
                            $('#agreementnextpayment').html(data.next_billing_date);
                            $('#ModalPreviewPaymentAgreement').modal('show');
                            $("#imageajaxiconpayment"+id).html('');

                        },
                            error: function(data) {
                             console.log(data)
                             $("#imageajaxiconpayment"+id).html('');
                             alert('error')
                        }
                    });
        }
   
}    
    
    
    
        

/**
 * Fill a dropdown with values of industries
 * @param string selectorid of select control
 * @param string value(optional) default value to select 
 */
function fillDropdownOrganisationIndustries(selectorid, value){
    var value = trim(String(value));             
            $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'industrylist'},
                dataType: 'json',
                error: function (data) {
                    alert('Error insdustry list');
                },
                success: function (data) {
                    option = "<option value = '0'>Select</option>";
                    for (var i in data) {
                        Industry = data[i].Industry;
                        IndustryID = data[i].IndustryID;
                        selected = ''
                        if (IndustryID != 'undefined' && Industry != 'undefined') {
                            if (IndustryID.toLowerCase() == value.toLowerCase())
                                selected = "selected";
                            option = option + "<option value='" + IndustryID + "' "+ selected+" >" + Industry + "</option>";
                        }
                    }
                    $("#"+selectorid).html(option);
                    
                }
            });
}


/**
 * Show screem to send a email for a formal complaint to a business
 * @param integer complaintid id
 */

function showEmailLetter(id){
    
    
$('#frmSendletter').trigger("reset");
 id = parseInt(id);
 
var path = getBaseUrl()+'img/ajax-loader.gif';
    $("#imageajax"+id).html('<img src="'+path +'"/>');
 
             $.ajax({
                url: 'complaints.php?action=showsendletter&complaintsid='+ id ,
                type: "POST",
                dataType: 'json',
                success:function(data){
                    if (data.success){
                        $('#txtEmailBusiness').val(data.EmailAddresses);
                        $('#txtSubjectLetter').val('Formal Complaint');
                        $('#txtMessageLetter').val(data.body);
                        $('#ModalSendLetter').modal('show');
                        $("#imageajax"+id).html('');
                        
                    }else{
                        $("#imageajax"+id).html('');
                        alert('no organisation')
                    }
                },
                    error: function(data) {
                      console.log(data)
                      alert('error showing business edit')
                    }
            });    
    
    
    
}

/**
 * call ajax function to send letter for a formal complaint
 */
function sendLetter() {
    if(checkIfBlank('txtEmailBusiness')){
        errorMessage('spanEmailBusiness','Field E-mail should not be blank ', true);
        return false;
    }    
    
    if(checkIfBlank('txtSubjectLetter')){
        errorMessage('spanSubjectLetter','Field Subject should not be blank', true);
        return false;
    }    

    var pattern = validEmail($('#txtEmailBusiness').val())
    if (!pattern){
        errorMessage('spanEmailBusiness','Email is not valid ', true);
        return false;
    }    
    
    if(checkIfBlank('txtMessageLetter')){
        errorMessage('spanMessageLetter','Field Message should not be blank ', true);
        return false;
    }    
    
      var path = getBaseUrl()+'img/ajax-loader.gif';
      
      
        $("#ajaxiconletter").html('<img src="'+path +'"/>');
        
         $("#cmdSendLetter").attr("disabled", "disabled");   
                
         $.ajax({
                url: 'complaints.php?action=sendletter',
                type: "POST",
                data:$('#frmSendletter').serialize(),
                dataType: 'json',
                success:function(data){
                    if (data.success){  
                        $('#ModalSendLetter').modal('hide');
                        $("#cmdSendLetter").removeAttr("disabled");
                        $("#ajaxiconletter").html('');
                        $("#pmessages").html('Email Sent Successfully');
                        $('#mgInformacion').modal('show');
                        $('#frmSendletter').trigger("reset");
                    }
                    else
                    {
                        $("#cmdSendLetter").removeAttr("disabled");
                        $("#ajaxiconletter").html('');
                        alert('An Error Ocurred');
                        
                    }
                },
                    error: function(data) {
                        $("#cmdSendLetter").removeAttr("disabled");
                        $("#ajaxiconletter").html('');
                        alert('An Error Ocurred');
                        console.log(data)
                }
                
            });
    }
    
    
/**
 * Show modal Social Media Login
 * @param string type of screen to show  type = "f" = facebook, type = "g" = gmail;
 */
 function showSocialMedia(type){
    $('#registerlogin').hide();
    $('#modalLoginTitle').html('User Login'); 
    if (type == 'f'){
        $('#loginfb').modal('show');
              setTimeout(function (){
                $("#username_f").focus();
             }, 600);

    }
    
    if (type == 'g'){
        $('#logingplus').modal('show');
             setTimeout(function (){
                $("#username_g").focus();
             }, 600);

    }
 
 }    
 
 
 function showPopupMessage(msg){
    $("#pmessages").html(msg);
    $('#mgInformacion').modal('show');
 }
 
    /**
     * Functions developed by Delstone Services, LTD
     * Carlos Parra -> parraparicio@gmail.com
     * Henry Leon -> Helg18@gmail.com
     *
     * 
     */