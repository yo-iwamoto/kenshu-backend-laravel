.PHONY: init
init:
	docker-compose exec web bash -c \
    " \
        chown www-data storage/ -R \
        && composer install \
        && php artisan key:generate \
        && php artisan migrate:fresh \
    "
