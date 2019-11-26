<?php
#Cache API data to ./cache folder

#Includes
#include "/var/www/html/master/public/graph_app/production/php/globalConfig.php";

#Companies array
$ccArray = array("1094622", "1123777", "1143619", "448019", "1147479", "373019", "720011", "434019", "1117688", "1093558", "199018", "257014", "258012", "345017", "462010", "475020", "1129493", "86027", "543017", "612010", "1085265", "1118116", "612024", "746016", "1082007", "1083443", "1083633", "1090315", "1094168", "1099571", "1102532", "1104058", "1105196", "1120161", "1121474", "1129451", "486027", "1140151", "1141316", "1141357", "1141969");

#Init times & dates
$todayDate=date("dmY");

$shiftDateWeek=date("dmY",strtotime("-7 days"));
$shiftDateMonth=date("dmY",strtotime("-1 months"));

$shiftDate1=date("dmY",strtotime("-1 years"));
$shiftDate5=date("dmY",strtotime("-5 years"));
$shiftDate3=date("dmY",strtotime("-3 years"));
$shiftDate6m=date("dmY",strtotime("-6 months"));
$shiftDate3m=date("dmY",strtotime("-3 months"));



#Handle connection to API
$jsonPresentation=file_get_contents('http://irwebsites.co.il/Investor_Relations/pages/gto/login.php');
$json_data_presentation=json_decode($jsonPresentation,true);


#Save cache for each company code. cache file pattern: 86027cached_6_month_data.json

for ($i = 0; $i < count($ccArray); $i++) {
    #Get data from API (from globalConfig.php)
    sleep(0.25);
    $apiCall_1week_data=historicalFunction_cache($shiftDateWeek,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_1month_data=historicalFunction_cache($shiftDateMonth,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_1year_data=historicalFunction_cache($shiftDate1,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_5year_data=historicalFunction_cache($shiftDate5,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_3year_data=historicalFunction_cache($shiftDate3,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_6month_data=historicalFunction_cache($shiftDate6m,$todayDate,$ccArray[$i]);
    sleep(0.25);
    $apiCall_3month_data=historicalFunction_cache($shiftDate3m,$todayDate,$ccArray[$i]);

    #Save cached data to ./chache local data repo

    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_1_week_data.json", $apiCall_1week_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_1_month_data.json", $apiCall_1month_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_1_year_data.json", $apiCall_1year_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_5_year_data.json", $apiCall_5year_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_3_year_data.json", $apiCall_3year_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_6_month_data.json", $apiCall_6month_data);
    save_cache("/var/www/html/master/public/graph_app/cache/".$ccArray[$i]."cached_3_month_data.json", $apiCall_3month_data);
    
}


#Func section
function save_cache($filePath, $apiOutput){
    #if(file_put_contents($filePath, json_encode($apiOutput, JSON_PRETTY_PRINT))) {
    if(file_put_contents($filePath, $apiOutput)) {
        echo '[*] Data successfully saved: ' . $filePath;
    }
    else 
        echo "error";
}



#Function for cached data
function historicalFunction_cache($shiftDate,$todayDate,$inputCC) {

    $curl = curl_init();
    
    
    #Dynamic API Path
    $path="https://api.gto.co.il:9005/v2/json/market/history?key=".$inputCC."&fromDate=".$shiftDate."&toDate=".$todayDate;
    
 #  echo "Path:"."<br>";
 #  echo $path;
 #  echo "<br>";
    
    global $json_data_presentation;

    echo "\n[!]API Key: " . $json_data_presentation["Login"]["SessionKey"];
    
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "9005",
        CURLOPT_URL => $path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "GET",
        //CURLOPT_POSTFIELDS => "{\n\t\"Login\": {\n\t\t\n\t\t\"User\":\"apizvi01\",\n\t\t\"Password\":\"12345\"\n\t\n\t}\n}",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "session: ".$json_data_presentation["Login"]["SessionKey"]
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    $jsonWorks = json_decode($response, true);
    echo "\n[!] Content: " . $jsonWorks["History"]["-Key"];
    return $response;
}

#END - Get data from API
?>



?>