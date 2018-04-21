function openKayttajat(){
	
	document.location="kayttajat.php";
	
}

function openSeuranta(){
	
	document.location="seuranta.php";
}

function openRaportit(){
	
	document.location="raportit.php";
}

function modifyRow(id) {
	var row = document.getElementById(id);
	var personId= row.childNodes[1];
	var date= row.childNodes[2];
	var project= row.childNodes[3];
	var hours= row.childNodes[4];
	var overtime = row.childNodes[5];
	var wkd= row.childNodes[6];
	var km= row.childNodes[7];
	var kmDes= row.childNodes[8];
	
	document.getElementById('pvm').value=date;
}