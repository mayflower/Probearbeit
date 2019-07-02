# Probearbeit

##Preparation
* Install Docker: https://docs.docker.com/docker-for-windows/install/
* Install PHPStorm: https://www.jetbrains.com/phpstorm/download/#section=windows

## Setup
 
* checkout Project from [GitHub][1]: <code>git clone git@github.com:mayflower/Probearbeit.git</code> 
* <code>cd Probearbeit/Docker</code>
* <code>docker-compose up -d</code>
* <code>docker exec -it docker_php_fpm_1 bash</code>

## Create SF4 Project
* Follow the instructions: https://symfony.com/doc/current/best_practices/creating-the-project.html
* the public folder should be /var/www/probearbeit/public
* the host is sf.local:8080