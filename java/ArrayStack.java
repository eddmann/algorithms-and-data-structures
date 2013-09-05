public class ArrayStack<T> {

    private T[] arr;

    private int total;

    public ArrayStack()
    {
        arr = (T[]) new Object[2];
    }

    public boolean isEmpty()
    {
        return total == 0;
    }

    private void resize(int capacity)
    {
        T[] tmp = (T[]) new Object[capacity];
    
        for (int i = 0; i < total; i++) {
            tmp[i] = arr[i];
        }
        
        arr = tmp;
    }

    public ArrayStack<T> push(T ele)
    {
        if (arr.length == total) {
            resize(2 * arr.length);
        }
        
        arr[total++] = ele;

        return this;
    }

    public T pop()
    {
       T ele = arr[total - 1];
       arr[total - 1] = null;
       total--;
       
       if (total > 0 && total == arr.length / 4) {
           resize(arr.length / 2);
       }
       
       return ele;
    }

    public static void main(String[] args)
    {
        ArrayStack<Integer> numbers = new ArrayStack<Integer>();

        numbers.push(1).push(2);

        System.out.println(numbers.pop() + numbers.pop());
    }

} 
