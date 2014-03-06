import itertools

def id_dfs(puzzle, goal, moves):
    def dfs(route, depth):
        if depth == 0:
            return
        if goal(route[-1]):
            return route
        for move in moves(route[-1]):
            if move not in route:
                next_route = dfs(route + [move], depth - 1)
                if next_route:
                    return next_route

    for depth in itertools.count(1):
        route = dfs([puzzle], depth)
        if route:
            return route

def num_matrix_goal(rows, cols):
    '''Checks for the goal matrix based on supplied row and col length.'''
    def matrix(subject):
        for row in range(rows):
            for col in range(cols):
                value = subject[row][col]
                if value != 0 and value != row*rows + col+1:
                    return False
        return True
    return matrix

def num_matrix_moves(subject):
    moves = []

    zrow, zcol = next((r, c)
        for r, l in enumerate(subject)
            for c, v in enumerate(l) if v == 0)

    def board(row, col):
        import copy
        b = copy.deepcopy(subject)
        b[zrow][zcol] = b[row][col]
        b[row][col] = 0
        return b

    # north
    if zrow != 0:
        moves.append(board(zrow - 1, zcol))
    # east
    if zcol < len(subject[0]) - 1:
        moves.append(board(zrow, zcol + 1))
    # south
    if zrow < len(subject) - 1:
        moves.append(board(zrow + 1, zcol))
    # west
    if zcol != 0:
        moves.append(board(zrow, zcol - 1))

    return moves

def num_matrix(puzzle, steps):
    import random
    for step in range(steps):
        puzzle = random.choice(num_matrix_moves(puzzle))
    return puzzle

puzzle = num_matrix([[1, 2, 3], [4, 5, 6], [7, 8, 0]], 25)

solution = id_dfs(puzzle, num_matrix_goal(3, 3), num_matrix_moves)

print(len(solution))