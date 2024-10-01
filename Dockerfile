# Utilizziamo un'immagine PHP con supporto per NGINX e FPM
FROM php:8.1-fpm

# Installiamo le estensioni necessarie
RUN docker-php-ext-install pdo pdo_mysql

# Copiamo il codice del backend nella cartella /var/www
COPY ./api /var/www/html

# Installiamo Nginx
RUN apt-get update && apt-get install -y nginx

# Copiamo il file di configurazione di Nginx
COPY ./nginx/default.conf /etc/nginx/sites-available/default

# Avviamo sia Nginx che PHP-FPM
CMD service nginx start && php-fpm

EXPOSE 80
