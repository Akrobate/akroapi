# AkroAPI project

## Files architecture

core - L'ensemble des controlleurs de base et generiques et templates
custom - surcharge a core et creation de nouveaux controlleurs et templates
libs - Contient l'ensemble des libs utilisés dans le programme
modules - contient la description de chaque module 'Champs du module'

## Quick Start

Define your fields in /modules/{modulename}/fields.php

fields contains fields definition

### To build application

```bash

sh build.sh
# equivalent
php core/tools/build.php --create --initdb
```

### To run tests

```bash

sh runtests.sh
# equivalent
php tests/phpunit.phar tests/
```
