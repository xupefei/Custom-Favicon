#Custom Favicon
#####for Google Plus
________________
##Usage
1. Upload all files in this repo to your server.

2. Write a new config file to your web server to let your server handle wildcard DNS correctly. You should replace `server_name` with your own ones.

    server_name icon.sukima.me *.icon.sukima.me;
    location / {
        rewrite ^/favicon.ico$ /favicon.php last;
    }

3. Configure your DNS server, point `*.icon.sukima.me` (as an example) to your IP address.

________________

by [Paddy Xu](https://plus.google.com/104849771033212826335)