<?php 
  $title = "Home";
    include_once("header.php");
    $logged = 0;
    if (!empty($nameuser))
        $logged = 1;
//require dirname(__FILE__ ) . '/lib/ReCaptcha/autoload.php';
?>

<body>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <input id="logged" value="<?php echo $logged ?>" type="hidden">
  
  <div id="body">
            
  <div id="start" style="text-align:center">
      <div style="padding-top: 17.5px; margin-bottom:27.5px;">
          <div class="gridContainer clearfix content-with-footer">
              <h1 align="center" class="footer">Feeling <em>dissatisfied</em>?</h1>
              <h3 align="center" class="medium deslis-top">Receiving a poor product or lousy service is never nice. Let’s get the company to put it right; if they refuse, well, let’s tell the whole world about it. Posting a complaint far and wide on the web often gets businesses to see sense…</h3>
              <p class="buttons"><a id = "cmdLetsgo" href="#who" class="button button-next" onclick="businessnamefocus();"><span>Let’s go</span></a></p>
          </div>
      </div>
        <footer id="secondfooter" style="width: 100%;">
          <a href="explore.php" target="_self" class="smaller-button linkclean secondfooterbutton">Explore Complaints</a>
          <a href="howitworks.php" target="_self" class="smaller-button linkclean secondfooterbutton">How it Works</a>
          <a href="termsofuse.php" target="_self" class="smaller-button linkclean secondfooterbutton">Terms of use</a>
          <a href="contact.php" target="_self" class="smaller-button linkclean secondfooterbutton">Contact Us</a>
        </footer>
  </div>    

    <div class="section_article">
      <div id="who" class="content content-with-progress section_page">
        <div>
            <h2 >What’s the company you want to complain about?</h2>
            <label class="instruction">just let us have their business name</label>
        </div>
        
        <div style="width:100%;float:left; height: auto; margin-bottom: 10px;">
          
            <form onsubmit="return false;" class="no-submit team-members business-name wide ng-pristine ng-valid inputindex " style="width:100%; "  >
              <input
                    tabindex="1"
                    onkeypress ="loadListOne();"
                    id="businessname" 
                    autocomplete="off"
                    type="text" 
                    name="q" 
                    alt="Business Name"
                    style ="width: 100%; font-size: 30px;"
                    class="inputindex" 
                    onfocus="businessnamefontsize();">
              <input type="submit" value="submit" class="hidden who-submit">
              <label class="instruction" id="msg-error-businessname" style="float: left; width:100%; text-align: center;">Business name</label>
            </form>
            <input id="exist" value="" type="hidden">
            <input id="industryid" name = "industryid" value="" type="hidden">
            <p class="buttonson">
              <a href= "#" onclick="showAddBusiness(); return false;" id="addBusiness" class="button button-large button-next" alt="Register a new business">
                <span>Add Business</span>
              </a>
            </p>
       </div>

          <!-- details rating -->
          
          <div style ="float:left; width: 100%; margin-left: 9%;" class ="detailspadding" >
            <div id="detailsbusiness" hidden="true"  >
                  <div id="ratingstatus" class="responsive">    
                    <span id="AddressBusinessReputation"></span>
                    <span id="Address2BusinessReputation"></span>
                    <span id="TwonBusinessReputation"></span>
                    <span id="CountybusinessReputation"></span>
                    <span id="RegionBusinessReputation"></span>
                    <span id="PostCodeBusinessReputation"></span>
                  </div>
                  <div id="nocomplaintsbusiness"  style=" font-size:14px; margin-top:-20px !important; font-weight:bold;" class="responsive">
                    No complaints registered
                  </div>
                  <div id="raitingvalues"  style ="padding-top: 30px; margin-bottom: 30px;" class = "detailspaddingreview">
                          <form id="ratingsForm">
                              <div class="stars-small-reviews " style="text-align: center !important">
                                    <input type="radio" name="starsmall" class="star-1" id="starsmall-1" value = "1">
                                    <label class="star-1" for="starsmall-1">1</label>
                                    <input type="radio" name="starsmall" class="star-2" id="starsmall-2" value = "2">
                                    <label class="star-2" for="starsmall-2">2</label>
                                    <input type="radio" name="starsmall" class="star-3" id="starsmall-3" value = "3">
                                    <label class="star-3" for="starsmall-3">3</label>
                                    <input type="radio" name="starsmall" class="star-4" id="starsmall-4" value = "4">
                                    <label class="star-4" for="starsmall-4">4</label>
                                    <input type="radio" name="starsmall" class="star-5" id="starsmall-5" value = "5">
                                    <label class="star-5" for="starsmall-5">5</label>
                                    <span></span>
                              </div>
                          </form>
                  </div>
              
            </div>
        
            <div class = "responsive" >
                <p>
                    <a
                          tabindex="2"
                          onclick="return validationbusiness();"
                          id="nextOne" 
                          href="#what"
                          class="button button-next">
                          <span>Next</span>
                      </a>
               </p>
            </div>    
              
              </div>
      
    </div>

    <div class="section_article">
        <div id="what" class="content content-with-progress section_page" >
            <div>
                <h2>What’s the title of your complaint?</h2>
                <label class="instruction">KEEP IT BRIEF AND MEANINGFUL</label>
            </div>
            <div class="forms">

      <form class="no-submit project-description wide">
              <input  
                  type="text" 
                   tabindex="3" 
                   autocomplete="off" 
                   id="myComplaints" 
                   alt="Type a title for your complaint" 
                   onfocus="whatsyourcomplaintsclean();" 
                   maxlength="50" 
                   style ="width: 100%; font-size: 30px; height: 40px "
                   class="inputindex" 
                   onkeyup="countChar(this, 50, charNum1, ' chars')" >
                   
                   <label id="whatsyourcomplaints" class="instruction">Describe your complaint in a sentence <label style="color:red;">&nbsp;*</label><div id="charNum1" style="padding-top:-10px;  text-align:right; width:15%; font-weight:600; float:right">50 chars</div></label> 
                   <div id = "divspelltitle" class="checkspellcontainer checkspelltitle"  style = "margin-top: -22px;"><a id = "spellchecktitle" class="checkspell" href="javascript:checkSpell()"><img src = "img/spellcheck.png" class = "imgspell" >Check Spelling</a></div>
                </form>
            </div>
            <div style="width: 100%; text-align: center; float: left;">
              <p class="buttons next">
              <a
              onclick="whatsyourcomplaints(); return false;" 
              id="nextMyComplaints" 
              tabindex="4" 
              href="#complainer" 
              class="button button-next "><span>Next</span></a></p>
            </div>
        </div>
    </div>

    
    <div class = "section_article">
      <div id="complainer" class="content content-with-progress section_page" >
        <div>
          <h2>What is your name and email address?</h2>
          <label class="instruction">We’ll need this to create your account and send you replies </label>
        </div>
          <div class="forms" >
          <form id="frmcomplainer" class="no-submit team-members wide ng-pristine ng-valid">
            <input 
            style ="width: 100%; font-size: 30px; "
            class="inputindex" 
            tabindex="5" 
            alt="Type your name"                   
            autocomplete="off" 
            type="text" 
            id="name_config" 
            onfocus="clearnamecomplainer();"
            value="<?php echo $nameuser ?>" >
            
            <input type="submit" id='name_conf' value="Add another member" class="hidden who-submit" >
            <label id="namecomplainer" class="instruction longer" >Name</label>
            
            <input 
            tabindex="6" 
            style ="width: 100%; font-size: 30px; "
            class="inputindex" 
            type="text"                    
            autocomplete="off" 
            alt="Type your email"
            id='email_conf' 
            onfocus="clearemailcomplainer();"
            autocomplete="off"
            value="<?php echo $useremail ?>">
            <input type="submit" value="Add another email" class="hidden who-submit">
            <label id="emailcomplainer" class="instruction">Email Address</label>
            
          </form>
        </div>
      <p
      id="poncomplainer"  style="margin-top:50px;"
      class="buttons next" >
      <a href = "#description"
      tabindex="7" 
      id="buttomnextdescomplainer"
      onclick="return validatemail(); return false;"
      class="button button-next">
    <span>Next</span></a></p>

        </div>
    </div>
    
