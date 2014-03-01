CC=gcc
CFLAGS=
RM=rm -rf
OUT=vector

all: build

build: main.o vector.o
    $(CC) $(CFLAGS) -o $(OUT) main.c vector.c
    $(RM) *.o

debug: CFLAGS+=-DDEBUG_ON
debug: build

main.o: main.c vector.h
    $(CC) $(CFLAGS) -c main.c

vector.o: vector.c vector.h
    $(CC) $(CFLAGS) -c vector.c

clean:
    $(RM) *.o $(OUT)