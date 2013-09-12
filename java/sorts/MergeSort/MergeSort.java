import java.util.Arrays;

/**
 * Merge Sort implementation, using natural ordering.
 *
 * Worst Case: O(n log n)
 */
public class MergeSort {

    /**
     * Merge routine.
     *
     * @param  arr Array to sort.
     * @param  tmp Auxiliary array.
     * @param  l   Low index bounds.
     * @param  m   Middle index bounds.
     * @param  h   High index bounds.
     * @return     void
     */
    private static void merge(Comparable[] arr, Comparable[] tmp, int l, int m, int h)
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

    /**
     * Sort routine, with temporary array supplied.
     *
     * @param  arr Array to sort.
     * @param  tmp Auxiliary array.
     * @param  l   Low index bounds.
     * @param  h   High index bounds.
     * @return     void
     */
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

    /**
     * Sort routine.
     *
     * @param  arr Array to sort.
     * @return     void
     */
    public static void sort(Comparable[] arr)
    {
        Comparable[] tmp = new Comparable[arr.length];
        sort(arr, tmp, 0, arr.length - 1);
    }

    public static void main(String[] args)
    {
        String[] alpha = new String[] { "b", "a", "d", "c" };

        System.out.println("Before: " + Arrays.toString(alpha));

        sort(alpha);

        System.out.println("After: " + Arrays.toString(alpha));
    }

}