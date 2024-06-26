FROM php:8.3
RUN apt-get update -y && apt-get install -y nginx
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN docker-php-ext-install pdo mbstring
WORKDIR /app
COPY . /app
RUN composer install

# 複製 Nginx 配置文件
COPY nginx.conf /etc/nginx/sites-available/default

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
