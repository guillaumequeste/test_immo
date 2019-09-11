Base de données

Table "biens" :
    - id : int clé primaire AUTO-INCREMENT
    - title : varchar(255)
    - price : int
    - image : varchar(100)
    - created_at : datetime, valeur par défaut : CURRENT_TIMESTAMP

Table "users" :
    - id : int clé primaire AUTO-INCREMENT
    - username : varchar(255)
    - email : varchar(255)
    - password : varchar(255)