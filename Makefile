.PHONY: build
build:
	docker-compose up -d --build

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: console
console:
	docker exec -it tt_php bash