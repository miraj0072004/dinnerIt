<?php
// Need two pieces of information:
require('includes/config.inc.php');
require MYSQL;


if (isset($_GET['outlet_id'])) {
    
    if ($_GET['outlet_id'] != 0)
    {
        $_SESSION['chosen_outlet_id']=$_GET['outlet_id'];
    }

   $q="select 1 from choice where user_id=".$_COOKIE['user_id']." and DATE(choice_date)=DATE(NOW())"; 
   $r=mysqli_query($dbc,$q);
   if (mysqli_num_rows($r) == 0)
   {     
        $q="insert into choice(user_id,outlet_id) values (".$_COOKIE['user_id'].",". $_GET['outlet_id'].")";
   }
   else
   {
        $q="update choice set outlet_id=".$_GET['outlet_id']." where user_id=".$_COOKIE['user_id'];    
   }
   $r = mysqli_query($dbc, $q);
   $rows=mysqli_affected_rows($dbc);
    
//    $q="select a.outlet_id,b.user_id from outlets a,users b 
//        where exists (select 1 from order_contents c,orders d,food_items e
//                      where c.order_id=d.order_id
//                      and c.item_id=e.item_id
//                      and d.user_id=b.user_id
//                      and e.outlet_id=a.outlet_id
//                      and d.order_date=DATE(NOW())) ";
    
    $q="select a.outlet_id,b.user_name from choice a,users b
        where DATE(a.choice_date)=DATE(NOW())
        and a.user_id=b.user_id 
        order by outlet_id,a.user_id";
    $r=mysqli_query($dbc,$q);
    $outlets=array();
    while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
    {
      $outlets[$row["outlet_id"]][]= $row["user_name"]; 
    }

       //$winetable = array("test" => "testing shit","white" => "white");
       $encoded=json_encode($outlets);
       echo $encoded;
       
  
}
     
?>