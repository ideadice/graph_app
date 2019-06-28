<?php
#Cache API data to ./cache folder

#Includes
include "/var/www/html/master/public/graph_app/workground/php/globalConfig.php";

#Init times & dates
$todayDate=date("dmY");
$shiftDate1=date("dmY",strtotime("-1 years"));
$shiftDate5=date("dmY",strtotime("-5 years"));
$shiftDate3=date("dmY",strtotime("-3 years"));
$shiftDate6m=date("dmY",strtotime("-6 months"));
$shiftDate3m=date("dmY",strtotime("-3 months"));

#Get data from API (from globalConfig.php)
$apiCall_1year_data=historicalFunction($shiftDate1,$todayDate);
$apiCall_5year_data=historicalFunction($shiftDate5,$todayDate);
$apiCall_3year_data=historicalFunction($shiftDate3,$todayDate);
$apiCall_6month_data=historicalFunction($shiftDate6m,$todayDate);
$apiCall_3month_data=historicalFunction($shiftDate3m,$todayDate);

#Save cahced data to ./chache local data repo
save_cache("/var/www/html/master/public/graph_app/cache/cached_1_year_data.json", $apiCall_1year_data);
save_cache("/var/www/html/master/public/graph_app/cache/cached_5_year_data.json", $apiCall_5year_data);
save_cache("/var/www/html/master/public/graph_app/cache/cached_3_year_data.json", $apiCall_3year_data);
save_cache("/var/www/html/master/public/graph_app/cache/cached_6_month_data.json", $apiCall_6month_data);
save_cache("/var/www/html/master/public/graph_app/cache/cached_3_month_data.json", $apiCall_3month_data);

#Func section
function save_cache($filePath, $apiOutput){
    #if(file_put_contents($filePath, json_encode($apiOutput, JSON_PRETTY_PRINT))) {
    if(file_put_contents($filePath, $apiOutput)) {
        echo '[*] Data successfully saved: ' . $filePath;
    }
    else 
        echo "error";
}

?>