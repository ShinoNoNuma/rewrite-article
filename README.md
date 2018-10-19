# Rewrite Article Generator
Article Rewriter Tool - Reword or Paraphrase Text Content, is a machine learning program that allows you to change the sentences contained in an article while keeping the same meaning. The algorithm makes that for each word he doesn't know then the program will find on the website thesaurus.com an associated list of synonyms and store it in is own database (so basically the program will be faster and faster over time). Thereafter the program will replace each word by the best possible synonym. Several configuration levels are possible. 

How to use :

	    		1 - Clone a git repository :

	        		git clone https://github.com/ShinoNoNuma/rewrite-article.git
                       
           	 	2 - chmod directory permission for tmp folder:
                
               	 	 chmod -R 1777 rephrase

			3 - Create a MySQL Database

			    mysql -uroot -p
			    CREATE DATABASE IF NOT EXISTS rephrase;
			
			4 - Import the database
			    mysql -uroot -p rephrase < rephrase.sql 

			5 - Edit the file app/Config/database.php

			6 - App Rewrite Article Generator is ready, go to http://localhost/rephrase


Notice : This project is just a prototype.
	 I used the framework cakephp 2.10
