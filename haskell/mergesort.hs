merge :: Ord a => [a] -> [a] -> [a]
merge [] xs = xs
merge ys [] = ys
merge xs@(x:xt) ys@(y:yt) | x <= y = x : xt `merge` ys
                          | otherwise = y : xs `merge` yt

split :: [a] -> ([a], [a])
split xs = splitAt (length xs `quot` 2) xs

--split (x:y:zs) = let (xs, ys) = split zs in (x:xs, y:ys)
--split [x] = ([x], [])
--split [] = ([], [])

sort :: Ord a => [a] -> [a]
sort [] = []
sort [x] = [x]
sort xs = let (lft, rgt) = split xs
          in sort lft `merge` sort rgt

main = print $ sort [ 4, 3, 2, 1 ]