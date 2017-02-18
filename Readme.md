Anmeldungen
-----------

Eine Sammlung von PHP-Skripten, die einen Anmeldeprozess automatisieren sollen.

The process
------------------
1. A participant fills out the form participant.php
2. On the submit_participant.php she or he gets access 
to the filled pdf document of the application (->has to be firmed manually)
	-> E-Mail with access token is being to group leader
	-> Confirmation mail is being sent to participant
3. Group leader uses token to add information about the participant in about_participant.php
4. Somebody in the postoffice has to recognize whether the firmed application
arrived (and when -> critical for the discount 'Frühbucherrabatt'):
	-> In administration.php one can confirm the arrival and 
	-> track if the application has been handled by the group leader
5. reminder.php sends an e-mail to the group leaders  
	-> who still have not filled out their part of the applications or 
	-> who have to remind their members of the group to send the firmed application by post


Installation
------------
1. Install dependencies from Documentation/Dependencies.txt
2. Use Apache* to serve the files *only* with TLS
3. Use the htpasswd command to add credentials**
4. Create a MySQL-Database and user who can access it
5. Add your MySQL information in credentials.php
6. Run "php setup.php RUN" from the bash
7. Set the global variables in helpers.php

\* The administration is "secured" by a .htaccess file.
\*\* Manual for htpasswd: https://httpd.apache.org/docs/current/programs/htpasswd.html


Holes
--------------------
1. The generated pdfs are stored in a servable area. 
The filename contains 30 random character. 
Intentionally accessible for those who know the 30 random characters.
2. So far there is no countermeasure against bots
3. No ip-ban
4. It makes use of the error_log function
5. No log rotation
6. Missing FOREIGN CONSTRAINT for Participants -> Groups
7. Makes use of basic auth
	-> only apache




