function check_word(str) {
  var xmlhttp;
  if (str=="") {//if empty
    document.getElementById("existance").innerHTML="";
    return;
  }

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var message = '';
      var match = xmlhttp.responseText;
      if(match.substring(0,1)=="!") {//does not exists
        message = 'The word "'+match.substring(1)+'" does not exist.';
      } else {//exists
		message = 'The word "'+match+'" exists!';
      }
      document.getElementById("existance").innerHTML = message;
    }
  }

  xmlhttp.open("GET","check_word.php?word="+str,true);
  xmlhttp.send();
}