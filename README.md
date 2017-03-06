# AkroAPI project

## Files architecture

 - **core** contains the core framework
 - **controllers** - directory for your own controllers for modules
 - **modules** - Your data schema definition and sql seeds

## Quick Start

```bash

# Checkout AkroAPI
cd your-projects-folder/
git clone

Create new forlder for your new project.
mkdir mynewproject

# Copy modules, config, tests folders
cd mynewproject
cp your-projects-folder/akroapi/modules ./ -R
cp your-projects-folder/akroapi/config ./ -R
cp your-projects-folder/akroapi/controllers ./ -R
cp your-projects-folder/akroapi/tests ./ -R

# Copy api.php index.php build.sh runtests.sh files
cd mynewproject
cp your-projects-folder/akroapi/api.php ./ -R
cp your-projects-folder/akroapi/index.php ./ -R
cp your-projects-folder/akroapi/build.sh ./ -R
cp your-projects-folder/akroapi/runtests.sh ./ -R


# Make a symbolic link to the akroapi core
ln -s your-projects-folder/akroapi/core/ core

# Define your fields in /modules/{modulename}/fields.php
# fields contains fields definition
```

### build application

```bash

sh build.sh
# equivalent
php core/tools/build.php --create --initdb
```

### Run tests

```bash

sh runtests.sh
# equivalent
php tests/phpunit.phar tests/
```
