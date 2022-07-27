<?php
    $current=getdate();
    $day=$current['year'].'-'.$current['mon']."-".$current['mday'];
    $x=date_create($day);
    date_add($x,date_interval_create_from_date_string("1 days"));
    echo date_format($x,'Y-m-d');
    ?>