<div class = "section_article " style="margin-top:80px;" style="align:center;">
    <div id="description" class="content content-with-progress section_page">
            <div>
                <h2>Tell us about your complaint in more detail…</h2>
            </div>
            <div class="boxsection">
                <div class = "descriptioncontainer" >
                    <textarea tabindex="8" 
                    onfocus="cleanfullcomplaints();" 
                    id="complaintscomplete"
                    alt="Describe your complaint with more details"
                    maxlength="2500" 
                    onkeyup="countChar(this, 2500, charNum, ' characters remaining')" 
                    class="description" ></textarea>
                <div id="charNum" style="padding-top:10px; float:right; width:auto; font-weight:bold; font-size: 14px;" >2500 characters remaining</div>
                
                
                
                
                    <div id = "divspellcomplaint" class="checkspellcontainer" ><a id = "spellcheckcomplaint" class="checkspell" href="javascript:checkSpellComplaint()" ><img src = "img/spellcheck.png" style="float:left; width: 20px">Check Spelling</a></div>    
                    <div id="imcompletecomplaints" style="float:left; width: 100%; background: green; font-size:14px; visibility: hidden;"></div>
                

                <div style="width: 100%; float: left; text-align: center;">
                    <p class="buttons next" id="buttontellfullcomplaint">
                        <a 
                            onclick="fullcomplaints(); return false;"
                            href= "#rating" 
                            id="tellfullcomplaints" 
                            tabindex="9" 
                            class="button button-next"><span>Next</span>
                        </a>
                    </p>
                    
                </div>
                
            </div>
                </div>
                
    </div>
</div>

            &nbsp;

