<?php
require_once('connection.php');

$names = $_POST['names'];
$p_info = $_POST['person_info'];
$o_info = $_POST['other_info'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

if (count($names) == 0) {
    return "Valitse ainakin yksi henkilö";     
}else {
    $arguments = array_merge($p_info, $o_info);
}
//$arguments = array_map('stripslashes',$arguments);
//$arguments = json_decode(stripslashes(json_encode($arguments)), true);
//echo (implode(',', $arguments));
$sql = ("SELECT ".str_replace("'","",implode(",", $arguments))." FROM henkilo join tuntiseuranta ON
henkilo.idhenkilo = tuntiseuranta.henkilo_idhenkilo WHERE henkilo.idhenkilo IN (".implode(',',$names).")
ORDER BY henkilo.idhenkilo,pvm ");
echo $sql;
$result = execute_query($sql);
$row = $result->fetch_assoc();
while($row = $result->fetch_assoc()) {
foreach ($row as $item) {
    echo '<br>'.$item;
}
}