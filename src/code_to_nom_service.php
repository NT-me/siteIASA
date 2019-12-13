<?php
function ctn_service($service_dir){
  switch ($service_dir) {
    case '86883657':
    $NS = "Informatique";
    break;
    case '44609807':
    $NS = "Defense";
    break;
    case '91345364':
    $NS = "Elimination";
    break;
    case '22195465':
    $NS = "Enquete";
    break;
    case '78334802':
    $NS = "Enquete interne";
    break;
    case '6350262':
    $NS = "Action";
    break;
    case '1738411':
    $NS = "Assistance";
    break;
    case '17410830':
    $NS = "Contre-espionnage";
    break;
  }

  return $NS;
}
?>