<div class = "section_article">
  <div id="rating" class="content content-with-progress section_page" >
    <h2 class="wide">How are you feeling about your complaint?</h2>
    <div align="center">
      <form id="ratingsForm">
          <div id = "reviewindex" class="stars" align="left">
          <input type="radio" name="star" class="star-1" id="big-star-1" tabindex="10" value="1" />
          <label class="star-1" for="big-star-1" onclick="selectstar('#big-star-1');">1</label>
          <input type="radio" name="star" class="star-2" id="big-star-2" tabindex="11" value="2" />
          <label class="star-2" for="big-star-2" onclick="selectstar('#big-star-2');">2</label>
          <input type="radio" name="star" class="star-3" id="big-star-3" tabindex="12" value="3" />
          <label class="star-3" for="big-star-3" onclick="selectstar('#big-star-3');">3</label>
          <input type="radio" name="star" class="star-4" id="big-star-4" tabindex="13" value="4" />
          <label class="star-4" for="big-star-4" onclick="selectstar('#big-star-4');">4</label>
          <input type="radio" name="star" class="star-5" id="big-star-5" tabindex="14" value="5" />
          <label class="star-5" for="big-star-5" onclick="selectstar('#big-star-5');">5</label>
          <span></span>
        </div>
      </form>
      <div id="nofitiraiting" style="font-size:14px; width: 320px;"></div>
    </div>
    <p align="center" class="buttons next" style="margin-top: 50px">
      <a href="#targetsites" id="nexttargetsites" class="button button-next" onclick="return validatebigstar();"><span>Next</span></a>
    </p>
  </div>
</div>

            <div  class = "section_article">
                <div id="targetsites" class="content section_page" style="padding-top: 120px;">
                  <div>
                    <h2 class="wide ng-binding">We have found over 100 sites for your complaint...</h2>
                    <label class="instruction">Some sites need a social media login to post a complaint - you can skip this step but the number of sites will drop</label>
                  </div>
                  <div class="login">
                    <div class="fblog" id="fb">
                      <p class="buttons social" id="facebook">
                        <a 
                          alt="Register your facebook credentials"    
                          data-toggle="modal" 
                          onclick="showSocialMedia('f')"
                          href="#" 
                          class="button social" 
                          tabindex="15"><span>Facebook</span>
                        </a>
                      </p>
                      <p id="fbdetails" class="fbdetails">Awaiting details</p>
                    </div>
                    <div class="fblog">
                      <p class="buttons social" id="gmail">
                        <a 
                          alt="Register your Google+ credentials"
                          data-toggle="modal" 
                          onclick="showSocialMedia('g')"
                          href="#" 
                          data-reveal-id="socialModalG"
                          class="button social" 
                          tabindex="16"><span>Gmail</span>
                        </a>
                      </p> 
                      <p id="googleplusdetails" class="fbdetails">Awaiting details</p>
                    </div>
                  </div>
                  <div>
                    <p class="buttons next" style="width: 100%; float: left; text-align: center;" id="botonextsend"><a tabindex="17" href="#send" class="button button-next"><span>Next</span></a></p>
                  </div>
                </div>
            </div>

            &nbsp;

    <div id= "ajaxiconcomplaint" class="ajaxicon" >
    
    </div>      
            
<div  class = "section_article">
  <div id="send" class="content section_page" >
    <div>
      <h2 class="wide ng-binding">Let the broadcast begin...</h2>
      <label class="instruction" id="issue">
        Choose if you want to broadcast immediately or if you want to give the business some time to resolve the issue
      </label><br/><br/>
    </div>
    <div class="when medium" id="sendbody">
       
      <label id="vnt" for="today" class="instruction"><input type="radio" id="today" name="broadcast" tabindex="18" value = "1" /> <p> <strong>24</strong> hours to broadcast</p></label>
      
      <label id="cnc" for="soon" class="instruction"><input type="radio" id="soon" name="broadcast" checked="checked" tabindex="19" value = "5" /> <p> <strong>5</strong> days to broadcast unless resolved</p></label>
    </div>
    <div style="margin-top:2%; vertical-align:center;">
      <label for="confirmterm" style="margin-left:10px; font-size:10px;" class="instruction" onclick="cleanmsgerrorsend();">
      <input type="checkbox" id="confirmterm" name="confirmterm" onclick="cleanmsgerrorsend();" checked="checked"/>
           I confirm my complaint is true to the best of my belief and I accept the <a target="_blank" class="linkclean" style="font-size: inherit;" href="termsofuse.php">terms of use</a>
      </label><br><br>
      <span id="msgerrorsend"></span>
    </div>
    <div style = "width: 100%; text-align: center;  margin:auto; margin-top: 2%">  
        <form id = "frmCaptcha" action="fun_jq.php" method="post">
            <div id = "captchaid" class="g-recaptcha" data-sitekey="<?php echo SITEKEY  ?>" style = "display:inline-table;"></div>
        </form>
    </div>
  
    <p class="send" style="margin-top:-5px;">
        <a href="#done" id="gotodone" title="Send" class="button button-next" style="margin-top:50px;" onclick="return generalnotice(); return false">
        <span>Broadcast</span>
      </a>
    </p>
    <span id="generalnotice"></span>
  </div>
