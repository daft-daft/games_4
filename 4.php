<?php

// play the game
if (isset($_GET['la'])) {
        $yn=substr(test_input($_GET["yn"]),0,10);
        $pa=substr(test_input($_GET["pa"]),0,10);
    $la=htmlspecialchars($_GET["la"]);
    $number=test_input($_GET["number"]);
    $started=test_input($_GET["started"]);
    $playernumber=test_input($_GET["playernumber"]);
    $turnnumber=test_input($_GET["turnnumber"])+1;  // next turn....
    $lab = explode(",", $la);
    $winner=checkwinninglines($la,$playernumber);
    $lchtml='<table  border="2"> <tr>';
    for ($lnx=0;$lnx<25;$lnx++) {
        if (trim($lab[$lnx])=="X" || trim($lab[$lnx])=="O" ) {
            if ($lnx==$number) {
                $lchtml=$lchtml. '<td><input style="background-color:#aaffff;" id="'.$lnx.'" type="text" size="1" value="'.trim($lab[$lnx]).'" readonly="readonly"></td> ';
            }else {
                $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1" value="'.trim($lab[$lnx]).'" readonly="readonly"></td> ';
            }
        }else {
            $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1" onclick="return clicked('.$lnx.');" onkeypress="return testForEnter(event);"></td>';
        }
        if ($lnx==4 || $lnx==9 || $lnx==14 || $lnx==19) {
            $lchtml=$lchtml. "</tr><tr>";
        }
    }
    $lchtml=$lchtml. "</tr></table>nextdata";
    // for the nextdata, make a read only table
    $lchtml=$lchtml. '<table border="2"> <tr>';
    for ($lnx=0;$lnx<25;$lnx++) {
        if (trim($lab[$lnx])=="X" || trim($lab[$lnx])=="O" ) {
            if ($lnx==$number) {
                $lchtml=$lchtml. '<td><input style="background-color:#aaffff;" id="'.$lnx.'" type="text" size="1" value="'.trim($lab[$lnx]).'" readonly="readonly"></td> ';
            }else {
                $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1" value="'.trim($lab[$lnx]).'" readonly="readonly"></td> ';
            }
        }else {
            $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1"  readonly="readonly"></td>';
        }
        if ($lnx==4 || $lnx==9 || $lnx==14 || $lnx==19) {
            $lchtml=$lchtml. "</tr><tr>";
        }
    }
    $lchtml=$lchtml."nextdata".$started;
    $lchtml=$lchtml."nextdata".$playernumber;
    $lchtml=$lchtml."nextdata".$turnnumber;
    $lchtml=$lchtml."nextdatanewgame";
    $lchtml=$lchtml."nextdata".$winner;
    $lchtml=$lchtml."nextdatafromget_la";
    file_put_contents($yn.$pa.".txt", $lchtml);
    echo $lchtml;
    return;
}


if (isset($_GET['readdata'])) {
// file format is
// 0 PLAYGRID
// 1 READONLY GRID
// 2 STARTED
// 3 PLAYER NUMBER
// 4 TURN NUMBER
// 5 NEW GAME - HAS A NEW GAME STARTED
// 6 WINNER
        $yn=substr(test_input($_GET["yn"]),0,10);
        $pa=substr(test_input($_GET["pa"]),0,10);
    $newgame=test_input($_GET["newgame"]);
    $lcrhtml="";
    if (is_file($yn.$pa.".txt") && ($newgame="newgame")) {
        $lcrhtml=file_get_contents($yn.$pa.".txt");
    }
    echo $lcrhtml;
    return;
}



