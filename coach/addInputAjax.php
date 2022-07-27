<?php
session_start();
$c=$_POST['count'];
?>
<tr <?php echo "id=row".$c; ?>>
            <td><input type="text" name="name" <?php echo "id=name".$c; ?>></td>
            <td><input type="text" name="set" <?php echo "id=set".$c; ?>></td>
            <td><input type="text" name="rep" <?php echo "id=rep".$c; ?>></td>
            <td><button type="button" class="remove_btn" <?php echo "id=remove_btn".$c; ?> onclick="removeInput(<?php echo $c; ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
            </svg></button>
            </td>
</tr>