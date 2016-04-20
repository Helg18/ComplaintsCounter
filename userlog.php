<?php  
$title = "Dashboard";
require_once('functions.php');
require_once('db.php');

$user = GetUserSession();
    
if (!isset($user['userid'])){
    header('Location:index.php');
    exit();
}
    $userid = $user['userid'];
    $username = $user['username'];
    
    $hiddentabs = true;
    if (isset($user['usertype'])){
         if  ($user['usertype'] == "a")
                $hiddentabs = false;
    }
    
    include_once("header.php");
    require_once('preview.php');
    
    $lastcomplaintid = 0;
    $userlastid = 0;
    
?>
<style>
    /* Sortable tables */
table.sortable thead {
}
@media screen and (max-width: 700px) {
    .trcomplaint td:nth-of-type(1):before { content: "Date"; }
    .trcomplaint td:nth-of-type(2):before { content: "Business Name"; }
    .trcomplaint td:nth-of-type(3):before { content: "ID"; }
    .trcomplaint td:nth-of-type(4):before { content: "Complaint Title"; }
    .trcomplaint td:nth-of-type(5):before { content: "Email"; }
    .trcomplaint td:nth-of-type(6):before { content: "Status"; }
    .trcomplaint td:nth-of-type(7):before { content: "Broadcast Date"; }
    .trcomplaint td:nth-of-type(8):before { content: "Responded"; }
    .trcomplaint td:nth-of-type(9):before { content: "Actions"; }

    .trbusiness td:nth-of-type(1):before { content: "Date"; }
    .trbusiness td:nth-of-type(2):before { content: "ID"; }
    .trbusiness td:nth-of-type(3):before { content: "Business Name"; }
    .trbusiness td:nth-of-type(4):before { content: "Address"; }
    .trbusiness td:nth-of-type(5):before { content: "Status"; }
    .trbusiness td:nth-of-type(6):before { content: "Actions"; }
    
    .trusers td:nth-of-type(1):before { content: "ID"; }
    .trusers td:nth-of-type(2):before { content: "Username"; }
    .trusers td:nth-of-type(3):before { content: "Email"; }
    .trusers td:nth-of-type(4):before { content: "User Type"; }
    .trusers td:nth-of-type(5):before { content: "Registered Since"; }
    .trusers td:nth-of-type(6):before { content: "# Complaints"; }
    .trusers td:nth-of-type(7):before { content: "Status"; }
    .trusers td:nth-of-type(8):before { content: "Actions"; }
    
    .trresponse td:nth-of-type(1):before { content: "Date"; }
    .trresponse td:nth-of-type(2):before { content: "From"; }
    .trresponse td:nth-of-type(3):before { content: "to"; }
    
    
    
    
    .trorganisations td:nth-of-type(1):before { content: "ID"; }
    .trorganisations td:nth-of-type(2):before { content: "Business Name"; }
    .trorganisations td:nth-of-type(3):before { content: "Address"; }
    .trorganisations td:nth-of-type(4):before { content: "City"; }
    .trorganisations td:nth-of-type(5):before { content: "# Complaints"; }
    .trorganisations td:nth-of-type(6):before { content: "P. Status"; }
    .trorganisations td:nth-of-type(7):before { content: "Actions"; }

    /*td of complaint broadcastdate*/
    .broadcastdate, .businessresponded, .ncomplaints, .registered {
        text-align: left !important;
    }
    .response_preview{
        margin-left: -50px !important; 
        font-size: 120% !important;
        
    }
    
}

</style>

