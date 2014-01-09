all: vector

vector: main.o vector.o
	gcc main.o vector.o -o vector
	rm -rf *o

main.o: main.c vector.h
	gcc -c main.c

vector.o: vector.c vector.h
	gcc -c vector.c

clean:
	rm -rf *o vector