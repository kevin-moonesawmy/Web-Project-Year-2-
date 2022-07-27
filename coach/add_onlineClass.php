<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtreme Fitness|Coach</title>
    <link rel="stylesheet" href="css/mystyle.css?v=<?php echo time(); ?>">
    <?php
    require_once "includes/metatags.php";
    ?>
    <style>
        
        legend {
            text-align: center;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            margin: auto;
            font-size: 50px;
            padding: auto;
            font-weight: bold;
            
        }

        fieldset {
            margin: auto;
            padding: auto;
            margin-bottom: 3%;
            border-left: none;
            border-right: none;
            border-bottom: none;
        }

        .show {
            display: grid;
            grid-template-columns: auto auto auto;
            justify-items: center;
            margin-top: 5%;
            margin-bottom: 3%;
        }

        .polaroid {
            width: 430px;
            background-color: white;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin-bottom: 25px;
            border-radius: 25px;
        }

        .polaroid img {
            border-top-left-radius: 25px;
            border-top-right-radius: 25px;
        }

        .container {
            text-align: center;
            padding: 10px 20px;
        }

        .p2 {
            font-family: sans-serif;
            line-height: 0.5;
        }

        .show1 {
            cursor: pointer;
            margin-left: 1.5%;
        }
        #result{
            color: red;
        }
        #addBtn{
            border-radius: 5px;
            width: 250px;
            height: 40px;
            font-size: 20px;
            background-color: #00ff00;
            border: none;
            color: white;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bolder;
            
        }
        #addBtn:hover{
            background-color: #000033;
        }
        input{
            border-left: none;
            border-top: none;
            border-right: none;
            
        }
        input:focus{
            outline: none;
        }
        
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "view_onlineClassAjax.php",
                method: "GET",
                success: function(result) {
                    $("div#myClasses").html(result);

                },
                error: function(xhr) {
                    alert(xhr.statusText);
                }
            });

            $("#addClass").hide();

            $(".show1").click(function() {
                $("#addClass").show();
                $('html,body').animate({
                    scrollTop: $("#addClass").offset().top
                }, 1000);
            });

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            $('#txt_date').attr('min', today);

            $("#addBtn").click(function() {
                var cName = $("#txt_class").val();
                var cDate = $("#txt_date").val();
                var cTime = $("#txt_time").val();
                var duration = $("#txt_duration").val();
                //alert (cName+" "+cDate+" "+cTime+" "+duration);
                $.ajax({
                    url: "add_onlineClassAjax.php",
                    method: "POST",
                    data: {
                        txt_class: cName,
                        txt_date: cDate,
                        txt_time: cTime,
                        txt_duration: duration
                    },
                    success: function(text) {
                        //alert(text);
                        $("#result").html(text);
                        $.ajax({
                url: "view_onlineClassAjax.php",
                method: "POST",
                success: function(result) {
                    $("div#myClasses").html(result);
                    $('html,body').animate({
                    scrollTop: $("div#myClasses").offset().top
                }, 1000);
                },
                error: function(xhr) {
                    alert(xhr.statusText);
                }
            });
                    },
                    error: function(xhr) {
                        //alert(xhr.statusText);
                        $("#result").html('<b>Error</b>');
                    }
                });
            });
            
        });
        function deleteClass(id)
        {
            alert("this function");
        }
    </script>
</head>

<body>
    <?php
    $active_menu = "onlineClass";
    include('includes/menu.php'); ?>
    <div style="margin-left:20%;margin-right:5%;">
        <fieldset>
            <legend>Your classes</legend>
            <div id="myClasses"></div>
            <div class="show1">
                <div class="polaroid">
                    <img src="images/add.png" style="width: 100%;">
                    <div class="container">
                        <b>Add a class</b>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset id="addClass">
            <legend>Add your class</legend>
            <div style="text-align: center;margin-top:2%;">
            Class Name: <input type="text" name="txt_class" id="txt_class" required><br><br>
            Class Date: <input type="date" name="txt_date" id="txt_date" required><br><br>
            Class Time: <input type="time" name="txt_time" id="txt_time" required><br><br>
            Duration: <input type="text" name="txt_duration" id="txt_duration" required><br><br>
            <div id="result"></div><br><br>
            </div>
            
            <div style="text-align: center;"><button id="addBtn">Add</button></div>
        </fieldset>
        
    </div>
</body>

</html>