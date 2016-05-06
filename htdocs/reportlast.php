<?php
require('includes/config.inc.php');
include('includes/header.html');

require MYSQL;
?>


    <h2>We're Done  <?php echo $_COOKIE['user_name'] ?>!! This is your team's total order so far</h2>

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
    
    
    $q1= "select d.item_name,a.price,a.quantity,b.outlet_name from order_contents a,outlets b,orders c,food_items d 
    where a.item_id=d.item_id
    and d.outlet_id=b.outlet_id
    and a.order_id=c.order_id
    and DATE(c.order_date)=DATE(NOW())
    order by b.outlet_name";

$r1 =mysqli_query ($dbc,$q1);
?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Today's Total Order</h3>
            </div>
            <div class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Outlet</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $total=0;
                    while($row	=	mysqli_fetch_array($r1, MYSQLI_ASSOC))
                    { 
                        echo"
                          <tr>
                            <td>".$row['outlet_name']."</td>
                            <td>".$row['item_name']."</td>
                            <td>".$row['quantity']."</td>
                            <td>".$row['quantity']*$row['price']."</td>
                            
                          </tr>
                          ";
                         $total+=$row['quantity']*$row['price'];
                        
                    }
                     echo "<tr>
                                <td colspan=3>Your Team total is </td>
                                <td><b>$total</b></td>
                          </tr>";   
                    ?>
                    </tbody>
                </table>

            </div>
        </div>

        <a href="thanks.php" role="button" class="btn btn-success" id="finish">Finish</a> 
        
       <?php
} 
        ?>