<p align="center"><a href="https://www.national-g.com/ar" target="_blank"><img src="https://www.national-g.com/storage/images/settings/FGQhjV9XFw7U5Tdhiq0NtTGxvpchVoLciZELFqRo.png" width="400" alt="Laravel Logo"></a></p>

<!-- GETTING STARTED -->
## Getting Started

To get started please go to the top right of the project press the green `code` button and copy the URL [https://github.com/azooz59T/Medicamentum.git] provided perferably from the SSH tab for more useful config and less authentication hassel in the future, if having issues with SSH just use the HTTPS URL. In your hdocs file open the command line and type `git clone` hit space and then paste the URL copied from the previous step.

Congratulations you have cloned the repository 

### Prerequisites

To run the project you need to have local server packages such as XAMPP or WAMP, and of course you need to have PHP, Composer and NPM installed. 

### Installation


1. Run Apache and MYSQL servers from the Control panel of XAMMP or WAMP (press the Start button under the Actions tab)

2. In your browser navigate to the phpMyAdmin using the following URL `http://localhost:80/phpmyadmin` or `http://localhost:8080/phpmyadmin`

3. Click on the `New` button on the left pane. In the middle section enter `medicamentum` in the database name field and press `create` to create a new database with the name entered

4. Open your favorite IDE/text editor and open the repository you just cloned, go to the .env.example file at the root directory and copy it's contents and then create a new file in the root of the project and name it `.env`, once created paste the contents to that file.

5. Uncomment the Database credentials in the .env file by removing the `#` from lines 24 to 28 and change the Database connection from  `sqlite` to `mysql` and set the DB_DATABASE to `medicamentum` the name of the database we just created, also set the first line's APP_NAME to `medicamentum`

6. open the terminal in your IDE and type
    ```sh
    composer install 
    ```

7. Generate API encryption key
    ```sh
    php artisan key:generate 
    ```

8. Run the database migrations to connect the project to the MYSQL database and create the necessary tables 
    ```sh
    php artisan migrate 
    ```

9. Install node dependecies  
    ```sh
    npm install 
    ```
10. Build your NPM assets  
    ```sh
    npm run build 
    ``` 
11. Run your Laravel server  
    ```sh
    php artisan serve 
    ```
    your project setup is pretty much completed and you can navigate to your project on [http://127.0.0.1:8000] however the project lacks any products to test or develop

12. Execute the seeder
    ```sh
    php artisan db:seed
    ```
    One Final minute step is to generate a symlink from `storage/app/public` folder to the `public/storage` folder to allow for product upload image on creation.    

13. Create Symlink
    ```sh
        php artisan storage:link
    ```

<!-- USAGE EXAMPLES -->
## Usage

You can login with a seeded user with the following credential     
(email: ahmed.fawzy@national-g.com) (password: admin123)



<p align="right">(<a href="#readme-top">back to top</a>)</p>
