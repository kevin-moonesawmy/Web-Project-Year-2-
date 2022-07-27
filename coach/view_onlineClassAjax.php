<?php
session_start();
require_once "includes/db_connect.php";
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $("button.deletebtn").on('click',function(){
                var buttonID = $(this).attr('id');
                $.ajax({
                url: "delete_onlineClassAjax.php",
                method: "POST",
                data:{txt_value:buttonID},
                success: function(result) {
                    setTimeout(function(){
                        location.reload();
                    });
                },
                error: function(xhr) {
                    alert(xhr.statusText);
                }
            });
            }); 
        });
    </script>
    <style>
        .deletebtn {
            border-radius: 5px;
            width: 350px;
            height: 40px;
            font-size: 20px;
            background-color: #ff0000;
            border: none;
            color: white;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bolder;
        }

        .deletebtn:hover {
            background-color: #000033;
        }
    </style>
</head>

</html>
<?php
if (isset($_GET)) {
    //$name = "kevin@gmail.com";
    $name = $_SESSION['username'];
    $sQuery = "SELECT online_class.class_name,online_class.class_date,online_class.start_time,online_class.duration,online_class.imagepath
            FROM online_class
            WHERE online_class.coach_mail='" . $name . "'
            ORDER BY online_class.class_date ASC";
    $Result = $conn->query($sQuery);
    echo "<div class='show'>";
    while ($value = $Result->fetch()) {
        if ($value['class_date'] >= strftime("%Y-%m-%d")) {
            $id=$value['class_name'].'|'.$value['class_date'] . '|' . $value['start_time'];
            echo "<div class='polaroid' id='c". $value['class_name'] . '|' . $value['class_date'] . '|' . $value['start_time']."'>";
            echo '<img src=' . $value['imagepath'] . ' style="width: 100%;">';
            echo '<div class="container">';
            echo '<p class="p2"><b>' . $value['class_name'] . '</b></p>';
            echo '<p class="p2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
</svg> ';
            $dt = strtotime($value['class_date']);
            echo date("D", $dt) . " " . date("d", $dt) . " " . date("M", $dt) . " " . date("Y", $dt);
            echo '</p>';
            echo '<p class="p2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
<path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
</svg> ';
            echo $value['start_time'] . '</p>';
            echo '<p class="p2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
  <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
  <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
</svg> ' . $value['duration'] . '</p>';
            //echo '<button class="deletebtn" type="button" id="' . $value['class_name'] . '|' . $value['class_date'] . '|' . $value['start_time'] . '" onclick="deleteClass('.$id.')">Delete</button>';
            ?>
            <button class="deletebtn" type="button" id='<?php echo $id; ?>' onclick="deleteClass(<?php echo $id; ?>)">Delete</button>
            <?php
            echo '</div>';
            echo "</div>";
        }
    }
    echo "</div>";
}
?>
