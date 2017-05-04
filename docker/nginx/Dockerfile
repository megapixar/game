FROM nginx:latest

ADD nginx.conf /etc/nginx/
ADD symfony.conf /etc/nginx/conf.d/

CMD adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443