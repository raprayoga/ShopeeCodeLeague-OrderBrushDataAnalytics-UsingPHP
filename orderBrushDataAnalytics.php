<?php

set_time_limit(3600);

$filename = 'order_brush_order.csv';

// The nested array to hold all the arrays
$the_big_array = [];
$sortData = [];
$result = [];
$shopid = 0;
$shopidData = [];
$resultSort = [];

// Open the file for reading
if (($h = fopen("{$filename}", "r")) !== FALSE) 
{
  while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
  {
    $sortData[] = $data[1];
  }
  
  sort($sortData);

  for ($i = 1; $i < count($sortData); $i++)
  {
    if ( $sortData[$i] != $shopid ) {
      $shopidData[] = $sortData[$i];
      $shopid = $sortData[$i];
    }
  }
}


if (($h = fopen("{$filename}", "r")) !== FALSE) 
{
  for ($m = 0; $m < count($shopidData); $m++)
  {
    $result = [];
    $resultSort = [];
    $ord = [];
    $solution = [];
    $h = fopen("{$filename}", "r");
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
    {
      if ( $data[1] == $shopidData[$m]) {
        $result[] = $data;
      };
    }
    // print_r($result);

    foreach ($result as $key => $value){
      $ord[] = strtotime($value[3]);
    }

    sort($ord);

    for ($k = 0; $k < count($result); $k++)
    {
      foreach ($result as $key => $value) {
        if (strtotime($value[3]) == $ord[$k]) {
          $resultSort[] = $value;
        }
      }
    }

    for ( $l = 0; $l < count($resultSort)-6; $l++) {
      $loop = 1;
      $order = 1;
      $userid = [$resultSort[$l][2]];
      while ($loop == 1) {
        if ( strtotime($resultSort[$l + ($order)][3]) - strtotime($resultSort[$l][3]) <= 3600) {
          $order += 1;
          if ($resultSort[$l + ($order)][2] != $userid[count($userid)-1]) {
            $userid[] = $resultSort[$l + ($order)][2];
          }
        } else {
          $loop = 0;
          if($order >= 3){
            $concentrate = $order/count($userid);
            if ($concentrate >= 3) {
              echo "Ada";
              echo "<br>";
            }
          }
        }
      }
    }
  }
}
// }
// Display the code in a readable format
// echo "<pre>";
// var_dump($solution);
// echo "</pre>";