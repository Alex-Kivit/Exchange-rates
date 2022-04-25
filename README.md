# Exchange-rates
Demo web app for displaying currency conversion rates. Took about 8 hours to complete.

# Notes

App uses bootstrap 5 and PHP Symfony 4.4 framework. This project does not use any database, as it is not required. Currency rates are taken from https://www.frankfurter.app/docs.

# Setup
1. In project root run:
```
composer install
```
2. Launch application:
```
symfony server:start
```

# Possible improvements

1. Make language selector not reset search results. Could be done by replacing Symfony form with html one. For this project I decided to go with Symfony form for demonstration puposes.
2. Add base currency and currency pairs as form input.
3. Add end date as form input.
