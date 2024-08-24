.PHONY: sail

sail:
	@./vendor/bin/sail $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
