# Hetzner Cloud Failover
Simple yet usable script for creating automatic failover scenarios for Hetzner's Cloud projects.

It is actually a PHP script that was built for my own specific needs, so it may not be a plug2play solution for you.
It instantly deploys a new VM straight from the latest available backup, once it verifies that another one is down (state: error) inside a Hetzner's cloud project, using its API.

Feel free to create your branches and extend its functionalities in case you want to contribute. 

Please consider the following and behave/expect things accordingly: This is my first project here and my first hands-on experience with version control software.
