<?php
$where = 'WHERE henkilo_idhenkilo ';
$names = $_POST['names'];
$p_info = $_POST['person_info'];
$o_info = $_POST['other_info'];

if ($names == 0) {
    return "Valitse ainakin yksi henkilö";
    
}elseif($names == 1){
    $where .= " = " . $_POST['names'][0]. ";";
    
}else {
    $where .= "IN (";
    foreach ($_POST['names'] as $selectedNames){
        $where .= $selectedNames. ", ";
    }
}
    //echo count($_POST['names']);
    //echo 50*'*';
    //echo $selectedNames;
echo implode("," , $p_info);
$in = join(',', array_fill(0, count($names), '?'));
echo $in
  
 
	
?>