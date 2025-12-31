# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory in the container
WORKDIR /var/www/html

# Copy all project files to container
COPY . /var/www/html/

# Install PHP extensions needed for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
