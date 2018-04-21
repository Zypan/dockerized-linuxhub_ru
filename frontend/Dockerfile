FROM debian:9

# avoid debconf and initrd
ENV DEBIAN_FRONTEND noninteractive
ENV INITRD No

RUN apt-get update
RUN apt-get install -y apache2
RUN apt-get install -y php php-cli php-mysql php-xml

RUN rm -rf /var/www/html
ADD html /var/www/html
ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN chmod -R 777 /var/www/html
RUN chmod -R 777 /var/run/apache2/
RUN chmod -R 777 /var/log/apache2/

EXPOSE  80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
