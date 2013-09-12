import java.util.Arrays;
import java.util.Comparator;

public class Selection {

    public static void sort(Comparable[] arr)
    {
        int total = arr.length;

        for (int i = 0; i < total; i++) {
            int min = i;
            for (int j = i + 1; j < total; j++) {
                if (arr[j].compareTo(arr[min]) < 0) {
                    // find smallest value left in the array.
                    min = j;
                }
            }
            Comparable tmp = arr[i];
            arr[i] = arr[min];
            arr[min] = tmp;
        }
    }

    public static void sort(Comparable[] arr, Comparator com)
    {
        int total = arr.length;

        for (int i = 0; i < total; i++) {
            int min = i;
            for (int j = i + 1; j < total; j++) {
                if (com.compare(arr[j], arr[min]) < 0) {
                    min = j;
                }
            }
            Comparable tmp = arr[i];
            arr[i] = arr[min];
            arr[min] = tmp;
        }
    }

    public static void main(String[] args)
    {
        String[] alpha = new String[] { "x", "e", "o", "a" };

        System.out.println("Before: " + Arrays.toString(alpha));

        sort(alpha);

        System.out.println("After: "  + Arrays.toString(alpha));

        System.out.println("Before: " + Arrays.toString(alpha));

        sort(alpha, new Comparator() {
            // reverse order.
            public int compare(Object a, Object b) {
                return -( (String) a ).compareTo( (String) b );
            }
        });

        System.out.println("After: "  + Arrays.toString(alpha));
    }

}