function modifyRow(id){
	
	var row = document.getElementById(id);
	alert(row.childNodes[2].innerText);
	
	//var personId= row.childNodes[1];
	var date= row.childNodes[2].innerText;
	//var project= row.childNodes[3];
	//var hours= row.childNodes[4];
	//var overtime = row.childNodes[5];
	//var wkd= row.childNodes[6];
	//var km= row.childNodes[7];
	//var kmDes= row.childNodes[8];
	//console.log(kmDes);
	
	document.getElementById('pvm').innerText=date;
	console.log(document.getElementById('pvm').innerText);
	//document.getElementById('tunnit').value=hours;
	//document.getElementById('ylityo').value=overtime;
	//document.getElementById('vkl').value=wkd;
	//document.getElementById('km').value=km;
	//document.getElementById('selite').value=kmDes;
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

