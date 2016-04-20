<?php 
$title = "Contact us";
	include_once("header.php");
?>

<body>
	<div class="section_article" >
            <div class="medium" style="margin-top: -100px">
                      
		<h1 class= "title_page">Contact <em>Us</em></h1>
	     <form  role="form" method="post" name="frmContact" id="frmContact" accept-charset="utf-8" style="text-align:left;" >

				<div class="formsubscriber">
					<div class = "labelform">NAME *</div>
					<div class = "controlform" >
						<input type = "text" name="txtNameContact" id="txtNameContact" class="inputform" alt="Enter your name">
						<div class = "messagesform"><span id = "spanNameContact" ></span></div>
					</div>
				</div>
				
				<div class="formsubscriber">
					<div class = "labelform">EMAIL *</div>
					<div class = "controlform" >
						<input type = "text" name="txtEmailContact" id="txtEmailContact" class="inputform" alt="Enter your email">
                                                <div class = "messagesform"><span id = "spanEmailContact" ></span></div>
					</div>
				</div>

				<div class="formsubscriber">
					<div class = "labelform">SUBJECT</div>
					<div class = "controlform" >
						<input type = "text" name="txtSubjectContact" id="txtSubjectContact" class="inputform" alt="Enter a subject of contact">
					</div>
				</div>

                                <div class="formsubscriber">
					<div class = "labelform">MESSAGE *</div>
					<div class = "controlform" >
						<textarea name = "txtMessage" id = "txtMessage" cols="62" rows="3" style="text-align: left" class="inputform" alt="Enter your question" ></textarea>
                                                <div class = "messagesform"><span id = "spanMessageContact" ></span></div>
					</div>
				</div>
            
			
			<div class="formsubscriber">
				<div id= "ajaxiconcontact" class="ajaxicon" >
                                    
                                </div>
			</div>
			


			<div class="formsubscriber" style = "text-align:center">
			   <p class="" onclick = "contactUs()" ><a id = "cmdContact" href="#who" class="button button-next"><span>Submit</span></a></p>
			</div>
			
		 </form>  

		
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
