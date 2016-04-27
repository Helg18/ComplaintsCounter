<div id="ModalSendLetter" class="modal fade" tabindex="-1">
	    <div class="modal-dialog  modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel" align="center">Formal Complaint</h3>
	            </div>

                    <div class="modal-body" style="float:left; width: 100%">
                        <form  role="form"  method="post" name="frmSendletter" id="frmSendletter" accept-charset="utf-8" style="text-align:left;" >                            

                                        <div class="formsubscriber">
                                                <div class = "labelform">BUSINESS EMAIL *</div>
                                                <div class = "controlform" >
                                                        <input type = "text" name="txtEmailBusiness" id="txtEmailBusiness" class="inputform" >
                                                        <div class = "messagesform"><span id = "spanEmailBusiness" ></span></div>
                                                </div>
                                        </div>

                                        <div class="formsubscriber">
                                                <div class = "labelform">SUBJECT *</div>
                                                <div class = "controlform" >
                                                        <input type = "text" name="txtSubjectLetter" id="txtSubjectLetter" class="inputform">
                                                        <div class = "messagesform"><span id = "spanSubjectLetter" ></span></div>
                                                </div>
                                        </div>

                                        <div class="formsubscriber">
                                                <div class = "labelform">MESSAGE *</div>
                                                <div class = "controlform" >
                                                        <textarea name = "txtMessageLetter" id = "txtMessageLetter" cols="62" rows="13" style="text-align: left; height: 1% !important" class="inputform" ><?php echo $body ?></textarea>
                                                        <div class = "messagesform"><span id = "spanMessageLetter" ></span></div>
                                                </div>
                                        </div>


                                        <div class="formsubscriber">
                                                <div id= "ajaxiconletter" class="ajaxicon" >

                                                </div>
                                        </div>
                            </form>   
                        </div>                        
                        
                        <div class="modal-footer" >
                                <input type="submit"  class="btn btn-primary btn-default" name = "cmdSendLetter" id = "cmdSendLetter"  value ="Send" onclick="sendLetter()" >
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id = "myBtn" >Cancel</button>
                        </div>                        
	        </div>
	    </div>
</div>

<?php 
        
        include_once("footer.php");
        require_once("modalmessages.php"); 	
?>	

<script>
    removeErrorMessage('txtNameContact', 'spanNameContact');
    removeErrorMessage('txtEmailContact', 'spanEmailContact');
    removeErrorMessage('txtMessage', 'spanMessageContact');
</script>    
</body>
</html>
