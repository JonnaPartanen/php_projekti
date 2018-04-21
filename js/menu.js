function modifyRow(id){
	
	var row = document.getElementById(id);
	//alert(row.childNodes[2].innerText);
	
	var personId= row.childNodes[1].innerText;
	var date= row.childNodes[2].innerText;
	var project= row.childNodes[3].innerText;
	var hours= row.childNodes[4].innerText;
	var overtime = row.childNodes[5].innerText;
	var wkd= row.childNodes[6].innerText;
	var km= row.childNodes[7].innerText;
	var kmDes= row.childNodes[8].innerText;
	
	document.getElementById('pvm').defaultValue=date;
	document.getElementById('tunnit').defaultValue=hours;
	document.getElementById('kohde').defaultValue=project;
	document.getElementById('ylityo').defaultValue=overtime;
	document.getElementById('vkl').defaultValue=wkd;
	document.getElementById('km').defaultValue=km;
	document.getElementById('selite').defaultValue=kmDes;
};


function openKayttajat(){
	
	document.location="kayttajat.php";
	
}

function openSeuranta(){
	
	document.location="seuranta.php";
}

function openRaportit(){
	
	document.location="raportit.php";
}

