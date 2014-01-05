#include <stdio.h>

#define COUNT(arr) (sizeof(arr) / sizeof(arr[0]))

#define SWAP(arr, a, b) \
  do { \
    int tmp = arr[a]; \
    arr[a] = arr[b]; \
    arr[b] = tmp; \
  } while (0)

#define PRINT(arr, size) \
  do { \
    for (int i = 0; i < size; i++) printf("%d ", arr[i]); \
    printf("\n"); \
  } while (0)

int total;

void heapify(int arr[], int i)
{
    int lft = i * 2;
    int rgt = lft + 1;
    int grt = i;

    if (lft <= total && arr[lft] > arr[grt]) grt = lft;
    if (rgt <= total && arr[rgt] > arr[grt]) grt = rgt;
    if (grt != i) {
        SWAP(arr, i, grt);
        heapify(arr, grt);
    }
}

void sort(int arr[], int size)
{
    total = size - 1;

    for (int i = total / 2; i >= 0; i--)
        heapify(arr, i);

    for (int i = total; i > 0; i--) {
        SWAP(arr, 0, i);
        total--;
        heapify(arr, 0);
    }
}

int main(int argc, char *argv[])
{
    int arr[] = { 3, 2, 1, 5, 4 };
    int size = COUNT(arr);

    PRINT(arr, size);
    sort(arr, size);
    PRINT(arr, size);
}