</div>

            <div class = "section_article">
                <div id="done"  class="content section_page" >
                    <h2 id="msgfinal" class="wide ng-binding">We’ll send your complaint to <em id='doneb'>Business</em> and email you once they reply
                        <br><br>
                        In the meanwhile feel free to explore reviews others have left...
                    </h2>
                    <div class="fine-print small">
                        <a href="explore.php" class="edit-answers" tabindex="20"><i class="back-arrow"></i>Explore Complaints</a>
                        <a href="index.php#who" class="edit-answers" tabindex="21"><i class="back-arrow"></i>Another Complaint</a>
                        <a href="#" class="edit-answers" tabindex="21" data-toggle="modal" onclick="showFeedBack()"><i class="back-arrow"></i>FeedBack</a>
                    </div>
                </div>
            </div>
<!-- FEEDBACK -->
<div id="myModalF" class="modal fade">
  <div class="modal-dialog modal-mg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel" align="center">Feedback and suggestions</h3>
      </div>
      <div class="modal-body" style="width: 100%; float: left; text-align: left;">
        <label style="width: 100%; text-align: left; float: left; font-weight: bold; font-size: 16px; font-family: georgia; margin-bottom: 1%">Subject</label>
        <input type="text" class="inputform form-control" autofocus="on" id="feedbacktitle" name="feedbacktitle">
        <label style="font-size: 16px; font-weight: bold; font-family: georgia; margin-bottom: 10px; margin-top:3%;">Message</label>
        <textarea name="feedback" id="feedbackcontent" cols="90" class="inputform form-control" style=" margin-top:2%;"></textarea>
        <label id="notify-success" style="color: green;" style=" margin-top:2%;"></label>
        <label id="notify-error" style="color: red;" style=" margin-top:2%;"></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="feedbackhidden" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="feedBackSumbitEnable(); return false;" id="feedbacksubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

  <!-- End feedback -->

            &nbsp;
          <footer id="footer-scroll" style = "position:fixed; " >
            <p class="terms"><a href="explore.php" target="_self" class="button-small smaller-button">Explore Complaints</a>
            <p class="terms"><a href="howitworks.php" target="_self" class="button-small smaller-button">How it Works</a>
            <p class="terms"><a href="termsofuse.php" target="_self" class="button-small smaller-button">Terms of use</a></p>
            <p class="terms"><a href="contact.php" target="_self" class="button-small smaller-button">Contact Us</a></p>
          </footer>

        </div><!-- end body-->
        
</div>

        <script>
            
            function showFeedBack(){
                if ( $("#email_conf").val().length == 0 || $("#name_config").val().length == 0){
                    alert("To make a feedback you must fill Name and Email.");
                return false;
            }
                $('#myModalF').modal('show');
                
            }
            $(window).on('resize', function(){
                var win = $(this);
                if ( win.height() <= 607 && win.width() <= 970 ) 
                    $("#footer-scroll").css("visibility", "hidden");
                else
                    $("#footer-scroll").css("visibility", "visible");
            });
          
            var win = window,
                    docEl = document.documentElement,
                    $logo = document.getElementById('footer-scroll');

            win.onscroll = function () {
                var sTop = (this.pageYOffset || docEl.scrollTop) - (docEl.clientTop || 0);
                $logo.style.display = sTop > 100 ? "none" : "block";
            };
        </script>


        <script type="text/javascript">
            

            $(function () {
                // Calling Password Form
                $("#forgot_password").click(function () {
                    $(".user_login").hide();
                    $(".forgot_password").show();
                    $(".header_title").text('Forgot Password');
                    return false;
                });

                // Calling Register Form
                $("#register_form").click(function () {
                    $(".social_login").hide();
                    $(".user_login").hide();
                    $(".forgot_password").hide();
                    $(".user_register").show();
                    $(".header_title").text('Register');
                    return false;
                });

                // Going back to Social Forms
                $(".back_btn").click(function () {
                    $(".user_login").show();
                    $(".user_register").hide();
                    $(".forgot_password").hide();
                    $(".social_login").hide();
                    $(".header_title").text('Login');
                    return false;
                });

                        })


  //Key press in Title of complaints
  $("#myComplaints").keypress(function(event){
    if (event.which == 13) {
      whatsyourcomplaints();
      var flag = whatsyourcomplaints();
      if (flag == true) {
        var target = $(this.hash);
        var target = target.length ? target : $('#complainer');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
          }
        }
      return false;
    }
    return true;
  });

  //Key press in name user of complaints
  $("#name_config").keypress(function(event){
    if (event.which == 13) {
      $("#email_conf").focus();
      return false;
    }
    return true;
  });

  //Key press in email of complaints
  $("#email_conf").keypress(function(event){
    if (event.which == 13) {
      var flag = validatemail();
      if (flag == true) {
        var target = $(this.hash);
        var target = target.length ? target : $('#description');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
          }
          setTimeout(function(){
            $("#complaintscomplete").focus();
          }, 500);
        }
      return false;
    }
    return true;
  });



    //Key press in rating of complaints
  $("#tellfullcomplaints").keypress(function(event){
    if (event.which == 13) {
      var flag = fullcomplaints();
      if (flag == true) {
        var target = $(this.hash);
        var target = target.length ? target : $('#rating');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
          }
        }
      return false;
    }
    return true;
  });

