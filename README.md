SETUP
=====

1. Create a new composer application depending on baohx2000/apitude
1. Copy `vendor/baohx2000/apitude/install/bootstrap.php` to your application
1. Copy `vendor/baohx2000/apitude/install/public` and `vendor/baohx2000/apitude/install/config` directories to your application's root directory
  1. Set environment constants in `config/local.config.php`
  1. Include any extra plugin modules you will want for your application (auth, etc)

1. Set your web server to hit `public/api.php` for non-static content
