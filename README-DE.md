# google-fit-into-nightscout-importer
Importiert die Werte von Googles-Fit https://takeout.google.com/settings/takeout from Google-Fit über die API in Nightscout.

Geh auf: https://takeout.google.com/settings/takeout

Wähle ab, ausser "Google-Fit"

Dann auf den "weiter"-Button clicken

Dann auf den Button "Archiv erstellen"

Warten, bis das Archiv fertig ist.

Oder nach der Anleitung von: https://googlesystem.blogspot.de/2016/02/export-google-fit-data.html

Dann das Archiv auf den Server/Linux-Shell/Windows-PHP runter laden.
Entpacken.

Werte in der "config.inc.php" anpassen.

Wenn im Verzeichnisnamen von "googlefitdir" spezielle Zeichen wie z.B. äü usw. (deutsch, chinesisch, russisch) der Fall ist, kann das Probleme machen.
Da am besten dern Ordner in z.B. /Takeout/Fit/aktiv/ umbennen.

googlefitdir in der config.inc.php anpassen.


Wichtig: es werden nur die Dateien von "Aktivitäten" eingelesen. Die Werte von dem Ordner "Geringe Genauigkeit" oder "Tägliche Zusammenfassung" nicht.

Aber man kann in der config.inc.php den Ordner ja anpassen und dann das Skript noch mal ausführen.

Dann das Skript ausführen:

php7 -f import-google-fit-to-ns.php

Fertig.


<a href="https://www.pic-upload.de" target="_blank"><img src="https://www2.pic-upload.de/img/33044613/google-fit-nightscout.jpg" title="Bilder oder Fotos hochladen"></a>


Wichtig! Der Code ist schon sehr alt und sollte mal überarbeitet werden :-)
Und wenn du den Code so verwendest wie er ist, dann verwendest du ihn mit allen Gefahren.
Du kannst den Code natürlichi gerne optimieren :-)

