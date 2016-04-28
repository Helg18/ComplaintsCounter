<?php 
$title="Explore complaints";
$userid = "";
if (isset($_GET['userid']) && !empty($_GET['userid']) && ($_GET['userid'] != '' ) ) {
  $userid = $_GET['userid'];
}
else
{
  $userid = "";  
}

$searchbusinessbyid ="";
if (isset($_GET['businessID']) && $_GET['businessID'] != "undefined") {
  $searchbusinessbyid = $_GET['businessID'];
}

if (isset($_GET['key']) == 'yes') {
$withoutcomplaints = 'yes';
}
else
{
  $withoutcomplaints = 'no';
}
    include_once("header.php");
    $logged = 0;
    if (!empty($nameuser))
        $logged = 1;
?>
<input type="hidden" id="searchbusinessbyid" value="<?php echo $searchbusinessbyid ?>">
<input type="hidden" id="userid" value="<?php echo $userid ?>">
<input type="hidden" id="key" value="<?php echo $withoutcomplaints ?>">
<body onload="loadMoreComplaints();" >

    <div id="body" style="width: 100%; float:left; padding: 0% 10% 0% 10%; text-align: center;">

        <h1 align="center">Explore <em>Complaint(s)</em></h1>

        <div class="input-group order-reviews" id="dropdownorderby">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="buttonorderby" >
                    Order Complaints By <span class="caret"></span>
                  </button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1" style="margin-right: 2%; margin-top: -1%">
                    <li id="recents"><a href="#" onclick="cleanblocklo();" alt="View recents complaints">Date</a></li>
                    <li id="worst"><a href="#" onclick="cleanblockhi();" alt="View By No of Complaints">No of Complaints</a></li>
                  </ul>
        </div>    
        
        <div id="reviewsloaded"></div>
        <div id="complaintsregister" style="visibility: hidden;  ">
        </div>
    
	 <div id="ajaxiconmorecomplaints" align="center"></div>
        <div style="float:left; width: 100%; text-align: center; margin-bottom: 30px; " id="contentshowhidebutton" >
		
            <div id="showhidebutton" style="visibility:hidden; ">
              <p class="" style = "text-align:center;" id="pinnextbuttonshowmore" >
                <a href="#" class="button button-next" id="showmorebutton" onclick="OrderComplaintsbylo(); return false;"><span>Show more</span></a>
              </p>
            </div>
        </div>   
         
    </div>  
    
        <div  style="margin-left: 10px;">
          <div id="lastreview" style="visibility:hidden;"></div>
          <div id="lastrating" style="visibility:hidden;">0</div>
          <div id="flag" style="visibility:hidden;">0</div>
          <div id="list" style="visibility:hidden;"></div>
          <div id="starpoint" style="visibility:hidden;"></div>
          <div id="lastcomplaintviewed" style="visibility:hidden;"></div>
          <div id="fromexplore" style="visibility:hidden;">present</div>
          <div id="SearchboxClean" style="visibility:hidden;">yes</div>
          <div id="loadmoreusercomplaint" style="visibility:hidden;"></div>
          <div id="userdetail" style="visibility:hidden;"></div>
          <div id="businessdetail" style="visibility:hidden;"></div>
        </div>

    <?php 
    include_once('footer.php');
    ?>

  <script>
  /**
   * Start loadcomplaintsforusers function
   */
  function loadcomplaintsforusers(){
    var userid = $("#userid").val(); 
    var userdetail = $("#userdetail").html();
    var lastcomplaint = $("#loadmoreusercomplaint").html();
    var path = getBaseUrl()+'img/ajax-loader.gif';
    $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');
     $.ajax({
        url: 'complaints.php?action=loadcomplaintsforusers&user='+userdetail+'&userid='+userid+'&lastcomplaint='+lastcomplaint,
        type: "POST",
        dataType: "json",
          success:function(data){
            $("#reviewsloaded").append(data.block);
            if(data.numrows < 8){
              $("#showhidebutton").attr('style', 'visibility:hidden;');
            }
            else{
              $("#showmorebutton").attr("onclick",'loadcomplaintsforusers(); return false;');                    
              $("#showhidebutton").attr('style', 'visibility:block;');
            }

            $("#loadmoreusercomplaint").html(data.complaintsid);
            $("#ajaxiconmorecomplaints").html('');
          },
          error:function(data){
            alert('Error');
            $("#ajaxiconmorecomplaints").html('');
            console.log(data);
          }
      });

  }
  /**
   * End function loadcomplaintsforusers
   */


  function loadMoreComplaints(){
    var path = getBaseUrl()+'img/ajax-loader.gif';
    $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');
    var key = $("#key").val();

    var userid = $("#userid").val();
    var searchbusinessbyid = $("#searchbusinessbyid").val();
    if (searchbusinessbyid != ''){

      var a = $("#businessdetail").html();
      var CompanyName = a.split(' ').join('');
      
      var businessID = $("#searchbusinessbyid").val();
        $.ajax({
            url: 'complaints.php?action=loadcomplaintsforbusiness&CompanyName='+CompanyName+'&id='+ parseInt(businessID)+'&key='+key,
            type: "POST",
            dataType: 'json',
            success:function(data){
              $("#key").val(data.withoutflag);
              if (data.numrows == 0 && key == 'yes') {
                $("#reviewsloaded").html('');
                $("#reviewsloaded").html(data.without);
                $("#ajaxiconmorecomplaints").html('');
                $("#showhidebutton").attr('style', 'visibility:hidden;');
              }
              else
              {
                $("#reviewsloaded").append(data.block);
                $("#ajaxiconmorecomplaints").html('');
                $("#lastcomplaintviewed").html(data.complaintsid);
              }

              if(data.numrows < 8 ){  
                  $("#showhidebutton").attr('style', 'visibility:hidden;');
              }
              else{
                  
                  $("#showmorebutton").attr("onclick",'LoadBusinessEspecific(); return false;');                    
                  $("#showhidebutton").attr('style', 'visibility:block;');
                  //$("#complaintsregister").html(data.nocomplaintsregistered);
              }
          },
          error: function(data) {
              $("#ajaxiconmorecomplaints").html('');
              alert('error')
              console.log(data);
            }
        });
    }
    else if(userid != ''){
      $.ajax({
        url: 'complaints.php?action=loadcomplaintsforusers&userid='+userid,
        type: "POST",
        dataType: "json",
          success:function(data){
            $("#reviewsloaded").html(data.block);
            $("#showmorebutton").attr("onclick",'loadcomplaintsforusers(); return false;');                    
            $("#showhidebutton").attr('style', 'visibility:block;');
            $("#ajaxiconmorecomplaints").html('');
            $("#loadmoreusercomplaint").html(data.complaintsid);
            if (data.numrows < 8) {
              $("#showhidebutton").attr('style', 'visibility:hidden;');
            }
          },
          error:function(data){
            alert('Error');
            $("#ajaxiconmorecomplaints").html('');
            console.log(data);
          }
      });
    }
    else
    {
      $("#list").html('');
      $("#starpoint").html('');


      var lastreview = $("#lastreview").html();

      var path = getBaseUrl()+'img/ajax-loader.gif';
        $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');

      $.ajax({
          url: 'complaints.php?action=explorerreviews&orderby=0&lastreview=0',
          type: "POST",
          dataType: 'json',
          success:function(data){
              

            $("#reviewsloaded").html(data.block);
            $("#ajaxiconmorecomplaints").html('');
            $("#lastreview").html(data.lastreview);
            $("#flag").html('1');
            if (data.vieworderby == 1) {
              $("#recents").attr('style', 'background-color: #E8E8E8;');
              $("#worst").removeAttr("style");
            };
            if (data.block =="") {
              
              $("#showhidebutton").attr('style', 'visibility:hidden');
              $("#dropdownorderby").attr('style', 'visibility:hidden');
              $("#pinnextbuttonshowmore").attr('style', 'margin-bottom:-30%;');
              $("#pinnextbuttonshowmore").attr('style', 'margin-top: -20%;');
              $("#complaintsregister").attr('style', 'visibility:block');
              $("#complaintsregister").html(data.nocomplaintsregistered)
            }else{
              $("#dropdownorderby").attr('style', 'visibility:block');
              if (data.numrows < 8 ) {
                $("#showhidebutton").attr('style', 'visibility:hidden');
                $("#contentshowhidebutton").attr('style', 'visibility:hidden');
                $("#footer").attr('style', 'margin-top:-85%;');
                $("#footer").attr('style', 'padding-top:3%;');
              }else{
                $("#showhidebutton").attr('style', 'visibility:block');
              }
            }

          },
          error: function(data) {
            console.log(data);
            $("#ajaxiconmorecomplaints").html('');
            
            
          }
      });
  }
}
  function OrderComplaintsbyhi(){
    $("#lastreview").html('');
    var lastrating = $("#lastrating").html();
    var lastreview = $("#lastreview").html();
    var list = $("#list").html();
    var flag = $("#flag").html();
    var starpoint = $("#starpoint").html();

      
    var path = getBaseUrl()+'img/ajax-loader.gif';
      $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');
      $("#buttonorderby").html('No of Complaints <span class="caret"></span');
      $("#complaintsregister").attr('style','visibility:hidden');

             $.ajax({
                url: 'complaints.php?action=explorerreviews&orderby='+ parseInt(1)+'&lastreview='+parseInt(lastrating)+'&list='+list+'&starpoint='+starpoint,
                type: "POST",
                dataType: 'json',
                success:function(data){
                     
                  $("#complaintsregister").attr('style','visibility:hidden');
                  $("#showhidebutton").attr('style', 'visibility:block');
 
                  $("#showmorebutton").attr("onclick",'OrderComplaintsbyhi(); return false;');

                  if (data.numrows == '0') {
                    $("#showhidebutton").attr('style', 'visibility:hidden');
                    $("#ajaxiconmorecomplaints").html('');

                    if ($("#reviewsloaded").html() == '' ) {
                        
                      $("#complaintsregister").attr('style','visibility:block');
                      $("#complaintsregister").html(data.nocomplaintsregistered)
                      
                    }
                    
                  } else {

                    if (data.numrows < 8) {
                      $("#showhidebutton").attr('style', 'visibility:hidden');
                    }

                    if (flag == 1 ) {
                    $("#reviewsloaded").html(data.block);
                    $("#starpoint").html(data.starpoint);
                    }
                    else
                    {
                      $("#reviewsloaded").append(data.block);
                    };
                    $("#list").html(data.list);
                    $("#flag").html('0');
                    $("#ajaxiconmorecomplaints").html('');
                    if (data.vieworderby == 0) {
                      $("#worst").attr('style', 'background-color: #E8E8E8;');
                      $("#recents").removeAttr("style");
                    };

                  };

                },
                error: function(data) {
                  $("#ajaxiconmorecomplaints").html('');
                  alert('error')
                  console.log(data);
                }
            });
}
  function OrderComplaintsbylo(){ 
    $("#lastrating").html('');
    $("#list").html('');
    $("#starpoint").html('');
    var lastrating = $("#lastrating").html();
    var lastreview = $("#lastreview").html();
    var list = $("#list").html('');
    var flag = $("#flag").html();
    var starpoint = $("#starpoint").html();
    var path = getBaseUrl()+'img/ajax-loader.gif';
      $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');
      $("#buttonorderby").html('<span style = "width: 110px; float:left"  >Date </span> <span class="caret"></span');
      $("#complaintsregister").attr('style','visibility:hidden');
    
             $.ajax({
                url: 'complaints.php?action=explorerreviews&orderby='+ parseInt(0)+'&lastreview='+parseInt(lastreview),
                type: "POST",
                dataType: 'json',
                success:function(data){
                      $("#showhidebutton").attr('style', 'visibility:block');

                    if (data.numrows < 8) {
                      if (data.numrows > 0) {
                          
                        $("#complaintsregister").attr('style','visibility:hidden');
                      } else {
                          
                        $("#complaintsregister").attr('style','visibility:block');
                        $("#complaintsregister").html(data.nocomplaintsregistered)
                      }
                        
                      if ($("#reviewsloaded").html() == '' ) {
                        $("#showhidebutton").attr('style', 'visibility:hidden');
                      }
                    }

                  $("#showmorebutton").attr("onclick",'OrderComplaintsbylo(); return false;');                    
                  if (lastreview != '') {
                    $("#reviewsloaded").append(data.block);
                    $("#lastreview").html(data.lastreview);
                  }
                  else
                  {
                    $("#reviewsloaded").html(data.block);
                  } 

                  $("#lastreview").html(data.lastreview);
                  $("#ajaxiconmorecomplaints").html('');

                  if (data.vieworderby == 1) {
                    $("#recents").attr('style', 'background-color: #E8E8E8;');
                    $("#worst").removeAttr("style");
                  };
                },
                error: function(data) {
                  $("#ajaxiconmorecomplaints").html('');
                  alert('error')
                  console.log(data);
                }
            });
}



  function LoadBusinessEspecific(){
  var businessID          = $("#searchbusinessbyid").val();
  var CompanyName         = $("#businessdetail").html();
  var lastcomplaintviewed = $("#lastcomplaintviewed").html();
  $("#key").val('no');

  var path = getBaseUrl()+'img/ajax-loader.gif';
  $("#ajaxiconmorecomplaints").html('<img src="'+path +'"/>');

  $.ajax({
      url: 'complaints.php?action=loadcomplaintsforbusiness&CompanyName='+CompanyName+'&id='+ parseInt(businessID)+'&lastcomplaintviewed='+lastcomplaintviewed,
      type: "POST",
      dataType: 'json',
      success:function(data){
        var a = $("#businessdetail").html();
        var CompanyName = a.split(' ').join('');
        if (data.without == 0 && key == 'yes') {
          $("#businessdetail").html(data.CompanyName);
          $("#reviewsloaded").html('');
          $("#reviewsloaded").html(data.without);
          $("#ajaxiconmorecomplaints").html('');
          $("#showhidebutton").attr('style', 'visibility:hidden;');
        }
        else
        {
          $("#reviewsloaded").append(data.block);
          $("#ajaxiconmorecomplaints").html('');
          $("#lastcomplaintviewed").html(data.complaintsid);
        }

        if(data.numrows < 8){
            $("#showhidebutton").attr('style', 'visibility:hidden;');
        }
        else{
            $("#showmorebutton").attr("onclick",'LoadBusinessEspecific(); return false;');                    
            $("#showhidebutton").attr('style', 'visibility:block;');
        }

      },
      error: function(data) {
        $("#ajaxiconmorecomplaints").html('');
        alert('error')
        console.log(data);
      }
  });
}

