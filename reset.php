<?php 
$title = "Reset Password";
   include_once("header.php");
   
?>

<body onload="$('#txtEmailRecover').focus();">

    <div id="payment" class="section_article medium" >
            <h1 class="title_page">Reset your <em>password</em></h1>
            
                <form role="form" method="post" name="frmReset" id="frmReset" accept-charset="utf-8" style="text-align:left;" >
                   <div class="formsubscriber">
                       <div class = "labelform">EMAIL*</div>
                           <div class = "controlform" >
                                <input type = "text" name="txtEmailRecover" id="txtEmailRecover" class="inputform" alt="Enter your email here" onclick="clearresetfield(); return false;" >
                                <div class = "messagesform"><span id = "spanEmailRecover" style="width: 100%; float: left;"></span></div>
                           </div>
					<div id= "ajaxiconpassword" class="ajaxicon" style = 'margin-left: 20%'>
										
					</div>					   
                   </div>
                </form>    
        <div class="formsubscriber" style=" text-align: center !important">
            <a id = "cmdResetPassword" href="#" onclick = "ResetPassword()" class="button button-next"><span>Send</span></a>
        </div>
     </div>   

<?php 
   include_once("footer.php");
?>
	 
     
    
<script>
    $("#txtEmailRecover").keypress(function(event){ 
      if (event.which == 13) { 
        if ($("#txtEmailRecover").val().length > 7 ) {
          ResetPassword();
          return true;
        }
        else
        {
          return false;
        }
      } //end event.which
    });


    $( document ).ready(function() {
        removeErrorMessage('txtEmailRecover', 'spanEmailRecover');
    });

    function clearresetfield(){
      $('#spanEmailRecover').html("");
      $('#spanEmailRecover').removeClass('error-messages ng-active');

    }
   
</script>    
</body>
</html>
