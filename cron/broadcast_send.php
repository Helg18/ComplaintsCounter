<?php
	require_once dirname(__FILE__ ) .'/broadcast.php';
	require_once '../payments.php';
	$broadcast = new broadcast();
	$broadcast->broadcast24();
	
	$payments = new payments();
	$payments->CheckPendingPayments();
?>
