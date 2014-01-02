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

int delete(bool from_tail)
{
    if (NULL == head) {
        return -1;
    } else if (from_tail) {
        node *ptr = tail;
        int item = ptr->item;
        node *prev = xor(ptr->np, NULL);
        prev->np = xor(ptr, xor(prev->np, NULL));
        tail = prev;
        free(ptr);
        ptr = NULL;
        return item;
    } else {
        node *ptr = head;
        int item = ptr->item;
        node *next = xor(NULL, ptr->np);
        next->np = xor(ptr, xor(NULL, next->np));
        head = next;
        free(ptr);
        ptr = NULL;
        return item;
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

    list(); // 10 9 8 7 6 1 2 3 4 5

    for (int i = 1; i <= 4; i++)
        delete(i < 3);

    list(); // 8 7 6 1 2 3
}