#include <stdio.h>

int inc(int i)
{
    return i + 1;
}

int dbl(int i)
{
    return i * 2;
}

int compose(int (*f)(int), int i)
{
    return (*f)((*f)(i));
}

int main()
{
    printf("%d", compose(dbl, 1));
}