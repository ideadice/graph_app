<?php
     session_start();
     session_regenerate_id();
     #echo session_id();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="windows-1255">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GraphsApp_build_version</title>

<!--Include libraries-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript" src="../lib/chartjs-plugin-zoom.js"></script>
<script type="text/javascript" src="../lib/chartjs-plugin-zoom.min.js"></script>

<!--Include js & angular code libraries-->
<script type="text/javascript" src="../data/company_design.js"></script>
<script type="text/javascript" src="../lib/data_builders.js"></script>
<script type="text/javascript" src="../lib/server_calls.js"></script>
<script type="text/javascript" src="../lib/project_src.js"></script>
<script type="text/javascript" src="../lib/app.js"></script>

<!--Include design sheets-->
<link href="../design/design.css" type="text/css" rel="stylesheet">
<link href="../design/loader.css" type="text/css" rel="stylesheet">

<script>
    function startup(){
        <?php
            include "/var/www/html/master/public/graph_app/workground/php/globalConfig.php";
            if (isset($_SESSION['cc']))
            {
                $_SESSION = array();
            }
            $_SESSION['cc']=$_GET["cc"];
        ?>
        //Init global variables for implemention
        company_code= "<?php echo $_GET["cc"]; ?>";
        //design1 = "<?php echo $_GET["design1"]; ?>";
        //Start app & send global variables
        initialize(company_code);
    }   
</script>

</head>

<!-- 
INFO:
-   Passing variables from url: http://shodor.org/~kevink/phpTutorial/davida_PassVarByUrl.php

-->

<body ng-app="chartsApp" onload="startup()">

<div  ng-controller="mainController">

<div id="contentLoader" ng-show="loaderStatus"  class="lds-ripple"><div></div><div></div></div>

<div id="appCharts">

<!--Show/Hide buttons-->
<div  class="mainButtons">
<input type="button" class="btn-dice" id="dailyFlag" ng-click="showHideFunc('showDaily');" value="Daily">
<input type="button" class="btn-dice" ng-click="showHideFunc('showWeek');" value="Week"> 
<input type="button" class="btn-dice" ng-click="showHideFunc('showMonth');" value="Month">
<input type="button" class="btn-dice" ng-click="showHideFunc('show3Month');" value="3 Months">
<input type="button" class="btn-dice" ng-click="showHideFunc('show6Month');" value="6 Months">
<input type="button" class="btn-dice" ng-click="showHideFunc('showYear');" value="Year" autofocus>
<input type="button" class="btn-dice" ng-click="showHideFunc('show3year');" value="3 Years">
<input type="button" class="btn-dice" ng-click="showHideFunc('show5year');" value="5 Years">
</div>

<!--Weekly chart-->
<div ng-show="showval" class="chart-container">
        <div class="InfoBox">
                <p class="data" id="weekDate"></p>
                <p class="data" id="weekLockRate"> </p>
                <p class="data" id="weekPrevClose"> </p> 
                <p class="data" id="weekOpeningRate"> </p> 
                <p class="data" id="weekDailyHigh"> </p> 
                <p class="data" id="weekDailyLow"> </p> 
                <p class="data" id="weekTurnover"> </p>                
        </div>
        <canvas id="chart"></canvas>
        <button class="rz-dice" onclick="resetZoomWeek()">Reset Zoom</button>
        
</div>

<!--Monthly chart-->
<div ng-hide="hideval" class="chart-container">
        <div class="InfoBox">
                <p class="data" id="monthDate"></p>
                <p class="data" id="monthLockRate"></p>
                <p class="data" id="monthPrevClose"></p> 
                <p class="data" id="monthOpeningRate"></p> 
                <p class="data" id="monthDailyHigh"></p> 
                <p class="data" id="monthDailyLow"></p> 
                <p class="data" id="monthTurnover"></p>                
        </div>
    <canvas id="chartMonth"></canvas>
        <button class="rz-dice" onclick="resetZoomMonth()">Reset Zoom</button>
</div>

<!--3 Months chart-->
<div ng-hide="hideval3m" class="chart-container">
    <div class="InfoBox">
            <p class="data" id="month3Date"></p>
            <p class="data" id="month3LockRate"></p>
            <p class="data" id="month3PrevClose"></p> 
            <p class="data" id="month3OpeningRate"></p> 
            <p class="data" id="month3DailyHigh"></p> 
            <p class="data" id="month3DailyLow"></p> 
            <p class="data" id="month3Turnover"></p>                
    </div>
