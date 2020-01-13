TS := $(shell /bin/date "+%Y-%m-%d--%H-%M-%S")
UTIL := @docker-compose -f docker-compose.yml -f docker-compose.util.yml run --rm

composer:
	@docker-compose exec app /usr/local/bin/composer ${S} ${C}

setup:
	@make composer S=all C=install
	@make migrations S=all C=migrate

migrations:
	@docker-compose exec app /usr/local/bin/migrations ${S} ${C}

create-service:
	@docker-compose exec app /usr/local/bin/add-service ${S}

restart:
	@docker-compose stop ${S}-service
	@docker-compose up -d ${S}-service
