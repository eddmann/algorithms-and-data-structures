
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

    public int getScore()
    {
        return board.hammingDistance() + moves;
    }

    public boolean isBoardGoal()
    {
        return board.isGoal();
    }

    public Iterable<Board> getBoardNeighbors()
    {
        return board.getNeighbors();
    }

    public int compareTo(Node that)
    {
        return this.getScore() - that.getScore();
    }

}