FROM php:8.1-apache

# Copier tous les fichiers du dossier courant dans /var/www/html du conteneur
COPY . /var/www/html/

# Exposer le port 80 (HTTP)
EXPOSE 80
