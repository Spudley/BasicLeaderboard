## Very Simple Leaderboard

This is a very basic leaderboard application, as a proof of concept using raw Javascript and PHP with no libraries or third party code at all, except Composer, to provide autoloading in PHP.

The PHP code includes a simple router written from scratch for this project that runs controller classes or renders templates directly, according to a routing config file. It also has an abstracted data layer that can work with either a MySQL database or session-based storage, according to config.

The JavaScript code queries the leaderboard using the REST API exposed by the PHP code, and renders the leaderboard. Also provided is a page with insert/update/delete functions, again driven by the API.

I'm aware that there are numerous areas that require better validation/error handling/security/etc. This is a proof-of-concept, not production code. Please use a framework such as Symfony or Laravel rather than this router! And likewise for the JavaScript code.


# To run

* Clone the repo.
* `cd <project_base>`
* `composer install` (to build the autoloader; no third party libraries are installed)
* `cd public`
* `php -S localhost:8000 index.php`  (to run PHP's internal web server)
* Browse to `localhost:8000/leaderboard` to see the leaderboard page.
* Browse to `localhost:8000/crud` to perform inserts, updates or deletes.

Please do not run anywhere other than localhost: This application has is a proof-of-concept, and has no real security or sufficient error handling.

# Author

Simon Champion, April 12th 2021.

