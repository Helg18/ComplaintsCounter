
<!DOCTYPE html>
<html>
<head>
<title>Credit Card</title>
<link href="style.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.creditCardValidator.js"></script>
<script type="text/javascript" src="js/card.js"></script>
</head>
<body>
<div id="container">

<h1>BrainTree PayPal Payment Integration with PHP. </h1> 

<div id="paymentGrid">
<div style="margin-top:20px">


<table class="items">
                    <thead>
                        <tr>
                            <th class="desc" data-property="CAT_ITEMDESCRIPTION">Item Description</th>
                            <th class="color" data-property="CAT_COLOR">Color</th>
                            <th class="size" data-property="CAT_SIZE">Size</th>
                            <th class="status" data-property="GLB_STATUS">Status</th>
                            <th class="price" data-property="CAT_PRICE">Price</th>
                        </tr>
                    </thead>
                    <tbody>

                            <tr class="item in-stock" data-longsku="120-201-0802-002" data-priceflag="1" data-sku="617454061" data-mks="CLT" data-usd-price="58.00" data-collection="95870" data-productid="5320676" data-list-price="58.00" data-offer-price="58.00000" data-name="Iconic Crew Neck Sweater">
                                <td class="item-desc">
                                    <ul>
                                        <li class="img" >
                                                <a href="#" data-seq="02" data-productid="5319592">
                                                <img class="prod-img" src="images/macbook.png" alt="Macbook Pro">
                                                </a><br/>
                                                <b>Apple Macbook Pro</b>
                                            
                                        </li>
                                        
                                    </ul>
                                </td>
                                <td class="color" data-seq="02">SILVER</td>
                                <td class="size">13 Inch</td>
                                <td class="status">
                                    In Stock
                                </td>
                                <td class="price">
                                
                                            <span class="offer-price" style="font-weight:bold">$1299.00</span>
                                        
                                </td>
                            </tr>
                        
                    </tbody>
                </table>
</div>
<div style="float:left;widht:450px">
<form method="post"  id="paymentForm" action = "cardProcess.php">


                    <h4>Payment details</h4>

                    <ul>
                        <li>
                            <label for="card_number">Card Number </label>
                            <input type="text" name="card_number" id="card_number"  maxlength="20" placeholder="1234 5678 9012 3456">

                            
                        </li>

                         <li>
                            <label for="card_name">Name on Card</label>
                            <input type="text" name="card_name" id="card_name" placeholder="Srinivas Tamada">
                        </li>
						
				        <li>
                            <label for="monto">AMOUNT</label>
                            <input type="text" name="monto" id="monto" placeholder="0.00">
                        </li>


                        <li class="vertical">
                            <ul>
                                <li>
                                    <label for="expiry_date">Expires</label>
                                    <input type="text" name="expiry_month" id="expiry_month" maxlength="2" placeholder="MM" class="inputLeft marginRight">
                                    <input type="text" name="expiry_year" id="expiry_year" maxlength="2" placeholder="YY" class="inputLeft "><br/>
                                    <span >Month</span> <span style="margin-left:35px">Year</span>
                                </li>

                                <li style="text-align:right">
                                    <label for="cvv">CVV</label>
                                    <input type="text" name="cvv" id="cvv" maxlength="3" placeholder="123" class="inputRight">
                                </li>
                            </ul>
                        </li>
                       <li style="clear:both;">
                        <input type="submit" id="paymentButton" value="Proceed" >
                        </li>

                       
                    </ul>
                </form>
                </div>
                <div style="float:right;width:340px;margin-top:40px">


                <div style="margin-bottom:20px">Try these demo numbers</div>
                <ul id="cards">
                <li>5105105105105100</li>
                <li>
                4111 1111 1111 1210</li>
                <li>
              4111 1111 1113 1010
                </li>
                <li>
                4000 0000 0000 0002
                </li>
                <li>
                4026 0000 0000 0002
                </li>
                <li>
                5018 0000 0009
                </li>
                <li>
                5100 0000 0000 0008
                </li>
                 <li>
               6011 0000 0000 0004
                </li>
                </ul>

                </div>
                  </div>
                <div id="orderInfo">
                   

                </div>
                </div>
              
</body>
</html>


