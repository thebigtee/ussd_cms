<?php
$original = "1,1,1,5,1,1,7,1,1,   ";
echo "Original Data : ".$original."<br/><hr/>";
//Remove the last "," if any
$original = str_replace(' ', '', $original);
$data = rtrim($original,", " );
echo "Trimmed Data: ".$data."<br><hr>";
$data = explode(",",$data);
var_dump($data);
$output = "";
//Loop through the array and append 'G'
foreach ($data as $datum) {
  # code...
  $output .= "G".$datum;
}

var_dump($output);
echo "php binary file: ".PHP_BINDIR;


 ?>
