<?php
  require_once 'vendor/autoload.php';
  use Leth\IPAddress\IP, Leth\IPAddress\IPv4, Leth\IPAddress\IPv6;
  require 'functions.php';
   //$ipaddress = getHostByName(getHostName());

  $ipaddress = getRealIpAddr() ;
?>
<html>
  <head>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/papercss@1.1.0/dist/paper.min.css">
    <title>Know Your IP!!</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="main.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript">
    // function findselected() { 
    //     var result = document.querySelector('input[name="paperRadios"]:checked').value;
    //     if(result=="ipv6"){
    //       console.log("disabled");
    //         document.getElementById("cidr").setAttribute('hidden', true);
    //     }
    //     else{
    //       console.log("enabled");
    //         document.getElementById("cidr").removeAttribute('hidden');
    //     }
    // }
  </script>
  </head>
  <body>
    <div class="paper container">
      <h1 class="text-center"><b>Know Your IP !!</b></h1>
      <hr>
      <?php 
      //$ipaddress = '192.168.0.1';
      //$reseverd =findReseverd($ipaddress);
      $cidr = findReseverd($ipaddress);
      $net_addr = IP\NetworkAddress::factory($ipaddress,$cidr);
      echo "<h3 class = 'text-success'>Your Current IP Address is : ".$ipaddress."</h3>";
        if ($net_addr instanceof IPV4\NetworkAddress ) 
          echo "<h4 class = 'text-muted'>Your Current IP Address Broadcast Address is : ".$net_addr->get_broadcast_address()."</h4>";
        echo "<h4 class = 'text-muted'>Your Current IP Address Subnetmask Address is : ".$net_addr->get_subnet_mask()."</h4>"; 
        if ($net_addr instanceof IPV4\NetworkAddress)
          echo "<h4 class = 'text-muted'>Your Current IP Address network class is : ".$net_addr->get_network_class()."</h4>"; 
      ?>
      <hr>
      <h1 class="text-center text-warning">Validate Your IP !!</h1>
      <form action="index.php" method="POST" role="form" class="form-horizontal" id="myForm" data-toggle="validator">
        <div class="row form-group">
          <div class="col sm-8">
            <div class="row">
               <div class="col sm-8">
                <h3 class="text-muted"><label>Choose IPV Format : </label><h3>
                <label for="paperRadios1" class="paper-radio">
                  <!-- <input type="radio" name="paperRadios" id="paperRadios1" value="ipv4" onChange="findselected()"> <span>IPV4<span> -->
                    <input type="radio" name="paperRadios" id="paperRadios1" value="ipv4"> <span>IPV4<span>
                </label>
                <label for="paperRadios2" class="paper-radio">
                  <!-- <input type="radio" name="paperRadios" id="paperRadios2" value="ipv6" onChange="findselected()"> <span>IPV6<span> -->
                     <input type="radio" name="paperRadios" id="paperRadios2" value="ipv6"> <span>IPV6<span>
                </label>

              </div>
              <div class="col sm-4">
                <iframe width="360" height="240" src="https://www.youtube.com/embed/8zEVA-Bxs-0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
              </div>
            </div>
             

                <h3 class="text-muted"><label>Enter IP Address : </label><h3>
                <div class="row">
                  <input class="input-block col sm-8" type="text" placeholder="Enter IP Address" name="ipaddress" id="ipaddress" required>
                  <input class="input-block col sm-4" type="text" placeholder="Enter CIDR(optional)" name="cidr" id="cidr">
                </div>
                
                <button popover="Submit to validate your IP" popover-position="top" type="submit" id="submit">SUBMIT</button>
             
              
          </div>
          
        </div>
      </form>
      <div class="ip-result"></div>
      <div class="display-error"></div>
      <hr>
    </div>
  </body>
</html>
