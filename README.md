# Blog

## Local environment

If you're developing on Linux and Docker Compose is already installed, you can follow instructions below to manage the project.

### Run installation script

Navigate to the project root directory and execute the installation script to set up your local development environment:

`chmod +x ./scripts/install.sh` to set permissions.

`./scripts/install.sh` to execute.

### Starting and stopping environment

#### Start the environment

`make sail -- up -d`

#### Stop the environment

`make sail down`

### Sail

Laravel Sail is used for local development.

To simplify running Sail commands, the `Makefile` file has been created to simplify Sail commands.

Instead of typing the full Sail command, it is possible to use `make sail` followed by any Sail command and options.

The `--` is used to separate make's own options from the commands and options that are meant for Sail. This ensures make does not try to interpret Sail commands as its own.

#### How to Use

Simple command example:

`make sail ps` to list containers.

More complex command with `--` examples:

`make sail -- up -d` to start Sail in detached mode.

`make sail -- build --no-cache` to build without cache.

## Usage

### Test user

Test user has been created with login credentials:

E-mail: `user@example.com`  
Password: `asdasdasd`

### API token

To create API Bearer token:

`/tokens/create/api`

### Tests

#### Tests created:

`tests/Feature/CommentApiControllerTest.php`
`tests/Feature/ArticleApiControllerTest.php`

#### Test run:

In app container (`make sail`):

`php artisan test`
