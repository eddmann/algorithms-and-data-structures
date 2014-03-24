import java.util.Arrays;

public class MergeSortParallel<T extends Comparable<? super T>> {

    private T[] arr, tmp;

    public MergeSortParallel(T[] arr)
    {
        this.arr = arr;
        this.tmp = (T[]) new Comparable[arr.length];
    }

    public void sort()
    {
        Sort sort = new Sort(0, arr.length - 1);
        sort.start();
        try {
            sort.join();
        } catch (InterruptedException e) { }
    }

    private class Sort extends Thread {

        private int l, m, h;

        public Sort(int l, int h)
        {
            this.l = l;
            this.h = h;
        }

        public void run()
        {
            if (l >= h) return;

            m = l + (h - l) / 2;
            Sort lft = new Sort(l, m);
            Sort rgt = new Sort(m + 1, h);

            lft.start();
            rgt.start();
            try {
                lft.join();
                rgt.join();
            } catch (InterruptedException e) { return; }

            merge();
        }

        private void merge()
        {
            for (int i = l; i <= h; i++) {
                tmp[i] = arr[i];
            }

            int i = l, j = m + 1;
            for (int k = l; k <= h; k++) {
                if (i > m)                             arr[k] = tmp[j++]; // left complete
                else if (j > h)                        arr[k] = tmp[i++]; // right complete
                else if (tmp[j].compareTo(tmp[i]) < 0) arr[k] = tmp[j++]; // right < left
                else                                   arr[k] = tmp[i++]; // left < right
            }
        }

    }

    public static void main(String[] args)
    {
        Integer[] arr = { 10, 9, 8, 7, 6, 5, 4, 3, 2, 1 };

        MergeSortParallel<Integer> merge = new MergeSortParallel<>(arr);

        System.out.println("Before: " + Arrays.toString(arr));

        merge.sort();

        System.out.println("After: " + Arrays.toString(arr));
    }

}