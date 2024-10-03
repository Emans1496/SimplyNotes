# Usa una base di PHP-FPM
FROM php:8.1-fpm

# Installa Nginx e le dipendenze necessarie
RUN apt-get update && apt-get install -y \
    nginx \
    gettext-base \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libmysqlclient-dev \
    default-mysql-client \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql

# Copia i file della tua applicazione PHP nella directory di lavoro del container
COPY . /var/www/html

# Copia la configurazione Nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.template

# Setta la directory di lavoro
WORKDIR /var/www/html

# Espone la porta per Nginx (Render utilizza di default la variabile PORT)
EXPOSE 10000

# Avvia sia Nginx che PHP-FPM, con envsubst per sostituire la variabile $PORT
CMD ["sh", "-c", "envsubst '$PORT' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf && php-fpm -D && nginx -g 'daemon off;'"]
