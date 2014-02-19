function check_username(str) {
  var xmlhttp;
  if (str=="") {
    document.getElementById("check_username").innerHTML="";
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
      if(match=='true') {
        message = 'Username already taken';
      } else if(match=='short') {
        message = 'Username too short';
      } else if(match=='long') {
        message = 'Username too long';
      } else if(match=='characters') {
        message = 'Invalid characters. Only a-z, numbers, "-" and "_" can be used.';
      } else if(match=='false') {
        message = '';
      }
      document.getElementById("check_username").innerHTML = message;
    }
  }

  xmlhttp.open("GET","/scripts/check_username.php?username="+str,true);
  xmlhttp.send();

}

function check_email(str) {
  var xmlhttp;
  if (str=="") {
    document.getElementById("check_email").innerHTML="";
    return;
  }

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var message = '' ;
      var match=xmlhttp.responseText;
      if(match=='invalid') {
        message = 'Invalid email address';
      } else if(match == 'false') {
        message = '';
      } else if(match == 'true') {
        message = 'Email address already taken';
      }
      document.getElementById("check_email").innerHTML = message;
    }
  }

  xmlhttp.open("GET","/scripts/check_email.php?email="+str,true);
  xmlhttp.send();

}

function check_password(str) {
  var xmlhttp;
  if (str=="") {
    document.getElementById("check_password").innerHTML="";
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
      var error = xmlhttp.responseText;
      if(error=='short') {
        message = 'Password too short';
      } else if(error=='long') {
        message = 'Password too long';
      } else if(error=='characters') {
        message = 'Invalid characters. Only a-z, numbers, "-" and "_" can be used.';
      } else if(error=='false') {
        message = '';
      }
      document.getElementById("check_password").innerHTML = message;
    }
  }

  xmlhttp.open("GET","/scripts/check_password.php?password="+str,true);
  xmlhttp.send();

}

function check_confirm_password(pass1,pass2) {
  var passes = pass1+","+pass2;
  var xmlhttp;
  if (pass1==""||pass2=="") {
    document.getElementById("check_confirm_password").innerHTML="";
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
      if(match=='false') {
	    message = 'Passwords do not match';
	  } else {
	    message = '';
	  }
      document.getElementById("check_confirm_password").innerHTML = message;
    }
  }

  xmlhttp.open("GET","/scripts/check_confirm_password.php?passwords="+passes,true);
  xmlhttp.send();

}