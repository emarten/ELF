<h2 style="margin:0; padding:0; margin-bottom: 10px;">Download wird gestartet..</h2>Vielen Dank, dass Sie <?php 
 if (isset($_ELF)) { echo $_ELF->_SOFTWARE->name; }
 else
 {
	 echo $_GET["name"];
 }
?> nutzen.
<hr />
<a href="<?php echo $_GET["site"]; ?>" class="btn btn-primary">zur Startseite</a>