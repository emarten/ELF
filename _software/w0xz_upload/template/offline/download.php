<h2 style="margin:0; padding:0; margin-bottom: 10px;">Download erfolgt in <span id="secs">${time_left}</span> Sekunden</h2>
Vielen Dank für die Nutzung von <?php echo $_ELF->_SOFTWARE->name; ?>
<script type="text/javascript">
	
	
	function countdown()
	{
		var secs=jQuery("#secs").html();
		secs--;
		if (secs>=0) { jQuery("#secs").html(secs); }
		
		if (secs==0)
		{
			document.location.href='${location}';
		}
		if (secs<=-1)
		{
//			document.location.href='${siteURL}success';
			jQuery("#content").load("${softwareURL}template/offline/success.php?site="+escape("${siteURL}")+"&name="+escape("<?php echo addslashes($_ELF->_SOFTWARE->name); ?>"));
		}
		
		setTimeout("countdown();",1000);
	}	setTimeout("countdown();",1000);
	
	
	//setTimeout("document.location.href='${location}';", ${time_left_ms} );
</script>
