<?php

include('includes/header.html');

?>
    <div id="login_area">

        <form class="form-inline" method="post" action="index.php" id="login">
            <div class="form-group has-feedback" id="emailGroup">
                <label for="email" class="sr-only">
                    Email address
                </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>

            <div class="form-group has-feedback" id="passwordGroup">
                <label for="password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <button type="submit" class="btn btn-default">Sign in</button>


        </form>


        <div id="emailError">The email address is incorrect</div>
        <div id="passwordError"> The password is incorrect</div>

        <div id="results">

        </div>
        <div id="logged_in">
            <img class="inline">
            <div id="welcome" class="inline">
                <h3></h3>
                <a href="choice.php" role="button" class="btn btn-success">Let's Get Started</a>
                <a href="#" id="logout">
                    <span class="glyphicon glyphicon-log-out"></span>
                </a>
            </div>
        </div>
    </div>

    <?php

include('includes/footer.html');

?>