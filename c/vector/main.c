#include <stdio.h>
#include <stdlib.h>

#include "vector.h"

/*
int main(void)
{
    int i;

    vector v;
    vector_init(&v);

    vector_add(&v, "Bonjour");
    vector_add(&v, "tout");
    vector_add(&v, "le");
    vector_add(&v, "monde");

    for (i = 0; i < vector_total(&v); i++)
        printf("%s ", (char *) vector_get(&v, i));
    printf("\n");

    vector_delete(&v, 3);
    vector_delete(&v, 2);
    vector_delete(&v, 1);

    vector_set(&v, 0, "Hello");
    vector_add(&v, "World");

    for (i = 0; i < vector_total(&v); i++)
        printf("%s ", (char *) vector_get(&v, i));
    printf("\n");

    vector_free(&v);
}
*/

int main(void)
{
    int i;

    VECTOR_INIT(v);

    VECTOR_ADD(v, "Bonjour");
    VECTOR_ADD(v, "tout");
    VECTOR_ADD(v, "le");
    VECTOR_ADD(v, "monde");

    for (i = 0; i < VECTOR_TOTAL(v); i++)
        printf("%s ", VECTOR_GET(v, char*, i));
    printf("\n");

    VECTOR_DELETE(v, 3);
    VECTOR_DELETE(v, 2);
    VECTOR_DELETE(v, 1);

    VECTOR_SET(v, 0, "Hello");
    VECTOR_ADD(v, "World");

    for (i = 0; i < VECTOR_TOTAL(v); i++)
        printf("%s ", VECTOR_GET(v, char*, i));
    printf("\n");

    VECTOR_FREE(v);
}
