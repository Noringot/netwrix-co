## Instruction

Instruction for deploying site

- composer create-project laravel/laravel netwrix-co
- cd netwrix-co
- git init
- git remote add origin git@github.com:Noringot/netwrix-co.git
- git pull origin master
- git reset --hard origin/master
- composer install
- npm i
- edit .env file:
  DB_CONNECTION=mysql  
  DB_HOST=193.168.3.119  
  DB_PORT=3306  
  DB_DATABASE=netwrix  
  DB_USERNAME=noringotq  
  DB_PASSWORD=NhwaypawWasdanu721  

- php artisan serve
