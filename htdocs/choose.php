<?php
require('includes/config.inc.php');
include('includes/header.html');

require MYSQL;
?>

    <!--
    <div class="container">
        <div class="row">
-->
    <section id="outlets" class="col-xs-3">
        <ul class="nav nav-pills nav-stacked">

            <?php
                    $q="select * from outlets";
                    $r=mysqli_query($dbc,$q);
                    
                    while ($row=mysqli_fetch_array($r))
                    {
                        if ($_SESSION['chosen_outlet_id']==$row[0])
                        {
                          echo
                        '<li role="presentation" class="active">
                            <a href="#tab'.$row[0].'" role="pill" data-toggle="pill" >'.$row[1].'</a>
                        </li>';
                        }
                        else
                        {
                          echo
                        '<li role="presentation">
                            <a href="#tab'.$row[0].'" role="pill" data-toggle="pill" >'.$row[1].'</a>
                        </li>';
                        }
                    }
                    ?>

        </ul>


    </section>
    <section id="items" class="col-xs-6">
        <div class="tab-content">
            <?php
                    mysqli_data_seek( $r, 0 );
                    
                    while ($row=mysqli_fetch_array($r))
                    {
                        
                      if ($_SESSION['chosen_outlet_id']==$row[0])
                      {
                        echo
                        '<div id="tab'.$row[0].'" class="tab-pane fade in active">
                        <h2>'.$row[1].'</h2>';
                      }
                      else
                        {
                        echo
                        '<div id="tab'.$row[0].'" class="tab-pane fade in">
                        <h2>'.$row[1].'</h2>';
                        }
                        
                        //echo "before entering $row[0]";
                        if ($row[0]==1)
                        {
                             //echo "after entering $row[0]";
                            create_pizza_hut($dbc);   
                        }
                        else
                        {
                            //echo "$row[0]";
                            $q1="select t.item_id,t.item_name,t.image_name,t.item_price,t.sub_category,t.outlet_id from food_items t where t.outlet_id=$row[0]";
                            $r1=mysqli_query($dbc,$q1);

                            while ($row1=mysqli_fetch_array($r1))
                            {
                                //echo "$row1[0]";
                                echo "<div class='col-xs-4'><label class='btn btn-primary'><img src='images/$row1[2]' alt='...' class='img-thumbnail img-check'><input type='checkbox' name='$row1[1]' id='$row1[0]'                                           value='$row1[3]' class='hidden' autocomplete='off'></label><p>$row1[3]</p></div>";
                            }
                        }
                        echo '</div>';
                                               
                    }
                    
                    ?>

        </div>

    </section>
    <aside class="col-xs-3">

        <div id="pricing">
            <h3>Your Selection</h3>
            <form class="form-horizontal" action="reportfirst.php" method="post">

                <div class="form-group">

                    <div class="col-sm-10 ">
                        <h4 id="total_price" class="inline">Total : <span id="sum">0</span></h4>
                        <input type="submit" class="btn btn-default inline" value="submit">
                    </div>
                </div>
            </form>

        </div>
    </aside>
    <!--
        </div>
    </div>
-->

    <?php
function create_pizza_hut($dbc)
{
    echo "<div id='accordionCtrl'>";
    $q2="select distinct t.sub_category from food_items t where t.outlet_id=1";
    $r2=mysqli_query($dbc,$q2);
    
    while  ($row2=mysqli_fetch_array($r2))
    {
        echo "<h3>$row2[0]</h3>";
        echo "<div>";
        $q3="select t.item_id,t.item_name,t.image_name,t.item_price,t.sub_category,t.outlet_id from food_items t where t.sub_category='$row2[0]' and t.outlet_id=1";
        $r3=mysqli_query($dbc,$q3);
        while($row3=mysqli_fetch_array($r3))
        {
            echo "<div class='col-xs-4'><label class='btn btn-primary'><img src='images/$row3[2]' alt='...' class='img-thumbnail img-check'><input type='checkbox' name='$row3[1]' id='$row3[0]' value='$row3[3]'                           class='hidden' autocomplete='off'></label><p>$row3[3]</p></div>";
        }
        echo "</div>";
    }
    echo "</div>";
}


include('includes/footer.html');
?>