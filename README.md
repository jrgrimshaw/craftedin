# **craftedin — An open source social network**

Originally launched in 2014, craftedin was a social network for developers created as a side project in order to learn web development. It was a well-loved website home to a small community of developers for several years until it was eventually shut down in 2019.

The code from this project is now open source, and I would love to see it developed further. Please bear in mind the codebase is relatively old, and therefore security vulnerabilities will be present.

**This remains a part-time project for me. Pull requests are welcome and encouraged, but it may take a few days for me to respond.** 

---

## **Getting Started**

1. **Web Server** To get started, you will need to place the code into the root directory of a web server. You can either purchase web hosting to do this, or create a web server on your computer using [XAMPP](https://www.apachefriends.org/) on Windows or [MAMP](https://www.mamp.info/en/) on macOS.

2. **Database** The SQL required to create the database structure is included in the root directory, and is named `database.sql`. Guides for how to add a MySQL database on your server can be found online.

3. **Configuration** Next, you will need to configure the website for your system. In the file `app/init.php`, modify the database credentials to match yours, as well as the URL definitions, and Stripe details if necessary/applicable.

4. **Install Dependencies** Finally, you will need to install the project's dependencies using a package manager called [Composer](https://getcomposer.org/). You will first need to install Composer on your system (follow the [getting started](https://getcomposer.org/doc/00-intro.md) guide), and then inside the project directory run:
    ```
    composer install
    ```
    You should then be ready to go! Head over to http://localhost (or URL of your web server) in a web browser.

---

## **Credits**

Copyright &copy; 2019 James Grimshaw. Licenced under the [MIT licence](https://opensource.org/licenses/MIT).
