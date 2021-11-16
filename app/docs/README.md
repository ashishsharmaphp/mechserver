## ------------------- References --------------------##
========================================================

Bitbucket & Git : https://blog.kevinlee.io/2013/03/11/git-push-to-pull-from-both-github-and-bitbucket/
-----------------


AWS Install : https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04


AWS INstall phpmyadmin : http://stackoverflow.com/questions/34060036/have-trouble-installing-phpmyadmin-on-php7-apache-2-4-7-ubuntu

                       : http://askubuntu.com/questions/755383/phpmyadmin-not-working-due-to-missing-extensions



AWS webaccess : http://serverfault.com/questions/356598/why-cant-i-reach-my-amazon-ec2-instance-via-its-elastic-ip-address




## ------------------- Commands to fresh start --------------------##
=====================================================================

cd /to/path/to/project/dir/

git init

git clone https://ashishsharmaphp@bitbucket.org/ashishsharmaphp/mechserver.git

git status

git add -A

git commit -m 'Comments/Message to commit'

git push




## ------------------- Command to take update and push --------------------##
=============================================================================

git status

git pull origin master 

git add -A

git commit -m 'Comments/Message to commit'

git push





## ------------------- AWS Login and commit/update --------------------##
=============================================================================

ssh -i "Mechanik.pem" ubuntu@ec2-52-88-63-24.us-west-2.compute.amazonaws.com

cd /var/www/html/mechserver/