<body>
    
  <div id="bdash" style="text-align: center; float:left; width: 100%; ">
      
	<div class="content content-with-footer page_min_height"   >
            <div class="gridContainer clearfix content-with-footer" style ="width: 100%; " >
                <h1 align="center" id="terms">Welcome <em><?php echo $username ?></em></h1>
                
                <div id="tabs" style="margin-top:-30px">
                    <ul>
                      <li><a href="#tabs-1">Complaints</a></li>
                        <?php 
                          if (!$hiddentabs){
                        ?>  
                            <li><a href="#tabs-2">New Businesses</a></li>
                            <li><a href="#tabs-3">Users</a></li>
                            <li><a href="#tabs-4">Businesses</a></li>
                        <?php 
                            }
                        ?>
                    </ul>
                    <div id="tabs-1">
                          <table  width="100%" border="0" cellpadding="15" cellspacing="10" class="xxwide sortable">
                              <thead>
                                    <tr id="titles" align="center">
                                      <th width="5%">Date</th>
                                      <th width="8%">Business Name</th>
                                      <th width="2%">ID</th>
                                      <th width="10%">Complaint Title</th>
                                      <th width="16%">Email</th>
                                      <th width="5%">Status</th>
                                      <th width="6%" style="text-align: center">Broadcast Date</th>
                                      <th width="7%" class ="businessresponded"  style="text-align: center">Business Responded</th>
                                      <th width="12%" class="sorttable_nosort nohover" style="text-align: left">Actions</th>
                                      <th width="1%"></th>
                                    </tr>
                              </thead>      
                              <tbody id= "showmorecomplaints">
                              </tbody>    
                          </table>
                        
                          <div class="formsubscriber">
                               <div id= "ajaxiconmorecomplaints" class="ajaxicon" >
                                </div>
                          </div>
                        
                          <input type ="hidden" id="lastid" value ="<?php echo $lastcomplaintid ?> " >
                          <input type ="hidden" id="userid" value ="<?php echo $userid ?> " >
                          
                          <p id = "complaintshowmore" ><a href="#" onclick="showMoreComplaints(); return false;" class="button button-next"><span>More</span></a></p>
                          
                  </div>
                  <?php 
                    if (!$hiddentabs){
                  ?>
                    <div id="tabs-2">
                          <table  width="100%" border="0" cellpadding="15" cellspacing="10" class="xxwide sortable">
                              <thead>
                                    <tr id="titles" align="center">
                                        <th width="5%">date</th>
                                        <th width="1%">ID</th>                              
                                        <th width="10%">Business Name</th>
                                        <th width="9%">Address</th>
                                        <th width="9%">Status</th>
                                        <th width="12%" class="sorttable_nosort nohover" style="text-align: left; " >Actions</th>
                                        <th width="1%"></th>
                                    </tr>
                              </thead>      
                              <tbody id= "showmorebusiness">
                              </tbody>    
                          </table>
                          <div class="formsubscriber">
                               <div id= "ajaxiconmorebusiness" class="ajaxicon" >
                               </div>
                          </div>
                          <input type ="hidden" id="businesslastid" value ="0" >
                          <p id = "businessshowmore" ><a href="#" onclick="showMoreBusiness(); return false;" class="button button-next"><span>More</span></a></p>
                          &nbsp;
                  </div>
                  <div id="tabs-3">
                      
                          <table width="100%" border="0" cellpadding="15" cellspacing="10" class="xxwide sortable">
                              <thead>
                                    <tr id="titles" align="center">
                                      <th width="3%">ID</th>                              
                                      <th width="10%">Username</th>
                                      <th width="15%">Email</th>
                                      <th width="5%">User Type</th>
                                      <th width="5%" style="text-align: center">Registered Since</th>
                                      <th width="5%" style="text-align: center"># Complaints</th>
                                      <th width="5%">Status</th>
                                      <th width="10%" class="sorttable_nosort nohover" style="text-align: left">Actions</th>
                                      <td width="1%"></td>
                                    </tr>
                              </thead>    
                            <tbody id= "showmoreusers" >
                                
                            </tbody>                            
                          </table>
                          <div class="formsubscriber">
                               <div id= "ajaxiconmoreusers" class="ajaxicon" >

                                </div>
                          </div>
                      
                      <input type ="hidden" id="userlastid" value ="0" >
                      <p id = "usersshowmore" ><a href="#" onclick="showMoreUsers(); return false;" class="button button-next"><span>More</span></a></p>
                     
                  </div>
                    <div id="tabs-4">
                          <table  width="100%" border="0" cellpadding="15" cellspacing="10" class="xxwide sortable">
                              <thead>
                                    <tr id="titles" align="center">
                                        <th width="5%">ID</th>
                                        <th width="10%">Business Name</th>
                                        <th width="9%">Address</th>
                                        <th width="9%">City</th>
                                        <th width="9%" style="text-align: center"># Complaints</th>
                                        <th width="9%" >Payment Status</th>
                                        <th width="12%" class="sorttable_nosort nohover" style="text-align: left; " >Actions</th>
                                        <th width="1%"></th>
                                    </tr>
                              </thead>      
                              <tbody id= "showmoreorganisations">
                              </tbody>    
                          </table>
                          <div class="formsubscriber">
                               <div id= "ajaxiconmoreorganisation" class="ajaxicon" >
                               </div>
                          </div>
                          <input type ="hidden" id="organisationlastid" value ="0" >
                          <p id = "organisationshowmore" ><a href="#" onclick="showMoreOrganisations(); return false;" class="button button-next"><span>More</span></a></p>
                          &nbsp;
                  </div>                    
                    <?php 
                        }//end hiddentabs
                    ?>
                </div>
            </div>
        </div>
</div>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  
    //hide showmore complaints button
    $('#complaintshowmore').hide();
    
    //hide showmore business button
    $('#businessshowmorebusiness').hide();

    //hide showmore users button
    $('#usersshowmoreuser').hide();

    $( document ).ready(function() {
      showMoreComplaints();
      showMoreBusiness();
      showMoreUsers();
      showMoreOrganisations();
    });
    

</script>
<script src="js/sorttable.js"></script>

 <?php 
    include_once('footer.php');
    include_once("businessedit.php");
    include_once("useredit.php");
    include_once("response.php");
    include_once("previewpayment.php");
    include_once("sendletter.php");
	
    
 ?>
</body>
</html>