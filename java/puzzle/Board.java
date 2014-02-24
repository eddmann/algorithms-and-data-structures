import java.util.LinkedList;

class Board {

    private final int size;

    private final int[][] board;

    public Board(int[][] board)
    {
        this.size = board.length;
        this.board = clone2dArray(board);
    }

    // hamming distance - number of tiles out of place
    public int hamming()
    {
        int score = 0;

        for (int i = 0; i < size; i++) {
            for (int j = 0; j < size; j++) {
                if (board[i][j] != 0 && board[i][j] != i*size + j+1) {
                    score++;
                }
            }
        }

        return score;
    }

    // manhattan distance - sum of the minimum number of steps to move each tile in its correct location
    public int manhattan()
    {
        int score = 0;

        int row, col;
        for (int i = 0; i < size; i++) {
            for (int j = 0; j < size; j++) {
                if (board[i][j] != 0) {
                    row = (board[i][j] - 1) / size;
                    col = (board[i][j] - 1) % size;
                    score += Math.abs(row - i) + Math.abs(col - j);
                }
            }
        }

        return score;
    }

    public boolean isGoal()
    {
        for (int i = 0; i < size; i++) {
            for (int j = 0; j < size; j++) {
                if (board[i][j] != 0) {
                    if (board[i][j] != i*size + j + 1) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public Iterable<Board> neighbors()
    {
        LinkedList<Board> boards = new LinkedList<Board>();

        // locate empty slot
        int row = 0, col = 0;
        for (int i = 0; i < size; i++) {
            for (int j = 0; j < size; j++) {
                if (board[i][j] == 0) {
                    row = i;
                    col = j;
                }
            }
        }

        // north
        if (row != 0) {
            int[][] north = clone2dArray(board);

            north[row][col] = north[row-1][col];
            north[row-1][col] = 0;

            boards.addFirst(new Board(north));
        }

        // east
        if (col != size - 1) {
            int[][] east = clone2dArray(board);

            east[row][col] = east[row][col+1];
            east[row][col+1] = 0;

            boards.addFirst(new Board(east));
        }

        // south
        if (row != size - 1) {
            int[][] south = clone2dArray(board);

            south[row][col] = south[row+1][col];
            south[row+1][col] = 0;

            boards.addFirst(new Board(south));
        }

        // west
        if (col != 0) {
            int[][] west = clone2dArray(board);

            west[row][col] = west[row][col-1];
            west[row][col-1] = 0;

            boards.addFirst(new Board(west));
        }

        return boards;
    }

    public boolean equals(Board that)
    {
        if (that == this) return true;

        if (that == null) return false;

        if (this.size == that.size) {
            for (int i = 0; i < size; i++) {
                for (int j = 0; j < size; j++) {
                    if (this.board[i][j] != that.board[i][j]) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }

    public String toString()
    {
        StringBuilder sb = new StringBuilder();

        for (int i = 0; i < size; i++) {
            for (int j = 0; j < size; j++) {
                sb.append(String.format("%2d", board[i][j]));
            }
            sb.append("\n");
        }

        return sb.toString();
    }

    private static int[][] clone2dArray(int[][] src)
    {
        int[][] dst = new int[src.length][src[0].length];

        for (int i = 0; i < src.length; i++) {
            System.arraycopy(src[i], 0, dst[i], 0, src[i].length);
        }

        return dst;
    }

}