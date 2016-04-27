<?php
require_once 'db.php';
require_once  'functions.php';



use PayPal\Api\Agreement;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;



if (isset($_GET['action'])){
    if (!isset($_SESSION['organisationid']))
        GetUserSession();
    
    $action = $_GET['action'];
    
    if (!empty($_POST)){
        $data = $_POST; 
	}
    
    switch ($action) {
        case 'showpaymentdetails':
            $payments = new payments();         
            $organisationid = $_GET['organisationid'];   
            $result = $payments ->ShowPaymentDetails($organisationid);
            $result = json_encode($result);
            echo $result;    
            break;               
        case 'showagreementdetails':
            $payments = new payments();         
            $agreementid = $_GET['agreementid'];   
            $result = $payments ->ShowAgreementDetails($agreementid);
            $result = json_encode($result);
            echo $result;    
            break;               
        
        case 'createpaymentwithpaypal':
            $payments = new payments();         
            $amount = $data['paidPlanAmount']; 
            $planname = GetPlanName($data['planpaid']);
            $payment = $payments->CreatePaymentWithPaypal($amount, $planname, $data);
            
            $row['success'] = true;
            $row['paymentid'] = $payment->id;
            $row['paymentstate'] = $payment->state;
            $approvalurl = $payment->getApprovalLink();
            $approvalurl = str_replace("\\", "/", $approvalurl);
            $row['approvalurl'] = $approvalurl;
            $result = json_encode($row,JSON_UNESCAPED_SLASHES);
            echo $result;    
            break;                     
        
        case 'executepaymentwithpaypal':
            $payments = new payments();         
            $payment = $payments->ExecutePaymentWithPaypal();
            
            if ($payment->state == "created"){
                $row['success'] = true;
                $row['paymentid'] = $payment->id;
                $row['paymentstate'] = $payment->state;
            }
            
            $result = json_encode($row);
            echo $result;    
            break;          
        case 'createagreementwithpaypal':
            $payments = new payments(); 
            $payments->paymentamount = $data['paidPlanAmount']; 
            $payments->planid = $data['planpaid']; 
            $payments->planname = GetPlanName($data['planpaid']);
            $payments->datapost = $data; 
            $payment = $payments->CreateAgreementWithPaypal();
            if ($payment){ 
                $approvalurl = $payment->getApprovalLink();
                $approvalurl = str_replace("\\", "/", $approvalurl);
                $row['approvalurl'] = $approvalurl;
            }
            
            /*if ($payment->plan['state'] == "ACTIVE"){
                $row['success'] = true;
                $row['paymentid'] = $payment->id;
                $row['paymentstate'] = $payment->state;
            }*/
            $result = json_encode($row, JSON_UNESCAPED_SLASHES);
            echo $result;    
            break;     
        case 'executeagreementwithpaypal':
            $cardid = "";
            $agreementid = "";
            $payments = new payments(); 
            $payment = $payments->ExecuteAgreementWithPaypal();
            //id
            //state
            if ($payment->state == "Pending"){
                $row['success'] = true;
                $row['agreementid'] = $payment->id;
                $row['agreementstate'] = $payment->state;
                $agreementid = $payment->id;
                $paymentstate = $payment->state;
                $data = $_GET;
                require_once('subscription.php');
                
                $subscription = new subscription();         
               $organisationid = $data['organisationid'];
               
               if ($organisationid == 0){     
                    $organisationid = $subscription->InsertOrganisation(
                                                                        $data['txtBusinessName'], 
                                                                        $data['txtStreet'], 
                                                                        $data['townlistregister'], 
                                                                        $data['countrylistregister'], 
                                                                        "0", 
                                                                        $data['countylistregister'], 
                                                                        $data['txtPhone'],
                                                                        $data['txtContactEmail'],
                                                                        "", 
                                                                        $data['txtWebsite'],                               
                                                                        $data['txtPostal'],
                                                                        $data['txtContactName'],
                                                                        $data['industrylist']    
                                                                        );
                    } 
                //header("location:/index.php"); //to redirect back to "index.php" after logging out
                
                $result = $subscription->InsertSubscription(
                                                     $data['type'],
                                                     $data['status'], 
                                                     $data['txtCard'], 
                                                     $data['txtExp'], 
                                                     $data['txtCvc'], 
                                                     $data['txtBusinessName'], 
                                                     $data['txtStreet'], 
                                                     $data['townlistregister'], 
                                                     "", 
                                                     $data['txtPostal'], 
                                                     $data['countrylistregister'], 
                                                     $data['txtContactName'], 
                                                     $data['txtContactEmail'],
						     $data['planpaid'],
						     $data['txtPasswordRegister'],
						     $data['paidPlanAmount'],
                                                     $agreementid,
                                                     $organisationid,
                                                     $cardid,
                                                     $paymentid   
                                                    );
                
                
                //$result =  $this->CreatePaymentDetail($organisationid, $paymentstate, $paymentid, $data['paidPlanAmount'],  "GBP");                
                
            }
            if (isset($payment->id)){
               // require dirname(__FILE__ ) . '/lib/common.php';
                $rooturl = getBaseUrl();
                header("location:$rooturl/register_success.php"); 
                
            }else
                header("location:$rooturl/register_cancel.php"); 
            //echo $result;    
            break;     
    }

}


