<?php
    require_once 'vendor/autoload.php';
    use Leth\IPAddress\IP, Leth\IPAddress\IPv4, Leth\IPAddress\IPv6;
    require 'functions.php';
    $errorMSG = "";
    $cidr = NULL;
    $class_D = false;
    $class_E = false;
    if (empty($_POST['ip']) || empty($_POST['ipv_format']) ){
        if (empty($_POST['ip'])) 
            $errorMSG .= "<li>IP is required</li>";
        if(empty($_POST['ipv_format']))
            $errorMSG .= "<li>Please select the ipv format </li>";
    }
    else{
        if ($_POST['ipv_format'] == "ipv4") {
            $ipaddress = $_POST['ip'];
            $arr = explode(".",$ipaddress);
            if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
                $errorMSG .= "<li>Invalid IPv4 Address</li>";
            elseif ($arr[0]==0 || $arr[0]==255 ) {
                $errorMSG .= "<li>This IP Address Cannot be given</li>";
            }elseif ($arr[0]==127 ) {
               $errorMSG .= "<li>This IP Address loopback address</li>";
            }elseif ($arr[0]>=224 && $arr[0]<=239) {
                $class_D = true;
            }elseif ($arr[0]>=240 && $arr[0]<=254) {
                $class_E = true;
            }

            if (!empty($_POST['cidr'])) {
                $class_bool = false;
                $cidr = $_POST['cidr'];}
            else{
                 $class_bool = true;
                 $cidr =findReseverd($ipaddress);
            }

            if (!empty($_POST['cidr'])) {
                var_dump($_POST['cidr']);
                if (is_numeric($_POST['cidr'])) {
                   if (($_POST['cidr']<10 || $_POST['cidr']>30)) {
                       $errorMSG .= "<li>Please enter between 10-30</li>";
                   }
                }else{
                    $errorMSG .= "<li>Please enter digits in CIDR</li>";
                }
                
            }  
        }
        if ($_POST['ipv_format'] == "ipv6") {
            if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) 
                $errorMSG = "<li>Invalid IPv6 Address</li>";
            if (!empty($_POST['cidr'])) {
                //$class_bool = false;
                $cidr = $_POST['cidr'];}
            else{
                //$class_bool = true;
                $cidr = 64;
            }

            if (!empty($_POST['cidr']) && ($_POST['cidr']<64)) {
            $errorMSG = "<li>Please enter more than 64</li>";


        }   

        }  
           
    }

    if(empty($errorMSG)){
        $ipaddress = $_POST['ip'];
        if ($cidr == NULL) {
            $net_addr = IP\NetworkAddress::factory($ipaddress);
        }else
            $net_addr = IP\NetworkAddress::factory($ipaddress,$cidr);
        if ($_POST['ipv_format'] == "ipv4") {
            if ($class_D || $class_E) {
                if ($class_D) {
                   $msg = "<li>Class D</li>";
                   $msg .= "<li>This Address cannot be given as it is Reserved for Multicasting</li>";
                }
                else if ($class_E) {
                   $msg = "<li>Class E</li>";
                   $msg .= "<li>This Address cannot be given as it is for Experimental; used for research</li>";
                }
                
            }else{
                $broadcast_address = $net_addr->get_broadcast_address();
                $sunet_mask = $net_addr->get_subnet_mask();
                $class = $net_addr->get_network_class();
                $msg = "<li>Broadcast Address ".$broadcast_address."</li>";
                $msg .= "<li>Subnet Mask ".$sunet_mask."</li>";
                if ($class_bool == true) {
                    $msg .= "<li>Class ".$class."</li>";
                }
            }
            
            
        }else{
            if (!empty($_POST['cidr']) && ($_POST['cidr']==128)) {
                $msg = "This is the loopback Address";
             }
            else{
                $sunet_mask = $net_addr->get_subnet_mask();
                $msg = "<li>Sunet Mask ".$sunet_mask."</li>";
            }
            
       
        //$res = array("Broadcast address"=>$broadcast_address, "Sunet Mask"=>$sunet_mask, "Class"=>$class);
    	echo json_encode(['code'=>200, 'msg'=>$msg]);
    	exit;
    }
    echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
?>