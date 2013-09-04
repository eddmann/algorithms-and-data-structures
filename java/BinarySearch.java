import java.util.Arrays;
import java.util.Random;

public class BinarySearch {

    public static int search(int key, int[] arr)
    {
        int l = 0;
        int h = arr.length - 1;

        while (l <= h) {
            int m = l + (h - l) / 2;

            if (key < arr[m]) {
                h = m - 1;
            } else if (key > arr[m]) {
                l = m + 1;
            } else {
                return m;
            }
        }

        return -1;
    }

    public static void main(String[] args)
    {
        int[] arr = new int[10];

        Random random = new Random();
        for (int i = 0; i < arr.length; i++) {
            arr[i] = random.nextInt(20) + 1; // 1..20
        }

        Arrays.sort(arr);

        for (int ele : arr) System.out.print(ele + " ");
        System.out.println();

        int num = (args.length > 1)
            ? Integer.parseInt(args[1])
            : arr[arr.length / 2]; // middle element

        boolean exists = search(num, arr) != -1;

        System.out.println("Contains the value " + num + ": " + ((exists) ? "Yes" : "No"));
    }

}