function cleanblocklo(){
  $("#lastcomplaintviewed").html('');
  $("#searchbusinessname").val('');
  $("#lastrating").html('');
  $("#reviewsloaded").html('');
  $("#starpoint").html('');
  $("#reviewsloaded").html('');
  $("#starpoint").html('');
  $("#list").html('');
  $("#reviewsloaded").html('');
  $("#lastreview").html('');
  $("#showhidebutton").attr('style', 'visibility:hidden');
  OrderComplaintsbylo();
}
function cleanblockhi(){
  $("#lastcomplaintviewed").html('');
  $("#searchbusinessname").val('');
  $("#lastrating").html('');
  $("#reviewsloaded").html('');
  $("#starpoint").html('');
  $("#reviewsloaded").html('');
  $("#starpoint").html('');
  $("#list").html('');
  $("#reviewsloaded").html('');
  $("#lastreview").html('');
  $("#showhidebutton").attr('style', 'visibility:hidden');
  OrderComplaintsbyhi();
}

  </script>
</body>
    <style> .autocomplete-suggestions {
    text-align: left !important;
    cursor: default !important;
    border: 1px solid #ccc !important;
    border-top: 0 !important;
    background: #fff !important;
    box-shadow: -1px 1px 3px rgba(0,0,0,.1) !important;
    right:5px !important;

    display:scroll !important;
    position:fixed !important;
    z-index: 9999 !important;
    max-height: 254px !important;
    overflow: hidden !important;
    overflow-y: auto !important;
    box-sizing: border-box !important;
}
.autocomplete-suggestion { 
    position: relative !important;
    padding: 0 .6em !important;
    line-height: 23px !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    font-size: 120% !important;
    color: #333 !important;
    
}
.autocomplete-suggestion b { font-weight: normal; color: #1f8dd6; }
.autocomplete-suggestion.selected { background: #f0f0f0; }

.showautocomplete{
    visibility: hidden !important;
}


    </style>
<?php 
    include_once("preview.php");
?>    

</html>
