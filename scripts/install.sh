#!/bin/bash

set -e  # Exit immediately if a command exits with a non-zero status.

# Store the directory path of the script.
SCRIPT_DIR="$(dirname "$0")"

# Keep relative path to this script.
cd "$SCRIPT_DIR"

source ./variables.sh

cd ..

# Check that the 'vendor' directory and the 'vendor/bin/sail' file exist.
SAIL_INSTALLED=0

if [ -d "vendor" ] && [ -f "vendor/bin/sail" ]; then
    SAIL_INSTALLED=1
fi

# Copy the .env.example file to .env file.
if [ ! -f ".env" ]; then
  echo -e "${COLOR_LIGHT_BLUE}Copying .env.example file to .env file...${COLOR_END_COLOR}"
  cp .env.example .env
fi
read -p "$(echo -e "${COLOR_LIGHT_BLUE}Make changes to the .env file now if necessary. If everything is ready press enter to continue. [Enter]${COLOR_END_COLOR}")"

# Checking if Laravel Sail is already installed.
if [ $SAIL_INSTALLED -eq 1 ]; then
    echo -e "${COLOR_LIGHT_BLUE}Laravel Sail appears to be installed already.${COLOR_END_COLOR}"
else
    echo -e "${COLOR_LIGHT_BLUE}Laravel Sail Installation...${COLOR_END_COLOR}"

    # Running a Docker container to install dependencies.
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs

    echo -e "${COLOR_GREEN}Laravel Sail installed successfully.${COLOR_END_COLOR}"
fi

SAIL="./vendor/bin/sail"

echo -e "${COLOR_LIGHT_BLUE}Installing Sail...${COLOR_END_COLOR}"
$SAIL up -d
echo -e "${COLOR_GREEN}Sail installed successfully.${COLOR_END_COLOR}"

echo -e "${COLOR_LIGHT_BLUE}Installing Composer dependencies...${COLOR_END_COLOR}"
$SAIL composer install
echo -e "${COLOR_GREEN}Composer dependencies installed successfully.${COLOR_END_COLOR}"

echo -e "${COLOR_LIGHT_BLUE}Installing NPM dependencies...${COLOR_END_COLOR}"
$SAIL npm install
echo -e "${COLOR_GREEN}NPM dependencies installed successfully.${COLOR_END_COLOR}"

echo -e "${COLOR_LIGHT_BLUE}Running migrations...${COLOR_END_COLOR}"
$SAIL artisan migrate --seed
echo -e "${COLOR_GREEN}Migrations ran successfully.${COLOR_END_COLOR}"

echo -e "${COLOR_GREEN}Installation complete.${COLOR_END_COLOR}"

