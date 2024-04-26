# Rick and Morty Data Fetcher

This project retrieves character, location, and episode information from the Rick and Morty API and stores it in a local database. It is designed to process and persist data from the API into a structured database for further analysis and usage.

## Installation

Follow these steps to get the project up and running on your local machine:

-   **Clone the Repository:**
    git clone
    `https://github.com/saidbasgoze/RickAndMortyDataFetcher`

-   **Install Required Packages:**
    Navigate to the project directory in your command line interface and run:

`composer install`

-   **Configure the Database:**
    Copy the `.env.example` file to a new file named `.env`, and update the database settings according to your local environment:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    **Note:** XAMPP users typically do not require a password.

-   **Create Database Schemas:**
    Run the following command to create the database tables:

    `php artisan migrate`

## Usage

To fetch data from the Rick and Morty API and save it into your local database, execute:
`php artisan rickandmorty:getdata`

## Testing

Ensure that the various components of the application are working correctly by running:
`php artisan test`

## Contribute

If you have suggestions or improvements, please open an issue to discuss your ideas before submitting a pull request.
