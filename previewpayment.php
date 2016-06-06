<div id="ModalPreviewPayment" class="modal fade" tabindex="-1">
	    <div class="modal-dialog  modal-mg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h3 class="modal-title" align="center">Payment Details</h3>
	            </div>
                    <div class="modal-body preview_container ">
                        <form id="ratingsForm" action = "javascript:closePreview()">
                        <div class="section_preview">
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Date:</div>
                                </div>
                                <div  class="preview_payment_right">
                                    <span class = "preview_label" id = "paymentdate"></span>
                                </div>

                                <div class="preview_payment_left">
                                    <div class = "preview_label">Subscription Id:</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "paymentpaymentid"></span>
                                </div>

                                <div class="preview_payment_left">
                                    <div class = "preview_label">Status:</div>
                                </div>
                                <div class="preview_payment_right" >
                                    <span class = "preview_label" id = "paymentstatus"></span>
                                </div>
                        
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Value</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "paymentvalue" > </span>
                                </div>
                            
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Next Payment Date</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "paymentnextpayment" > </span>
                                </div>
                            
                            
                         </div>
                            
                        <div id = "divresponse" class="section_preview">
                            
                        </div>
	            </div>
                    <div class="modal-footer">
			   <button type="submit" class="btn btn-primary btn-default"  data-dismiss="modal" id = "myBtn" tabindex="-1" style ="width: 100px " >OK</button>
                    </div>           
                     </form>
	        </div>
	    </div>
	</div>


<div id="ModalPreviewPaymentAgreement" class="modal fade" tabindex="-1">
	    <div class="modal-dialog  modal-mg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h3 class="modal-title" align="center">Payment Details</h3>
	            </div>
                    <div class="modal-body preview_container ">
                        <form id="ratingsForm" action = "javascript:closePreview()">
                        <div class="section_preview">
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Date:</div>
                                </div>
                                <div  class="preview_payment_right">
                                    <span class = "preview_label" id = "agreementdate"></span>
                                </div>

                                <div class="preview_payment_left">
                                    <div class = "preview_label">Subscription Id:</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "agreementpaymentid"></span>
                                </div>

                                <div class="preview_payment_left">
                                    <div class = "preview_label">Status:</div>
                                </div>
                                <div class="preview_payment_right" >
                                    <span class = "preview_label" id = "agreementstatus"></span>
                                </div>
                        
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Value</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "agreementvalue" > </span>
                                </div>
                            
                                <div class="preview_payment_left">
                                    <div class = "preview_label">Next Payment Date</div>
                                </div>
                                <div class="preview_payment_right">
                                    <span class = "preview_label" id = "agreementnextpayment" > </span>
                                </div>
                            
                            
                         </div>
                            
                        <div id = "divresponse" class="section_preview">
                            
                        </div>
                        

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