[![Code Climate](https://codeclimate.com/github/baohx2000/apitude/badges/gpa.svg)](https://codeclimate.com/github/baohx2000/apitude)

SETUP
=====

1. Create a new composer application depending on baohx2000/apitude and run composer install
1. Copy everything in `vendor/apitude/apitude/install` to your application root
  1. Set environment constants and other configuration in `config/local.config.php`
  1. Include any extra plugin modules you will want for your application (auth, etc)
1. Create a `tmp` directory in your root application directory.
  1. Create `tmp/proxies`
  1. Create `tmp/cache`
  1. Ensure `tmp` directory and its children are writable by your web server user (www-data in most cases).
  1. Add `tmp` to your application's `.gitignore` file so none of its contents are added to your repository.
1. Create a `Migrations` folder (must be capitalized) in your application's root.
1. Set your web server to hit `public/api.php` for non-static content
1. To run console commands use the `vendor/bin/apitude` command
