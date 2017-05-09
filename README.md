**This is a very simple console game**

The idea of the game is quite simple: you fight with the enemies as long as you have your health, when you lose your health, 
you have to rest. In the game health is automatically restored as time goes by (this feature will be implemented in next release).

The docker-compose is located in the repository, so in order to run the required environment you need to run
```docker-compose up -d --build``` if you you use linux or create a docker-machine and then run this command.

```docker exec -it php composer install``` is used to install **Symfony** and all required packages, and  
also upgrades Database and adds required Mysql Schemas.

In this game you have only 3 commands:
1. `docker exec -it php bin/console app:create-hero` - to create a hero (Magician, Warrior, Archer)
2. `docker exec -it php bin/console app:start-game YOUR_NAME` - to start a fight with the enemy
3. `docker exec -it php bin/console app:hero-stats` - to see the heroes' statistics 

`docker exec -it php phpunit --coverage-text` - to run the tests and to check the coverage