<canvas id="chart3Month"></canvas>
    <button class="rz-dice" onclick="resetZoom3Month()">Reset Zoom</button>
</div>

<!--6 Months chart-->
<div ng-hide="hideval6m" class="chart-container">
    <div class="InfoBox">
            <p class="data" id="month6Date"></p>
            <p class="data" id="month6LockRate"></p>
            <p class="data" id="month6PrevClose"></p> 
            <p class="data" id="month6OpeningRate"></p> 
            <p class="data" id="month6DailyHigh"></p> 
            <p class="data" id="month6DailyLow"></p> 
            <p class="data" id="month6Turnover"></p>                
    </div>
<canvas id="chart6Month"></canvas>
    <button class="rz-dice" onclick="resetZoom6Month()">Reset Zoom</button>
</div>

<!--Year chart-->
<div ng-hide="hideval2" class="chart-container">
    <div class="InfoBox">
            <p class="data" id="yearDate"></p>
            <p class="data" id="yearLockRate"></p>
            <p class="data" id="yearPrevClose"></p> 
            <p class="data" id="yearOpeningRate"></p> 
            <p class="data" id="yearDailyHigh"></p> 
            <p class="data" id="yearDailyLow"></p> 
            <p class="data" id="yearTurnover"></p>                
    </div>
    <canvas id="chartYear"></canvas>
        <button class="rz-dice" onclick="resetZoomYear()">Reset Zoom</button>
</div>

<!--3 Years chart-->
<div ng-hide="hideval3y" class="chart-container">
    <div id="infoBox3y" class="InfoBox">
            <p class="data" id="year3Date"></p>
            <p class="data" id="year3LockRate"></p>
            <p class="data" id="year3PrevClose"></p> 
            <p class="data" id="year3OpeningRate"></p> 
            <p class="data" id="year3DailyHigh"></p> 
            <p class="data" id="year3DailyLow"></p> 
            <p class="data" id="year3Turnover"></p>                
    </div>
    <div id="loader3y" ng-show="loaderStatus"  class="lds-ripple"><div></div><div></div></div>
    
<canvas id="chart3Year"></canvas>
    <button class="rz-dice" onclick="resetZoom3Year()">Reset Zoom</button>
</div>

<!--5 Years chart-->
<div ng-hide="hideval5y" class="chart-container">
    <div id="infoBox5y" class="InfoBox">
            <p class="data" id="year5Date"></p>
            <p class="data" id="year5LockRate"></p>
            <p class="data" id="year5PrevClose"></p> 
            <p class="data" id="year5OpeningRate"></p> 
            <p class="data" id="year5DailyHigh"></p> 
            <p class="data" id="year5DailyLow"></p> 
            <p class="data" id="year5Turnover"></p>                
    </div>
    <div id="loader5y" ng-show="loaderStatus"  class="lds-ripple"><div></div><div></div></div>
    
<canvas id="chart5Year"></canvas>
        <button class="rz-dice" onclick="resetZoom5Year()">Reset Zoom</button>
</div>

<!--Daily chart-->
<div ng-hide="hidevalDaily" class="chart-container">
    <div class="InfoBox">
            <p class="data" id="dailyTime"></p>
            <p class="data" id="dailyRate"></p>
            <p class="data" id="dailyDailyHigh"></p> 
            <p class="data" id="dailyDailyLow"></p> 
            <p class="data" id="dailyBaseRate"></p> 
            <p class="data" id="dailyBaseRateChangePercent"></p> 
            <p class="data" id="dailyBaseRateChange"></p>   
            <p class="data" id="dailyAllYearMax"></p> 
            <p class="data" id="dailyAllYearMin"></p>    
    </div>
    <canvas id="chartDaily"></canvas>
        <button class="rz-dice" onclick="resetZoomDaily()">Reset Zoom</button>
</div>

</div>
<!--END mainController-->
</div>

    <!--Debug section-->
    <div class="debug">
        <p id="debug1"></p>
        <p id="debug2"></p>
        <p id="debug3"></p>
        <p id="debug4"></p>
        <p id="debug5"></p>
        <p id="debug6"></p>
        <p id="debug7"></p>
        <p id="debug8"></p>
        <p id="debug9"></p>
        <p id="debug10"></p>
        <p id="debug11"></p>
        <p id="debug12"></p>
        <p id="debug13"></p>
        <p id="debug14"></p>
        <p id="debug15"></p>
        <p id="debug16"></p>
        <p id="debug17"></p>
        <p id="debug18"></p>
        <p id="debug60"></p>
        
    </div>
    <!--Debug section-->
</body>

</html>