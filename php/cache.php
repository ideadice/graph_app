<?php
#Cache API data to ./cache folder

#Includes
include "/var/www/html/master/public/graph_app/workground/php/globalConfig.php";

#Companies array
$ccArray = array("1143619", "448019"ת "1147479", "373019", "720011", "434019", "1117688", "1093558", "199018", "257014", "258012", "345017", "462010", "475020", "1129493", "86027", "543017", "612010" , "1085265" , "1118116", "612024", "746016", "1082007", "1083443", "1083633", "1090315", "1094168", "1099571", "1102532", "1104058", "1105196", "1120161", "1121474", "1129451", "486027", "1140151", "1141316", "1141357", "1141969");

#Init times & dates
$todayDate=date("dmY");
$shiftDate1=date("dmY",strtotime("-1 years"));
$shiftDate5=date("dmY",strtotime("-5 years"));
$shiftDate3=date("dmY",strtotime("-3 years"));
$shiftDate6m=date("dmY",strtotime("-6 months"));
$shiftDate3m=date("dmY",strtotime("-3 months"));

#Save cache for each company code. cache file pattern: 86027cached_6_month_data.json

for ($i = 0; $i < count($ccArray); $i++) {
    #Get data from API (from globalConfig.php)
    $apiCall_1year_data=historicalFunction_cache($shiftDate1,$todayDate,$ccArray[$i]);
    $apiCall_5year_data=historicalFunction_cache($shiftDate5,$todayDate,$ccArray[$i]);
    $apiCall_3year_data=historicalFunction_cache($shiftDate3,$todayDate,$ccArray[$i]);
    $apiCall_6month_data=historicalFunction_cache($shiftDate6m,$todayDate,$ccArray[$i]);
    $apiCall_3month_data=historicalFunction_cache($shiftDate3m,$todayDate,$ccArray[$i]);

    #Save cached data to ./chache local data repo
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

?>