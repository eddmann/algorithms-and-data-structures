/**
 * Queue, implemented using an internal array (FIFO);
 */
public class QueueArray<T>
{

    /**
     * Internal array storing the queue elements.
     */
    private T[] arr;

    /**
     * Total elements in queue.
     */
    private int total;

    /**
     * Index of the first element in queue.
     */
    private int first;

    /**
     * Index of the next element slot in queue.
     */
    private int next;

    /**
     * Initialize the internal array.
     */
    public QueueArray()
    {
        arr = (T[]) new Object[2];
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
            // allow wrap-around.
            tmp[i] = arr[(first + i) % arr.length];
        }

        arr = tmp;
        first = 0;
        next = total;
    }

    /**
     * Enqueue an element onto the queue.
     *
     * @param  ele The new element.
     * @return     The queue instance, for chaining.
     */
    public QueueArray enqueue(T ele)
    {
        if (arr.length == total) {
            // double the internal array, if full.
            resize(arr.length * 2);
        }

        arr[next++] = ele;
        if (next == arr.length) {
            // allow wrap-around.
            next = 0;
        }
        total++;

        return this;
    }

    /**
     * Dequeue an element from the queue.
     *
     * @return The dequeued element.
     */
    public T dequeue()
    {
        T ele = arr[first];
        arr[first] = null;
        total--;

        first++;
        if (first == arr.length) {
            // allow wrap-around.
            first = 0;
        }

        if (total > 0 && total == arr.length / 4) {
            // half the internal array, if one quarter full.
            resize(arr.length / 2);
        }

        return ele;
    }

    /**
     * Class string representation.
     *
     * @return Visual representation of the internal array.
     */
    @Override
    public String toString()
    {
        StringBuilder s = new StringBuilder();

        // first element index.
        for (int i = 0; i < arr.length; i++) {
            s.append(i == first ? " F" : "  ");
        }

        s.append("\n");

        for (int i = 0; i < arr.length; i++) {
            s.append(i > 0 ? "|" + i : " " + i);
        }

        s.append(" {" + total + "}\n");

        // next element index.
        for (int i = 0; i < arr.length; i++) {
            s.append(i == next ? " N" : "  ");
        }

        return s.toString();
    }

    public static void main(String[] args)
    {
        QueueArray<String> places = new QueueArray<String>();

        places.enqueue("London")
              .enqueue("Paris")
              .enqueue("Tokyo")
              .enqueue("Berlin");

        System.out.println(places);

        places.dequeue();
        places.dequeue();

        places.enqueue("New York");

        System.out.println(places);
    }

}