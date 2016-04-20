<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="google-site-verification" content="2ORbV--wXiCjJ2V9ahJglzqj0ws7mer6WjUNfRm7RQk" />
        <!-- Force latest IE rendering engine or ChromeFrame if installed -->
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->        
        <meta charset="UTF-8">
        <meta name="title" content="<?php echo $title; ?> | Complaints Blaster">
        <meta name="description" content="Complaint Blaster, register your complaint and expected response of business, so you'll have better quality of service for the next opportunity. ">
        <meta name="keywords" content="Complaint, complaints, complaintsblaster, business, usercomplained, user, userlogin, businesslogin, broadcast, broadcastcomplaints, responses, explore, explorecomplaints, ordercomplaints, userdashboard, businessdashboard, businessregistration, dissatisfied, feelingdissatisfied, feeling, complaintslist, searchcomplaint, addbusiness, <?php echo $title; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?php echo $title; ?> | Complaints Counter</title>
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="css/boilerplate.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/reveal.css">
        <link rel="stylesheet" type="text/css" href="css/review.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.9.2.custom.css">


        <!--[if lt IE 9]>
          <script src='js/jquery.1.9.1.min.js'/></script>
        <![endif]-->

        <!--[if (gte IE 9) | (!IE)]><!-->  
          <script src="js/jquery.min.js" type='text/javascript'/></script>
        <!--<![endif]-->         
        
        <script src="js/bootstrap-3.3.6.js" ></script>
        <script src="js/jquery.creditCardValidator.js"></script>
        <script src="js/functions.js"></script>
        <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="js/respond.min.js"></script>
        
        <script>
            //SearchCountryIp() 
        </script>
    </head>
  
<?php 
   require_once('functions.php');
   
  /* $conn = @phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
   if (!$conn){
     header('Location:unavailable.html');
     exit();
   }*/
   
   $remember_me = ""; 
   $rememberpass = "";
   $nameuser = "";
   $useremail = "";
   $menuloginhidden = false;
   $dashboard = "Complaints List";

   $user = GetUserSession();
   if (isset($user['username']))
        $username = $user['username'];
   
   if (isset($user['name']))
        $nameuser = $user['name'];
   
      if (isset($user['email']))
        $useremail = $user['email'];


   if (!empty($username)){
       $menuloginhidden = true;
       
       if ($_SESSION['usertype'] == 'b')
           $settings = 'subscriptionaccount.php'; 
       else
           $settings = 'useraccount.php'; 
       
       if ($_SESSION['usertype'] == 'a'){
            $dashboard = "DASHBOARD";
       }
       
   }
   
   if (isset($_COOKIE['remember_me']))
       $remember_me = $_COOKIE['remember_me'];
   
   if (isset($_COOKIE['rememberpassword']))
       $rememberpass = $_COOKIE['rememberpassword'];

?>  
<!-- Model business login-->
  <div id="myModalbusinneslogin" class="modal fade" style = "text-align:center"  tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="modalLoginTitle">Business Login</h2>
                    </div>
                    <div class="modal-body">
                    <div class="bussiness_login"> 
                        <div class="popupBody">
                            <form id = "frmLogin" action="javascript:CheckLogin()" >
                            <label class="button-small">Email / Username</label> <input type="text" id = "txtUsername" onfocus="clearfieldsloginusr(); return false;" name = "txtUsername" class="login" value = "<?php echo $remember_me ?>" autofocus autocomplete="off"><br>
                            <label class="button-small">Password</label> <input type="password" id = "txtPassword" onfocus="clearfieldsloginpss(); return false;" name = "txtPassword" class="login" value = "<?php echo $rememberpass ?>" ><br><label id="errorinlogin"></label><br>
                            <div style = "height:30px; font-size:120%"><span id="spanmsg" ></span> </div>

                            <div class="checkbox-simple" style="margin-bottom: 20px;" >
                                <input id="rememberuser" name ="rememberuser" type="checkbox">
                                <label for= "rememberbusiness" class="rememberme">Remember me on this computer</label>
                            </div>
                            <div class="action_btns">
                                  <input type="submit" name = "cmdLogin" id = "cmdLogin" class="savebutton" value ="Login" onclick="validatelogin(); return false;">
                            </div>
          <a href="reset.php" id="forgotpassword" class="forgot_password" >Forgot password?</a>
                            <a href="register.php" id="registerlogin" class="forgot_password" >Register</a>
          <input type = "hidden" id ="logintype" name ="logintype" >
                        </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        
