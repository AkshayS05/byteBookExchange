<?php
$names = array('Akshay', 'Sunny', 'Tarun');

$count = 0;

// here count which is php method will count the length of the vairable 
while($count < count($names)){
  echo "<li>Hi, my name is $names[$count] </li>";
  $count++;
}
?>

