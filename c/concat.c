#include <stdio.h>
#include <string.h>

int main()
{
    char str1[20] = "abc", str2[20] = "def", str3[20] = "ghi";
    int i, j;

    printf("str1 = %s | str2 = %s\n", str1, str2);

    for (i = 0; str1[i] != '\0'; i++);

    printf("str1 = %d\n", i);

    for (j = 0; str2[j] != '\0'; j++) str1[i+j] = str2[j];
    str1[i+j] = '\0';

    printf("str1 = %s\n", str1);

    strcat(str1, str3);

    printf("str1 = %s\n", str1);
}