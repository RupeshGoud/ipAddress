<?php
function getRealIpAddr(){
      if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
      }
      elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      else{
        $ip=$_SERVER['REMOTE_ADDR'];
      }
      return $ip;
  }
  function findReseverd($ipaddress){
    $arr = explode(".",$ipaddress);
    //echo $arr[0] ;
    if ($arr[0]>=0 && $arr[0]<=127) 
      $reseverd = 8;
    elseif ($arr[0]>=128 && $arr[0]<=191) 
      $reseverd = 16;
    elseif ($arr[0]>=192 && $arr[0]<=223) 
      $reseverd = 24;
    else 
      $reseverd = 24;
    return $reseverd;
  }
  function findCidr($ipaddress,$reseverd){
    $arr = explode(".",$ipaddress);
    if ($reseverd=8) {
      $firstSet = arr[1];
      //$secon
    }
    $bin = sprintf( "%08d", decbin( $reseverd ));
    return $cidr;
  }
?>