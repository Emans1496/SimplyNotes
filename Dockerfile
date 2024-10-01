# Usa una base di PHP-FPM
FROM php:8.1-fpm

# Installa Nginx
RUN apt-get update && apt-get install -y nginx

# Installa le estensioni PHP necessarie
RUN docker-php-ext-install pdo pdo_mysql

# Copia i file della tua applicazione PHP nella directory di lavoro del container
COPY . /var/www/html

# Copia la configurazione Nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Setta la directory di lavoro
WORKDIR /var/www/html

# Espone la porta per Nginx (Render utilizza di default la variabile PORT, spesso 10000)
EXPOSE 10000

# Avvia sia Nginx che PHP-FPM
CMD service nginx start && php-fpm
