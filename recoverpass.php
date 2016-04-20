<?php 
    include_once("db.php");
    if (!isset($_GET['id'])){
        header('Location:index.php');
        exit();
    }

   $title = "Reset Password";
   $hash = $_GET['id'];  
   $email = $_GET['email'];
   
   $query ="SELECT COUNT(*)  AS count FROM users WHERE CONCAT(MD5(MD5(username)), MD5(PASSWORD)) = '$hash' AND email = '$email' ";   
   
   
   $result = phpmkr_query($query);
   $row = $result->fetch_assoc();
   if ($row['count'] == 0 ){
       header('Location:index.php');
   }  

   include_once("header.php");

?>

<body onload="$('#txtPasswordRecover').focus();">
    

<div id="body">
    <div id="payment" class="section_article medium">
            <h1 class="title_page" style= "font-size: 400% !important;">Change your <em>password</em></h1>
            
                <form role="form" method="post" name="frmReset" id="frmReset" accept-charset="utf-8" style="text-align:left;" >
                   <div class="formsubscriber">
                       <div class = "labelform">New Password*</div>
                           <div class = "controlform" >
                                <input type = "password" name="txtPasswordRecover" id="txtPasswordRecover" class="inputform" >
                                <div class = "messagesform"><span id = "spanPasswordRecover" ></span></div>
                           </div>
                   </div>
					<div id= "ajaxiconpassword" class="ajaxicon" >
										
					</div>
				   

                    <div class="formsubscriber">
                       <div class = "labelform">Repeat Password*</div>
                           <div class = "controlform" >
                                <input type = "password" name="txtRepeatPasswordRecover" id="txtRepeatPasswordRecover" class="inputform" >
                                <div class = "messagesform"><span id = "spanRepeatPasswordRecover" ></span></div>
                           </div>
                   </div>
                    <input type = "hidden" id = "txtEmailRecover"  name = "txtEmailRecover" value = "<?php echo $email ?>">
					<input type = "hidden" id = "txtHash"  name = "txtHash" value = "<?php echo $hash ?>">
                </form>    
        <div class="formsubscriber" style=" text-align: center !important">
            <a id = "cmdRecoverPassword" href="#" onclick = "RecoverPassword()" class="button button-next"><span>Save</span></a>
        </div>
     </div>     
    
    
    
<?php 
   include_once("footer.php");
?>
	
 
    
<script>
    $( document ).ready(function() {
        removeErrorMessage('txtPasswordRecover', 'spanPasswordRecover');
        removeErrorMessage('txtRepeatPasswordRecover', 'spanRepeatPasswordRecover');
    });

    $("#txtPasswordRecover").keypress(function(event){ 
      if (event.which == 13) { 
        if ($('#txtPasswordRecover').val().length > 5 ) {
          $("#txtRepeatPasswordRecover").focus(); 
          return true;
        } //length
      } //end event.which
    });

    $("#txtRepeatPasswordRecover").keypress(function(event){ 
      if (event.which == 13) { 
        if ($("#txtRepeatPasswordRecover").val().length > 5 && $("#txtRepeatPasswordRecover").val() == $("#txtPasswordRecover").val() ) {
          RecoverPassword();
          return true;
        }
        else
        {
          alert('no match');
          return false;
        }
      } //end event.which
    });   
</script>    
</body>
</html>
