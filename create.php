<?php


if(isset($_GET['f'])){
    $item = file_get_contents($_GET['f'].".txt");
}else{
    
   $item = file_get_contents("abc.txt"); 
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


input[type="text"],.OkButton,textarea{
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

.numrator {
    background: #333;
    padding: 4px 10px;
    display: inline-block;
    border-radius: 4px;
    color: #aaa;
    margin: 2px;
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

<div id=questionNr></div><br>
<div id=CreateQuestions></div>



<!--h1 id=demo><span class=blinking>_</span></h1>
<div id=resultsDiv></div-->


<div class=createLink ><a href='./'>Retun Home</a></div>
</body>
<script>


var questionNumbers = 1;
var numberOfQuestionInEditing = 0;
var question = [];


function renderQuestionNumbers___(){
    let html = '';
    
    for(let i = 0; i < questionNumbers; i++){
        let color = '';
        if(i == numberOfQuestionInEditing){color="#b6dd2d";}
        html += "<span class=numrator style='background:"+color+";' onclick='SaveQuestionTempAndGo("+i+");RenderQuestion()'>"+(i+1)+"</span>";
    }
    html += "<span class=numrator onclick='SaveQuestionTempAndGo("+(questionNumbers-1)+");saveQuestion()' style='float:right;'>Share</span>";
    html += "<span class=numrator onclick='questionNumbers++;SaveQuestionTempAndGo("+questionNumbers+");RenderQuestion()'>+ New</span>";
    
    document.getElementById('questionNr').innerHTML = html;
}


function renderQuestionBox(){
    for(let i = 0; i < questionNumbers; i++){
        if(!question[i]){question[i]=[]};   
    }
}


function RenderQuestion(){
    renderQuestionBox();
    renderQuestionNumbers___();
    let html = '';
    let Q = question[numberOfQuestionInEditing][0] ? question[numberOfQuestionInEditing][0]: "";
    let R = question[numberOfQuestionInEditing][1] ? question[numberOfQuestionInEditing][1]: "";
    html += "<textarea id=QN"+numberOfQuestionInEditing+" onkeyup='beep(undefined, 8401, 40)' placeholder='Type the question here...'>"+Q+"</textarea><input onkeyup='beep(undefined, 8401, 40)' id='RE"+numberOfQuestionInEditing+"' type=text placeholder='Correct answer here...' value='"+R+"'><hr><br>";
    document.getElementById('CreateQuestions').innerHTML = html;
}
RenderQuestion();


function SaveQuestionTempAndGo(numberNew){
    let q = document.getElementById("QN"+numberOfQuestionInEditing).value;
    let r = document.getElementById("RE"+numberOfQuestionInEditing).value;
    question[numberOfQuestionInEditing][0]=q;
    question[numberOfQuestionInEditing][1]=r;
    numberOfQuestionInEditing = numberNew;
    RenderQuestion();
}



function getURLbase(){
    let base_url = window.location.origin;
    let host = window.location.host;
    let pathArray = window.location.pathname.split('/');
    let newSub = '';

    for(let i=0; i<pathArray.length-1;i++){
        if(pathArray[i] != ""){
        newSub += pathArray[i]+"/";
        }
    }
    return base_url+"/"+newSub;
}

function saveQuestion(){
    dergo();
    let urlBase = getURLbase();
    alert(urlBase+"?f="+file);
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



let file = "q"+ID();;

///////////////////////////...SAVE DATA...//////////////////////////////////
function dergo() {
var e = JSON.stringify(question);

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















