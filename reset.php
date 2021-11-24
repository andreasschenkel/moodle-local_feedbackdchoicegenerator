<?php
session_start();
session_destroy();
echo "Zurücksetzen der Session erfolgreich";
echo "<br>";
echo "<a href=\"index.php?id=1\">zurück zur Eingabe</a>";
echo "<br>";

?>
