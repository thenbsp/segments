http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html

```
server {
    server_name     example.com;
    root            /path/to/example.com/web;

    location / {
        try_files $uri /app.php$is_args$args;
    }

    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass                127.0.0.1:9000;
        fastcgi_split_path_info     ^(.+\.php)(/.*)$;
        include                     fastcgi_params;
        fastcgi_param               SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param               DOCUMENT_ROOT $realpath_root;
    }

    location ~ ^/app\.php(/|$) {
        fastcgi_pass                127.0.0.1:9000;
        fastcgi_split_path_info     ^(.+\.php)(/.*)$;
        include                     fastcgi_params;
        fastcgi_param               SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param               DOCUMENT_ROOT $realpath_root;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /usr/local/nginx/logs/example_com_error.log;
    access_log /usr/local/nginx/logs/example_com_access.log;
}
```
