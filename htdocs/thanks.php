<?php
require('includes/config.inc.php');
include('includes/header.html');

require MYSQL;
?>
    <section id="thanks">
        <h2>Thanks for ordering with DinnerIt <?php $_COOKIE['user_name'] ?>! </h2>
        <h2>Hope to see you again soon !!</h2>
        <img src='images/thanks.jpg'>
        <!--        <button type="submit" class="btn btn-success btn-lg" id="finish">Finish</button>-->
    </section>

<?php

mysqli_autocommit($dbc, FALSE);
            
if (!empty($_SESSION['cart'])) {            
$total=0;           
            
foreach ($_SESSION['cart'] as $item_id => $item)
{
    //echo $value["name"]."<br>";
    $total=$total+($item["quantity"]*$item["price"]);
}
            
$q = "INSERT INTO orders (user_id, total) VALUES (".$_COOKIE['user_id'].", $total)";
$r = mysqli_query($dbc, $q);
if (mysqli_affected_rows($dbc) == 1) 
{
    $oid = mysqli_insert_id($dbc);  
    
    $q1 = "INSERT INTO order_contents (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q1);
	mysqli_stmt_bind_param($stmt, 'iiid', $oid, $item_id, $qty, $price);
    
    $affected = 0;
    
    foreach ($_SESSION['cart'] as $item_id => $item) {
		$qty = $item['quantity'];
		$price = $item['price'];
		mysqli_stmt_execute($stmt);
		$affected += mysqli_stmt_affected_rows($stmt);

	}
    
    mysqli_stmt_close($stmt);
    
    if ($affected == count($_SESSION['cart'])) { // Whohoo!
	
		// Commit the transaction:
		mysqli_commit($dbc);
		
		
		// Clear the cart:
		unset($_SESSION['cart']);
        
       
    }
}
    $_SESSION = array();
}
include('includes/footer.html');
?>