FROM nickistre/ubuntu-lamp

MAINTAINER kasihappy "2021201675@ruc.edu.cn"
RUN apt-get update && apt-get dist-upgrade -y

COPY src /var/www/html
RUN rm /var/www/html/index.html &&\
 chown www-data:www-data /var/www/html -R
COPY httpd-foreground /usr/bin
RUN chmod a+x /usr/bin/httpd-foreground

EXPOSE 80
CMD ["httpd-foreground"]
