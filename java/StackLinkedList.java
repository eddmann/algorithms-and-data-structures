public class StackLinkedList<T> {

    private int total;

    private Node first;

    private class Node {
        private T ele;
        private Node next;
    }

    public StackLinkedList()
    {
    }

    public StackLinkedList<T> push(T ele)
    {
        Node current = first;
        first = new Node();
        first.ele = ele;
        first.next = current;
        total++;
        return this;
    }

    public T pop()
    {
        T ele = first.ele;
        first = first.next;
        total--;
        return ele;
    }

    public static void main(String[] args)
    {
        StackLinkedList<Integer> numbers = new StackLinkedList<Integer>();

        numbers.push(1).push(2);

        System.out.println(numbers.pop() + numbers.pop());
    }

}
