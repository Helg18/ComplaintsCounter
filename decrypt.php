#!/usr/bin/php -f

<?php
/**
 * This class is responsible for decrypting the passwords stored in the table userssocialmedia. and it runs directly from the console.
 *
 * How works it?
 *
 * cd complaintscounter/
 * ./decrypt.php StringEncoded 
 *
 * example
 * ./decrypt.php qozpLRnKUwAO2UfMrcr7wDDaTF1Y4R8TB3wN4BfhoAS4afuygoy3vJ1/7tg9ifl3XrtVdYQPYrbm4QTvW4jDYLjLu0aRYozeXtEk2lzbxbwe94lG37q8FMYFwYarYU3YssSFjGk8/D/a7zbW3X3d3eGLXPjbg4qp1Q0Mjfhii43Z3XuwyTzbyIBs2dfM2HjaiyeSoPMWOGOu
 *  --this return 
 *  		-> 'hola'
 *  		-> this is the password
 *
 * Alternative to uso
 * cd complaintscounter/
 * php decrypt.php StringEncoded
 *
 * example
 * ./decrypt.php qozpLRnKUwAO2UfMrcr7wDDaTF1Y4R8TB3wN4BfhoAS4afuygoy3vJ1/7tg9ifl3XrtVdYQPYrbm4QTvW4jDYLjLu0aRYozeXtEk2lzbxbwe94lG37q8FMYFwYarYU3YssSFjGk8/D/a7zbW3X3d3eGLXPjbg4qp1Q0Mjfhii43Z3XuwyTzbyIBs2dfM2HjaiyeSoPMWOGOu
 *  --this return 
 *  		-> 'hola'
 *  		-> this is the password
 * 
 */


/**
 * Library to decode encrypted passwords.
 */
include('lib/EasyCry.php');
$plain_txt = $argv[1];
$star    ="ComplaintsBlaster";

//instance
$EasyCry = new EasyCry();

//call decode method
$obj = $EasyCry->decode($plain_txt, $star);

//cut result
$newobj = implode('µµ', $obj); //µ is limiter
echo "\n\n";
$post   = strpos($newobj, 'µµ'); 

//obtain pass decryted
$pass   = substr($newobj, 0, $post); 

//print results
echo "The result is: ";
echo $pass."\n\n";
?>