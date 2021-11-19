include .env

.PHONY: up stop down clean dump

up:
	docker compose up -d

stop:
	docker compose stop

down:
	docker compose down -v

clean: down
	-rm -rf ./data/db/*
	rm -rf ./log/db/*
	rm -rf ./log/apache2/*
	rm -f $(MYSQL_DATABASE).sql

dump: up
	@docker compose exec database mysqldump --add-drop-table -u root --password=$(MYSQL_ROOT_PASSWORD) $(MYSQL_DATABASE) > $(MYSQL_DATABASE).sql
