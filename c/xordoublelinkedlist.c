#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <stdbool.h>

// http://www.geeksforgeeks.org/xor-linked-list-a-memory-efficient-doubly-linked-list-set-2/
// http://stackoverflow.com/questions/612328/difference-between-struct-and-typedef-struct-in-c

typedef struct node {
    int item;
    struct node *np;
} node;

node *head, *tail;

node* xor(node* a, node *b)
{
    return (node*) ((uintptr_t) a ^ (uintptr_t) b);
}

void insert(int item, bool at_tail)
{
    node *ptr = (node*) malloc(sizeof(node));
    ptr->item = item;

    if (NULL == head) {
        ptr->np = NULL;
        head = tail = ptr;
    } else if (at_tail) {
        ptr->np = xor(tail, NULL);
        tail->np = xor(ptr, xor(tail->np, NULL));
        tail = ptr;
    } else {
        ptr->np = xor(NULL, head);
        head->np = xor(ptr, xor(NULL, head->np));
        head = ptr;
    }
}

void list()
{
    node *curr = head;
    node *prev, *next;
    prev = next = NULL;

    while (NULL != curr) {
        printf("%d ", curr->item);
        next = xor(prev, curr->np);
        prev = curr;
        curr = next;
    }

    printf("\n");
}

int main()
{
    for (int i = 1; i <= 10; i++)
        insert(i, i < 6);

    list();
}