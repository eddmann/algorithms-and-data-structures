
def dfs_rec(graph, start, visited=None):
    if visited is None:
        visited = set()
    visited.add(start)
    for next in graph[start] - visited:
        # ignore visited assignment
        dfs_rec(graph, next, visited)
    return visited

def dfs_iter(graph, start):
    visited, stack = set(), [start]
    while stack:
        vertex = stack.pop()
        if vertex not in visited:
            visited.add(vertex)
            stack.extend([ next for next in graph[vertex] if next not in visited ])
    return visited

def bfs_iter(graph, start):
    visited, queue = set(), [start]
    while queue:
        vertex = queue.pop(0)
        if vertex not in visited:
            visited.add(vertex)
            queue.extend([ next for next in graph[vertex] if next not in visited ])
    return visited

def dfs_path_rec(graph, start, goal, path=None):
    if path is None:
        path = [start]
    if start == goal:
        return path
    for next in graph[start] - set(path):
        next_path = dfs_path_rec(graph, next, goal, path + [next])
        if next_path:
            return next_path
    return []

def dfs_path_iter(graph, start, goal):
    stack = [(start, [start])]
    while stack:
        (vertex, path) = stack.pop()
        for next in graph[vertex] - set(path):
            if next == goal:
                return path + [next]
            else:
                stack.append((next, path + [next]))
    return []

def bfs_path_iter(graph, start, goal):
    queue = [(start, [start])]
    while queue:
        (vertex, path) = queue.pop(0)
        for next in graph[vertex] - set(path):
            if next == goal:
                return path + [next]
            else:
                queue.append((next, path + [next]))
    return []

def dfs_paths_iter(graph, start, goal):
    stack = [(start, [start])]
    while stack:
        (vertex, path) = stack.pop()
        for next in graph[vertex] - set(path):
            if next == goal:
                yield path + [next]
            else:
                stack.append((next, path + [next]))
    return []

graph = {'A': set(['B', 'C']),
         'B': set(['A', 'C', 'D', 'E']),
         'C': set('D'),
         'D': set('C'),
         'E': set(['D', 'F']),
         'F': set()}

print(dfs_rec(graph, 'A'))

print(dfs_iter(graph, 'A'))

print(bfs_iter(graph, 'A'))

print(dfs_path_rec(graph, 'A', 'E'))

print(dfs_path_iter(graph, 'A', 'E'))

print(bfs_path_iter(graph, 'A', 'E'))

print(list(dfs_paths_iter(graph, 'A', 'C')))