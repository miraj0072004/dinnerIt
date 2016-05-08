<?php
require('includes/config.inc.php');
include('includes/header.html');

require MYSQL;
?>

    <h2>Great Work  <?php echo $_COOKIE['user_name'] ?>! You have ordered the following</h2>
    <?php

//foreach( $_POST as $stuff ) {
//    if( is_array( $stuff ) ) {
//        foreach( $stuff as $thing ) {
//            echo $thing;
//        }
//    } else {
//        echo $stuff;
//    }
//}

//print_r($_POST);

/*

$q="select t.item_id,t.item_name,t.image_name,t.item_price,t.sub_category,t.outlet_id from food_items t where t.item_id=?";

$stmt = mysqli_prepare($dbc, $q);
mysqli_stmt_bind_param($stmt, 'i', $item_id);


foreach ($_POST as $key=>$value)
{
    $item_id=$key;
     mysqli_stmt_execute($stmt);
     mysqli_stmt_bind_result($stmt, $item_id1, $item_name, $image_name, $item_price, $sub_category, $outlet_id);
     printf("%s %s %s %s %s %s\n", $item_id1, $item_name, $image_name, $item_price, $sub_category, $outlet_id);
    //echo $item_name;

}
*/
$item_ids=",";
foreach ($_POST as $key=>$value)
{

    //echo   nl2br($key."->".$value."\n");    
    $item_ids=$item_ids.$key.",";
}
 $item_ids=trim($item_ids,',');

$q="select t.item_id,t.item_name,t.image_name,t.item_price,t.outlet_id,getOutletName(t.outlet_id) as outlet_name from food_items t where t.item_id in (".$item_ids.")";
$r=mysqli_query($dbc,$q);
?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Your Order</h3>
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
                    while($row	=	mysqli_fetch_array($r, MYSQLI_ASSOC))
                    { 
                        echo"
                          <tr>
                            <td>".$row['outlet_name']."</td>
                            <td>".$row['item_name']."</td>
                            <td>".$_POST[$row['item_id']]."</td>
                            <td>".$_POST[$row['item_id']]*$row['item_price']."</td>
                          </tr>
                          ";
                         $total+=$_POST[$row['item_id']]*$row['item_price'];
                        $_SESSION['cart'][$row['item_id']] = array ('name' => $row['item_name'], 'price' => $row['item_price'], 'quantity' => $_POST[$row['item_id']]);
                    }
                     echo "<tr>
                                <td colspan=3>Your personal total is </td>
                                <td><b>$total</b></td>
                          </tr>";   
                    ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div id="checkoutDiv">
        <a href="reportlast.php" role="button" class="btn btn-success btn-lg" id="checkout">Checkout</a>
        </div>
        <?php

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



            <?php   
//$total=0;
//while($row	=	mysqli_fetch_array($r, MYSQLI_ASSOC))
//{
//  echo "you ordered " .$_POST[$row['item_id']]." of  ". $row['item_name'] . " which amounts to " . $_POST[$row['item_id']]*$row['item_price'];
//    echo "<br>";
//    $total+=$_POST[$row['item_id']]*$row['item_price'];
//}
//
//echo "Your personal total bill is $total";


include('includes/footer.html');
?>