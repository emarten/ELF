<!doctype html>
<html>
	<head>
		::{title:${title}}::
		${jQuery}
		${bootstrap}
		::{css:${softwareURL}template/css/style.css}::
		::{favicon:${softwareURL}template/favicon.ico}::
	</head>
	<body>
		::{load:${templateDIR}header.php}::
		<div style="margin:0 auto; width:550px; border:solid 1px #dfdfdf; padding:10px;" id="content">
			::{load:${content_file1}}::
		</div>
		::{load:${templateDIR}footer.php}::
		<?php /* <iframe style="border:none; height:2px; width:2px;" src="${siteURL}api/cronjob/"></iframe> */ ?>

	</body>
</html>