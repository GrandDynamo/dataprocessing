# MAL-API
<i>(MyAnimeList-API)</i><br><br>

An API for my school assignment.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

## Introduction
<p>Welcome to my API. This project is made for a school assignment where i needed to process data from a database to a consumer application. The reason it is called 'MAL-API', is because i use data from MyAnimeList in my database and this API retrieved those data.</p>

### Prerequisites
There are a couple of things you will need before running this API.

If you dont have `XAMPP 7.4.4` or higher (<a href="https://www.apachefriends.org/download.html" title="download" target="_blank">download</a>) installed. You need to install the newest version of XAMPP or the individual software.

<b> The software you need to install when you dont have / want XAMPP installed.</b>
<pre>
PHP 7.4.4 or higher. (<a href="https://www.php.net/downloads.php" title="PHP download" target="_blank">download</a>)
MariaDB 10.4.11 or higher. (<a href="https://downloads.mariadb.org/" title="MariaDB download" target="_blank">download</a>)
</pre>



### Installing

A step by step series of examples that tell you how to get a development env running

Say what the step will be

```
Give the example
```

And repeat

```
until finished
```

End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Tim Gels** - *Initial work* - [GitHub](https://github.com/GrandDynamo/)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc
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
