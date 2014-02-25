import java.util.LinkedList;
import java.util.PriorityQueue;

class Solver {

    public static Node solve(Board initial)
    {
        PriorityQueue<Node> pq = new PriorityQueue<Node>();

        pq.add(new Node(initial, 0, null));

        Node solution = null;

        while (solution == null) {
            Node node = pq.poll();

            if (node.getBoard().isGoal()) {
                solution = node;
                break;
            }

            Iterable<Board> neighbors = node.getBoard().getNeighbors();

            for (Board board : neighbors) {
                if ((node.getParent() != null && ! board.equals(node.getParent().getBoard())) ||
                     node.getParent() == null)
                {
                    pq.add(new Node(board, node.getMoves() + 1, node));
                }
            }
        }

        return solution;
    }

    public static Iterable<Board> getSolutionMoves(Node solution)
    {
        LinkedList<Board> moves = new LinkedList<Board>();

        Node node = solution;

        moves.addFirst(node.getBoard());

        while (node.getParent() != null) {
            moves.push(node.getParent().getBoard());
            node = node.getParent();
        }

        return moves;
    }

    public static void main(String[] args)
    {
        Board initial = Board.getInstanceFromFile(args[0]);

        Node solution = Solver.solve(initial);

        System.out.println("Moves = " + solution.getMoves());

        for (Board move : Solver.getSolutionMoves(solution)) {
            System.out.println(move);
        }
    }

}