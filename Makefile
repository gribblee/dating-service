# -----------------------------
# CONFIG
# -----------------------------
DC = docker compose -f docker-compose.dev.yml
PHP = php

# -----------------------------
# HELP
# -----------------------------
.PHONY: help
help:
	@echo ""
	@echo "Available commands:"
	@echo "  make up          - start dev environment"
	@echo "  make down        - stop dev environment"
	@echo "  make restart     - restart dev environment"
	@echo "  make sh          - shell into php-fpm container"
	@echo "  make psalm       - run psalm"
	@echo "  make cs          - run php-cs-fixer"
	@echo "  make cs-check    - check coding style (dry-run)"
	@echo ""

# -----------------------------
# DOCKER
# -----------------------------
.PHONY: up
up:
	$(DC) up -d

up-build:
	$(DC) up -d --build

.PHONY: down
down:
	$(DC) down

.PHONY: restart
restart:
	$(DC) down
	$(DC) up -d --build

# -----------------------------
# PHP CONTAINER
# -----------------------------
.PHONY: sh
sh:
	$(DC) exec $(PHP) sh

# -----------------------------
# QA TOOLS
# -----------------------------
.PHONY: psalm
psalm:
	$(DC) exec $(PHP) psalm

.PHONY: cs
cs:
	$(DC) exec $(PHP) php-cs-fixer fix

.PHONY: cs-check
cs-check:
	$(DC) exec $(PHP) php-cs-fixer fix --dry-run --diff

.PHONY: test
test:
	$(DC) exec $(PHP) php bin/phpunit --colors=always --testdox

.PHONY: coverage
coverage:
	$(DC) exec $(PHP) sh -c "XDEBUG_MODE=coverage php bin/phpunit --coverage-text"

.PHONY: coverage-html
coverage-html:
	$(DC) exec $(PHP) sh -c "XDEBUG_MODE=coverage php bin/phpunit --coverage-html=var/coverage/html"

.PHONY: clean
clean:
	$(DC) down --remove-orphans
	docker rm -f grafana promtail loki 2>/dev/null || true
