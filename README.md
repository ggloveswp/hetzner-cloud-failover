# Hetzner Cloud Failover
Simple yet usable script for creating automatic failover scenarios for Hetzner's Cloud projects.

It is actually a PHP script that was built for my own specific needs, so it may not be a plug2play solution for you (ie, I dont use floating IPs etc). 
Its main purpose is to instantly deploy a new VM straight from the latest available backup, once primary VM is verified as down (state: error), inside a Hetzner's cloud project, using its API key and in the same database.

# Usage
- Open up check.php and replace API_KEY_HERE with your Hetzner's project API key.
- Add a cronjob using PHP, cURL or similar

# Useful links
Hetzner's Cloud API Documentation: https://docs.hetzner.cloud/

# Important
Feel free to create your branches and extend its functionalities in case you want to contribute. 

Please consider the following and behave/expect things accordingly: This is my first project here and my first hands-on experience with version control software.
