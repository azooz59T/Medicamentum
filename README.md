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
3. Execute the seeder
   ```sh
   npm install
   ```
4. Enter your API in `config.js`
   ```js
   const API_KEY = 'ENTER YOUR API';
   ```
5. Change git remote url to avoid accidental pushes to base project
   ```sh
   git remote set-url origin github_username/repo_name
   git remote -v # confirm the changes
   ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] Add Changelog
- [x] Add back to top links
- [ ] Add Additional Templates w/ Examples
- [ ] Add "components" document to easily copy & paste sections of the readme
- [ ] Multi-language Support
    - [ ] Chinese
    - [ ] Spanish

See the [open issues](https://github.com/othneildrew/Best-README-Template/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Top contributors:

<a href="https://github.com/othneildrew/Best-README-Template/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=othneildrew/Best-README-Template" alt="contrib.rocks image" />
</a>

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the Unlicense License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Your Name - [@your_twitter](https://twitter.com/your_username) - email@example.com

Project Link: [https://github.com/your_username/repo_name](https://github.com/your_username/repo_name)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

Use this space to list resources you find helpful and would like to give credit to. I've included a few of my favorites to kick things off!

* [Choose an Open Source License](https://choosealicense.com)
* [GitHub Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet)
* [Malven's Flexbox Cheatsheet](https://flexbox.malven.co/)
* [Malven's Grid Cheatsheet](https://grid.malven.co/)
* [Img Shields](https://shields.io)
* [GitHub Pages](https://pages.github.com)
* [Font Awesome](https://fontawesome.com)
* [React Icons](https://react-icons.github.io/react-icons/search)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
