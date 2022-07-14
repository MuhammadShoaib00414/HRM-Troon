FROM ahsanshabir/troon-public:larvel-vue as builder
RUN mkdir -p /app
WORKDIR /app && mkdir -p /hrm
WORKDIR /app/hrm
COPY . /app/hrm
RUN composer clear-cache
#RUN composer update
RUN composer install --no-interaction
#RUN composer install
#RUN php artisan passport:keys
RUN composer require laradevsbd/zkteco-sdk
FROM troontech/troon-hrm:apache
RUN apt-get clean; docker-php-ext-install pdo pdo_mysql
COPY  --from=builder /app/ /var/www/
#RUN touch 137qOxgq3nOQ25m9vNSPU71V4xLBz0wHnKQ5QsW6
RUN cd /var/www/hrm/storage/framework/ && mkdir -p sessions
#RUN touch /var/www/hrm/storage/framework/sessions/137qOxgq3nOQ25m9vNSPU71V4xLBz0wHnKQ5QsW6
#RUN cp 137qOxgq3nOQ25m9vNSPU71V4xLBz0wHnKQ5QsW6 /var/www/hrm/storage/framework/sessions/ 
#RUN pwd && ls -alh
#RUN cd /var/www/hrm/storage/framework/sessions 
#RUN cd /var/www/hrm/storage/framework/sessions && pwd
RUN cd /var/www/hrm/storage/framework/sessions && touch 137qOxgq3nOQ25m9vNSPU71V4xLBz0wHnKQ5QsW6
#RUN touch /var/www/hrm/storage/framework/sessions/137qOxgq3nOQ25m9vNSPU71V4xLBz0wHnKQ5QsW6
RUN chown -R www-data.www-data /var/www/hrm && mv .htaccess hrm/
RUN chmod -R 755 /var/www/hrm
RUN chmod -R 777 /var/www/hrm/storage/*
RUN chmod -R 777 /var/www/hrm/public/*
RUN cd /var/www/hrm && php artisan storage:link
#RUN docker-php-ext-install sockets
RUN apt-get update -y
#RUN apt-get install -y php-sockets
RUN docker-php-ext-install sockets
EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]
