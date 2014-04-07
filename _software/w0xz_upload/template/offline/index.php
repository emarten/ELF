<script type="text/javascript">
	function uploadstarted()
	{
		var nel=document.createElement("div");
		var nel2=document.createElement("div");
		nel.appendChild(nel2);
		jQuery(nel).css({ position:"fixed", top:0, left:0, width:"100%", height:"100%", background:"rgba(255,255,255,0.4)" });
		jQuery(nel2).css({ width:550, margin:"220px auto 0 auto" });
		nel2.innerHTML="<center class='rotate shadow' style='background:#f1f1f1; padding:10px;'>Der Upload wurde gestartet<br />Bitte warten Sie..</center>";
		
		
		
		document.body.appendChild(nel);
	}
</script>

		<h2 style="margin:0; padding:0; margin-bottom: 10px;">Datei Hochladen</h2>
		<form action="${siteURL}upload/" method="post" enctype="multipart/form-data" id="form" onsubmit="uploadstarted();">
			<p>W&auml;hlen Sie eine Datei von Ihrem Rechner aus:<hr />
				<input name="upload" type="file" size="50" maxlength="${max_filesize}" accept="*/*" style="float:left; margin-right:10px; width:300px;" />
				<span style="font-size: 10px; color:red;">${max_filesize_str}</span>
				<div style="clear:both; height:0px;">&#160;</div>
			</p>
			<p>
				<input type="text" name="email" placeholder="yourname@example.com" style="width:300px; margin-right:10px;" /> <span style="color:green; font-size:10px;">Kein Pflichtfeld</span>
				<br />
				<em style="font-size:10px;">Möchten Sie den Downloadlink zusätzlich per E-Mail erhalten?</em>
			</p>
			<input type="submit" value="Upload" class="btn btn-primary" />
		</form>
		<hr />
		<em style="font-size:10px;">Ihre Datei wird ${time2live_days} Tage lang gespeichert. Die Speicherdauer erhöht sich jedoch mit jedem Download um weitere ${time2live_days} Tage ab dem Tag des letzten Downloads. Sie versichern der Rechteinhaber der hochgeladenen Datei zu sein und deren Verbreitungsrechte inne zu halten.</em>
		<em style="font-size:10px;">Die angegebene E-Mailadresse wird nur für die Zusendung des Downloadlinks verwendet und wird nicht gespeichert.</em>