/**
 * Insertion sort implementation, using natural ordering.
 *
 * Worst Case: O(n2) - quadratic
 */
public class Insertion {

    public static void sort(Comparable[] arr)
    {
        int total = arr.length;

        for (int i = 0; i < total; i++) {
            // move the element left until greater than element before.
            for (int j = i; j > 0 && arr[j].compareTo(arr[j - 1]) < 0; j--) {
                Comparable tmp = arr[j];
                arr[j] = arr[j - 1];
                arr[j - 1] = tmp;
            }
        }
    }

    public static void main(String[] args)
    {
        String[] alphabet = new String[] { "b", "c", "a", "e", "d" };

        for (String alpha : alphabet) {
            System.out.print(alpha + " ");
        }
        System.out.println();

        sort(alphabet);

        for (String alpha : alphabet) {
            System.out.print(alpha + " ");
        }
        System.out.println();
    }

}