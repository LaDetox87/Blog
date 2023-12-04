**Mathieu Marais**

**Mise en place de la VM**

Il faut une VM linux (debian 10 obligatoire sinon lisez même pas ma doc)

Ouvrer le port 80 pour que le serveur web soit accessible.

**Mise en place du serveur Apache2**

```sh
sudo apt update
sudo apt install apache2 (Y)
sudo systemctl status apache2 (vérifier si Active : active (running))
</code>
```

**Installer PHP**

```sh
sudo apt install php8.2 php8.2-cli php8.2-{bz2,curl,mbstring,intl}sudo dpkg -l | grep php | tee packages.txt
sudo apt install php8.2-{dom,xml,zip,mysql}
sudo apt install apt-transport-https lsb-release ca-certificates wget -y
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg 
sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-{bz2,curl,mbstring,intl,mysql}
sudo apt install php8.2-fpm
sudo a2enconf php8.2-fpm
sudo systemctl reload apache2
```

**Allez courage on code !**

![image](https://th.bing.com/th/id/OIP.SKFe8QkzzIi23TMV3lORXQAAAA?rs=1&pid=ImgDetMain)

**Installer GITHUB (FTP)**

```sh
sudo apt install git
git clone https://github.com/LaDetox87/Blog.git
```

**Installer les packages**

fluxoscript-formation.me 

**Installer un serveur de base de donnée**

cours de première année de monsieur Mery
Mettez la dans une DMZ (cybersécurité les gars putain cours de première année)

**Installer Symfony**

```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

(dans le dossier Blog récupéré sur github)

```
composer install (pour récupérer tous les packages)
```

**Modifier le fichier .env à la racine du dossier récupéré sur github (Blog)**

-> Adapter la ligne 29 : DATABASE_URL = ""
"mysql://User_DataBase:MdpUser_DataBase@IPDELAVM/Nom_DataBase"

**Config BINDADRESS**

sudo nano /etc/mysql/mariadb.conf.d/50-server
-> 0.0.0.0

**Migrations BD**

Ensuite après avoir composer install, vous devez avoir le package Migrations.
Il sert à transférer la base de donnée du Blog, dans votre base de donnée.
Pour ça vous aller devoir utiliser les commandes suivantes :

```sh
php bin/console make:migration
```
(Pour créer un fichier qui contient toutes les commandes pour la BD Blog)

```sh
php bin/console doctrine:migrations:migrate
```
(Pour dump le fichier et effectuer les commandes)

**Étape Finale**

Déplacer le dossier récupéré du github (Blog) à l'endroit : 
/var/www/

**Redémarrer la vm**

```sh
Vagrant halt
Vagrant up
Vagrant ssh
```

=> Aller sur l'url IpVM et vous devez avoir ma page
```sh
if("c'est bon" === True){
    return 'super trop cool';
}else{
    return 'venez me voir sans en parler à MR.MERY sinon il va me crier dessus';
}
```








