server {
    listen 80;
    server_name {domain};
    
    location /{    
        root {docroot};
        index index.php;

        if (!-e $request_filename) {
                rewrite ^/(.*)$ /index.php?_url=$1 last;
                   break;
               }

    }

    location ~ \.php$ {
            root {docroot};
              fastcgi_pass {fastcgi_pass};
              fastcgi_index index.php;
           include fastcgi.conf;
       }
    
    access_log {access_log}; 
    error_log {error_log};
}