class payments{
    
/** 
 * Create  payment details after approved transaction on paypel
 * @param integer organisation id
 * @param string status 
 * @param string payment id from paypal aster transaction approval
 * @param string amount of transaction
 * @param string currency of transaction
 * @return array
 */    
 var $planname;
 var $paymentamount;
 var $planid;
 var $datapost;
 
    
function CreatePaymentDetail($organisationid, $status, $paymentid, $amount, $currency){
    $success = false;		
    $query = " INSERT INTO subscriptionpayments ( organisationID , status, paymentdate , paymentid, amount, currency ) VALUE ($organisationid, '$status', CURRENT_DATE, '$paymentid', $amount, '$currency' )";
    $result = phpmkr_query($query);
    if ($result){
        $success = true;	
            $query = "UPDATE subscriptions SET nextpaymentdate  = DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH) WHERE organisationID = $organisationid ";
            $result = phpmkr_query($query);
    }
    $row['success'] = $success;		
    return $row;
    
}  

 /** 
 * Create a credicard vault in paypal
 * @param integer credit card number
 * @param string type = visa, mastercard, discover
 * @param string expiration date format MM/YYYY
 * @param string CVV security code
 * @param string email
 * @param string name 
 * @param string lastname
 * @return object
 */  
function CreateCreditCard($cardnumber, $type, $expirydate, $cvc, $email, $name = "", $lastname = ""  ){

// # Create Credit Card Sample
// You can store credit card details securely
// with PayPal. You can then use the returned
// Credit card id to process future payments.
// API used: POST /v1/vault/credit-card


require dirname(__FILE__ ) . '/lib/bootstrap.php';


 $pos = strpos($expirydate, '/');
 $expmonth = substr($expirydate, 0, $pos ); 
 $expyear = substr($expirydate, $pos+1, strlen($expirydate)); 
    
            
// ### CreditCard
// A resource representing a credit card that is 
// to be stored with PayPal.
$card = new CreditCard();
$card->setType($type)
    ->setNumber($cardnumber)
    ->setExpireMonth($expmonth)
    ->setExpireYear($expyear)
    ->setCvv2($cvc)
    ->setFirstName($name);
    //->setLastName($lastname);

// ### Additional Information
// Now you can also store the information that could help you connect
// your users with the stored credit cards.
// All these three fields could be used for storing any information that could help merchant to point the card.
// However, Ideally, MerchantId could be used to categorize stores, apps, websites, etc.
// ExternalCardId could be used for uniquely identifying the card per MerchantId. So, combination of "MerchantId" and "ExternalCardId" should be unique.
// ExternalCustomerId could be userId, user email, etc to group multiple cards per user.
$card->setMerchantId("Complaint Blaster");
$card->setExternalCardId("complaintblaster" . generateRandomString(5));
$card->setExternalCustomerId("complaintblaster".$email);

// For Sample Purposes Only.
//$request = clone $card;

// ### Save card
// Creates the credit card as a resource
// in the PayPal vault. The response contains
// an 'id' that you can use to refer to it
// in future payments.
// (See bootstrap.php for more on `ApiContext`)
try {
    $card->create($apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	//ResultPrinter::printError("Create Credit Card", "Credit Card", null, $request, $ex);
        //echo "ERROR CREANDO LA TARJETA";
    return false;
    exit(1);
}

return $card;

}

/** 
 * Create a credicard vault in paypal
 * @param cardid from paypal vault
 * @param decimal amoutn payment 
 * @param string plan name
 * @return object
 */    
function CreatePayment($cardid, $paymentamount, $planname ){
    require dirname(__FILE__ ) . '/lib/bootstrap.php';


// ### Credit card token
// Saved credit card id from a previous call to
// CreateCreditCard.php
$creditCardToken = new CreditCardToken();
$creditCardToken->setCreditCardId($cardid);

// ### FundingInstrument
// A resource representing a Payer's funding instrument.
// For stored credit card payments, set the CreditCardToken
// field on this object.
$fi = new FundingInstrument();
$fi->setCreditCardToken($creditCardToken);

// ### Payer
// A resource representing a Payer that funds a payment
// For stored credit card payments, set payment method
// to 'credit_card'.
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
    ->setFundingInstruments(array($fi));

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$planname = "£$paymentamount per month - ".$planname;

$item1 = new Item();
$item1->setName($planname)
    ->setCurrency('GBP')
    ->setQuantity(1)
    ->setPrice($paymentamount);

$itemList = new ItemList();
$itemList->setItems(array($item1));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(0)
    ->setTax(0)
    ->setSubtotal($paymentamount);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("GBP")
    ->setTotal($paymentamount)
    ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Complaint Blaster Subscription")
    ->setInvoiceNumber(uniqid());

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setTransactions(array($transaction));


// For Sample Purposes Only.
//$request = clone $payment;

// ###Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state.
try {
    $payments = $payment->create($apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	//ResultPrinter::printError("Create Payment using Saved Card", "Payment", null, $request, $ex);
    echo "ERROR CREATING PAYMENT ". $ex;
    exit(1);
}

return $payments ;    
    
}


 /** 
 * get payment details
 * @param string agreement id
 * @return array
 */  
function ShowPaymentDetails($organisationid){
    $success = false;
    $query  = "  SELECT b.CompanyName, DATE_FORMAT(a.paymentdate, '%d-%m-%Y') AS paymentdate, DATE_FORMAT(c.nextpaymentdate, '%d-%m-%Y') AS nextpaymentdate,   a.paymentid, a.amount, a.currency, a.status, a.paymentdate ";
    $query  .= " FROM subscriptionpayments AS a JOIN organisations AS b  ON a.organisationID = b.organisationID ";
    $query  .= " JOIN subscriptions AS c ON c.organisationID = a.organisationID where a.organisationID = $organisationid ";
    $query  .= " ORDER BY  a.subscriptionpaymentsid DESC LIMIT 1" ;
 				
    $result = phpmkr_query($query);
   
    if ($result){
        $row  = $result->fetch_assoc();
        $success = true;
    }
            
    $row['success'] = $success;		
    $row['business'] = $row['CompanyName'];
		
    return $row;
    
    
}  

   
/**
 * 
 * check for pending payment and make the payment with a store credicard from paypal
 * @return array 
 */    
function CheckPendingPayments(){
        $sucess = false;
        $query = "SELECT a.organisationID, a.nextpaymentdate, a.cardid, a.paidplan, a.amount FROM subscriptions a WHERE a.nextpaymentdate <= CURRENT_DATE ";  
        $result = phpmkr_query($query);
        if ($result){
            while ($row = $result->fetch_assoc()) {
                $organisationid = $row['organisationID']; 
                $cardid = $row['cardid']; 
                $planid = $row['paidplan']; 
                $amount = $row['amount']; 
                $nextpaymentdate = $row['nextpaymentdate']; 
                $planname = GetPlanName($planid);
                $payments = $this->CreatePayment($cardid, $amount, $planname ); 
                $paymentstate = $payments->state;
                if ($paymentstate == "approved"){
                    $paymentid = $payments->id;    
                    $this->CreatePaymentDetail($organisationid, $paymentstate, $paymentid , $amount, "GBP");
                    $query = "UPDATE subscriptions SET nextpaymentdate = DATE_ADD($nextpaymentdate, INTERVAL 1 MONTH) WHERE organisationID = $organisationid";
                    $update = phpmkr_query($query);
                }else{
                    $this->CreatePaymentDetail($organisationid, $paymentstate, "No Payment" , $amount, "GBP");
                }
                    
                
            }
        }else{
            return $row['success'] = false;
        }
        
        
    }
    
    
function CreatePaymentWithPaypal($paymentamount, $planname, $data ){
    $fields = "";    
    foreach ($data as $key => $value) {
        $fields .= "&".$key."=".$value;   
    }
    
require dirname(__FILE__ ) . '/lib/bootstrap.php';
//require dirname(__FILE__ ) . '/lib/common.php';

$payer = new Payer();
$payer->setPaymentMethod("paypal");

$planname = "£$paymentamount per month - ".$planname;
$item1 = new Item();
$item1->setName($planname)
    ->setCurrency('GBP')
    ->setQuantity(1)
    ->setSku("0") // Similar to `item_number` in Classic API
    ->setPrice($paymentamount);

$itemList = new ItemList();
$itemList->setItems(array($item1));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(0)
    ->setTax(0)
    ->setSubtotal($paymentamount);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("GBP")
    ->setTotal($paymentamount)
    ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/payments.php?success=true&action=executeagreementwithpaypal".$fields)
    ->setCancelUrl("$baseUrl/payments.php?success=false");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));



try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    echo "error creando el pago";
    exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();

return $payment;
    
}    


function ExecutePaymentWithPaypal(){
    
require dirname(__FILE__ ) . '/lib/bootstrap.php';
//require dirname(__FILE__ ) . '/lib/common.php';
    
// ### Approval Status
// Determine if the user approved the payment or not
if (isset($_GET['success']) && $_GET['success'] == 'true') {

    // Get the payment Object by passing paymentId
    // payment id was previously stored in session in
    // CreatePaymentUsingPayPal.php
    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);

    // ### Payment Execute
    // PaymentExecution object includes information necessary
    // to execute a PayPal account payment.
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    try {
        // Execute the payment
        // (See bootstrap.php for more on `ApiContext`)
        $result = $payment->execute($execution, $apiContext);

        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (Exception $ex) {
          exit(1);
        }
    } catch (Exception $ex) {
        exit(1);
    }

    return $payment;

} else {
    exit;
}
    
}



