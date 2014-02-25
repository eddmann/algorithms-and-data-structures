import java.util.LinkedList;
import java.util.Scanner;
import java.io.File;
import java.io.FileNotFoundException;

class Board {

    private final int rows, cols;

    private final int[][] board;

    public Board(int[][] board)
    {
        this.rows = board.length;
        this.cols = board[0].length;
        this.board = cloneArray(board);
    }

    public int hammingDistance()
    {
        int score = 0;

        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                if (board[r][c] != 0 && board[r][c] != r*rows + c+1) {
                    score++;
                }
            }
        }

        return score;
    }

    public int manhattanDistance()
    {
        int score = 0;

        int row, col;
        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                if (board[r][c] != 0) {
                    row = (board[r][c] - 1) / rows;
                    col = (board[r][c] - 1) % cols;
                    score += Math.abs(row - r) + Math.abs(col - c);
                }
            }
        }

        return score;
    }

    public boolean isGoal()
    {
        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                if (board[r][c] != 0 && board[r][c] != r*rows + c+1) {
                    return false;
                }
            }
        }

        return true;
    }

    public Iterable<Board> getNeighbors()
    {
        LinkedList<Board> neighbors = new LinkedList<Board>();

        // locate empty position
        int row = 0, col = 0;
        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                if (board[r][c] == 0) {
                    row = r;
                    col = c;
                }
            }
        }

        int[][] tmp;

        // north
        if (row != 0) {
            tmp = cloneArray(board);
            tmp[row][col] = tmp[row - 1][col];
            tmp[row - 1][col] = 0;
            neighbors.addFirst(new Board(tmp));
        }

        // east
        if (col != cols - 1) {
            tmp = cloneArray(board);
            tmp[row][col] = tmp[row][col + 1];
            tmp[row][col + 1] = 0;
            neighbors.addFirst(new Board(tmp));
        }

        // south
        if (row != rows - 1) {
            tmp = cloneArray(board);
            tmp[row][col] = tmp[row + 1][col];
            tmp[row + 1][col] = 0;
            neighbors.addFirst(new Board(tmp));
        }

        // west
        if (col != 0) {
            tmp = cloneArray(board);
            tmp[row][col] = tmp[row][col - 1];
            tmp[row][col - 1] = 0;
            neighbors.addFirst(new Board(tmp));
        }

        return neighbors;
    }

    public String toString()
    {
        StringBuilder sb = new StringBuilder();

        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                sb.append(String.format("%2d", board[r][c]));
            }
            sb.append("\n");
        }

        return sb.toString();
    }

    public boolean equals(Object other)
    {
        if (other == this) return true;

        if (other == null) return false;

        if (other.getClass() != this.getClass()) return false;

        Board that = (Board) other;

        if (this.rows != that.rows || this.cols != that.cols) return false;

        for (int r = 0; r < rows; r++) {
            for (int c = 0; c < cols; c++) {
                if (this.board[r][c] != that.board[r][c]) {
                    return false;
                }
            }
        }

        return true;
    }

    private static int[][] cloneArray(int[][] src)
    {
        int[][] dst = new int[src.length][src[0].length];

        for (int i = 0; i < src.length; i++) {
            System.arraycopy(src[i], 0, dst[i], 0, src[i].length);
        }

        return dst;
    }

    public static Board getInstanceFromFile(String filePath)
    {
        try {
            Scanner in = new Scanner(new File(filePath));

            int rows = in.nextInt();
            int cols = in.nextInt();
            int[][] board = new int[rows][cols];

            for (int r = 0; r < rows; r++) {
                for (int c = 0; c < cols; c++) {
                    board[r][c] = in.nextInt();
                }
            }

            return new Board(board);
        } catch (Exception exp) {
            return null;
        }
    }

}