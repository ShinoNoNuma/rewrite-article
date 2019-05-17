# Rewrite Article Generator

![Article Generator](https://www.sam-y.ml/img/articlegenerator.png)

Article Rewriter Tool - Reword or Paraphrase Text Content, is a machine learning program that allows you to change the sentences contained in an article while keeping the same meaning. The algorithm makes that for each word he doesn't know then the program will find on the website thesaurus.com an associated list of synonyms and store it in is own database (so basically the program will be faster and faster over time). Thereafter the program will replace each word by the best possible synonym. Several configuration levels are possible. 

### Installation

Clone the repository in you web app folder:

```shell
git clone -b master git://github.com/ShinoNoNuma/rewrite-article.git rephrase
```
Change the directory permission for /tmp folder:

```shell
chmod -R 1777 rephrase
```

Now let's create the Database (MySQL):

```shell
mysql -uroot -p
```
```mysql
CREATE DATABASE IF NOT EXISTS rephrase;
```
Import the tables:
```shell
mysql -uroot -p rephrase < rephrase.sql
```

Edit the file app/Config/database.php to link the project to the database previously created:

```php
public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'password',
		'database' => 'rephrase',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
```

Now App Rewrite Article Generator is ready, please go to http://localhost/rephrase


***Notice : This project is just a prototype.
	 I used the framework cakephp 2.10