/********************PAYPAL PAYMENTS***********************************/    
 /** 
 * create a billing plan with paypal
 * @param decimal amount of the paypal plan 
 * @return object 
 */  
    
   function CreateBillingPlan($data){
        require dirname(__FILE__ ) . '/lib/bootstrap.php';
        //require dirname(__FILE__ ) . '/lib/common.php';
        
        $fields = "";    
        foreach ($data as $key => $value) {
            $fields .= "&".$key."=".urlencode($value);   
        }        
        
        $planname = "£".$this->paymentamount." per month - ".$this->planname;
        
        $plan = new Plan();

        $plan->setName('Complaint Blaster')
            ->setDescription($planname)
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => $this->paymentamount, 'currency' => 'GBP')));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = getBaseUrl();
        //$fields = urlencode($fields);
        $merchantPreferences->setReturnUrl("$baseUrl/payments.php?success=true&action=executeagreementwithpaypal".$fields)
            ->setCancelUrl("$baseUrl/register_cancel.php?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0") 
            ->setSetupFee(new Currency(array('value' => $this->paymentamount, 'currency' => 'GBP')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $request = clone $plan;

        try {
            $output = $plan->create($apiContext);
        } catch (Exception $ex) {
            $row['error'] = $ex;
            return $row;
            exit(1);
        }

           //echo "PLAN CREADO<br>";

        return $output;

    }
 /** 
 * update a billing plan with paypal
 * @param decimal amount of the paypal plan 
 * @return object 
 */      
    function UpdateBillingPlan(){
        require dirname(__FILE__ ) . '/lib/bootstrap.php';
        $createdPlan = $this->CreateBillingPlan($this->datapost); 
        try {

            $patch = new Patch();

            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan->update($patchRequest, $apiContext);

            $plan = Plan::get($createdPlan->getId(), $apiContext);

        } catch (Exception $ex) {
            $row['error'] = $ex;
            return $row;
            exit(1);
          }

        return $plan;

    }

/** 
 * create a billing plan with paypal
 * @return object 
 */      
function CreateAgreementWithPaypal(){
require dirname(__FILE__ ) . '/lib/bootstrap.php';

        date_default_timezone_set('UTC');

        $createdPlan = $this->UpdateBillingPlan();
        //yyyy-MM-dd z
        $agreement = new Agreement();
        
        $now = $createdPlan->update_time;
        $now = strtotime ( '+5 minute' , strtotime ( $now ) ) ;
        $currentdate = date("Y-m-d",$now);
        $currenttime = date("H:i:s",$now);
        $now = $currentdate."T".$currenttime."Z";
        $planname = "£".$this->paymentamount." per month - ".$this->planname; 
        $agreement->setName($planname)
            ->setDescription($planname)
            ->setStartDate($now);

        // Add Plan ID
        // Please note that the plan Id should be only set in this case.
        $plan = new Plan();
        $plan->setId($createdPlan->getId());
        $agreement->setPlan($plan);

        // Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // Add Shipping Address
        /*$shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        $agreement->setShippingAddress($shippingAddress);*/

        // For Sample Purposes Only.
        //$request = clone $agreement;

        // ### Create Agreement
        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($apiContext);

            // ### Get redirect url
            // The API response provides the url that you must redirect
            // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
            // method
           // $approvalUrl = $agreement->getApprovalLink();

        } catch (Exception $ex) {
            $row['error'] = $ex;
            return $row;
            exit(1);
        }

        return $agreement;        
 }
 
