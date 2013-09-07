/**
 * Stack, implemented using a linked-list (LIFO).
 */
public class StackLinkedList<T> {

    /**
     * Total items stored in the stack.
     */
    private int total;

    /**
     * Reference to the first element in the stack.
     */
    private Node first;

    /**
     * Element node class structure.
     */
    private class Node {
        private T ele;
        private Node next;
    }

    public StackLinkedList()
    {
        // total defaults to 0
        // first defaults to null
    }

    /**
     * Push an element onto the stack.
     *
     * @param  ele The new element.
     * @return     The stack instance, for chaining.
     */
    public StackLinkedList<T> push(T ele)
    {
        Node current = first;

        first = new Node();
        first.ele = ele;
        first.next = current;

        total++;

        return this;
    }

    /**
     * Pop an element off the stack.
     *
     * @return The popped element.
     */
    public T pop()
    {
        T ele = first.ele;
        first = first.next;

        total--;

        return ele;
    }

    public static void main(String[] args)
    {
        StackLinkedList<String> greeting = new StackLinkedList<String>();

        greeting.push("World").push("Hello");

        System.out.println(greeting.pop() + ", " + greeting.pop() + "!");
    }

}