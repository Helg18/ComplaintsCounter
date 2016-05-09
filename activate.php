<?php 
$user = $_GET['us'];
$token = $_GET['token'];
if ( isset($_GET['us']) && !empty($_GET['us']) &&
	 isset($_GET['token']) && !empty($_GET['token'])) {
	$flag=1;
}
else {
	$flag=0;
}

 ?>

 <!Doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
    <!--<![endif]-->
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title> Activate account | Complaints Counter</title>
      <link rel="icon" href="img/favicon.ico" type="image/x-icon">

      <link rel="stylesheet" type="text/css" href="css/boilerplate.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" type="text/css" href="css/reveal.css">
      <link rel="stylesheet" type="text/css" href="css/review.css">
      <link href='https://fonts.googleapis.com/css?family=Merriweather:400,700italic,700' rel='stylesheet' type='text/css'>
    </head>
    <body onload="verifytoken();">
      
        <!--[if lt IE 9]>
          <script src='js/jquery.1.9.1.min.js'/></script>
        <![endif]-->

        <!--[if (gte IE 9) | (!IE)]><!-->  
          <script src="js/jquery.min.js" type='text/javascript'/></script>
        <!--<![endif]--> 
        
        <script src="js/bootstrap-3.3.6.js" ></script>
        <script src="js/functions.js" ></script>
        
    
    <div id="body">

    <article style="width:100%;">
      <section id="complainer" class="content content-with-progress" style="padding-top: 65px;">
        <div>
          <h2>Account Validation.</h2>
          <label class="instruction">Enter the new password for your account...!</label>
        </div>
        <div class="forms">
          <form class="no-submit team-members wide">
            <input type="text" id="token" hidden="hidden" <?php echo "value='".$token."'"; ?>>
            <input type="text" id="email" hidden="hidden" <?php echo "value='".$user."'"; ?>>
            <input 
            style="font-size: 30px; border: none" 
            type="password" 
            id='pass' 
            onfocus="clearnewpass();"
            autocomplete="off">
            <label id="newpass" class="instruction">New password</label>
          </form>
          <form class="no-submit team-members wide">
            <input 
            style="font-size: 30px;border: none" 
            type="password" 
            id='pass_conf' 
            onfocus="clearnewpassconf();"
            autocomplete="off">
            <label id="rnewpass" class="instruction">Retype your new password</label>
          </form>
        </div>
      <p onclick="validate(); return false;" 
      class="buttons next">
      <a href="#"
      id="buttomnextdescomplainer"
      class="button button-next"><span>Activate</span></a></p>
                  <div class="formsubscriber">
                      <div id= "ajaxiconactivate" class="ajaxicon" style ="margin-left: 40% " >

                      </div>
                  </div>

        </section>

      <section class="content content-with-progress" id="complainer2" style="padding-top: 10%;">
        <div>
          <h2>Oops..! something went wrong.</h2>
          <label class="instruction">We could not receive all data, we try again..!</label>
        </div>
        <div class="forms buttons">  
          <p 
            class="buttons button-small next">
            <a 
              href="index.php" 
              id="buttomnextdescomplainer"
              class="button button-next"
              style="text-align: center;"><span>Home</span>
            </a>
          </p>
        </div>
      </section>
    </article>


        </div>
        
        <script type="text/javascript">
  $("#pass").keypress(function(event){
    if (event.which == 13) {
    	if ($("#pass").val() == '') {
    		validate();
    		return false;
    	}else{
    		$("#pass_conf").focus();
    	}

      return false;
    }
    return true;
  });

  $("#pass_conf").keypress(function(event){
    if (event.which == 13) {
    	if ($("#pass_conf").val() == '') {
    		validate();
    		return false;
    	} else {
    		validate();
    		return false;
    	}

      return false;
    }
    return true;
  });


        function verifytoken(){
          var email = $("#email").val();
          var token = $("#token").val();
          var pass = $("#pass").val();
          var pass_conf = $("#pass_conf").val();

          $.ajax({
            url: 'fun_jq.php',
            type: 'POST',
            global: false,
            data: {action: 'verifytoken', email: email, token: token},
            dataType: 'json',
            error: function (data) {
              console.log("errpr " + data);
            },
            success: function (data) {

              if (data.success == 0) 
               {
                $("#complainer").hide();
                $("#complainer2").show();
                return false;
              } else {
                $("#complainer").show();
                $("#pass").focus();
                $("#complainer2").hide();
                return false;
              }

            }
          });
        }
     

            function clearnewpass(){
              $("#newpass").html('New password');
              $('#newpass').removeClass('error-messages ng-active');
            }
            function clearnewpassconf(){
              $("#rnewpass").html('Retype your new password');
              $('#rnewpass').removeClass('error-messages ng-active');
                    
            }
            function validate()
            {
            	var newpass = $("#pass").val();
            	var rnewpass = $("#pass_conf").val();
            	var flag = 0;

            	if (newpass == "" && newpass.lenght < 5) {
	            	$("#newpass").html('You must complete this field....');
	                $('#newpass').addClass('error-messages ng-active');
	                flag =0;
            	}

            	if (rnewpass == '' && rnewpass.lenght < 5) {
	            	$("#rnewpass").html('You must complete this field....');
	                $('#rnewpass').addClass('error-messages ng-active');
	                flag =0;
            	}

            	if (rnewpass != '' && newpass != rnewpass || newpass.lenght < 5 && rnewpass.lenght < 5 || newpass != rnewpass) {
	            	$("#rnewpass").html('Passwords do not match....');
	                $('#rnewpass').addClass('error-messages ng-active');
	            	$("#newpass").html('Passwords do not match....');
	                $('#newpass').addClass('error-messages ng-active');
	                flag = 0;
            	}

            	if (newpass.length <= 5) {
	            	$("#newpass").html('It must contain at least 6 characters....');
	                $('#newpass').addClass('error-messages ng-active');
	            	$("#rnewpass").html('It must contain at least 6 characters....');
	                $('#rnewpass').addClass('error-messages ng-active');
	                flag =0;
            	}

            	if (newpass.length <= 5 && newpass != rnewpass) {
	            	$("#rnewpass").html('It must contain at least 6 characters....');
	                $('#rnewpass').addClass('error-messages ng-active');
	                flag =0;
            	}

            	if (newpass.length >= 6 && newpass == rnewpass) {
            		flag=1
            	}


            	if (flag==1) {
            		activateaccount();
            		return true;
            	}
            	else
            	{
            		return false;
            	}

            }

            function activateaccount() {

                var email = $("#email").val();
                var token = $("#token").val();
                var pass = $("#pass").val();
                var pass_conf = $("#pass_conf").val();
               
                if (email != "" && token != '' && pass !== "" && pass_conf !== "") {
                        var path = getBaseUrl()+'img/ajax-loader.gif';
                         $("#ajaxiconactivate").html('<img src="'+path +'"/>');
   
                    

                            	$.ajax({
                            	    url: 'fun_jq.php',
                            	    type: 'POST',
                            	    global: false,
                            	    data: {action: 'activateuser', email: email, token: token, pass: pass, pass_conf: pass_conf},
                            	    dataType: 'json',
                            	    error: function (data) {
                                        $("#ajaxiconactivate").html('');
                            	        console.log("errpr " + data);
                            	    },
                            	    timeout: 20000,
                            	    success: function (data) {
                                       $("#ajaxiconactivate").html('');
                                       if (!data.validtoken) 
                                        {
                                           showPopupMessage('the token is incorrect or has expired.');
                                           return false;
                                        }   
                                        
                            	    	if (data.success == 1 )
                            	        {   
                                            window.top.location = "useraccount.php";
                            	        }
                            	        else
                            	        {
                                            showPopupMessage('We were unable to update your password, we try again?');
                                            return false;
                            	        }
                            	    }
                            	    });
                            }
                }
            
        </script>
    </body>

</html>