function feedBackSumbitEnable(){
      if (($('#feedbackcontent').val().length == 0  && $("#feedbacktitle").val().length == 0) ||
       ( $('#feedbackcontent').val().length != 0  && $("#feedbacktitle").val().length == 0 ) ||
       ( $('#feedbackcontent').val().length == 0  && $("#feedbacktitle").val().length != 0 ) ){
        $("#notify-error").html('Complete all fields');
        alert('Complete all fields');
        return false;
    } else {
        sendFeedBack();
        return true;
    }
}
$('.bs-example-modal-lg').on('shown.bs.modal', function () {
    $('#feedbacktitle').focus();
})

function sendFeedBack() {
  $("#notify-error").html('');
  $("#notify-success").html('');
  var name = $("#name_config").val();
  var email = $("#email_conf").val();
  var title = $("#feedbacktitle").val();    
  var content = $("#feedbackcontent").val();
  if (name == '') {
    name = 'undefined';
  }
  if (email == '') {
    email = 'undefined';
  }
         $.ajax({
                url: 'fun_jq.php',
                type: 'POST',
                global: false,
                data: {action: 'feedback', title:title, content:content, name:name, email:email},
                dataType: 'json',
                success:function(data){
                  if (data.success == 0) {
                      $("#notify-error").html('The mail has not been sent.')
                  }
                  if (data.success == 1) {
                      $("#feedbackcontent").val('');
                      $("#feedbacktitle").val('');
                      $("#notify-success").html('The mail has been sent successfully');
                  }
                      setTimeout(function(){
                        $('#myModalF').modal('hide');
                      $("#notify-error").html('');
                      $("#notify-success").html('');
                      }, 1200);
                },
                error: function(data) {
                    console.log(data)
                    $("#notify-error").html('An Error Ocurred');
                    alert('An Error Ocurred');  
                }
                
            });
    }
  
function loadListOne(){     
    var businessname = $("#businessname").val();
    $("#detailsbusiness").hide();
    $("#detailsreview").hide();
    $("#industryid").val(0);
    $("#exist").val('');
    
    
    $("#businessname").autocomplete({
      source: "fun_jq.php?action=businesslist",
      minLength: 2,
      select: function( event, ui ) {
            $("#detailsbusiness").show();
            event.preventDefault();
            document.getElementById('businessname').value = ui.item.CompanyName;
            
            $("#industryid").val(ui.item.IndustryID);
            $("#exist").val(ui.item.Label);
            $("#businessname").css({width: "100%" });
            $("#detailsbusiness").attr("hidden", false);
            $("#raitingvalues").attr("hidden", false);
            $("#nocomplaintsbusiness").attr("hidden", true);
            $("#starsmall-1").attr("disabled", true);
            $("#starsmall-2").attr("disabled", true);
            $("#starsmall-3").attr("disabled", true);
            $("#starsmall-4").attr("disabled", true);
            $("#starsmall-5").attr("disabled", true);
            
            
            $("#businessname").keypress( function(event){
              if (event.which == 13) {
                $("#exist").val(ui.item.Label);
                event.preventDefault();

                var flag = validationbusiness();
                validationbusiness();
                if (flag == true) {
                var target = $(this.hash);
                var target = target.length ? target : $('#what');
                  if (target.length) {
                    $('html, body').animate({
                      scrollTop: target.offset().top
                    }, 1000);
                    setTimeout(function(){
                      $("#myComplaints").focus();
                    }, 100);
                  }

                }
                $("#detailsbusiness").show();
                $("#detailsreview").show();
                return true;
              }
              
              
              return true;
            });

             
            $("#businessname").blur( function(){
                if($("#businessname").val() == "" ){       
                    $("#detailsbusiness").attr("hidden", true);
                    $("#raitingvalues").attr("hidden", true);
                    $("#nocomplaintsbusiness").attr("hidden", false);
                    $("#exist").val('');
                }
            });
            //Reputation values
            var id = ui.item.Label;
            //Start ajax 
                $.ajax({
                    url: 'fun_jq.php',
                    type: 'POST',
                    global: false,
                    data: {action: 'raiting-business', id:id},
                        dataType: 'json',
                    error: function (data) {
                        console.log(data);
                    },
                    success: function (data) {     
                            //set the values of twon region and country Address
                            $("#AddressBusinessReputation").html(data.Address);
                            $("#Address2BusinessReputation").html(data.Address2);

                            //show only Company Name short globally
                            document.getElementById('businessname').value = data.CompanyName;
                            $('#doneb').html(data.CompanyName);
                            checkReviewByVal('starsmall', data.average);
                            $("#detailsreview").show();
                            if (Math.floor(data.average) == 0) {
                                
                                $("#raitingvalues").attr("hidden", true);
                                $("#nocomplaintsbusiness").attr("hidden", false);
                            }
                    }
                });//end ajax
        }//end onSelect
    }); //end function loadListOne          
 
}
function businessnamefocus() {
  setTimeout(function (){
    $("#businessname").focus();
  }, 100);
  return true;
}



function businessnamefontsize(){
    $("#businessname").css("font-size", "hidden");
    $("#msg-error-businessname").removeClass('error-messages ng-active');
    $("#msg-error-businessname").html("BUSINESS NAME");

}

