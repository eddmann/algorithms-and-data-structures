
class Node implements Comparable<Node> {

    private final Board board;

    private final int moves;

    private final Node parent;

    public Node(Board board, int moves, Node parent)
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
        return (board.hammingDistance() + moves) - (that.getBoard().hammingDistance() + that.getMoves());
    }

}