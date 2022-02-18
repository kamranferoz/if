<?php

  include_once "/var/www/vhosts/didx.net/httpdocs/kf/if/func/funnelfunction.php"; 

  $email            = "kamranferoz@yahoo.com";
  $funnelID         = 3503;
  $addEmailList     = 96;
  $removeEmailList  = 95;
  $addSMSList       = 125;
  $removeSMSList    = 124;
  $fName            = "Kamran";
  $lName            = "Feroz";
  $cellNo           = "03118859348";

  $get_data = createLead($email, $funnelID, $addEmailList, $removeEmailList, $addSMSList, $removeSMSList, $fName, $lName, $cellNo);

  echo "<PRE>";
  print_r($get_data);

?>