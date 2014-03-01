import copy, random

class Board:

    def __init__(self, matrix=[]):
        self._matrix = copy.deepcopy(matrix)
        self._rows = len(self._matrix)
        self._cols = len(self._matrix[0])
        self._score = 0
        self._depth = 0
        self._parent = None

    def __eq__(self, that):
        if self.__class__ == that.__class__:
            return self._matrix == that._matrix
        return False

    def __str__(self):
        return '\n'.join([' '.join(map(str, row)) for row in self._matrix]) + '\n'

    def clone(self):
        return Board(self._matrix)

    def shuffle(self, steps):
        for i in range(steps):
            board = random.choice(self.get_neighbours())
            self._matrix = board._matrix
        self._score = 0
        self._depth = 0
        self._parent = None

    def find(self, value):
        for row in range(self._rows):
            for col in range(self._cols):
                if self._matrix[row][col] == value:
                    return row, col

    def get_neighbours(self):
        neighbours = []
        zero = self.find(0)
        row, col = zero

        def create_board(row, col):
            b = self.clone()
            b.swap(zero, (row, col))
            b._depth = self._depth + 1
            b._parent = self
            return b

        # north
        if row > 0:
            neighbours.append(create_board(row - 1, col))
        # east
        if col < self._cols - 1:
            neighbours.append(create_board(row, col + 1))
        # south
        if row < self._rows - 1:
            neighbours.append(create_board(row + 1, col))
        # west
        if col > 0:
            neighbours.append(create_board(row, col - 1))

        return neighbours

    def _get(self, row, col):
        return self._matrix[row][col]

    def _set(self, row, col, value):
        self._matrix[row][col] = value

    def swap(self, a, b):
        tmp = self._get(*a)
        self._set(*a, value=self._get(*b))
        self._set(*b, value=tmp)

def solve(puzzle, goal, heuristic):
    def index(item, seq):
        return seq.index(item) if item in seq else -1

    openl = [puzzle]
    closedl = []
    moves = 0

    while len(openl) > 0:
        node = openl.pop(0)

        if node._matrix == goal:
            return node, moves

        moves += 1
        neighbours = node.get_neighbours()
        idx_open = idx_closed = -1

        for board in neighbours:
            idx_open = index(board, openl)
            idx_closed = index(board, closedl)
            score = heuristic(board)
            value = score + board._depth

            if idx_open < 0 and idx_closed < 0:
                board._score = score
                openl.append(board)
            elif idx_open > -1:
                copy = openl[idx_open]
                if value < copy._score + copy._depth:
                    copy._score = score
                    copy._parent = board._parent
                    copy._depth = board._depth
            elif idx_closed > -1:
                copy = closedl[idx_closed]
                if value < copy._score + copy._depth:
                    board._score = score
                    closedl.remove(board)
                    openl.append(board)

        closedl.append(node)
        openl = sorted(openl, key=lambda b: b._score + b._depth)

    return [], 0

goal = [[1, 2, 3],
        [4, 5, 6],
        [7, 8, 0]]

def hamming(puzzle):
    score = 0
    for row in range(puzzle._rows):
        for col in range(puzzle._cols):
            if puzzle._get(row, col) != 0 and puzzle._get(row, col) != row*3 + col+1:
                score += 1
    return score

def main():
    puzzle = Board(goal)
    puzzle.shuffle(20)
    print(puzzle)
    print(solve(puzzle, goal, hamming))

if __name__ == '__main__':
    main()