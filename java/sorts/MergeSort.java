public class MergeSort {

    public static void merge(Comparable[] arr, Comparable[] tmp, int l, int m, int h)
    {
        // copy current order into temp array.
        for (int i = l; i <= h; i++) {
            tmp[i] = arr[i];
        }

        int i = l, j = m + 1;

        for (int k = l; k <= h; k++) {
            if (i > m) {
                // left complete.
                arr[k] = tmp[j++];
            } else if (j > h) {
                // right complete.
                arr[k] = tmp[i++];
            } else if (tmp[j].compareTo(tmp[i]) < 0) {
                // right < left.
                arr[k] = tmp[j++];
            } else {
                // left < right.
                arr[k] = tmp[i++];
            }
        }
    }

    public static void sort(Comparable[] arr, Comparable[] tmp, int l, int h)
    {
        // return if 0..1
        if (l >= h) {
            return;
        }

        int m = l + (h - l) / 2;

        sort(arr, tmp, l, m);     // left.
        sort(arr, tmp, m + 1, h); // right.

        merge(arr, tmp, l, m, h);
    }

    public static void sort(Comparable[] arr)
    {
        Comparable[] tmp = new Comparable[arr.length];
        sort(arr, tmp, 0, arr.length - 1);
    }

    public static void main(String[] args)
    {
        String[] alphabet = new String[] { "b", "a", "d", "c" };

        System.out.print("Before: ");
        for (String a : alphabet) System.out.print(a + " ");
        System.out.println();

        sort(alphabet);

        System.out.print("After: ");
        for (String a : alphabet) System.out.print(a + " ");
        System.out.println();
    }

}