function fbuserclean()
{
    $('#username_f').css('border-color', '#f3f3f3');
    $('#fbmsgerroremail').html('');
    $('#fbmsgerroremail').removeClass("error-messages ng-active");
}
function fbpassclean()
{
    $('#password_f').css('border-color', '#f3f3f3');
    $('#fbmsgerror').html('');
    $('#fbmsgerror').removeClass("error-messages ng-active");
}
function gplususerclean()
{
    $('#username_g').css('border-color', '#f3f3f3');
    $('#gplusmsgerroremail').html('');
    $('#gplusmsgerroremail').removeClass("error-messages ng-active");
}
function gpluspassclean()
{
    $('#password_g').css('border-color', '#f3f3f3');
    $('#gplusmsgerror').html('');
    $('#gplusmsgerror').removeClass("error-messages ng-active");
}
            
            function addS(type) {
                var flag = 0;
                var fog = '';
                var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

                if (type == 'F') {
                    var name = $("#username_f").val();
                    var password = $("#password_f").val();
                    if (regex.test($('#username_f').val().trim()) && $("#password_f").val() != "") {
                        flag=1;
                        fog ='F';
                        
                        $('#fbmsgerror').html('');
                        $('#fbmsgerror').removeClass("error-messages ng-active");
                    }
                    else
                    {
                        if($('#password_f').val()== "" && regex.test($('#username_f').val().trim()))
                        {
                            $('#password_f').css('border-color', 'red');
                            flag=0;
                        }
                        if (!regex.test($('#username_f').val().trim())) {
                            $('#username_f').css('border-color', 'red');
                            $('#fbmsgerroremail').html("Please, type your mail here.");
                            $('#fbmsgerroremail').addClass("error-messages ng-active");
                            flag=0;
                        };
                        if (!regex.test($('#username_f').val().trim()) && $('#password_f').val() == ""){
                            $('#password_f').css('border-color', 'red');
                            $('#username_f').css('border-color', 'red');
                        }
                            $('#fbmsgerror').html("Please, complete both fields.");
                            $('#fbmsgerror').addClass("error-messages ng-active");
                            flag = 0;
                        
                    }
                   
                } else {
                    var name = $("#username_g").val();
                    var password = $("#password_g").val();
                    if (regex.test($('#username_g').val().trim()) && $("#password_g").val() != "") {
                        flag = 1;
                        fog  = 'G';

                        $('#gplusmsgerror').html('');
                        $('#gplusmsgerror').removeClass("error-messages ng-active");
                    }
                    else
                    {
                        if($('#password_g').val()== "" && regex.test($('#username_g').val().trim()))
                        {
                            $('#password_g').css('border-color', 'red');
                            flag=0;
                        }
                        if (!regex.test($('#username_g').val().trim())) {
                            $('#username_g').css('border-color', 'red');
                            $('#gplusmsgerroremail').html("Please, type your mail here.");
                            $('#gplusmsgerroremail').addClass("error-messages ng-active");

                            flag=0;
                        };
                        if (!regex.test($('#username_g').val().trim()) && $('#password_g').val() == ""){
                            $('#password_g').css('border-color', 'red');
                            $('#username_g').css('border-color', 'red');
                        }
                            $('#gplusmsgerror').html("Please, complete both fields.");
                            $('#gplusmsgerror').addClass("error-messages ng-active");
                            flag = 0;
                    }
                }

               if (flag == 1) {
                    $.ajax({
                        url: 'fun_jq.php',
                        type: 'POST',
                        global: false,
                        data: {action: 'addSocial', name: name, password: password, type: type},
                        dataType: 'json',
                        error: function (data) {
                            alert('No Conection add social');
                            console.log(data);
                        },
                        timeout: 15000,
                        success: function (data) {

                            if (data[0] == 1)
                            {
                              if (fog == 'F' ) {
                                $("#fbdetails").html('Details received.');
                                $("#fbdetails").attr('style', 'color:#5cb85c;');
                                $("#username_f").val('');
                                $("#password_f").val('');
                                $("#loginfb").modal('hide');
                              }
                                
                              if (fog == 'G' ) {
                                $("#googleplusdetails").html('Details received.');
                                $("#googleplusdetails").attr('style', 'color:#5cb85c;');
                                $("#username_g").val('');
                                $("#password_g").val('');
                                $("#logingplus").modal('hide');
                              }

                            }
                        }
                    });
                };
               

            }

            function clearFieldsRegister() {
                $("#name").val("");
                $("#address").val("");
                $("#city").val("");
                $("#countrylist").val("");
                $("#regionlist").val("");
                $("#countylist").val("");
                $("#phone").val("");
                $("#email").val("");
            }

            function equals(){
                $("#name").val($("#businessname").val());
            }

            function cleanmsgerrorsend(){
                $("#msgerrorsend").html('');
                $("#msgerrorsend").removeClass('error-messages ng-active');
            }

            function confirmterm(){
              var flag = false;

              //$("#gotodone").attr("href", "#");

              if ($("#confirmterm").is(':checked')) {
                flag=true;
              }
              else
              {
                $("#msgerrorsend").html('You must confirm this.');
                $("#msgerrorsend").addClass('error-messages ng-active');
              }
              return flag;
            }

            function requiredBusiness() {
                var val = $("#businessname").val();

                var obj = $("#businesslist").find("option[value='" + val + "']");

                if (obj != null && obj.length > 0) {
                    $("#nextOne").attr("href", "#what");
                    $("#exist").val(obj.attr('id'));
                } else {
                    $("#nextOne").removeAttr("href");
                    $("#exist").val('');
                }
            }
            
            function validationbusiness() {
                var businessname = $("#businessname").val();
                var idOption = $("#exist").val();
               
                if (businessname != "" && businessname != 'undefined' && idOption != "") {
                    $("#nextOne").attr("href", "#what");
                    setTimeout(function (){
                      $("#myComplaints").focus();
                    }, 100);
                    return true;
                } else {
                    $('#msg-error-businessname').html("Please, complete this field.");
                    $('#msg-error-businessname').addClass("error-messages ng-active");
                    $("#nextOne").attr("href","#");
                    return false;
                }
            }
 
            function clearfields() {
                $(".user-review-statement").html("");
                $(".complaint").html("");
            }



