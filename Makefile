# Пути
PHPUNIT := vendor/bin/phpunit
UNITS_DIR := src/tests/units

# Запуск всех unit-тестов
test-units-all:
	@echo "Running all unit tests..."
	$(PHPUNIT) $(UNITS_DIR)

# Запуск конкретного unit-теста
test-units:
ifndef MAKECMDGOALS
	$(error Please specify the test name: make test-units TelegramReportParserTest)
endif
	@echo "Running unit test $(word 2,$(MAKECMDGOALS))..."
	$(PHPUNIT) $(UNITS_DIR)/$(word 2,$(MAKECMDGOALS)).php --verbose --color
