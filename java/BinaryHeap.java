import java.util.*;

public class BinaryHeap<T extends Comparable<T>> {

    private T[] arr;

    private int total;

    private boolean max;

    public BinaryHeap(int capacity, boolean isMax)
    {
        arr = (T[]) new Comparable[capacity];
        total = 0;
        max = isMax;
    }

    public BinaryHeap(boolean isMax) { this(1, isMax); }

    public BinaryHeap() { this(false); }

    private void resize(int capacity)
    {
        T[] tmp = (T[]) new Comparable[capacity];
        System.arraycopy(arr, 0, tmp, 0, total + 1);
        arr = tmp;
    }

    private void swap(int a, int b)
    {
        T tmp = arr[a];
        arr[a] = arr[b];
        arr[b] = tmp;
    }

    private boolean compare(int a, int b)
    {
        return (max)
            ? arr[a].compareTo(arr[b]) < 0
            : arr[a].compareTo(arr[b]) > 0;
    }

    public void add(T ele)
    {
        if (total == arr.length - 1) resize(arr.length * 2);
        arr[++total] = ele;
        up(total);
    }

    public T peek()
    {
        if (total == 0) throw new NoSuchElementException();
        return arr[1];
    }

    public T remove()
    {
        if (total == 0) throw new NoSuchElementException();
        swap(1, total);
        T ele = arr[total--];
        down(1);
        arr[total + 1] = null;
        if ((total > 0) && (total == (arr.length - 1) / 4)) resize(arr.length / 2);
        return ele;
    }

    private void up(int i)
    {
        while (i > 1 && compare(i / 2, i)) {
            swap(i, i / 2);
            i /= 2;
        }
    }

    private void down(int i)
    {
        while (i * 2 <= total) {
            int j = i * 2;
            if (j < total && compare(j, j + 1)) j++;
            if ( ! compare(i, j)) break;
            swap(i, j);
            i = j;
        }
    }

    public String toString()
    {
        return Arrays.toString(arr);
    }

    public static void main(final String[] args)
    {
        BinaryHeap<Integer> heap = new BinaryHeap<>(true);

        for (int i = 0; i < 10; i++)
            heap.add(i);

        System.out.println(heap);

        for (int i = 0; i < 10; i++)
            System.out.print(heap.remove() + " ");

        System.out.println();
    }

}