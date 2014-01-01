#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

// clear && gcc linkedlist.c -o linkedlist && ./linkedlist && rm ./linkedlist

struct node {
    int item;
    struct node *next;
} *head, *tail;

struct node* insert(int item, bool at_tail)
{
    struct node *ptr = (struct node*) malloc(sizeof(struct node));
    ptr->item = item;
    ptr->next = NULL;

    if (NULL == head) {
        head = tail = ptr;
    } else if (at_tail) {
        tail->next = ptr;
        tail = ptr;
    } else {
        ptr->next = head;
        head = ptr;
    }

    return ptr;
}

int delete(bool from_tail)
{
    if (NULL == head) {
        return -1;
    } else if (from_tail) {
        if (head == tail) return delete(false);
        struct node *ptr = head;
        while (ptr->next != tail) ptr = ptr->next;
        int item = ptr->next->item;
        tail = ptr;
        free(tail->next);
        tail->next = NULL;
        ptr = NULL;
        return item;
    } else {
        struct node *ptr = head;
        int item = ptr->item;
        head = ptr->next;
        if (NULL == head) tail = head;
        free(ptr);
        ptr = NULL;
        return item;
    }
}

void list()
{
    struct node *ptr = head;

    while (NULL != ptr) {
        printf("%d ", ptr->item);
        ptr = ptr->next;
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