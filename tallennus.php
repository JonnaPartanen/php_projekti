<?php
require_once('connection.php');


$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$tables=1;

    if (count($_POST['names']) == 0) {
        return "Valitse ainakin yksi henkilö";     
    }else {
        $names = $_POST['names'];
    }
    if(count($_POST['person_info']) > 0 && count($_POST['other_info'])>0){
        $arguments = array_merge($_POST['person_info'], $_POST['other_info']);
    }

//$arguments = array_map('stripslashes',$arguments);
//$arguments = json_decode(stripslashes(json_encode($arguments)), true);
//echo (implode(',', $arguments));
$sql = ("SELECT ".str_replace("'","",implode(",", $arguments))." FROM henkilo join tuntiseuranta ON
henkilo.idhenkilo = tuntiseuranta.henkilo_idhenkilo WHERE henkilo.idhenkilo IN (".implode(',',$names).")
AND pvm BETWEEN '" .$start_date."' AND '". $end_date. "' ORDER BY henkilo.idhenkilo,pvm ");
echo $sql;
$result = execute_query($sql);
$row = $result->fetch_assoc();

$table1 = "<table><tr>";

for ($i=0;$i<count($arguments);$i++){
    $table1 .= "<th>".str_replace("'", "", $arguments[$i]) ."</th>";
}
$table1 .= "</tr></table>";   

echo $table1;
while($row = $result->fetch_assoc()) {
foreach ($row as $item) {
    echo '<br>'.$item;
}
}