if (isset($_GET['newgame'])) {
    $newgame=test_input($_GET["newgame"]);
    if(newgame=="newgame") {
        $yn=substr(test_input($_GET["yn"]),0,10);
        $pa=substr(test_input($_GET["pa"]),0,10);
        if (is_file($yn.$pa.".txt")) {
            unlink($yn.$pa.".txt");
        }
        $lchtml='<table border="2"> <tr>'; // game table
        for ($lnx=0;$lnx<25;$lnx++) {
            $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1"  onclick="return clicked('.$lnx.');" onkeypress="return testForEnter(event);"></td>';
            if ($lnx==4 || $lnx==9 || $lnx==14 || $lnx==19) {
                $lchtml=$lchtml. "</tr><tr>";
            }
        }
        $lchtml=$lchtml. "</tr></table>nextdata"; // now a readonly table
        $lchtml=$lchtml. '<table border="2"> <tr>'; 
        for ($lnx=0;$lnx<25;$lnx++) {
            $lchtml=$lchtml. '<td><input id="'.$lnx.'" type="text" size="1"  readonly="readonly"></td>';
            if ($lnx==4 || $lnx==9 || $lnx==14 || $lnx==19) {
                $lchtml=$lchtml. "</tr><tr>";
            }
        }
        $lchtml=$lchtml. "</tr></table>";
        $lchtml=$lchtml."nextdatastarted";
        $lchtml=$lchtml."nextdata1";  // playernumber
        $lchtml=$lchtml."nextdata1";  //turnnumber
        $lchtml=$lchtml."nextdatanewgame";
        $lchtml=$lchtml."nextdataNoWinner"; // winning line
        $lchtml=$lchtml."nextdatafromnewgame";
        file_put_contents($yn.$pa.".txt", $lchtml);
        echo $lchtml;
        return;
    }
}


function checkwinninglines($la,$playernumber) {
    $winninglines = array(
array(0,1,2,3),
array(1,2,3,4),
array(5,6,7,8),
array(6,7,8,9),
array(10,11,12,13),
array(11,12,13,14),
array(15,16,17,18),
array(16,17,18,19),
array(20,21,22,23),
array(21,22,23,24),
array(0,5,10,15),
array(5,10,15,20),
array(1,6,11,16),
array(6,11,16,21),
array(2,7,12,17),
array(7,12,17,22),
array(3,8,13,18),
array(8,13,18,23),
array(4,9,14,19),
array(9,14,19,24),
array(5,11,17,23),
array(0,6,12,18),
array(6,12,18,24),
array(1,7,13,19),
array(3,7,11,15),
array(4,8,12,16),
array(8,12,16,20),
array(9,13,17,21)
        );



 //   $Xnumbers="";
 //   $Onumbers="";
        $Xnumbers = array();
    $Onumbers = array();

    $emptysquares=false;
    $lab = explode(",", $la);
    $lnxcounter=0;
    $lnocounter=0;
    for ($lnx=0;$lnx<42;$lnx++) {
        if (trim($lab[$lnx])=="X") {
            $Xnumbers[$lnxcounter]=$lnx;
            $lnxcounter=$lnxcounter+1;
        }
        if (trim($lab[$lnx])=="O") {
            $Onumbers[$lnocounter]=$lnx;
            $lnocounter=$lnocounter+1;
        }
        if (trim($lab[$lnx])=="") {
            $emptysquares=true;
        }
    }

     foreach($winninglines as $value) {
        if (in_array($value[0], $Xnumbers)
                && in_array($value[1], $Xnumbers)
                && in_array($value[2], $Xnumbers)
                && in_array($value[3], $Xnumbers)
        ) {
            return "Xwins ".$value[0]." ".$value[1]." ".$value[2]." ".$value[3];
        }
        if (in_array($value[0], $Onumbers)
                && in_array($value[1], $Onumbers)
                && in_array($value[2], $Onumbers)
                && in_array($value[3], $Onumbers)
        ) {
            return "Owins ".$value[0]." ".$value[1]." ".$value[2]." ".$value[3];
        }
    }



//    $win= $la." X ".$Xnumbers." O ".$Onumbers;
//    foreach($winninglines as $value) {
//        $pos = strrpos($Xnumbers, $value);
//        if ($pos === false) { // note: three equal signs
//            // not found...
//        }else {
//            return ("Xwins".$value);
//        }
//        $pos = strrpos($Onumbers, $value);
//        if ($pos === false) { // note: three equal signs
//            // not found...
//        }else {
//            return ("Owins".$value);
//        }
//    }
    if (!$emptysquares) {
        return ("Draw ");
    }
    return ("NoWinner");
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = preg_replace("/[^a-zA-Z0-9]/", "", $data);
    $data = strtolower($data);
    return $data;
}
?>

