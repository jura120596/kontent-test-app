    git clone
    cd project_dir
    composer install

#1 task

    php artisan parse:onlinetraid
    cat app/Console/Commands/Commandsonlinetraidout.csv
    Examle file: 
    
https://docs.google.com/spreadsheets/d/1QDiouOMVMdL9X9EiTIhT3q-BUlHk2FqwLNWN3o6rZFg/edit?usp=sharing

#2 task

    set DEV_EMAIL cariable in  .env file
    set DB configs in .env file
    php artisan serve
    open localhost:8000/products
    
To parsing from categories.json and products.json
   
    php artisan parse:json
  
