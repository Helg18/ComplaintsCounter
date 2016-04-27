<div id="ModalPreviewComplaint" class="modal fade" tabindex="-1">
	    <div class="modal-dialog  modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h3 class="modal-title" align="center"></h3>
	            </div>
                    <div class="modal-body preview_container ">
                        <form id="ratingsForm" action = "javascript:closePreview()">
                        <div class="section_preview">
                                <div class="preview_left">
                                    <div class = "preview_label">Date:</div>
                                </div>
                                <div  class="preview_right">
                                    <span class = "preview_label" id = "complaintdate"></span>
                                </div>

                                <div class="preview_left">
                                    <div class = "preview_label">Company Name:</div>
                                </div>
                                <div class="preview_right">
                                    <span class = "preview_label" id = "complaintcompany"></span>
                                </div>

                                <div class="preview_left">
                                    <div class = "preview_label">Complaint:</div>
                                </div>
                                <div class="preview_right">
                                    <span class = "preview_label" id = "complainttitle"></span>
                                </div>

                                <div class="preview_left">
                                    <div class = "preview_label">Review:</div>
                                </div>
                                <div class="preview_right" >
                                    <div id="reviewpreview"  class="stars-reviews_preview" style="font-size: 150%; font-weight: bold ">
                                        <div id = "reviewpreview" class ="stars-small-reviews" >
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
                                    <div class = "preview_label"><p class = "preview_complaint" id = "complaintcomplaint"></p></div>
                                </div>
                         </div>
                        <div class="section_preview" style="text-align: center"><h3 id="responseheader" >No Responses</h3></div>
                        <div id = "divresponse" class="section_preview">
                            
                        </div>
                        <input type = "hidden" id="lastidcomplaint" >
                        <input type = "hidden" id="lastidresponse" >
                        
                        <p id = "showmoreresponse" style="text-align: center "><a href="#" onclick="showMoreResponse(); return false;" class="button button-next"><span>More</span></a></p>

	            </div>
                    <div class="modal-footer">
			   <button type="submit" class="btn btn-primary btn-default"  data-dismiss="modal" id = "myBtn" tabindex="-1" style ="width: 100px " >OK</button>
                    </div>           
                     </form>
	        </div>
	    </div>
	</div>

<script>
    $("#ModalPreviewComplaint").keydown(function (event) {
        if (event.keyCode == 13) {
             $('#ModalPreviewComplaint').modal('hide');
            return true;
        }
    });
    
</script>