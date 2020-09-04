# APPLICATION TEMPLATE

Application template for developing simple PHP web applications

## Requirements

- PHP 7.3
- Composer (https://getcomposer.org/)

## Installation

1. Clone this repository `git clone https://github.com/aerlaut/app-template`
2. Install Composer dependencies `composer install`
3. Copy `.env.example` to `.env` edit files wit the correct parameters
4. Run with `php -S localhost:8000`
5. View at `http://localhost:8000`

## Maintainer

- Anugerah Erlaut (aerlaut@live.com)

# Documentation

This application is built with simplicity in mind.

## Application structure

The basic application structure is

```
/app
  /components
  /css
  /img
  /js
  /php
  composer.json
```

The entry point for the application is `index.php`. `composer.json` only contains `symfony/dotenv` which is used to read `.env` configurations.

To use the supporting functions available in the template, include `init.php` at every page of the application.

To create a page under a `path`, simply create the folder `path`within the application folder.

```
/app
  /path
    /index.php
  ...
```

The page is then accessible at `localhost:8000/path/index.php`

## Using database

The minimal database structure required for the application is a `users` table which contains the following fields :

| Column   | Type            | Detail                   | Comments           |
| :------- | :-------------- | :----------------------- | :----------------- |
| id       | BIGINT UNSIGNED | NOT NULL, AUTO_INCREMENT | PRIMARY KEY        |
| username | VARCHAR(255)    | NOT NULL                 | UNIQUE             |
| password | VARCHAR(255)    | NOT NULL                 | `bcrypt` encrypted |
| role     | VARCHAR(255)    | NOT NULL                 | admin, user        |

The `role` field is optional, but it is used together for `is_admin`

Database connection is managed by the `DBConnection` class that is contained in `php\db`. To create a connection, create a new instance of `DBConnection` and call `connect()`.

```
$conn = new DBConnection()
$conn->connect()
```

The `$conn` object contains a `PDO` object that is connected to the database. To run a query, create a `PDOStatement` and run `execute`. The following pattern is usually used.

```
// Fetch user from database
$sql = "SELECT id, username, password, role FROM users WHERE username = :username";

$stmt = $conn->prepare($sql);

$params = ['username' => $_POST['username']];

if (!$stmt->execute($params)) {
  // Return error
  header('Content-Type: application/json');
  echo json_encode(['error' => $stmt->errorInfo]);
};

$user = $stmt->fetch();
```

## Page Structure

It is recommended to divide the page structure into 2 parts : processing and display.

```
// dashboard.php
// Processing
<?php

include_script('../init.php')
...

?>

<!-- DISPLAY -->

<html>

  <head>

    ...
    <?php include_script('../header.php') ?>

  </head>
  <body>

    <?php include_script('../navbar.php') ?>

    <main>
    ...
    </main>

  </body>

  <?php include_script('../footer.php') ?>
</html>
```

All data processing to display the page is procesed at the processing part. The display part is only concerned with displaying data that is previously processed. This pattern separates logic from presentation to make the code easier to read and maintain.

## Helpers

Helper functions are contained in `php/helpers.php`. The following functions are available :

### `include_script($url, $return = false)`

Include script relative to root using `require_once()`

**Example**

```
include_script('/components/footer.php')
```

**Return**

void

### `url($url, $return = false)`

Translates url relative to base path. Appends url to `APP_URL` in `.env`.

**Example**

```
// APP_URL = 192.168.1.67/trunkmon

url('/users/index.php') // 192.168.1.67/trunkmon/users/index.php
```

**Return**

String with the url appended to base application path.

### `redirect($url = '/')`

Redirects users to url to `APP_URL` in `.env`.

**Example**

```
// APP_URL = 192.168.1.67/trunkmon

redirect('/users/index.php')
```

**Return**

void

### `flash_message($url = '/', $message = '', $data = []), $status = 'ok', `

Appends a flash message to `session` and redirect user to `$url` Flash message is accessible with `has_messages()`

**Example**

```
$data = [ ... ]
flash_message('/users/index.php', 'success', $data)
```

**Return**

void

### `has_messages()`

Checks if there is any message in `session`.

**Example**

```
if(has_messages()) {

  $message = has_messages()

  foreach($message['data']) {
    ...
  }

}

```

**Return**

Array containing `status`, `message`, and `data` or `false` if there are no messages.

### `flash_error($url = '/', $message = '', $data = [], $status = 'error', )`

Appends a flash error message to `session` and redirect user to `$url` Flash message is accessible with `has_messages()`

**Example**

```
$data = [ ... ]
flash_message('/users/index.php', $err, $data)
```

**Return**

void

### `has_errors()`

Checks if there is any error message in `session`.

**Example**

```
if(has_errors()) {

  $errors = has_erros()

  foreach($errors['data']) {
    ...
  }

}

```

**Return**

Array containing `status`, `message`, and `data` or `false` if there are no errors.

### `send_json($message = 'success', $data = [], $status = 'ok', $http_code = 200, $return = false)`

Standardize format of JSON messages.

**Example**

```
$data = [ ... ]
send_json('Duplicate entries', $data, 'warning')

```

**Return**

JSON with the input values.

### `json_error($message = 'Internal server error', $http_code = 500, $return = false)`

Standardize format of JSON error messages.

**Example**

```
$data = [ ... ]
json_error()

```

**Return**

JSON error with the input values.

### `user($attr = 'username')`

Returns user's attribute. Uses `session`

**Example**

```
user('id')
```

**Return**

JSON error with the input values.

### `is_logged_in($else_kick_out = false)`

Check if user is logged in. If `$else_kick_out` is set to `true`, the user is logged out and redirected back to login page.

**Example**

```
if(!is_logged_in(true)) { exit; }
```

**Return**

`true` if user is logged in, else `false`

### `is_admin()`

Check if user's role is `admin`. First checks if user is logged in using `is_logged_in()`. Uses `role` in database.

**Example**

```
if(!is_admin()) {
  redirect('/dashboard.php)
}
```

**Return**

`true` if user is `admin`, else `false`
