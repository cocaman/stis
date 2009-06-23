htmlSQL - Version 0.5 - README
---------------------------------------------------------------------
AUTHOR: Jonas John (http://www.jonasjohn.de/)

BESCHREIBUNG:
---------------------------------------------------------------------
htmlSQL ist eine experimentelle PHP Klasse mit der man auf HTML
Elemente �ber eine SQL �hnliche Syntax zugreifen kann. Das
bedeutet das man nicht mehr �ber komplizierte Funktionen
bestimmte Tags extrahieren muss, sondern einfach eine Query
wie diese ausf�hrt:

SELECT href,title   FROM  a   WHERE $class == "liste"
       ^ HTML Attrib.     ^         ^ Abfrage (kann auch leer sein)
         die zur�ck-      ^
         gegeben          ^ HTML Tags die durchsucht werden sollen 
         werden sollen      "*" ist hier m�glich = alle Tags
                              
Diese Abfrage gibt einen Array aller Links mit dem Attribut class="liste"
zur�ck.

Alle HTTP Verbindungen in htmlSQL ben�tzen die wunderbare Snoopy Klasse
(Package Version 1.2.3 - URL: http://snoopy.sourceforge.net/). 
Allerdings wird Snoopy nicht f�r "file" oder "string" Queries ben�tigt.
Alle Snoopy betreffenden Dokumente (z.B: Copyright-Infos, Readme, usw.)
befinden sich im "snoopy_data/" Unterordner.


INSTALLATION / ANWENDUNG:
---------------------------------------------------------------------
Um htmlSQL in eigenen Projekten zu ben�tzen ist es nur notwendig die
zwei Dateien "snoopy.class.php" und die "htmlsql.class.php" zu laden
(mit include oder z.B. require). Danach kann htmlSQL, wie in den 
Beispielen (siehe examples/-Ordner), angesprochen werden. Dies sollte
nicht allzu schwer sein :-)


HINTERGRUND / GESCHICHTE:
---------------------------------------------------------------------
Ich hatte die Idee zu dieser Klasse als ich Daten von einer Web-Seite
extrahiert habe und dabei merkte das sich die Funktionen und Quelltexte
oftmals wiederholen. Da kam mir die Idee das ganze zu vereinfachen und
eine universelle Klasse daf�r zu entwickeln. 


WARNUNG:
---------------------------------------------------------------------
F�r die Abfragen wird die eval()-Funktion ben�tzt. Deshalb sollten alle
vom Besucher abh�ngige Daten wie z.b. IDs gepr�ft oder ggf. gefiltert 
werden da es ansonsten m�glich w�re schadhaften PHP Quelltext auszuf�hren.
Vertraue niemals Benutzereingaben!


TODO:
---------------------------------------------------------------------
- den internen HTML Parser verbessern
- ein eigenes Query system entwickeln und nicht
  das PHP eigene nutzen ( Die eval()-L�sung gef�llt mir nicht wirklich)
- Mehr Fehlerpr�fungen
- LIMIT Funktion einbauen


ANWENDUNGSGEBIETE VON HTMLSQL:
---------------------------------------------------------------------
- Daten von anderen Web-Seiten auslesen
- HTML basierte Datenbanken?
- XML Daten auslesen


LIZENZ:
---------------------------------------------------------------------
htmlSQL ben�tzt eine modifizierte BSD Lizenz, welche ziemlich offen ist.
Der Lizenztext befindet sich in der "htmlsql.class.php". 
Kurz zusammengefasst besagt er folgendes: 

- Die htmlSQL Klasse kann frei in kommerziellen und nicht-kommerziellen 
  Projekten ben�tzt werden
- Die Klasse darf mit oder ohne �nderungen frei weitergegeben werden
- Der Copyright-Hinweis darf nicht entfernt werden
- Der Autor �bernimmt keine Haftung f�r eventuelle Sch�den
- Der Name des Autors oder anderen beteiligten Autoren darf nur mit
  schriftlicher Genehmigung ben�tzt werden um f�r Produkte, welche 
  htmlSQL ben�tzen, zu werben


