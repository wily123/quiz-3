<?php


if(isset($_GET['f'])){
    $item = file_get_contents("./db/".$_GET['f'].".txt");
}else{
    
   $item = file_get_contents("./db/abc.txt"); 
}




?><!DOCTYPE html>
<html>
<head>
<title>Quiz</title>   
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>

html{background:#475459;}
body{padding:10px 70px;}
h1{color:#fff;font-size:4vw;}


.timeline{
transition: width 1s ease-in-out;
top: 0px;
position: absolute;
height: 5px;
background: #3fbcf8;
width: 0%;
display: block;
left: 0px;
}


input[type="text"],.OkButton{
font-size:3.5vw;
width:70%;
padding:10px;
display:inline-block;
margin:4px;
vertical-align: bottom;
border-radius:6px;
color:#294c62;
font-family: "Times New Roman", Times, serif !important;
}

.OkButton{
   background:#aaaaaa;
   width:20%;
   padding:12px;
   
   text-align:center;
}

@media only screen and (max-width: 700px) {
    input[type="text"],.OkButton,textarea{
    width:100%;
    padding:10px;
    }
}


.blinking{
color:#fff;
animation:blinkingText 0.5s infinite;
}
@keyframes blinkingText{
    0%{     color: #fff;    }
    49%{    color: #fff; }
    60%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #fff;    }
}




#resultsDiv {
    color: #fff;
    font-size: 2.5vw;
    max-width: 800px;
    margin: auto;
    text-align: justify;
}

.createLink{display: block;
margin: auto;
    margin-top: auto;
margin-top: 150px;

position: fixed;
bottom: 15px;
right: 15px;
width: 150px;
text-align: right;

}
.createLink a{
text-decoration: none !important;
color: #aaaaaa !important;   
}

</style>
<body>
<div class=timeline></div>


<h1 id=demo><span class=blinking>_</span></h1>
<div id=resultsDiv></div>


<div class=createLink ><a href='./create.php'>Create my Quiz</a></div>
</body>
<script>

var items = [];


items = <?php echo $item;?> ;


var itemsResponse = [];


var speed = 10;
var turnNr = 0;
var widthOfTimeline = 0;


function typeWriter0(arr){
var txt = arr;
var nrText = txt.length;
var i = -1;
var conTent = '';
var afterText = "<span class=blinking>_</span>";




function typeWriter() {
  if (i < nrText) {
    if(i == -1){ 
    conTent = "<span class=blinking>_</span>";  
    } else{
    conTent = txt.substring(0,(i+1));
    }
    
    if(i == (nrText-1)){ afterText = "<br><br><input type=text id=response onkeyup='onEnter(event)'><span class=OkButton type=button  onclick='OkButton()'>OK</span>";}
    document.getElementById("demo").innerHTML = conTent+''+afterText;
    
    if(i == (nrText-1)){ document.getElementById("response").focus();}
    
    if(!(i % 4)){beep(undefined, 8401, 40);
    }; 
    i++;
    setTimeout(typeWriter, speed);
  }
}

typeWriter();
}




function deleteText0(arr){
var txt = arr;
var nrText = txt.length;
var i = nrText;
var conTent = '';
var speed = 3;
var numberOfCharToDelete = 3;
function deleteText() {
  if (i >= 0 || i > -(numberOfCharToDelete) ) {
    conTent = txt.substring(0,i);
    document.getElementById("demo").innerHTML = conTent+'<span class=blinking>_</span>';
    if(!(i % 4)){beep(undefined, 8404, 40);
    }; 

if (i <= 0 ) { setTimeout(function(){nextQ();}, 400);}
   
    i-=numberOfCharToDelete; 
    setTimeout(deleteText, this.speed);
  }
}
deleteText();
}





function getRespnse(){
    let vlera = document.getElementById("response").value;
    itemsResponse[turnNr] = vlera;
}



setTimeout(function(){typeWriter0(items[turnNr][0])}, 400);



function onEnter(e){
  e = e || window.event;
  if (e.keyCode === 13) {
   event.preventDefault();
   OkButton();
  }
}


function OkButton(){
   getRespnse();
   setTimeout(function(){deleteText0(items[turnNr][0]);}, 400);
}


function nextQ(){
    turnNr++;
    if(turnNr < items.length){
    
    setTimeout(function(){typeWriter0(items[turnNr][0])}, 400);
    let numberOfItems = items.length; widthOfTimeline = parseInt(100*turnNr/numberOfItems);
    updateTimeline();
    }else{
    RenderResults();
    let numberOfItems = items.length; widthOfTimeline = parseInt(100*turnNr/numberOfItems);
    updateTimeline();
    dergo();
    }   
}







function RenderResults(){
    let html = "";
    let percent = 0;
    let numberOfItems = items.length;
    
    for(let i=0; i < numberOfItems ; i++){
        let colorRes= "";
        let CorrectOrWrong = '';
        let CoorrectAnswerIs = "";
        if( itemsResponse[i].toLowerCase() == items[i][1].toLowerCase() ){
            colorRes='#b6dd2d';
            CorrectOrWrong = "Correct";
            percent += 100/numberOfItems;
            } else {
            colorRes='#ff5858'
            CorrectOrWrong = "Wrong";
            CoorrectAnswerIs = ". The correct answer: "+items[i][1]+"."
            };
        html += "<span>"+(i+1)+") "+items[i][0]+"</span><br>";
        html += "<span style='color:"+colorRes+"'>"+CorrectOrWrong+": "+itemsResponse[i]+"</span><span>"+CoorrectAnswerIs+"</span><br><hr>";
    }
    
    let html2 = "<hr><span><b>Correct: "+parseInt(percent)+"%</span></b><br><hr>";
    document.getElementById("resultsDiv").innerHTML = html2+""+html;  
}



function updateTimeline(){
    document.getElementsByClassName('timeline')[0].style.width = widthOfTimeline+"%";
}


a=new AudioContext(); // browsers limit the number of concurrent audio contexts, so you better re-use'em

var safariAp = 0;
var ua = navigator.userAgent.toLowerCase(); 
if (ua.indexOf('safari') != -1) { 
  if (ua.indexOf('chrome') > -1) {
  } else {
    safariAp =1; // Safari
  }
}

function beep(vol=.6, freq, duration){
if(safariAp!=1){
  v=a.createOscillator()
  u=a.createGain()
  v.connect(u)
  v.frequency.value=freq
  v.type="square"
  u.connect(a.destination)
  u.gain.value=vol*0.01
  v.start(a.currentTime)
  v.stop(a.currentTime+duration*0.001)
}}



///////////////////////////...LOAD DATA...//////////////////////////////////

function kerko(){
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();  }
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");   }

	xmlhttp.onreadystatechange=function()  {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			if(xmlhttp.responseText != "null"){	
			if(xmlhttp.responseText=="No database found...") return false;
			  PIKE = JSON.parse(xmlhttp.responseText);
			  table = PIKE[0];
			  users = PIKE[1];
			  turno = PIKE[2];
			  openNr = PIKE[3];
			  openItems = PIKE[4];
			  findItems = PIKE[5];
			  file = PIKE[6];
			  points = PIKE[7];
			  render();
			}
		}
	}
	
	xmlhttp.open("GET","sog.php?get=1&f="+file,true);
	xmlhttp.send();
}


var ID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return '' + Math.random().toString(36).substr(2, 9);
};



let file = "r_"+ID();

///////////////////////////...SAVE DATA...//////////////////////////////////
function dergo() {
var e = JSON.stringify(itemsResponse);

	var xmlhttp;
	if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }

	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){ //xmlhttp.responseText
		}
	  }	  
	xmlhttp.open("POST","sog.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("jsonText="+e+"&f="+file);
}



</script>
</html>















