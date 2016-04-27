<div id="modalResponse" class="modal fade" tabindex="-1">
	    <div class="modal-dialog  modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            </div>
                    <div class="modal-body" style = "overflow: hidden" >    
                    <form  method="post" name="frmResponse" id="frmResponse" accept-charset="utf-8"  enctype="multipart/form-data" >
                        
                                <div class="preview_left">
                                    <div class = "preview_label">Date:</div>
                                </div>
                                <div  class="preview_right">
                                    <span class = "preview_label" id = "rcomplaintdate"></span>
                                </div>

                                <div class="preview_left">
                                        <div class = "preview_label">User Email</div>
                                </div>
                            
                                <div  class="preview_right">
                                    <span class = "preview_label" id = "rcomplaintuseremail"></span>
                                </div>

                                <div class="preview_left">
                                    <div class = "preview_label">Complaint:</div>
                                </div>
                                <div class="preview_right">
                                    <span class = "preview_label" id = "rcomplainttitle"></span>
                                </div>

                                <div class="preview_left">
                                    <div class = "preview_label">Review:</div>
                                </div>
                                <div class="preview_right" >
                                        <div id = "reviewresponse" class="stars-reviews_preview" style=" font-size: 150%; font-weight: bold" >
                                            <div class="stars-small-reviews" >
                                              <input type="radio" name="starpreview" class="star-1"  value = "1">
                                              <label class="star-1" for="starsmall-1">1</label>
                                              <input type="radio" name="starpreview" class="star-2"  value = "2">
                                              <label class="star-2" for="starsmall-2">2</label>
                                              <input type="radio" name="starpreview" class="star-3"  value = "3">
                                              <label class="star-3" for="starsmall-3">3</label>
                                              <input type="radio" name="starpreview" class="star-4"  value = "4">
                                              <label class="star-4" for="starsmall-4">4</label>
                                              <input type="radio" name="starpreview" class="star-5"  value = "5">
                                              <label class="star-5" for="starsmall-5">5</label>
                                              <span></span>
                                            </div>
                                        </div>
                                </div>
                        
                                <div class="preview_left">
                                    <div class = "preview_label">Complaint Description:</div>
                                </div>
                                <div class="preview_right">
                                    <div class = "preview_label"><p class = "preview_complaint" id = "rcomplaintcomplaint"></p></div>
                                </div>
                         
                            
                        <div class="section_preview" style="text-align: center"><h3 id="responseheader" >Response</h3></div>

                                <div class="formsubscriber">
                                    <div class = "labelform">MESSAGE *</div>
                                        <div class = "controlform" >
                                            <textarea name = "txtMessageResponse" id = "txtMessageResponse" cols="62" rows="3" style="text-align: left" class="inputform" alt="Enter your question" ></textarea>
                                        <div class = "messagesform"><span id = "spanMessageResponse" ></span></div>
                                    </div>
                               </div>
												
                               <div class="formsubscriber">
                                    <div class = "labelform">ATTACHMENT</div>
                                    <div class = "controlform" >
                                        <input type = "text" name="txtFile" id="txtFile" class="inputform">
                                    </div>
                               </div>
                        
                               <div class="formsubscriber">
                                   <div class="fileUpload btn btn-primary" style="margin-left: 40%" >
                                        <span style="text-align: center !important">Attach File</span>
                                        <input type="file" class="upload" id = "uploadbtn" name = "uploadbtn" data-url="complaints.php?action=uploadfile" />                    
                                    </div>                               
                                   <span id = "spanUpload" style = "float:right"> </span>
                                   <input type="button" class="btn btn-primary" value = "Clear" id = "cmdClear" onclick="clearUpload()"/> 
                               </div>
			
                               <div class="formsubscriber">
                                    <div id= "ajaxiconresponse" class="ajaxicon" >
                                    </div>
                               </div>
			       
                               <input type = "hidden" id="complaintid" name = "complaintid">
                               <input type = "hidden" id="emailcomplainer" name ="emailcomplainer" >
                               <input type = "hidden" id="titlecomplaint" name ="titlecomplaint" >

                            </form>     
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-default" id = "cmdResponse" tabindex="-1" onclick="insertResponse()">Response</button>
                                <button type="button" class="btn btn-primary "  data-dismiss="modal" id = "myBtn"  >Cancel</button>
                            </div>           
	        </div>
	    </div>
	</div>

<script>
    $("#uploadbtn").on('change', function() {
       $("#txtFile").val(document.getElementById("uploadbtn").files[0].name);
    });    
    
$( document ).ready(function() {
    //$('#cmdUpload').hide();
    disableKeys('txtFile');
    removeErrorMessage('txtMessageResponse', 'spanMessageResponse');
    $("#txtFile").attr("disabled", "disabled");  
    $("#cmdClear").hide();
});

$(function () {
    $('#uploadbtn').fileupload({
        dataType: 'json',
        add: function (e, data) {
            var path = getBaseUrl()+'img/ajax-loader.gif';
            $("#spanUpload").html('Uploading...<img src="'+path +'"/>');
            data.submit();
        },
        error: function (e, data) {   
            $("#txtFile").val('');
            $("#spanUpload").html('');
            alert('An error occured uploading the file');
            console.log(e);
        },
                
        done: function (e, data) {
            $("#cmdClear").show();
            $("#spanUpload").html('');
        }
    });
});


function clearUpload(){
    var filename =  $('#txtFile').val(); 
    $('#txtFile').val(''); 
    $('#cmdClear').hide(); 
    
     $.ajax({
                url: 'complaints.php?action=deleteuploadfile&filename='+filename,
                type: "POST",
                data:$('#frmResponse').serialize(),
                dataType: 'json',
                success:function(data){
                },
                    error: function(data) {
                    console.log(data)
                    //alert('An Error Ocurred deleting files');
                }
                
            });
}

</script>
<script src="js/jquery.fileupload.js" type="text/javascript"></script>

