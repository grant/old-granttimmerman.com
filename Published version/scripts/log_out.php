<?php
function log_out() {
  session_start(); 
  session_destroy();
}
?>