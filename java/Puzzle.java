import java.util.List;
import java.util.ArrayList;
import java.util.LinkedList;
import java.util.Collections;

public class Puzzle {

    /**
     * a b c
     * d e f
     * g h i
     * j k *
     */

    private static final int ROWS = 4, COLS = 3;

    private static List<String> getMoves(String subject)
    {
        List<String> moves = new LinkedList<>();

        int pos = subject.indexOf('*');
        int row = pos / COLS;
        int col = pos % COLS;

        // north
        if (row != 0) moves.add(swapChar(subject, pos, pos - COLS));
        // east
        if (col != COLS - 1) moves.add(swapChar(subject, pos, pos + 1));
        // south
        if (row != ROWS - 1) moves.add(swapChar(subject, pos, pos + COLS));
        // west
        if (col != 0) moves.add(swapChar(subject, pos, pos - 1));

        return moves;
    }

    private static String swapChar(String subject, int i, int j)
    {
        StringBuilder sb = new StringBuilder(subject);
        char tmp = sb.charAt(i);
        sb.setCharAt(i, sb.charAt(j));
        sb.setCharAt(j, tmp);
        return sb.toString();
    }

    public static List<String> solve(String puzzle, String goal)
    {
        for (int depth = 1; true; depth++) {
            LinkedList<String> root = new LinkedList<String>();
            root.add(puzzle);
            List<String> route = depthFirst(root, goal, depth);
            if (route != null) return route;
        }
    }

    private static List<String> depthFirst(LinkedList<String> route, String goal, int depth)
    {
        if (depth == 0) return null;

        String last = route.getLast();

        if (last.equals(goal)) return route;

        for (String move : getMoves(last)) {
            if ( ! route.contains(move)) {
                LinkedList<String> nextRoute = (LinkedList<String>) route.clone();
                nextRoute.add(move);
                List<String> fullRoute = depthFirst(nextRoute, goal, depth - 1);
                if (fullRoute != null) return fullRoute;
            }
        }

        return null;
    }

    private static String[] createPuzzle(int steps)
    {
        String puzzle = "", goal = "abcdefghijk*";

        for (int step = 0; step < steps; step++) {
            List<String> moves = getMoves(goal);
            Collections.shuffle(moves);
            if (step == steps / 2) puzzle = moves.get(0);
            goal = moves.get(0);
        }

        return new String[] { puzzle, goal };
    }

    public static void main(String[] args)
    {
        ArrayList<String[]> puzzles = new ArrayList<String[]>(10);
        for (int i = 0; i < 10; i++) {
            puzzles.add(createPuzzle(50));
        }

        for (String[] puzzle : puzzles) {
            List<String> solution = solve(puzzle[0], puzzle[1]);
            System.out.println(solution.size());
        }
    }

}