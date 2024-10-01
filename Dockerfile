# Dockerfile

FROM php:8.1-fpm

# Installa estensioni necessarie
RUN docker-php-ext-install pdo pdo_mysql

# Copia i file della tua applicazione PHP nella directory di lavoro del container
COPY . /var/www/html

# Setta la directory di lavoro
WORKDIR /var/www/html

# Espone la porta (Render utilizza di default la variabile PORT, che spesso è 10000)
EXPOSE 10000

# Comando di avvio
CMD ["php-fpm"]
