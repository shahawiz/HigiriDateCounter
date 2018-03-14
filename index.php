
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "Hijri_GregorianConvert.class";

// int Conv_type
$Conv_Type = 3;
$year_r = 0;
$month_r = 0;
$day_r = 0;
$hour_r = 0;
$min_r = 0;


if (isset($_GET["year"]) && isset($_GET["month"]) && isset($_GET["day"]) && isset($_GET["conv_type"])) {
    $Conv_Type = $_GET["conv_type"];
    $Year = $_GET["year"];
    $Month = $_GET["month"];
    $Day = $_GET["day"];
}


if ($Conv_Type == "gre") {
    Count_Time($Year, $Month, $Day);
} elseif ($Conv_Type == "hijiri") {
    hijiri($Year, $Month, $Day);
} elseif ($Conv_Type == 3) {
    echo "Please select Date type !";
}

function Time_Now() {
    //Get Today time in GRE. with fromat Y/m/d
    $today_date = date('Y/m/d', time() + (3600 * 24));
    $date_format = new DateTime($today_date);
    $date = $date_format->format('Y/m/d');
    return $date;
}

function hijiri($year, $month, $day) {
    $DateConv=new Hijri_GregorianConvert;
   
    $format = "YYYY/MM/DD";
    $today = $DateConv->GregorianToHijri(Time_Now(), $format);
    $today_date = date_create($today);
    $given_date = date_create($year . "/" . $month . "/" . $day);
    
    $diff = date_diff($today_date, $given_date);

    $GLOBALS['year_r'] = $diff->format("%y");
    $GLOBALS['month_r'] = $diff->format("%m");
    if ($month == 12 || $month == 5 || $month == 1 || $month == 7  || $month == 8 || $month == 10){
        
        if ($day <11){
            $GLOBALS['day_r'] = $diff->format("%d");
        }  elseif ($day>=11) {
             $GLOBALS['day_r'] = $diff->format("%d");
        }else {
            $GLOBALS['day_r'] = $diff->format("%d")-1;
        }
        
              
        
    }elseif ( $month == 2) {
       // $GLOBALS['day_r'] = $diff->format("%d")+1;
        
        if ($day <11){
            $GLOBALS['day_r'] = $diff->format("%d");
        }else {
            $GLOBALS['day_r'] = $diff->format("%d")+1;
        }
        
        
    }
    else {
        $GLOBALS['day_r'] = $diff->format("%d");
    }
    
    $GLOBALS['hour_r'] = ($diff->format("%h"))+date("h",time());;
    $GLOBALS['min_r'] = ($diff->format("%i"))+date("i",time());;




   // echo $diff->format("%y Years , %m Months , %d Days, %h Hours , %i Minutes");
}



function Conv_Hijri2Gre($year, $month, $day) {
    $DateConv = new Hijri_GregorianConvert;
    $format = "YYYY/MM/DD";
    $date = $year . "/" . $month . "/" . $day;
    $result = $DateConv->HijriToGregorian($date, $format);

    $get_date = new DateTime($result);

    //Passing values to Count_time fn
    $y = $get_date->format("Y");
    $d = ($get_date->format("d")) - 1;
    $m = $get_date->format("m");
    Count_Time($y, $m, $d);
}

function Count_Time($year, $month, $day) {
    //Today Date 
    $Today = date("Y-m-d h:m", time() + 3600 * 10);
    //  echo $Today . "<br>";
    $Today_Date = date_create($Today);
    //Give Date
    $Given_Date = date_create($year . "-" . $month . "-" . $day . "-" . "" . "5");


    //Calcuate Time between dates
    $Date_Diff = date_diff($Given_Date, $Today_Date);
    //  echo $Date_Diff->format("%y Years , %m Months , %d Days, %h Hours , %i Minutes");


    $GLOBALS['year_r'] = $Date_Diff->format("%y");
    $GLOBALS['month_r'] = $Date_Diff->format("%m");
    $GLOBALS['day_r'] = $Date_Diff->format("%d");
    $GLOBALS['hour_r'] = ($Date_Diff->format("%h")) - 2;
    $GLOBALS['min_r'] = ($Date_Diff->format("%i")) - 8;
}
?>

