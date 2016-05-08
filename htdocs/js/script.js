$(document).ready(function (e) {
    $(".img-check").click(function () {
        $(this).toggleClass("check");

        //if the item has the class check then add the spinner,if not remove the spinner
        if ($(this).hasClass("check")) {
            var item_val = $(this).next().val();
            var input_id = $(this).next().attr("id");
            var input_name = $(this).next().attr("name");


            //var newInput = $('<input/>').attr({ type: 'text', id: $(this).next().attr("id"), name: 'test',class :'spinner'});

            //            var newInput = $('<div class="form-group"><p id="selected' + input_id + '"><label for="' + input_id + '">' + input_name + '</label><div class="col-sm-2"><input type="text" size="2" id="' + input_id + '" name="' + input_name + '" class="spinner"/></div></p></div>');

            //creating the spinners as the items are chosen
            var newInput = $('<div class="form-group" id="selected' + input_id + '"><label class="col-sm-3 control-label" for="' + input_id + '">' + input_name + '</label><div class="col-sm-4"><input type="text"  id="' + input_id + '" name="' + input_id + '" class="spinner form-control" value="1" /></div><label class="control-label col-sm-5 selected_price" id="selected_price' + input_id + '">' + item_val + '</label></div>');

            //            var newP = $("<p>");
            //            newP.attr("id", $(this).next().attr("id"))
            //            newP.append(item_val);
            //$("#pricing").append(newP);
            //$("#pricing form").append(newInput);
            $("#pricing form").prepend(newInput);
            $("#sum").html((parseFloat($("#sum").html()) + parseFloat(item_val)).toFixed(2)); //initial setting up of the sum value as the items are chosen

            $("#pricing form").find("#" + input_id).spinner({
                min: 1,
                spin: function (event, ui) {
                    console.log($(this).val());
                    console.log(ui.value)
                    console.log(item_val);
                    console.log(ui.value * item_val);
                    $("#pricing form").find("#selected_price" + input_id).html((parseFloat(ui.value * item_val)).toFixed(2));
                    //$(this).next().html(ui.value * item_val);
                    if (($(this).val() - ui.value) > 0) {
                        var sum = (parseFloat($("#sum").html()) - parseFloat(item_val)).toFixed(2);

                    } else if (($(this).val() - ui.value) < 0) {
                        var sum = (parseFloat($("#sum").html()) + parseFloat(item_val)).toFixed(2);
                    } else {
                        var sum = parseFloat($("#sum").html()).toFixed(2);
                    }

                    //                    $(".selected_price").each(function () {
                    //                        sum += Number($(this).val());
                    //                    });
                    $("#sum").html(sum);
                    console.log("The sum is " + sum);
                    checkLimit(sum);

                }
            });
            checkLimit(parseFloat($("#sum").html()));
        } else {
            var sum = (parseFloat($("#sum").html()) - parseFloat($("#pricing form").find("#selected_price" + $(this).next().attr("id")).html())).toFixed(2);
            $("#sum").html(sum);
            $("#pricing form").find("#selected" + $(this).next().attr("id")).remove();
            checkLimit(parseFloat($("#sum").html()));

        }

        canSubmitEnable();
    });

    function checkLimit(sum) {
        if (sum > 500) {
            $("#sum").css("color", "red");
        } else {
            $("#sum").css("color", "black");
        }
    }

    $("#accordionCtrl").accordion({
        autoHeight: false,
        heightStyle: "content"
    });



    //    console.log($(this).next().attr("id")+"'");
    //    $("#pricing").find("'#"+$(this).next().attr("id")+"'").spinner();

    $("#logged_in").hide();
    $("#emailError").hide();
    $("#passwordError").hide();
    $("#results").hide();

    // Assign an event handler to the form:
    $('#login').submit(function () {

        // Initialize some variables:
        var email, password;

        // Validate the email address:
        if ($('#email').val().length >= 6) {

            // Get the email address:
            email = $('#email').val();

            // Clear an error, if one existed:
            //$('#emailP').removeClass('error');

            // Hide the error message, if it was visible:
            $('#emailGroup').removeClass('has-error');
            $('#emailError').hide();

        } else { // Invalid email address!

            // Add an error class:
            $('#emailGroup').addClass('has-error');

            // Show the error message:
            $('#emailError').show();

        }

        // Validate the password:
        if ($('#password').val().length > 0) {
            password = $('#password').val();
            $('#passwordGroup').removeClass('has-error');
            $('#passwordError').hide();
        } else {
            $('#passwordGroup').addClass('has-error');
            $('#passwordError').show();
        }

        // If appropriate, perform the Ajax request:
        if (email && password) {

            // Create an object for the form data:
            var data = new Object();
            data.email = email;
            data.password = password;

            // Create an object of Ajax options:
            var options = new Object();

            // Establish each setting:
            options.data = data;
            options.dataType = 'text';
            options.type = 'get';
            options.success = function (response) {

                // Worked:
                //alert( response );
                if (String(response).trim() == 'CORRECT') {

                    // Hide the form:
                    $('#login').hide();
                    $("#results").hide();
                    // Show a message:
                    //$('#results').removeClass('error');
                    $('#logged_in').show();
                    $('#logged_in h3').html('Welcome ' + getCookie('user_name') + ' !');
                    $("#logged_in img").attr("src", "images/users/" + getCookie('user_name') + ".jpg");

                } else if (response == 'INCORRECT') {
                    $('#results').text('The submitted credentials do not match those on file!');
                    $('#results').show();
                    // $('#results').addClass('error');
                } else if (response == 'INCOMPLETE') {
                    $('#results').text('Please provide an email address and a password!');
                    $('#results').show();
                    //$('#results').addClass('error');
                } else if (response == 'INVALID_EMAIL') {
                    $('#results').text('Please provide your email address!');
                    $('#results').show();
                    //$('#results').addClass('error');
                } else {
                    $('#results').text(response);
                    $('#results').show();
                    //$('#results').addClass('error');
                }

            }; // End of success.
            options.url = 'login_ajax.php';

            // Perform the request:
            $.ajax(options);

        } // End of email && password IF.

        // Return false to prevent an actual form submission:
        return false;

    });

    $('#update').submit(function () {


        //        var options = new Object();
        //        var data = new Object();
        //        data.outlet_id = $("#selectOutlet").val();
        //        options.data = data;
        //        options.dataType = 'text';
        //        options.type = 'get';
        //        options.success = function (response) {
        //
        //            //            $.getJSON(response, function (info) {
        //            //
        //            //                $("#choices").append(info.test);
        //            //
        //            //            });
        //
        //            var data = $.parseJSON(response);
        //            //$("#choices").append(myObj["test"]);
        //
        //            $(".choice-users").empty();
        //            $.each(data, function (index, item) {
        //                //console.log(item);
        //                var a = $("#choices #" + index); 
        //                
        //                $.each(item, function (indexChild, itemChild) {
        //                    //a.append(itemChild + ",");
        //                    a.append('<img class="img-circle img-responsive center-block pull-left" src="images/users/'+itemChild+'.jpg" alt="Icon">');
        //                });
        //            });
        //
        //        };
        //        options.url = "update_ajax.php";
        //
        //        $.ajax(options);

        updateChoice();
        isContinue();
        return false;
    });

    function updateChoice() {
        var options = new Object();
        var data = new Object();
        data.outlet_id = $("#selectOutlet").val();
        options.data = data;
        options.dataType = 'text';
        options.type = 'get';
        options.success = function (response) {

            //            $.getJSON(response, function (info) {
            //
            //                $("#choices").append(info.test);
            //
            //            });

            var data = $.parseJSON(response);
            //$("#choices").append(myObj["test"]);

            $(".choice-users").empty();
            $.each(data, function (index, item) {
                //console.log(item);
                var a = $("#choices #" + index);

                $.each(item, function (indexChild, itemChild) {
                    //a.append(itemChild + ",");
                    a.append('<img class="img-circle img-responsive center-block pull-left" src="images/users/' + itemChild + '.jpg" alt="Icon">');
                });
            });

        };
        options.url = "update_ajax.php";

        $.ajax(options);
    }

    //to travese through a json object
    function traverse(jsonObj) {
        if (typeof jsonObj == "object") {
            $.each(jsonObj, function (k, v) {
                // k is either an array index or object key
                traverse(v);
            });
        } else {
            // jsonOb is a number or string            
        }
    }

    $("#logout").click(
        function () {
            var options = new Object();
            options.url = "logout_ajax.php";
            options.success = function () {
                $('#login').show();
                $('#logged_in').hide();
            };
            $.ajax(options);
            return false;
        }
    );

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    //    var myWindow;
    // 
    //$("#checkout").click
    //(
    //    function(evt) {
    //        
    //        myWindow=window.open("thanks.php");
    //    }
    //)

    //this is to show the current choices when the user loads 

    if (document.location.pathname.indexOf("choice") > 0) {
        updateChoice();
    }

    //when the drop down to choose outlets changes values
    $("#selectOutlet").change(function () {
        //isContinue();
        if ($("#selectOutlet").val() == 0) {
            $("#continue").addClass("disabled");
        }
    });

    //function to check whether a proper outlet is selected in the drop down. if so the continue button will be enabled. this is called when the page is loaded and also when the drop down changes
    function isContinue() {
        if ($("#selectOutlet").val() == 0) {
            $("#continue").addClass("disabled");
        } else {
            $("#continue").removeClass("disabled");
        }

    }

    //contine button checking when the page is loaded
    isContinue();

});

function canSubmitEnable() {
    if ($('#pricing div[id^="selected"]').length) {
        //$("#submitChoice").removeClass("disabled");
        $("#submitChoice").prop('disabled', false);
    } else {
        //$("#submitChoice").addClass("disabled");
        $("#submitChoice").prop('disabled', true);
    }
}

canSubmitEnable();