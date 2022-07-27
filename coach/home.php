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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <?php
  require_once "includes/metatags.php";
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $.ajax({
        url:"getAcceptedBookingJson.php",
        method:"POST",
        accepts:"application/json",
        error:function(xhr)
        {
          alert(xhr.statusText);
        },
        success:function(data)
        {
          if(data['msg']=='fail')
          {
            var msg="<br><br><h3 style='text-align:center'>No current bookings accepted.</h3>";
            $('#up_req').after(msg);

          }
          else
          {
            var count=1;
            var table_str="<table class='session_table'><thead><th>Name</th><th>Date</th><th>Time</th><th>Workout Plan</th></thead><tbody>";
            $.each(data.data,function(i,obj){
              table_str+="<tr class='rows' id='sess_row"+count+"' onclick='sessDisplay("+count+")'>";
              table_str+="<td id='"+obj['member_mail']+"'>";
              if(obj['member_cancel']=='1')
              {
                table_str+='<i id=sess_icon'+count+' style="color:red;" class="bi bi-exclamation-circle-fill"></i>';
              }
              table_str+=obj['firstname']+" "+obj['lastname']+"</td>";
              table_str+="<td>"+obj['date']+"</td>";
              table_str+="<td>"+obj['time_range']+"</td>";
              table_str+="<td>"+obj["name"]+"</td>";
              table_str+="</tr>";
              table_str+="<tr class='action_row' id=sess_action_row"+count+"><td></td>";
              if(obj['member_cancel']=='0')
              {
                table_str+="<td><label>Message:</label><br><input class='msg_input' id='sess_cancel_input"+count+"' type='text'></td>";
                table_str+="<td><button type='button' class='action_btn cancel_btn' id='sess_cancel_btn"+count+"' onclick='sessCancel("+count+")'>Cancel</button></td>";
              }
              else
              {
                table_str+="<td><span style='color:red;'>Cancelled by Client</span></td>";
                table_str+="<td><button type='button' class='action_btn remove_btn' id=sess_remove_btn'"+count+"' onclick='sessRemove("+count+")'>Remove</button></td>";

              }
              table_str+="<td></td></tr>";
              count++;
            });
            table_str+="</tbody></table>"
            $("#up_req").after(table_str);
            $(".action_row").hide();
          }
        }
      }); 
    });
    function sessDisplay(id)
    {
      $(".action_row").hide();
      $('.rows').removeClass("active");
      $('.rows td').removeAttr('style');
      $(".msg_input").removeAttr('style');


      $("#sess_icon"+id).hide();
      $("#sess_row"+id+" td").css("border-bottom","none");
      $("#sess_row"+id).addClass("active");
      $("#sess_action_row"+id).show(500);
    }
    function sessRemove(id)
    {
      var rowId=$('#sess_action_row'+id).prev().attr('id');
      var mail=$("#"+rowId).children().attr('id');
      var d=$("#"+rowId+" td:nth-child(2)").text();
      var time=$("#"+rowId+" td:nth-child(3)").text();
      $.ajax({
        url:"removeBookingsAjax.php",
        method:"POST",
        data:{member_mail:mail,date:d,time_range:time},
        error:function(xhr)
        {
          alert(xhr.statusText);
        },
        success:function()
        {
          $("#sess_row"+id).fadeOut(500,function(){
            $("#sess_row"+id).remove();
          });
          $("#sess_action_row"+id).fadeOut(500,function(){
            $("#sess_action_row"+id).remove();
          });
          
        }
      });
    }
    function sessCancel(id)
    {
      var msg=$("#sess_cancel_input"+id).val();
      if(!msg)
      {
        $("#sess_cancel_input"+id).css("border","2px solid red");
      }
      else
      {
        var rowId=$('#sess_action_row'+id).prev().attr('id');
        var mail=$("#"+rowId).children().attr('id');
        var d=$("#"+rowId+" td:nth-child(2)").text();
        var time=$("#"+rowId+" td:nth-child(3)").text();
        $.ajax({
          url:"updateBookingAjax.php",
          method:"POST",
          data:{action:"cancel",member_mail:mail,date:d,time_range:time,message:msg},
          error:function(xhr)
          {
            alert(xhr.statusText);
          },
          success:function()
          {
            $("#sess_row"+id).fadeOut(500,function(){
            $("#sess_row"+id).remove();
            });
            $("#sess_action_row"+id).fadeOut(500,function(){
              $("#sess_action_row"+id).remove();
            });
          }
        });
      }
    }
    function reqDisplay(id)
    {
      $(".action_row").hide();
      $('.rows').removeClass("active");
      $('.rows td').removeAttr('style');
      $(".msg_input").removeAttr('style');


      $("#req_icon"+id).hide();
      $("#req_row"+id+" td").css("border-bottom","none");
      $("#req_row"+id).addClass("active");
      $("#req_action_row"+id).show(500);
    }
    function reqRemove(id)
    {
      var rowId=$('#req_action_row'+id).prev().attr('id');
      var mail=$("#"+rowId).children().attr('id');
      var d=$("#"+rowId+" td:nth-child(2)").text();
      var time=$("#"+rowId+" td:nth-child(3)").text();
      $.ajax({
        url:"removeBookingsAjax.php",
        method:"POST",
        data:{member_mail:mail,date:d,time_range:time},
        error:function(xhr)
        {
          alert(xhr.statusText);
        },
        success:function()
        {
          $("#req_row"+id).fadeOut(500,function(){
            $("#req_row"+id).remove();
          });
          $("#req_action_row"+id).fadeOut(500,function(){
            $("#req_action_row"+id).remove();
          });
          
        }
      });
    }
    function reqReject(id)
    {
        var msg=$("#req_reject_input"+id).val();
        if(!msg)
        {
          $("#req_reject_input"+id).css("border","1px solid red");
        }
        else
        {
          var rowId=$('#req_action_row'+id).prev().attr('id');
          var mail=$("#"+rowId).children().attr('id');
          var d=$("#"+rowId+" td:nth-child(2)").text();
          var time=$("#"+rowId+" td:nth-child(3)").text();
          $.ajax({
            url:"updateBookingAjax.php",
            method:"POST",
            data:{action:"reject",member_mail:mail,date:d,time_range:time,message:msg},
            error:function(xhr)
            {
              alert(xhr.statusText);
            },
            success:function(data)
            {
              $("#req_row"+id).fadeOut(500,function(){
              $("#req_row"+id).remove();
              });
              $("#req_action_row"+id).fadeOut(500,function(){
               $("#req_action_row"+id).remove();
              });
            }
          });
        }
    }
    function acceptBooking(id)
    {
      var rowId=$('#req_action_row'+id).prev().attr('id');
      var mail=$("#"+rowId).children().attr('id');
      var d=$("#"+rowId+" td:nth-child(2)").text();
      var time=$("#"+rowId+" td:nth-child(3)").text(); 
      var msg=$("#req_reject_input"+id).val();
      $.ajax({
            url:"updateBookingAjax.php",
            method:"POST",
            data:{action:"accept",member_mail:mail,date:d,time_range:time,message:msg},
            error:function(xhr)
            {
              alert(xhr.statusText);
            },
            success:function(data)
            {
              $("#req_row"+id).fadeOut(500,function(){
              $("#req_row"+id).remove();
              });
              $("#req_action_row"+id).fadeOut(500,function(){
               $("#req_action_row"+id).remove();
              });
            }
          });
    }
  </script>
  <style>
    *{
      padding-right: 5px;
    }
    body{
      background-color: #f6f6f9;
      font-family: sans-serif;
    }
    h2{
      margin-top: 0;
      color:#363949;
      text-align: center;
    }
    table{
      border: 1px solid #dcdcdc;
      border-radius: 6px;
      background-color: #f6f6f9;
      margin-right: 20px;
      box-shadow: 0 2rem 3rem rgba(132,139,200,0.18);
      border-spacing: 0;
      font-size: 18px;
      padding: 1.8rem;
      margin: auto;
      text-align: center;
    }
    th,td{
      padding: 0 100px;
  
    }
    th{
      padding-bottom: 10px;
      font-size: 20px;
    }
    tbody tr:nth-last-child(2) td{
      border: none;
    }
    tbody td{
      padding: 20px 0;
      color:#363949;
      border-bottom: 1px solid #363949;
    }
    tbody tr{
      cursor: pointer;
      
    }
    tbody .rows:not(.active):hover{
      background-color: rgb(0,0,0,0.1);
      transition: 0.3s;
    }
    .action_btn{
      width: 100px;
      height: 35px;
      border:1px solid grey;
      outline: none;
      cursor: pointer;
      border-radius: 10px;
      font-size: 18px;
      font-weight: bold;
    }
    .cancel_btn:hover,.reject_btn:hover{
      background-color: red;
      color: white;
      transition: 0.5s;
    }
    .remove_btn:hover{
      width: 105px;
      font-size: 19px;
      transition: 0.3s;
    }
    .accept_btn:hover{
      background-color: lightgreen;
      transition: 0.5s;
    }
    .msg_input{
      height: 15px;
      width: 200px;
      font-size: 18px;
      font-family: sans-serif;
      padding: 2px;
      outline: none;
    }
  </style>
