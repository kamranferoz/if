<?php

  function createLead($email, $funnelID, $addEmailList, $removeEmailList, $addSMSList, $removeSMSList, $fName, $lName, $cellNo)
  {
    $url    = "https://interfunnels.com/app/web/api/leads/create"; 
    $curlError = "";

    $data = array (
                    'email'=> $email ,
                    'funnel_id' => $funnelID ,
                    "email_autoresponder" => array(
                                                    "add_to_list" => $addEmailList ,
                                                    "remove_from_list" => $removeEmailList 
                                                  ),
                    "params" => array(
                                      'firstname' => $fName ,
                                      'lastname' => $lName ,
                                      'cellphonenumber' => $cellNo
                                      ),
                    "sms_autoresponder" => array(
                                                  "add_to_list" => $addSMSList ,
                                                  "remove_from_list" => $removeSMSList
                                                )
                  );

    $emailID = $data['email'];
    $funnelID = $data['funnel_id'];
    $array = $data;

    $post = json_encode($array, true);
    $x = curl_init($url );

    curl_setopt($x, CURLOPT_POST, true);
    curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($x, CURLOPT_URL, $url);
    curl_setopt($x, CURLOPT_HTTPHEADER, array(
                                                'X-Auth-Token: a5568e01ea920b21499eb6c588734f06',
                                                'Content-Type: application/json',
                                              )
                );
    curl_setopt($x, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($x, CURLOPT_SSLVERSION, 6);
    curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($x, CURLOPT_POSTFIELDS, $post);
    curl_setopt($x, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($x, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($x, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    #Send message
    $result = curl_exec($x) or die($curlError = "Interfunnels server error!");

    $response = json_decode($result , true);

    if(isset($response["message"]))
    {
      $curlError .= $response["message"] .": <br>";

      if(isset($response["erorrs"][0]))
      {
        $curlError .=  $response["erorrs"][0] ."<br>";
      }     
    }

    if(!$result)
    {
      $result = curl_error($curl);
      $curlError .= curl_error($curl) ."<br>";
    }

    if(!empty($curlError))
    {
      $toEmail = 'kamran@supertec.com';
      $subject = 'Unable to send data to Interfunnels.com';

      $headers = 'From: care@didx.net'. "\r\n";
      // $headers .= 'CC: cticket@supertec.com' ."\r\n";
      $headers .= "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      $curlError = $curlError ."<br><i>" .$post ."</i>";

      mail($toEmail, $subject, $curlError, $headers);  
    }

    // return $result;
    exit();
  }

?>