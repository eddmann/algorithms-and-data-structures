import java.util.LinkedList;
import java.util.PriorityQueue;
import java.util.Scanner;
import java.io.File;
import java.io.FileNotFoundException;

class Solver {

    private PriorityQueue<Node> queue;

    private Node solution;

    public Solver(Board initial)
    {
        queue = new PriorityQueue<Node>();

        Node root = new Node(initial, 0, null);
        queue.add(root);

        while (solution == null) {
            Node node = queue.poll();

            if (node.getBoard().isGoal()) {
                solution = node;
                return;
            }

            Iterable<Board> neighbors = node.getBoard().neighbors();

            for (Board board : neighbors) {
                if (node.getParent() != null) {
                    if ( ! board.equals(node.getParent().getBoard())) {
                        queue.add(new Node(board, node.getMoves() + 1, node));
                    }
                } else {
                    queue.add(new Node(board, node.getMoves() + 1, node));
                }
            }
        }
    }

    public int getMoves()
    {
        return solution.getMoves();
    }

    public Iterable<Board> solution()
    {
        LinkedList<Board> result = new LinkedList<Board>();

        Node node = solution;

        Board board = node.getBoard();

        result.addFirst(board);

        while (node.getParent() != null) {
            result.push(node.getParent().getBoard());
            node = node.getParent();
        }

        return result;
    }

    public static void main(String[] args)
    {
        try {
            Scanner in = new Scanner(new File(args[0]));

            int size = in.nextInt();
            int[][] board = new int[size][size];
            for (int i = 0; i < size; i++) {
                for (int j = 0; j < size; j++) {
                    board[i][j] = in.nextInt();
                }
            }

            Board initial = new Board(board);
            Solver solver = new Solver(initial);

            System.out.println(solver.getMoves());

            for (Board b : solver.solution()) {
                System.out.println(b);
            }
        } catch (FileNotFoundException ex) {
            System.out.println("Invalid file!");
        }
    }

    private class Node implements Comparable<Node> {

        private Board board;

        private int moves;

        private Node parent;

        private Node(Board board, int moves, Node parent)
        {
            this.board = board;
            this.moves = moves;
            this.parent = parent;
        }

        public Board getBoard()
        {
            return board;
        }

        public Node getParent()
        {
            return parent;
        }

        public int getMoves()
        {
            return moves;
        }

        public int compareTo(Node that)
        {
            return (board.manhattan() + moves) - (that.getBoard().manhattan() + that.getMoves());
        }

    }

}