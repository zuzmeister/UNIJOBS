#Better Unijobs.at
	Stabile Version 00
	Datum: 2016-06-07
	Proof Of Concept
...für die Arbeit mit der "API" von Unijobs.at(siehe API)

##Demo
**Keine Garantie, auf zuverlässigkeit. Kann sein, dass es auch schon wieder down ist (Stand 2016-06-07).**

Demoinstallation: http://public.tommachtalles.net/unijobs/

##Installation
Wenn man sowieso [XAMPP](https://www.apachefriends.org/download.html) installiert hat, einfach einen Ordner im **/PATHTOXAMPP/xamppfiles/htdocs** erstellen und Projektdateien hineinkopieren. Fertig.

Ansonsten einfach auf Webserver kopieren und loslegen, solange...
- php 5+
- Apache oä.
...vorhanden sind, sollte es laufen.

**Unter Umständen muss die Datei .htaccess angepasst werden, damit alles korrekt läuft.**

##Was noch fehlt:
- Anzeigen der Liste aller Inserate
- Automatisches Parsen und Speichern aller Inserate in einer eigenen Datenbank (cronjob?), um nicht von dem engen Zeitfenster auf Unijobs abhängig zu sein.
- Durchsuchbarkeit der Inserate
- Unerwünschte Tags besser herausfiltern, besonders bei "TopJobs" (\<style\>, \<br\>\<br\>\<br\> )
Was ganz nett wäre
- Taggen von Inseraten

##API
- Inserate-Liste: http://www.unijobs.at/_ajax/job_suche.php
- Einzelnes Inserat:	http://www.unijobs.at/_ajax/jobs_getjob.php?anzid=262777
- JS: http://www.unijobs.at/javascripts/app.js