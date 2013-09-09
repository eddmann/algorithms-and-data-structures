public class MergeSortOptimised {

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