/** 
 * Execute agreement previosly made with paypal account
 * @return object 
 */      
  
function ExecuteAgreementWithPaypal(){
    require dirname(__FILE__ ) . '/lib/bootstrap.php';
    
// ## Approval Status
// Determine if the user accepted or denied the request
if (isset($_GET['success']) && $_GET['success'] == 'true') {

    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();
    try {
        // ## Execute Agreement
        // Execute the agreement by passing in the token
        $agreement->execute($token, $apiContext);
    } catch (Exception $ex) {
        $row['error'] = $ex;
        return $row;
        exit(1);
    }

    
    // ## Get Agreement
    // Make a get call to retrieve the executed agreement details
    try {
        $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
    } catch (Exception $ex) {
        $row['error'] = $ex;
        return $row;
        exit(1);
    }

} else {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    //ResultPrinter::printResult("User Cancelled the Approval", null);
}

  return $agreement;  
} 


  
 /** 
 * get Agreement from paypal
 * @param string agreement id
 * @return array
 */  
function ShowAgreementDetails($AgreementId){
require dirname(__FILE__ ) . '/lib/bootstrap.php';

   $success = false;
    try {
        $agreement = Agreement::get($AgreementId, $apiContext);
        $success = true;
    } catch (Exception $ex) {
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            //ResultPrinter::printError("Retrieved an Agreement", "Agreement", $agreement->getId(), $createdAgreement->getId(), $ex);
        exit(1);
    }
    date_default_timezone_set('UTC');
    
    
    $row['agreementid'] = $AgreementId;
    $row['state'] = $agreement->state;
    $row['description'] = $agreement->description;
    
    $agreementdetail =  $agreement->agreement_details;
    
    /*$row['start_date'] = date("d-m-Y", strtotime ( $agreement->start_date )) ;
    $row['next_billing_date'] = date("d-m-Y", strtotime ( $agreementdetail->next_billing_date )) ;
    $row['final_payment_date'] = date("d-m-Y", strtotime ( $agreementdetail->final_payment_date )) ;
     * 
     */
    
    $row['start_date'] = $agreement->start_date  ;
    $row['next_billing_date'] =  $agreementdetail->next_billing_date  ;
    $row['final_payment_date'] =  $agreementdetail->final_payment_date  ;
    
    
    
    $row['failed_payment_count'] = $agreementdetail->failed_payment_count;
    $row['cycles_remaining'] = $agreementdetail->cycles_remaining;
    $row['cycles_completed'] = $agreementdetail->cycles_completed;
    
    $plan = $agreement->plan->payment_definitions[0];
    $amount = $plan->amount;
    $row['currency'] = $amount->currency;
    $row['value'] = $amount->value;
    //$row['agreementname'] = $agreement->plan->payment_definitions[0];
    
    
    $row['success'] = $success;
    
    return $row;
}  
 

    
    
}//end class