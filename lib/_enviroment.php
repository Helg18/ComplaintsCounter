 <?php
 
require_once 'braintree/lib/autoload.php';
/*api credential uncomment production to live transactions*/

Braintree_Configuration::environment('sandbox');
//Braintree_Configuration::environment('production');
Braintree_Configuration::merchantId('nxjnbtx32hmjhdny');
Braintree_Configuration::publicKey('56y9gxgt7dnpcb8m');
Braintree_Configuration::privateKey('56b97c8a831b2a7a942cda5ab82697d8');
/*api credential */
	
?>	