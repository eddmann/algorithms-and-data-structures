public class Heap {

    private static Comparable[] arr;

    private static int total;

    private static void buildHeap(Comparable[] input)
    {
        arr = input;
        total = arr.length - 1;
        for (int i = total / 2; i >= 0; i--) {
            maxHeap(i);
        }
    }

    private static void maxHeap(int i)
    {
        int lft = i * 2;
        int rgt = lft + 1;
        int grt = i;

        if (lft <= total && arr[lft].compareTo(arr[grt]) > 0) grt = lft;
        if (rgt <= total && arr[rgt].compareTo(arr[grt]) > 0) grt = rgt;
        if (grt != i) {
            swap(i, grt);
            maxHeap(grt);
        }
    }

    private static void swap(int a, int b)
    {
        Comparable tmp = arr[a];
        arr[a] = arr[b];
        arr[b] = tmp;
    }

    public static void sort(Comparable[] input)
    {
        buildHeap(input);

        for (int i = total; i > 0; i--) {
            swap(0, i);
            total--;
            maxHeap(0);
        }
    }

    public static void main(final String[] args)
    {
        Integer[] arr = new Integer[] { 1, 4, 3, 2, 8 };
        sort(arr);
        System.out.println(java.util.Arrays.toString(arr));
    }

}