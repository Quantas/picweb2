FROM nimmis/apache-php5
RUN rm /var/www/html/index.html
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/
COPY apache-site.conf /etc/apache2/sites-enabled/000-default.conf
COPY . /var/www/html/picweb2/
