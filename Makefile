OUT = out.lex
SOURCE = example/main.c

all : main.php
	php main.php $(SOURCE) > $(OUT)

clean :
	rm $(OUT)

.PHONY :
	all clean
