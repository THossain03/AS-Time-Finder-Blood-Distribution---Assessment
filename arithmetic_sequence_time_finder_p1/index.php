<?php
    //the logic will be set up such that the total number of minutes by the face value of the display time will determine the time variable values.
    //for example, start time is set at 12:00 so simply 12*60 will be its value.
    //for another time like 2:40, it would rather be a value of 2*60 + 40.
    //Since 1:00 is the minimum face-time value, while 12:59 is the highest, we will use 12*60 + 59 = 779 as the max value and cutoff for a possible start/end time value. Similarily the minimum value at 1:00 will be 1*60 = 60.
    //remainders will thus need to be taken as part of if statements to determine the start time and end times accordingly. 

    $starttime = 12*60; 
    //variable declarations and temp assignments
    $endtime = -1;
    $duration = "";
    $duration_err = "";
    $endtime_display = "";
    $totnum = "";

    //the array list of arithmetic sequence times between 1:00 to 12:59, all converted to their corresponding tot. min. values
    $arith_min_index_sorted = array();
    for ($minval = 60; $minval<780; $minval++) { //adds arithmetic sequence times through this iterative for loop.
        if ($minval>=600) {
            $timefaceval12hr = array(1,intval($minval/60)%10,intval(intval($minval%60)/10),intval($minval%10));
            $comm_diff = $timefaceval12hr[1] - $timefaceval12hr[0];
            if (($timefaceval12hr[2] - $timefaceval12hr[1]) == $comm_diff && ($timefaceval12hr[3] - $timefaceval12hr[2]) == $comm_diff) {
                $arith_min_index_sorted[] = $minval;
            }
        } else {
            $timefaceval12hr = array(intval($minval/60),intval(intval($minval%60)/10),intval($minval%10));
            $comm_diff = $timefaceval12hr[1] - $timefaceval12hr[0];
            if (($timefaceval12hr[2] - $timefaceval12hr[1]) == $comm_diff) {
                $arith_min_index_sorted[] = $minval;
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate if duration value given is feasible
        if (empty(trim($_POST["duration_in"]))) {
            $duration_err = "Please enter a value for the duration.";
        } elseif (!is_numeric($_POST["duration_in"])) {
            $duration_err = "This value can only contain numbers.";
        } elseif (intval(trim($_POST["duration_in"]))>1000000000 || intval(trim($_POST["duration_in"])) < 0) {
            $duration_err = "This value is out of range.";
        } else {
            $duration = intval(trim($_POST["duration_in"]));
        }

        //mathematical calculations for finding htmllist, end time and totnum simultaneously.
        if ($duration < 60) {
            $endtime = $starttime + $duration;
            $totnum = ($duration>=34) ? (1) : (0);
            $htmllist = ($duration>=34) ? ("<p>12:34<p>") : ("");
        } else {
            $endtime = $duration-60;
            $totnum = 1 + (sizeof($arith_min_index_sorted) * intval($endtime/720));
            $endtime %= 720;
            $endtime += 60;
            $counter = 0;
            sort($arith_min_index_sorted);  //should be sorted already, just another precautionary sort before comparing until end time begins.         
            while ($arith_min_index_sorted[$counter]<=$endtime) {
                $counter++;
            }
            $totnum += $counter; 
        }

        $endtime_display = intval($endtime/60) . ":" . intval(intval($endtime%60)/10) . intval($endtime%10);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="index.css">
        <!-- Bootstrap CSS if needed-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Arithmetic Sequence Time Finder</title>
    </head>
    <body>
        <form method="post">
            <div class="row">
                <div class="col">
                    <h5>Enter Duration for clock to be observed: 
                        <input type="number" id="duration_in" name="duration_in" max="1000000000" min="0" value="<?= $duration ?>">&nbsp;&nbsp;min. 
                    </h5>
                    <?= $duration_err ?>
                </div>
                <div class="col">
                    <h6><span id="start_time_display">Start Time: 12:00</span>
                </div> 
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="submitbtn" name="submit_btn" style="float:right;">Calculate!</button>
                </div>
                <div class="col"></div>
            </div>
        </form>
        <br>
        <div class="row">
            <div class="col">
                <h5>Number of Arithmetic Sequences between Start and End time:  <?= $totnum ?></h5>
            </div>
            <div class="col">
                <h6><span id="start_time_display">End Time: </span><?= $endtime_display ?></h6>
            </div>
        </div>
    </body>
</html>