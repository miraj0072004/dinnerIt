<?php
require('includes/config.inc.php');
include('includes/header.html');

require MYSQL;
?>
    <div id="choice_outlet">
        <form class="form-inline" method="post" action="choice.php" id="update">

            <div class="form-group">

                <div class="col-sm-3">
                    <select class="form-control" id="selectOutlet">
                        <option value="0">Choose Outlet...</option>
                        <!--
                        <option>lynda.com</option>
                        <option>raybo.org</option>
                        <option>iviewsource.com</option>                        
-->
                        <?php
                        $q="select outlet_id,outlet_name from outlets order by outlet_name";
                        $r=mysqli_query($dbc,$q);
                        
                        while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
                        {
                           echo  "<option value=\"".$row['outlet_id']."\">".$row['outlet_name']."</option>";
                        }
                        ?>
                    </select>

                </div>

            </div>

            <button type="submit" class="btn btn-default">Update</button>
        </form>
    </div>

    <div id="choices">
        <?php
        mysqli_data_seek( $r, 0 );
        while ($row=mysqli_fetch_array($r))
        {
           echo
               "
                <section class=\"col-xs-12 choice_outlets\">
                    <div id=\"choice-container\" class=\"row\">
                        <div class=\"col-xs-1 col-xs-offset-3 \">
                            <img class=\"img-thumbnail center-block\" src=\"images/outlets/".$row['outlet_id'].".jpg\" alt=\"Icon\">
                        </div>
                        <div id=".$row['outlet_id']." class=\"col-xs-5 choice-users\">

                        </div>
                    </div>
                </section>
               ";
        }
        ?>
    </div>
    <div class="text-center">
        <a href="choose.php" role="button" class="btn btn-success" id="continue">Continue</a>
    </div>
    <?php
include('includes/footer.html');
?>