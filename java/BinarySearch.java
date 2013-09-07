/**
 * Binary Search implementation.
 */
public class BinarySearch {

    /**
     * Locate the key's index in supplied array.
     *
     * @param  key The key to locate.
     * @param  arr The array to search.
     * @return     The key's index, -1 if unsuccessful.
     */
    public static int search(Comparable key, Comparable[] arr)
    {
        int l = 0;
        int h = arr.length - 1;

        while (l <= h) {
            int m = l + (h - l) / 2;

            if (key.compareTo(arr[m]) < 0) {
                h = m - 1;
            } else if (key.compareTo(arr[m]) > 0) {
                l = m + 1;
            } else {
                return m;
            }
        }

        return -1;
    }

    public static void main(String[] args)
    {
        String[] places = new String[] { "London", "Paris", "Tokyo" };

        System.out.println("Paris is a place: "  + (search("Paris", places) > -1 ? "Yes" : "No"));

        System.out.println("Cheese is a place: " + (search("Cheese", places) > -1 ? "Yes" : "No"));
    }

}