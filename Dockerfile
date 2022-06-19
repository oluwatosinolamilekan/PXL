FROM php:7.4-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

COPY --chown=www:www docker/start.sh /usr/local/bin/start

RUN chmod u+x /usr/local/bin/start

#compy the .env.example to .env
RUN cp /var/www/.env.example /var/www/.env

# Install the php and npm dependencies
RUN /usr/local/bin/composer install --no-ansi --optimize-autoloader --no-plugins --no-interaction \
    && rm -rf /var/www/node_modules \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["/usr/local/bin/start"]
