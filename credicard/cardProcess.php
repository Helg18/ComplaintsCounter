<?php
//$price=$_SESSION['session_price'];
$price='50';
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['card_number']) && !empty($_POST['card_name']) && !empty($_POST['expiry_month']) && !empty($_POST['expiry_year']) && !empty($_POST['cvv']))
{
$card_number=str_replace("+","",$_POST['card_number']);  
$card_name=$_POST['card_number'];
$expiry_month=$_POST['expiry_month'];
$expiry_year=$_POST['expiry_year'];
$cvv=$_POST['cvv'];
$expirationDate=$expiry_month.'/'.$expiry_year;
$monto = $_POST['monto'];

require_once 'braintree/lib/autoload.php';
/*api credential */
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('nxjnbtx32hmjhdny');
Braintree_Configuration::publicKey('56y9gxgt7dnpcb8m');
Braintree_Configuration::privateKey('56b97c8a831b2a7a942cda5ab82697d8');
/*api credential */

$result = Braintree_Transaction::sale(array(
'amount' => $price,
'creditCard' => array(
'number' => $card_number,
'cardholderName' => $card_name,
'expirationDate' => $expirationDate,
'cvv' => $cvv
)
));

if ($result->success) 
{
//print_r("success!: " . $result->transaction->id);
if($result->transaction->id){
    $braintreeCode=$result->transaction->id;
//updateUserOrder($braintreeCode,$session_user_id);
echo "result code :". $braintreeCode;
}
} 
else if ($result->transaction) 
{
echo '{"OrderStatus": [{"status":"2"}]}';
} 
else 
{
echo '{"OrderStatus": [{"status":"0"}]}';
}

}



function create_customer(){
    
 #Set timezone if not specified in php.ini
        //date_default_timezone_set('America/Los_Angeles');
 require_once '_environment.php';
 $includeAddOn = false;
 
 /* First we create a new user using the BT API */
 $result = Braintree_Customer::create(array(
                'firstName' => mysql_real_escape_string($_POST['first_name']),
                'lastName' => mysql_real_escape_string($_POST['last_name']),
                'company' => mysql_real_escape_string($_POST['company']),
 'email' => mysql_real_escape_string($_POST['user_email']),
 'phone' => mysql_real_escape_string($_POST['user_phone']),
                
 // we can create a credit card at the same time
                'creditCard' => array(
                    'cardholderName' => mysql_real_escape_string($_POST['full_name']),
                    'number' => mysql_real_escape_string($_POST['card_number']),
                    'expirationMonth' => mysql_real_escape_string($_POST['expiry_month']),
                    'expirationYear' => mysql_real_escape_string($_POST['expiry_year']),
                    'cvv' => mysql_real_escape_string($_POST['card_cvv']),
                    'billingAddress' => array(
                        'firstName' => mysql_real_escape_string($_POST['first_name']),
                        'lastName' => mysql_real_escape_string($_POST['last_name'])
                       /*Optional Information you can supply
 'company' => mysql_real_escape_string($_POST['company']),
                        'streetAddress' => mysql_real_escape_string($_POST['user_address']),
                        'locality' => mysql_real_escape_string($_POST['user_city']),
                        'region' => mysql_real_escape_string($_POST['user_state']), 
                        //'postalCode' => mysql_real_escape_string($_POST['zip_code']),
                        'countryCodeAlpha2' => mysql_real_escape_string($_POST['user_country'])
       */
                    )
                )
            ));
    if ($result->success) {
       //Do your stuff
       //$creditCardToken = $result->customer->creditCards[0]->token;
       //echo("Customer ID: " . $result->customer->id . "<br />");
       //echo("Credit card ID: " . $result->customer->creditCards[0]->token . "<br />");
    } else {
        foreach ($result->errors->deepAll() as $error) {
            $errorFound = $error->message . "<br />";
        }
 echo $errorFound ;
        exit;
    }
}
?>