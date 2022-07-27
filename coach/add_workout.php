<?php
  session_start();
  
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/mystyle.css?v=<?php echo time(); ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <?php
    require_once "includes/metatags.php";
  ?>
  <title>Xtreme Fitness|Coach</title>
  <script>
    $(document).ready(function(){
      $('.add_workout_form').hide();
      $('.remove_btn').hide();
      $("#cancel_btn").click(function(){
        $(".add_workout_form").hide(1400);
        $('.start_btn').show(1500);
      });
      $("#create_btn").click(function(){
        $('.start_btn').hide(1400);
        $('.add_workout_form').show(1500);
      });
      $('#workout_id_input').focusout(function(){
        var id_entered=$(this).val();
        if(id_entered)
        {
          $.ajax({
            url:"checkWorkoutIdAjax.php",
            method:"POST",
            data:{workout_id:id_entered},
            error:function(xhr)
            {
              alert(xhr.statusText);
            },
            success:function(data)
            {
              if(data)
              {
                $('#id_fieldset').css("border","2px solid red");
                $("#id_legend").text("Workout_id already exits");
                $("#id_legend").css("color","red");
              }
              else{
                $("#id_fieldset").css("border","2px solid darkgreen");
                $("#id_legend").text("Workout Id:");
                $("#id_legend").css("color","white");
              }
            }
          });
        }
      });
    });
    function displayMoreInput()
    {
      var c=$(".list").find("tr").length;
      c=c-1;
      $.ajax({
        url:"addInputAjax.php",
        method:"POST",
        data:{count:c},
        error:function(xhr){
          alert(xhr.statusText);
        },
        success:function(data){
          var row="#row"+(c-1);
          $(row).after(data);
          $('.remove_btn').show();
          $("#add_fieldset").css("height","+=36px");

        }
      });
    }
    function removeInput(row)
    {
      var id=("#row"+row); 
      $(id).remove();
      $("#add_fieldset").css("height","-=36px");
      var rowCount=$(".list").find("tr").length-2;
      for(var i=1;i<=rowCount;i++)
      {
        var row1="tbody tr:nth-child("+i+")";

        var nameId="name"+i;
        $(row1+" td input[name='name']").attr('id',nameId);

        var setId="set"+i;
        $(row1+" td input[name='set']").attr('id',setId);

        var repId="rep"+i;
        $(row1+" td input[name='rep']").attr("id",repId);
        var btnid="remove_btn"+i;
        $(row1+" td button").attr('id',btnid);
        var para="removeInput("+i+")";
        $(row1+" td button").attr("onclick",para);

        var rowid="row"+i;
        $(row1).attr('id',rowid);

      }  
      if(rowCount==1)
      {
        $(".remove_btn").hide();
      }
    }
    function enterData()
    {
      var workout_id=$("#workout_id_input").val();
      var workout_name=$("#workout_name_input").val();
      var bodypart=$("input[name='txt_bp']:checked").val();
      var cat=$("#category_select").val();
      var comments=$("#comment_input").val();
      var rowCount=$(".list").find("tbody tr").length-1;
      var desc="";
      for(var i=1;i<=rowCount;i++)
      {
        var name=$("#name"+i).val();
        var set=$("#set"+i).val();
        var rep=$("#rep"+i).val();
        if(name && set && rep)
        {
          if(i==1)
          {
            desc+=name+","+set+","+rep;
          }
          else
          {
            desc+="|"+name+","+set+","+rep;
          }
          
        }
      }
      $.ajax({
        url:"storeWorkoutAjax.php",
        method:"POST",
        data:{id:workout_id,name:workout_name,description:desc,body_part:bodypart,category:cat,comment:comments},
        error:function(xhr)
        {
          alert(xhr.statusText);
        },
        success:function()
        {
          $(".add_workout_form").hide(1400);
          $('.start_btn').show(1500);
        }
      });
    }
  </script>
  <style>
    body{
      background: url("images/addwo.jpg");
      background-position: center;
    }
    .start_btn{
      display: block;
      margin: auto;
      position: relative;
      top:45%;
      margin-bottom: 10px;
      width: 370px;
      height: 50px;
      border: 2px solid white;
      outline: none;
      border-radius: 6px;
      background-color: transparent;
      font-size: 30px;
      font-weight: bold;
      color: white;
      cursor: pointer;
    }
    .start_btn:hover{
      background-color: white;
      color:black;
    }
    #add_fieldset{
      border: 3px solid rgb(6,0,255);
      height: 100%;
      margin-left: 10px;
      margin-right: 5px;
      position: relative;
      top:15px;
    }
    #add_legend{
      color: white;
      font-weight: bold;
      font-size: 25px;
      font-family: sans-serif;
      margin: auto;
      padding: 0 10px;
    }
    .value_fieldset{
      border: 2px solid white;
      border-radius: 6px;
      height: 70px;
      margin-bottom: 5px;
    }
    .value_legend{
      color:white;
      font-size: 18px;
      font-weight: bold;
    }
    .value_input{
      width: 100%;
      height: 50px;
      display: block;
      padding: 5px;
      background-color: transparent;
      outline: none;
      border: none;
      font-size: 20px;
      font-weight: bold;
      color: white;
    }
    #bp_label,#category_label{
      color: white;
      font-size: 25px;
      font-weight: bold;
      position: relative;
      top:20px;
    }
    .value_label{
      font-size: 20px;
      color: white;
      font-weight: bold;
      position: relative;
      left:100px;
      top:20px
    }
    [type=radio]{
      position: relative;
      left:100px;
      top:20px;
      margin-right: 10px;
    }
    #category_label{
      position: relative;
      top:50px;
    }
    #category_select{
      position: relative;
      top: 50px;
      left: 30px;
      width: 200px;
      height: 25px;
      font-size: 20px;
      font-weight: bold;
      outline: none;
    }
    table{
      position: relative;
      top:80px;
      margin: auto;
      font-size: 20px;
      font-family: sans-serif;
      color: white;
      border-spacing: 10px;
    }
    table th{
      
      padding-bottom: 10px;
    }
    table td{
      padding-bottom: 10px;

    }
    .list input{
      height:25px;
      outline: none;
      font-size: 20px;
     
    }
    .remove_btn{
      background-color: transparent;
      border: none;
      outline: none;
      cursor: pointer;
    }
    #more_btn{
      background-color: transparent;
      outline: none;
      border: none;
      color: white;
      cursor: pointer;
    
    }
    .bot_btn{
      position: relative;
      top:110px;
      left:425px;
      width: 150px;
      height:40px;
      font-size: 20px;
      font-weight: bold;
      color:white;
      background-color: transparent;
      outline: none;
      border-radius: 6px;
      border: 2px solid white;
      cursor: pointer;
      margin-right: 50px;
    }
    #cancel_btn:hover{
      background-color: white;
      color: black;
    }
    #add_btn{
      width: 160px;
      border: 2px solid lightblue;
    }
    #add_btn:hover{
      background-color: rgb(6,0,255);
      color:white;
    }
    #add_btn:disabled{
      background-color: rgb(220,220,220,0.5);
      color: rgb(0,0,0,0.5);
      border: none;
      cursor: default;
    }
  </style>
