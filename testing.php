<?php 
               
 function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}

$week_array = getStartAndEndDate(1,2020);
print_r($week_array);
echo date("W",strtotime('28th December 2019')) .' Weeks<br>';
                





                 ?>  