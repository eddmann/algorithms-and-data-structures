public class MergeSortBottomUp {

    private static void merge(Comparable[] arr, Comparable[] tmp, int l, int m, int h)
    {
        // copy current order into temp array.
        for (int i = l; i <= h; i++) {
            tmp[i] = arr[i];
        }

        int i = l, j = m + 1;
        for (int k = l; k <= h; k++) {
            if (i > m) {
                arr[k] = tmp[j++];
            } else if (j > h) {
                arr[k] = tmp[i++];
            } else if (tmp[j].compareTo(tmp[i]) < 0) {
                arr[k] = tmp[j++];
            } else {
                arr[k] = tmp[i++];
            }
        }
    }

    public static void sort(Comparable[] arr)
    {
        int total = arr.length;
        Comparable[] tmp = new Comparable[total];

        for (int i = 1; i < total; i = i * 2) {
            for (int j = 0; j < total - i; j += i * 2) {
                int l = j;
                int m = j + i - 1;
                int h = Math.min(j + i * 2 - 1, total - 1);
                System.out.printf("Merge: %d, %d, %d\n", l, m, h);
                merge(arr, tmp, l, m, h);
            }
        }
    }

    public static void main(String[] args)
    {
        String[] alphabet = new String[] { "d", "c", "a", "b" };

        System.out.print("Before: ");
        for (String a : alphabet) System.out.print(a + " ");
        System.out.println();

        sort(alphabet);

        System.out.print("After: ");
        for (String a : alphabet) System.out.print(a + " ");
        System.out.println();
    }

}