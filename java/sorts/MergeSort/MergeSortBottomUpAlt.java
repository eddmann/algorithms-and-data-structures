import java.util.Arrays;

public class MergeSortBottomUpAlt {

    private static void merge(int[] arr, int l, int m, int h)
    {
        int[] lf = new int[m - l + 1];
        int[] rg = new int[h - m + 1];

        for (int i = 0, k = l; k < m; i++, k++) {
            lf[i] = arr[k]; // l..m-1
        }

        for (int i = 0, k = m; k < h; i++, k++) {
            rg[i] = arr[k]; // m..h-1
        }

        lf[lf.length - 1] = Integer.MAX_VALUE;
        rg[rg.length - 1] = Integer.MAX_VALUE;

        for (int i = l, j = 0, k = 0; i < h; i++) {
            if (lf[j] <= rg[k]) {
                arr[i] = lf[j++];
            } else {
                arr[i] = rg[k++];
            }
        }
    }

    public static void sort(int[] arr)
    {
        if (arr.length <= 1) {
            return;
        }

        int step = 1;
        int l, m;

        while (step < arr.length) {
            l = 0;
            m = step;

            while (m + step <= arr.length) {
                merge(arr, l, m, m + step);
                l = m + step;
                m = l + step;
            }

            if (m < arr.length) {
                merge(arr, l, m, arr.length);
            }

            step *= 2;
        }
    }

    public static void main(String[] args)
    {
        int[] N = new int[] { 5, 3, 2, 6 };

        System.out.println("Before: " + Arrays.toString(N));

        sort(N);

        System.out.println("After: " + Arrays.toString(N));
    }

}