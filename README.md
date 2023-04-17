
1 - git clone https://github.com/lilow0001/app-movies.git -b master
2 - cd .\app-movies\ 
3 - composer i ;  npm i 
4 - cp .env.example .env
5 - php artisan key:generate
6 - npm run dev  
7 - npm run build
8 - docker compose up



- remplir la table movies de la BD à partir de API (avec une commande  artisan)
  
   * php artisan app:saveInDB