function validatemail()
{
  var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  var str = $("#email_conf").val();
  var n = str.indexOf("@");
  var afterarroba = str.indexOf("@");
  var beforepoint = str.indexOf(".");
  var emaillength = str.length;
  var flag = true;

      $("#buttomnextdescomplainer").attr("href", "#");
        name = $("#name_config").val();
        if (name.length ==0) {
            $('#namecomplainer').html('Enter your name');
            $('#namecomplainer').addClass('error-messages ng-active');
            flag = false;
        }
        
        email = $("#email_conf").val();
        if (email.length ==0){
            $('#emailcomplainer').html('Enter your email address');
            $('#emailcomplainer').addClass('error-messages ng-active');
            flag = false;    
        }

        else
        {
            if (n < 2) {
                $('#emailcomplainer').html('The email must contain at least 2 characters before the @ sign.');
                $('#emailcomplainer').addClass('error-messages ng-active');
            flag = false;
            }


            if(emaillength - beforepoint < 3 ){
                $('#emailcomplainer').html('Enter the extension of your e-mail.');
                $('#emailcomplainer').addClass('error-messages ng-active');
            flag = false;    
            }
           
            if ($("#email_conf").val() == "")
            {
                $('#emailcomplainer').html('Enter your email address');
                $('#emailcomplainer').addClass('error-messages ng-active');
                return false;    
            }
        }
        if (flag){
            $("#buttomnextdescomplainer").attr("href", "#description"); 
            setTimeout(function (){
            $('#complaintscomplete').focus();
           }, 100);
            
            
            return true;
        }
        
        
      return flag;
}
                                                                    
            function clearnamecomplainer(){
              $("#namecomplainer").html('Name');
              $('#namecomplainer').removeClass('error-messages ng-active');
            }
            function clearemailcomplainer(){
              $("#emailcomplainer").html('EMAIL ADDRESS');
              $('#emailcomplainer').removeClass('error-messages ng-active');
            }

            function addfieldname() {
                $('#name').html($("#businessname").val());
            }


            function fullcomplaints(){
                AtD.restoreTextArea('complaintscomplete');
                var flag = false;
                $("#tellfullcomplaints").attr("href", "#");

                if ($("#complaintscomplete").val().length < 100 ) {
                    $("#tellfullcomplaints").attr("href", "#");
                    $("#imcompletecomplaints").html('Your complaint must contain at least 100 characters...');
                    $('#imcompletecomplaints').addClass('error-messages ng-active');
                    $("#imcompletecomplaints").removeAttr('style', 'visibility');
                    flag =false;
                }
                
                if ($("#complaintscomplete").val().length >= 100)
                {
                    $("#imcompletecomplaints").html('');
                    $('#imcompletecomplaints').removeClass('error-messages ng-active');
                    $("#tellfullcomplaints").attr("href", "#rating");
                    flag = true;
                }
                return flag;

            }
            
            function cleanfullcomplaints(){ 
                $("#imcompletecomplaints").attr('style', 'visibility:hidden');
                $("#imcompletecomplaints").html('');
                $("#imcompletecomplaints").removeClass('error-messages ng-active');

            }

            function whatsyourcomplaints()
            {
                var flag=false;
                AtD.restoreTextArea('myComplaints');
                $("#nextMyComplaints").attr("href","#");

                if ($("#myComplaints").val()=='' || $("#myComplaints").val()==null) {
                    $('#whatsyourcomplaints').html('Please, complete this field.');
                    $('#whatsyourcomplaints').addClass('error-messages ng-active');
                    flag = false;
                }
                else
                {
                    
                    if ($("#email_conf").val().length > 0){
                        $("#nextMyComplaints").attr("href","#description");
                    }else
                        $("#nextMyComplaints").attr("href","#complainer");
                        setTimeout(function (){
                          $("#name_config").focus();
                        }, 100);
                    flag = true;
                }
                return flag;

            }

            function whatsyourcomplaintsclean(){
                $("#whatsyourcomplaints").html("Describe your complaint in a sentence <div id='charNum1' style='padding-top:-10px;  text-align:right; width:15%; font-weight:600; float:right'>50 chars</div>");
                $("#whatsyourcomplaints").removeClass('error-messages ng-active');
                return true;
            }         

            function selectstar(element)
            { 
                $('#big-star-1').removeAttr('checked');
                $('#big-star-2').removeAttr('checked');
                $('#big-star-3').removeAttr('checked');
                $('#big-star-4').removeAttr('checked');
                $('#big-star-5').removeAttr('checked');
                $(element).attr('checked', 'checked');
                $("#nexttargetsites").attr("href", "#targetsites");
                $("#nofitiraiting").html("");
                $("#nofitiraiting").removeClass('error-messages ng-active');
            }

            function validatebigstar(){
                var flag = false;
                
                $("#nexttargetsites").attr("href", "");
                
                if (
                   $("#big-star-1").is(':checked') || 
                   $("#big-star-2").is(':checked') || 
                   $("#big-star-3").is(':checked') || 
                   $("#big-star-4").is(':checked') || 
                   $("#big-star-5").is(':checked') 
                    ) {
                        $("#nofitiraiting").html();
                        $("#nofitiraiting").removeClass('error-messages ng-active');
                        $("#nexttargetsites").attr("href", "#targetsites");
                        flag = true;
                      }
                else
                {
                    $('#nofitiraiting').html('Please rate your experience...');
                    $('#nofitiraiting').addClass('error-messages ng-active');
                    flag = false;
                }
                return flag;
            }
