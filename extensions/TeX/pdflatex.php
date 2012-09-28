<?php

$tex = $_POST['tex'];

if ( $tex == '' )
	echo "Use the POST method to upload LaTeX";
else	{
	chdir('/home/Advokado/Wiki/images/');

	$tempfile = 'WikiTeX';

	unlink($tempfile.'.pdf');

	$file = fopen($tempfile.'.tex', 'w');
	fwrite($file, $tex);
	fclose($file);

	exec('pdflatex "'.$tempfile.'.tex"');

	$result = file_get_contents("$tempfile.log");

	if ( strpos($result, 'no output PDF file produced') === false ) {
		$PDF = file_get_contents($tempfile.'.pdf');
		if ( strlen(trim($PDF)) > 0 ) {
			header('Content-Type: application/pdf');
			header('Content-Disposition: inline; filename="WikiTeX.pdf"');
			echo $PDF;
			}
		else
			echo "Empty PDF. Something went wrong.";
		}
	else
		echo "<html>
<body>
<pre>$result</pre>
<script>
	window.scrollTo(0, document.body.scrollHeight)
</script>
</body>
</html>";

	unlink($tempfile.'.tex');
	unlink($tempfile.'.log');
	}

?>
