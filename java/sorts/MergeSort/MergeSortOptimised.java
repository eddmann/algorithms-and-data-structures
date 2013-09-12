import java.util.Arrays;

/**
 * Merge Sort implementation, including 'ordered skip' and 'merge copy skip' optimisations.
 *
 * Worst Case: O(n log n)
 */
public class MergeSortOptimised {

    /**
     * Merge routine.
     *
     * @param  src Source array.
     * @param  dst Destination array.
     * @param  l   Low index bounds.
     * @param  m   Middle index bounds.
     * @param  h   High index bounds.
     * @return     void
     */
    private static void merge(Comparable[] src, Comparable[] dst, int l, int m, int h)
    {
        int i = l, j = m + 1;
        for (int k = l; k <= h; k++) {
            if (i > m) {
                dst[k] = src[j++];
            } else if (j > h) {
                dst[k] = src[i++];
            } else if (src[j].compareTo(src[i]) < 0) {
                dst[k] = src[j++];
            } else {
                dst[k] = src[i++];
            }
        }
    }

    /**
     * Sort routine, with temporary array supplied.
     *
     * @param  src Source array.
     * @param  dst Destination array.
     * @param  l   Low index bounds.
     * @param  h   High index bounds.
     * @return     void
     */
    public static void sort(Comparable[] src, Comparable[] dst, int l, int h)
    {
        if (l >= h) {
            return;
        }

        int m = l + (h - l) / 2;

        // switch src, dst to skip merge copy step.
        sort(dst, src, l, m);
        sort(dst, src, m + 1, h);

        if (src[m].compareTo(src[m + 1]) < 0) {
            // already ordered.
            for (int i = l; i < h; i++) {
                dst[i] = src[i];
            }
        } else {
            merge(src, dst, l, m, h);
        }
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

        for (int i = 0; i < arr.length; i++) {
            tmp[i] = arr[i];
        }

        sort(tmp, arr, 0, arr.length - 1);
    }

    public static void main(String[] args)
    {
        String[] alpha = new String[] { "b", "a", "d", "c" };

        System.out.println("Before: " + Arrays.toString(alpha));

        sort(alpha);

        System.out.println("After: " + Arrays.toString(alpha));
    }

}