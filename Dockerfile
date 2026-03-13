FROM php:8.2-apache

# Instalamos y habilitamos la extensión mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Deshabilitamos el listado de directorios (Index) y configuramos la página de inicio
RUN echo '<Directory /var/www/html/> \n\
    Options -Indexes \n\
    DirectoryIndex Pagina_login.html \n\
</Directory>' >> /etc/apache2/apache2.conf

# Reiniciamos Apache para aplicar cambios
RUN a2enmod rewrite