</head>
<body>
  <?php
    $active_menu="workout"; 
   
    include "includes/menu.php";
  ?>
  <button id="view_btn" type="button" class="start_btn"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg> View Workouts</button>
<button id="create_btn" type="button" class="start_btn"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg> Create Workout</button>
<div class="add_workout_form" style="margin-left: 15%;">
    <fieldset id="add_fieldset">
      <legend id="add_legend">+Add Workout</legend>
      <fieldset id="id_fieldset" class="value_fieldset">
        <legend class="value_legend" id="id_legend">Workout Id:</legend>
        <input type="text" value="" class="value_input" id="workout_id_input" required>
      </fieldset>
      <fieldset id="name_fieldset" class="value_fieldset">
        <legend class="value_legend">Workout Name:</legend>
        <input type="text" value="" class="value_input" id="workout_name_input">
      </fieldset>
      <label class="form_label" id="bp_label">Body Part:</label>
      <label class="value_label">Full</label><input type="radio" value="full" name="txt_bp" id="" checked>
      <label class="value_label">Upper</label><input type="radio" value="upper" name="txt_bp" id="">
      <label class="value_label">Lower</label><input type="radio" value="lower" name="txt_bp" id=""><br>
      <label id="category_label">Category:</label>
      <select name="txt_category" id="category_select">
        <option value="">Select a category</option>
        <option value="body building">Body Building</option>
        <option value="yoga">Yoga</option>
        <option value="circuit training">Circuit Training</option>
        <option value="cross fit">Cross Fit</option>
        <option value="weight loss">Weight Loss</option>
        <option value="body sculpturing">Body Sculpturing</option>
        <option value="recovery">Recovery</option>
        <option value="all rounder">All Rounder</option>
        <option value="cycling">Cycling</option>
      </select>
      <fieldset id="comment_fieldset" class="value_fieldset" style="position:relative; top:70px;">
        <legend class="value_legend">Comment(brief):</legend>
        <input type="text" value="" class="value_input" id="comment_input">
      </fieldset>
      <table class="list">
        <thead>
          <th>Exercise Name</th>
          <th>No of Sets</th>
          <th>Reps/Mins</th>
        </thead>
        <tbody>
          <tr id="row1">
            <td><input type="text" name="name" id="name1" placeholder="E.g Exercise"></td>
            <td><input type="text" name="set" id="set1" placeholder="4"></td>
            <td><input type="text" name="rep" id="rep1" placeholder="10 reps"></td>
            <td><button type="button" class="remove_btn" id="remove_btn1" onclick="removeInput('1')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
            </svg></button>
            </td>
          </tr>
          <tr id="more_row">
            <td></td>
            <td style="padding-left: 110px;"><button id="more_btn" type="button" onclick="displayMoreInput()"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
            </svg></button></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <button id="cancel_btn" type="button" class="bot_btn">X Cancel</button>
      <button id="add_btn" type="button" class="bot_btn" onclick="enterData()">+Add Workout</button>
    </fieldset>
</div>
</body>
</html>