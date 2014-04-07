<div id="header">
	<div>
		<nav id="mainnav">
			<ul>
				<li>
					<a href="${siteURL}">Startseite</a>
				</li>
				<li>
					<a href="${siteURL}register/">Mitglied werden</a>
				</li>
				<li class="clearBoth">&#160;</li>
			</ul>
		</nav>
		<div id="login">
			<form action="${siteURL}login/" method="POST">
				<button style="float:right;" class="btn btn-default" id="loginbtn">Login</button>
				<div style="padding-top:5px;">
					<table>
						<tr>
							<td style="padding-right: 10px;">
								<label for="user">Benutzername</label>
							</td>
							<td style="padding-left: 10px;">
								<input type="text" name="user" id="user" value="" />
							</td>
						</tr>
						<tr>
							<td style="padding-right: 10px;">
								<label for="pass">Passwort</label>
							</td>
							<td style="padding-left: 10px;">
								<input type="password" name="pass" id="pass" value="" />
							</td>
						</tr>
						<tr>
							<td>&#160;</td>
							<td style="padding-left:10px;">
								<a href="${siteURL}lost-password/">Passwort vergessen</a> | <a href="${siteURL}register/">Anmelden</a>
							</td>
						</tr>
					</table>
				</div>
				 
			</form> 
		</div>
		<div class="clearBoth">&#160;</div>
	</div>
</div>
<div style="margin:50px auto 0; width:550px; padding:20px 0 10px;">
	<a href="${siteURL}"><img style="float:left; margin-bottom: -80px; margin-left: -135px;" src="${softwareURL}template/UPLOADw0xz.de.png" /></a>
	<h1 style="float:left; margin:0;padding:0;margin-bottom:10px;"><a href="${siteURL}"><?php echo $_ELF->_SOFTWARE->name; ?></a></h1>
</div>
<div style="clear:both; height:0;">&#160;</div>