# MAL-API
<i>(MyAnimeList-API)</i><br><br>

An API for my school assignment.

## Introduction
<p>Welcome to the MAL-API. This project is made for a school assignment where i needed to process data from a database to a consumer application. The reason it is called 'MAL-API', is because i use data from MyAnimeList in my database and this API parses this data.</p>

## Getting Started

These instructions will get you a copy of the project up and running on your local machine. These instructions use Windows 10 as operating system.

### Software requisites
There are a couple of things you will need before you can successfully run this API.

My recommended route is the XAMPP route. And i will use this route in the upcoming setup guide.
If you dont have `XAMPP 7.4.4` (<a href="https://www.apachefriends.org/download.html" title="download" target="_blank">download</a>) or higher installed. You need to install the newest version of XAMPP or the individual software.

<b> The software you need to install when you dont have / want XAMPP installed.</b>
<pre>
PHP 7.4.4 or higher. (<a href="https://www.php.net/downloads.php" title="PHP download" target="_blank">download</a>)
MariaDB 10.4.11 or higher. (<a href="https://downloads.mariadb.org/" title="MariaDB download" target="_blank">download</a>)
</pre>



### Installation and Setup

Now comes a step by step guide how to get everything up and running.

<b>Step 1</b><br>
Install XAMPP 7.4.4 or higher. (<a href="https://www.apachefriends.org/download.html" title="download" target="_blank">download</a>)

<b>Step 2</b><br>
Start the XAMPP control panel. (You may want to run this with Admin privileges when you encounter errors).

<b>Step 3</b><br>
When the Control panel is open, start the Apache and MySQL modules.

<b>Step 4</b><br>
Open the shell that is located on the right side of the Control panel. 

<b>Step 5</b><br>
<sub><b>Note:</b> This tutorial uses the default root account without password. It might be that you need to use other credentials.</sub><br>
When the shell is open, use the following command to create the database. 
<pre>
echo CREATE DATABASE `anime-db` | mysql -u root -p
</pre>

When you have created the database and are logged in successfully you are greeted by a welcome message.

<b>Step 6</b><br>
Download this project as an ZIP file.

<b>Step 7</b><br>
Extract the ZIP file into your htdocs folder of XAMPP. For me it is located at:```C:\xampp\htdocs```.<br>
Make sure you now have this path: ```C:\xampp\htdocs\dataprocessing```.<br>
To get this you may have to change the name of the extracted project to ```dataprocessing```.<br>
You can test this by typing this adress into your browser of choice: ```http://localhost/dataprocessing/```. 
If you have setup everything correctly it should greet you with a welcome message.<br>

<b>Step 8</b><br>
We now have to fill the ```anime-db``` database that we have created earlier. Start by exiting the MySQL by pressing the ```Ctrl + C``` combination on your keyboard.<br>
After that we use the following command to fill the ```anime-db``` database:<br>
```mysql -h localhost -u root -p anime-db < "C:\xampp\htdocs\dataprocessing\database\anime-db.sql"```

<b>Step 9</b><br>
To check if the database has filled with data, we are going to open the browser and go to ```http://localhost/phpmyadmin/```<br>
When you are on the PHPMyAdmin web-page start looking for the ```anime-db``` database and select it.<br>
If it is filled with data, good job!

<b>Step 10</b><br>
To see if the API works, go visit the next location with your browser: ```http://localhost/dataprocessing/website/```. If the API works, you should be able to see nice looking graphs from the data that sits inside the database.

<b>Step 11</b><br>
For the documentation of the API, i have used Swagger. It can be visited with your browser. The location of the API doc is: ```http://localhost/dataprocessing/doc/```.<br>
<sub><b>Note:</b> I have included a small personal message in the introduction message of the API.</sub>
In Swagger you can also try out queries. I have provided some sample data to use with inside the ZIP file i have turned in for the assignment. The file is called ```Swagger_test_data.docx```.

<b>Step 12</b><br>
At last we will take a look at the PHP code documentation. I have used PHPdoc to generate a web based documentation.<br>
You can go to the documenation with the following URL: ```http://localhost/dataprocessing/phpdoc/```.

## Acknowledgments<br>
I have used a couple of resources and libraries while working on this project.<br>
The resources i have used are displayed in the table beneath.
<br>

| Tool          | Use Case      | Location|
| ------------- |:-------------:|:-----:|
| Tutorial      | Got me started on the basics of routing. | <a href="https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241">source</a> |
| PHP Documentation      | Where i got information from.      |  <a href="https://www.php.net/manual/en/">source</a>  |
| Swagger |   API documentation.    | <a href="https://swagger.io/">source</a> |
| PHPDoc |   PHP API Code documentation.    | <a href="https://www.phpdoc.org/">source</a> |
| ChartJS |   Creation of JavaScript Graphs.    | <a href="https://www.chartjs.org/">source</a> |
| AJV |   Draft-07 Json validation.    | <a href="https://github.com/epoberezkin/ajv">source</a> |
| XML.js |   XSD XML validation.    | <a href="https://syssgx.github.io/xml.js/">source</a> |
| jQuery |   Making JavaScript coding simpler.    | <a href="https://jquery.com/">source</a> |
| xmlToJson |   Parsing XML to JSON    | <a href="https://github.com/andrewhouser/xmlToJson">source</a> |

## Roadmap for future releases
### Todo List
#### -Bugs
- Empty values (in XML) nodes can be send to user when column does not exist.
- When using GET with invalid ID it returns code 400.
- When posting without body. Errors appear with status code 500.
- Empty strings reaches database and queries.

#### -Features
- Content-type negotiation.
- Option to make it possible for queries to insert into database with key value pairs Now you can only insert with order. Need to somehow get key names into Mysql class.
- XML/JSON data switch on website. (It already accepts both)

## Authors

* **Tim Gels** - *Initial work* - [GitHub](https://github.com/GrandDynamo/)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

