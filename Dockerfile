FROM nimmis/apache-php5
RUN rm /var/www/html/index.html
RUN a2enmod rewrite
COPY . /var/www/html/