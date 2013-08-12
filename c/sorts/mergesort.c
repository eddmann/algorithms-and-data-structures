#include <stdio.h>
#include <stdlib.h> // malloc
#include <string.h> // memcpy
#include <time.h>

#define RANGE 100
#define SIZE 10

int merge(int *a, int a_len, int *b, int b_len, int *out)
{
    int i, j, k;
    i = j = k = 0;

    while (i < a_len && j < b_len) {
        out[k++] = (a[i] < b[j])
            ? a[i++]
            : b[j++];
    }

    while (i < a_len) out[k++] = a[i++];
    while (j < b_len) out[k++] = b[j++];
}

void sort(int *arr, int *tmp, int len)
{
    if (len <= 1) return;

    int mid = len / 2;

    sort(tmp, arr, mid);
    sort(tmp + mid, arr + mid, len - mid);

    merge(tmp, mid, tmp + mid, len - mid, arr);
}

void merge_sort(int *arr, int len)
{
    int *tmp = malloc(sizeof(int) * len);
    memcpy(tmp, arr, sizeof(int) * len);

    sort(arr, tmp, len);

    free(tmp);
}

int sorted(int *buf, int len)
{
    int i;
    for (i = 1; i < len; i++) {
        if (buf[i - 1] > buf[i]) return 0;
    }

    return 1;
}

int main()
{
    srand(time(NULL));

    int i, x[SIZE];

    for (i = 0; i < SIZE; i++) {
        x[i] = rand() % RANGE + 1; // 1 to RANGE
    }

    printf("Before: ");
    for (i = 0; i < SIZE; i++) printf("%d ", x[i]);
    putchar('\n');

    merge_sort(x, SIZE);

    printf("After: ");
    for (i = 0; i < SIZE; i++) printf("%d ", x[i]);
    putchar('\n');

    printf("Sorted: %s\n", sorted(x, SIZE) ? "Yes" : "No");

    return 0;
}