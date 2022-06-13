.PHONY: init
init:
	cp .env.example .env \
	&& docker-compose build \
	&& docker-compose up -d \
	&& docker-compose exec app bash -c \
		" \
			chown www-data storage/ -R \
			&& composer install \
			&& php artisan key:generate \
			&& php artisan migrate:fresh \
            && php artisan db:seed \
            && php artisan storage:link
		"

.PHONY: reload-nginx
reload-nginx:
	docker-compose exec web service nginx reload
