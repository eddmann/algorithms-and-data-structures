/**
 * Queue, implemented using a linked-list (FIFO).
 */
public class QueueLinkedList<T> {

    /**
     * Total items stored in the queue.
     */
    private int total;

    /**
     * Reference to the first element in the queue.
     */
    private Node first;

    /**
     * Reference to the last element in the queue.
     */
    private Node last;

    /**
     * Element node class structure.
     */
    private class Node {
        private T ele;
        private Node next;
    }

    public QueueLinkedList()
    {
        // total defaults to 0
        // first, last default to null
    }

    /**
     * Enqueue an element onto the queue.
     *
     * @param  ele The new element.
     * @return     The queue instance, for chaining.
     */
    public QueueLinkedList<T> enqueue(T ele)
    {
        Node current = last;

        last = new Node();
        last.ele = ele;

        if (total == 0) {
            // if first on queue.
            first = last;
        } else {
            // set the next reference on the old last node.
            current.next = last;
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
        T ele = first.ele;
        first = first.next;

        total--;
        if (total == 0) {
            // clean-up, if now an empty queue.
            last = null;
        }

        return ele;
    }

    public static void main(String[] args)
    {
        QueueLinkedList<String> greeting = new QueueLinkedList<String>();

        greeting.enqueue("Hello").enqueue("World");

        System.out.println(greeting.dequeue() + ", " + greeting.dequeue() + "!");
    }

}