</head>  
<body>
  <?php
    $active_menu="home";
    include "includes/menu.php"; 
  ?>
  <div class="container" style="margin-left:16%; padding-bottom:5px;">
    <h2 id="up_req">Upcoming Sessions(Weekly):</h2>
  <br><br><br>
  <h2 style="color:green;" id="book_req">Booking Requests:</h2>
  <?php
  $url="http://localhost/ExtremeFitness/coach/getRequestedBookingJson.php";
  $json=file_get_contents($url);
  $obj=json_decode($json,false);
  if(sizeof($obj)==0)
  {
    echo "<br><br><h3 style='text-align:center'>No current requests.</h3>";
  }
  else
  {
    ?>
    <table class="requst_table">
      <thead>
        <th>Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Workout Plan</th>
      </thead>
      <tbody>
        <?php
    $count=1;
    foreach($obj as $result)
    {
      ?>
      
        <tr class="rows" <?php echo "id=req_row".$count; ?> onclick='reqDisplay(<?php echo $count; ?>)'>
          <td <?php echo "id=".$result->member_mail; ?>>
            <?php 
            if($result->member_cancel=='1')
            {
              ?>
              <i <?php echo "id=req_icon".$count; ?> style="color:red;" class="bi bi-exclamation-circle-fill"></i>
              <?php
            }
            ?>
          <?php echo $result->firstname." ".$result->lastname; ?>
        </td>
          <td><?php echo $result->date; ?></td>
          <td><?php echo $result->time_range; ?></td>
          <td><?php echo $result->name ?></td>
        </tr>
        <tr class="action_row" <?php echo "id=req_action_row".$count; ?>>
          <td></td>
          <?php
          if($result->member_cancel=='0')
          {
            ?>
            <td><label for="">Message:</label><br><input class="msg_input" <?php echo "id=req_reject_input".$count; ?> type="text"></td>
            <td>
              <button type="button" class="action_btn accept_btn" <?php echo "id=acpt_btn".$count; ?> onclick="acceptBooking(<?php echo $count; ?>)" >Accept</button>
              <button type="button"class="action_btn reject_btn" <?php echo "id=reject_btn".$count; ?> onclick='reqReject(<?php echo $count; ?>)'>Reject</button>
            </td>
            <td></td>
            <?php
          }
          else
          {
            ?>
            <td><span style="color:red;">Cancelled by Client</span></td>
            <td><button type="button" class="action_btn remove_btn" <?php echo "id=req_remove_btn".$count; ?> onclick="reqRemove(<?php echo $count; ?>)">Remove</button></td>
            <td></td>
            <?php 
          }
          ?>
       </tr>   
      <?php
      $count++;
    }
    ?>
    </tbody>
      </table>
      <?php 
  }
  ?>

  
  </div>
</body>

</html>