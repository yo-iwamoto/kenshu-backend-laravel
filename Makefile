.PHONY: init
init:
	docker-compose exec app bash -c \
		" \
			chown www-data storage/ -R \
			&& composer install \
			&& php artisan key:generate \
			&& php artisan migrate:fresh \
		"

.PHONY: reload-nginx
reload-nginx:
	docker-compose exec web service nginx reload