<header>
<div class = "main_header">
    <div class = "header_nav header_logo" style="border: solid 0px #000;">
            <div class = "logo" >
                <a href = "index.php">
                    <img src="img/Logo.png" class ="logo" >
                </a>
            </div>
    </div>
    <div class = "header_nav search_nav" style = "border: solid 0px #000;" >
            <form>
              <input
                    tabindex="1"
                    autocomplete = "off"
                    onkeypress ="searchbusiness()"
                    placeholder="Search business..."
                    id="searchbusinessname" 
                    type="select" 
                    name="searchboxnav" 
                    class="form-control">
              <input type="submit" value="submit" class="hidden who-submit">
            </form>
            <input id="exist-nav" value="" type="hidden">

    </div>
    
    <div class= "header_right"  style="border: solid px #000 ">    
    <?php 
      if (!$menuloginhidden){
    ?>      
   
    
        <div class = "header_nav login_nav" >
        <ul>
            <li><a href="#" onclick="showLogin('b'); return false;" class = "button-small">Business Login</a></li>
        </ul>    
        
            
        </div>    
        <div class = "header_nav login_nav">
            <ul>
                <li><a href="#" onclick="showLogin('u'); return false;" class = "button-small">User Login</a></li>
            </ul>    
        </div>    
    
<?php 
            }
            else{
  ?>
        <div class = "header_nav">
            <ul>
                <li><a class = "button-small" href="userlog.php"><?php echo $dashboard ?></a></li>
            </ul>    
        </div>    
        
        <div class = "header_nav">
            <ul>
                <li class="dropdown button-small" style="margin-top:-5px;">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="<?php echo $settings ?>">Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </li>
            </ul>
        </div>    
        <?php     
            }
  ?>    
    
    </div><!--end right header-->     
</div><!--end header-->    
</header>
 

<style> 

/*
.ui-menu { 
  text-overflow: ellipsis!important;
  white-space: nowrap !important;
  overflow: hidden !important;
  width: 10px;
}

.ui-menu-hidden {
  visibility: hidden;
}
*/

    </style>
<?php 
  include_once("modalmessages.php");
?>
<script>
    
function searchbusiness(){     
      
    var businessname = $("#searchbusinessname").val();           
    $("#exist-nav").val('');

    $('#searchbusinessname').autocomplete({
      source: "fun_jq.php?action=businesslist",
      minLength: 2,
      select: function( event, ui ) {
          
          event.preventDefault();
          
            document.getElementById('searchbusinessname').value = ui.item.CompanyName;
            $("#exist-nav").val(ui.item.Label);
            var frompage = $("#fromexplore").html();
            var SearchBusinessID = $("#exist-nav").val();
            var a = ui.item.CompanyName;
            var CompanyName = a.split(' ').join('');
            var viewbusinesscomplaints = "explore.php?CompanyName="+CompanyName+"&businessID="+SearchBusinessID+'&key=yes';
            window.location.href=viewbusinesscomplaints;
            
             $("#searchbusinessname").blur( function(){

              $(".ui-menu").addClass('ui-menu-hidden');
            });
      }
    });
    
}
/**
 * End LoadListBusiness
 */


removeErrorMessage('txtPassword', 'spanmsg');
removeErrorMessage('txtUsername', 'spanmsg');

function validatelogin(){
  var userlogin = $("#txtUsername").val();
  var passwordlogin = $("#txtPassword").val();
 
  if (userlogin.length < 3 && passwordlogin < 7) {
    $("#txtUsername").attr("style", "border-color:#ff0000");    
    $("#txtPassword").attr("style", "border-color:#ff0000");
    $("#errorinlogin").html('Enter your credentials here...');
    $('#errorinlogin').addClass('error-messages ng-active');
    return false;
  }//
  CheckLogin();
  return true;
}


function clearfieldsloginusr(){
  $("#txtUsername").attr("style", "border-color:#f3f3f3");
}


function clearfieldsloginpss(){
  $("#txtPassword").attr("style", "border-color:#f3f3f3");
  $("#errorinlogin").html('');
  $('#errorinlogin').removeClass('error-messages ng-active');
}

</script>