#!/bin/bash

set -e  # Exit immediately if a command exits with a non-zero status.

# Store the directory path of the script.
SCRIPT_DIR="$(dirname "$0")"

# Keep relative path to this script.
cd "$SCRIPT_DIR"

source ./variables.sh

cd ..

# Copy the .env.example file to .env file.
if [ ! -f ".env" ]; then
  echo -e "${COLOR_LIGHT_BLUE}Copying .env.example file to .env file...${COLOR_END_COLOR}"
  cp .env.example .env
fi
read -p "$(echo -e "${COLOR_LIGHT_BLUE}Make changes to the .env file now if necessary. If everything is ready press enter to continue. [Enter]${COLOR_END_COLOR}")"

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
$SAIL artisan migrate
echo -e "${COLOR_GREEN}Migrations ran successfully.${COLOR_END_COLOR}"

echo -e "${COLOR_GREEN}Installation complete.${COLOR_END_COLOR}"

