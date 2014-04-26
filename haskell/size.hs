size [] = 0
size (x:xs) = 1 + size xs

main = print $ size [ 1, 2, 3, 4 ]