function cleangeneralnotice(){
  $("#generalnotice").html('');
  $("#generalnotice").removeClass('error-messages ng-active');
}

function generalnotice(){
  var flag  = false;
  var flag1 = false; 
  var flag2 = false;
  var flag3 = false;
  var flag4 = false;
  var flag5 = false;
  var flag6 = false;
  AtD.restoreTextArea('myComplaints');
  AtD.restoreTextArea('complaintscomplete');
  

 $("#gotodone").attr("href", "#");
  
  cleangeneralnotice();
  flag1 = validationbusiness();
  flag2 = whatsyourcomplaints();
  flag3 = validatemail();
  flag4 = fullcomplaints();
  flag5 = validatebigstar();
  flag6 = confirmterm();
  
  
  if (flag1 == false || flag2 == false || flag3 == false || flag4 == false || flag5 == false || flag6 == false ) {
            $("#generalnotice").html('Please complete all fields...');
            $('#generalnotice').addClass('error-messages ng-active');
            flag = false;
  }
  else
  {
           
            var doneb = $('#businessname').val();
            var success = insertComplaint();
            console.log(success)
            if (success){ 
                $("#gotodone").attr("href", "#done");
                cleanComplaintsFields();
                $('#doneb').html(doneb);
                grecaptcha.reset();
                flag=true;
            }else{
                $("#gotodone").attr("href", "#send");
                flag = false;
            }
  }
  
  if (!flag1){ 
    $("#cmdLetsgo").get(0).click();
      return flag1;
   }

  if (!flag2){ 
    $("#nextOne").get(0).click();
    return flag2;
  }
  
  if (!flag3){ 
    $("#myComplaints").get(0).click();
    return flag3;
  }

  if (!flag4){ 
    $("#nextMyComplaints").get(0).click();
    return flag4;
  }
  
  if (!flag5){ 
    $("#tellfullcomplaints").get(0).click();
    return flag5;
  }  
  
  if (!flag6){ 
    $("#nexttargetsites").get(0).click();
    return flag6;
  }    
  
  return flag;
}

 //footer in index when resolution screen is small
 $(function() {
  $(window).width(function (event) {
    var display = screen.width;
        if (display < 701) {
          $("#secondfooter").show();
        } else {
          $("#secondfooter").hide();
        }
  });
    $(window).resize(function (event) {
    var display = screen.width;
        if (display < 701) {
          $("#secondfooter").show();
        } else {
          $("#secondfooter").hide();
        }
  });
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        var display = screen.width;
        if (scroll < 250 && display < 701 ) {
          $("#secondfooter").show();
        } else {
          $("#secondfooter").hide();
        }

    });
 });     
 //End function static scroll in responsive screen -> for screen < 700px 
      
//SCROLL EFECT
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (this.hash.slice(1) == '') {
        return false;
      } else {
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      }
        
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});


/**
 * Close modal when keyup escape key
 */
$(document).keyup(function(event){
    if(event.which==27)
    {
        $('#myModalB').modal('hide');
    }
});

$( document ).ready(function() {
    var explorer = CheckInternetExplorer();
    if (explorer){
        $('#reviewindex').removeClass("stars");
        $('#reviewindex').addClass("reviewsie");
    }

});

$(window).trigger('resize');

    internetExplorerMessage();
    
function checkSpell(){
        AtD.checkTextAreaCrossAJAX('myComplaints', 'spellchecktitle', 'Edit Text');
}    


function checkSpellComplaint(){
        AtD.checkTextAreaCrossAJAX('complaintscomplete', 'spellcheckcomplaint', 'Edit Text');
}   
    
    $('#divspelltitle').hide();
    $('#divspellcomplaint').hide();
    
    showSpellCheck('myComplaints', 'divspelltitle');
    showSpellCheck('complaintscomplete', 'divspellcomplaint');



</script>
    </body>

</html>

