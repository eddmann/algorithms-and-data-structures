sort :: Ord a => [a] -> [a]
sort [] = []
sort (x:xs) = sort [ y | y <- xs, y <= x ] ++ [ x ] ++ sort [ y | y <- xs, y > x ]

main = print $ sort [ 4, 3, 2, 1 ]