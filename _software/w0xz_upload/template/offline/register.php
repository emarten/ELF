<h1>Filehosting von ${siteName}</h1>
Schön, dass du Dich für eine Mitgliedschaft bei ${siteName} entschieden hast. Sicher kennst du schon die <a href="${siteURL}membership/">Vorteile der Mitgliedschaft</a> also nichts wie los - teile deine Dateien mit Freunden, Familie und Kollegen!

<form action="" method="POST">
	<label for="user">Benutzername</label>
	<input type="text" name="user" value="<?php echo inputval(postval("user")); ?>" />
</form>