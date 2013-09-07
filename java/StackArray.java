/**
 * Stack, implemented using a resizing array.
 */
public class StackArray<T> {

    /**
     * Internally used array for storage.
     */
    private T[] arr;

    /**
     * Total items stored in internal array.
     */
    private int total;

    /**
     * Initialize the internal array.
     */
    public StackArray()
    {
        arr = (T[]) new Object[2];
    }

    public boolean isEmpty()
    {
        return total == 0;
    }

    /**
     * Resize the internal array.
     *
     * @param capacity New array size.
     */
    private void resize(int capacity)
    {
        T[] tmp = (T[]) new Object[capacity];

        for (int i = 0; i < total; i++) {
            tmp[i] = arr[i];
        }

        arr = tmp;
    }

    /**
     * Push an element onto the stack.
     *
     * @param  ele The new element.
     * @return     The stack instance, for chaining.
     */
    public StackArray<T> push(T ele)
    {
        if (arr.length == total) {
            // double the array size, if hit total.
            resize(arr.length * 2);
        }

        arr[total++] = ele;

        return this;
    }

    /**
     * Pop an element of the stack.
     *
     * @return The popped element.
     */
    public T pop()
    {
        T ele = arr[total - 1];
        arr[total - 1] = null;
        total--;

        if (total > 0 && total == arr.length / 4) {
            // half the internal array, if one quarter full.
            resize(arr.length / 2);
        }

        return ele;
    }

    public static void main(String[] args)
    {
        StackArray<String> greeting = new StackArray<String>();

        greeting.push("World").push("Hello");

        System.out.println(greeting.pop() + ", " + greeting.pop() + "!");
    }

}