<html>
    <head>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body style = "font-family:tahoma;">

        <div name ="master" style = "    margin-right: 40%;">

            <div class="container" style = "direction:rtl;float:right;">
                <h2>حساب العمر</h2>
                <p>حساب العمر - احسب عمرك بالهجري والميلادي</p>

                <ul class="nav nav-tabs" style = "direction:rtl;float:right;">
                    <li class="active"><a data-toggle="tab" href="#home">ميلادي</a></li>
                    <li><a data-toggle="tab" href="#menu1">هجري</a></li>

                </ul>
                <br>
                <br>
                <br>
                <div class="tab-content" style = "direction:rtl;float:right;">
                    <div id="home" class="tab-pane fade in active">



                        <table class="table table-bordered" style="text-align: center">
                            <thead style="background-color:rgb(233, 236, 239)"><tr><td colspan="3">أدخل تاريخ ميلادك بالميلادي</td></tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <form action="index.php" method="get">
                                <tbody id="gregorianDate" style="display: table-row-group;">
                                    <tr><td>اليوم</td><td>الشهر</td><td>السنة</td></tr>
                                    <tr>
                                <input type="text" id="conv_type" name="conv_type" value ="gre" hidden="hidden" >
                                <td><input type="text" id="gregorianDay" name="day" value="1" size="3" maxlength="2"></td>
                                <td> <select id="gregorianMonth" name="month">
                                        <option value="01" selected="selected">يناير (1)</option>
                                        <option value="02">فبراير (2)</option>
                                        <option value="03">مارس (3)</option>
                                        <option value="04">أبريل (4)</option>
                                        <option value="05">مايو (5)</option>
                                        <option value="06">يونيو (6)</option>
                                        <option value="07">يوليو (7)</option>
                                        <option value="08">أغسطس (8)</option>
                                        <option value="09">سبتمبر (9)</option>
                                        <option value="10">أكتوبر (10)</option>
                                        <option value="11">نوفمبر (11)</option>
                                        <option value="12">ديسمبر (12)</option>
                                    </select></td><td><input type="text" name="year" id="gregorianYear" value="2017" size="5" maxlength="4"></td>
                            </tr><tr><td colspan="3">
                                <div style="text-align: center;">
                                    <button type="submit" id="gregorianCalc">احسب عمرك</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </form>
                </table>



            </div>
            <div id="menu1" class="tab-pane fade">



                <table class="table table-bordered" style="text-align: center">
                    <thead style="background-color:rgb(233, 236, 239)"><tr><td colspan="3">أدخل تاريخ ميلادك بالهجري</td></tr>
                    </thead>
                    <form action="index.php" method="get">
                        <tbody id="hijriDate" style="display: table-row-group;">
                            <tr><td>اليوم</td><td>الشهر</td><td>السنة</td></tr>
                            <tr>
                        <input type="text" id="conv_type" name="conv_type" value ="hijiri" hidden="hidden" >
                        <td><input type="text" name="day" value="1" id="ummalquraDay" size="3" maxlength="2"> </td>
                        <td>
                            <select name="month" id="ummalquraMonth">
                                <option value="01">محرم (1)</option>
                                <option value="02">صفر (2)</option>
                                <option value="03">ربيع الأول (3)</option>
                                <option value="04">ربيع الآخر (4)</option>
                                <option value="05">جمادى الأولى (5)</option>
                                <option value="06">جمادى الآخرة (6)</option>
                                <option value="07">رجب (7)</option>
                                <option value="08">شعبان (8)</option>
                                <option value="09">رمضان (9)</option>
                                <option value="10">شوال (10)</option>
                                <option value="11">ذو القعدة (11)</option>
                                <option value="12">ذو الحجة (12)</option></select>
                        </td>
                        <td><input name="year" value="1438" type="text" id="ummalquraYear" size="5" maxlength="4"></td>
                        </tr>
                        <tr><td colspan="3">
                                <div style="text-align: center;">
                                    <button type="submit" id="hijriCalc">احسب عمرك</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                </table>

            </div>
            <table id="the_table_h" style="width: 100%;direction: rtl;display: table; padding-top: 2px; text-align: center;" class="table table-bordered  table-striped table-hover">
                <thead><tr><td colspan="5"><h3>عمرك</h3></td></tr></thead>
                <tbody>
                    <tr><td>سنة</td><td>شهر</td><td>يوم</td><td>ساعة</td><td>دقيقة</td></tr>
                    <tr id="div2">
                        <td><?php echo $year_r ?></td>
                        <td><?php echo $month_r ?></td>
                        <td><?php echo $day_r ?></td>
                        <td><?php echo $hour_r ?></td>
                        <td><?php echo $min_r ?></td></tr>
                </tbody>
            </table>

        </div>

    </div>



</div>





</body>

</html>