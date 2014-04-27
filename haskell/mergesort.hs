merge :: Ord a => [a] -> [a] -> [a]
merge [] xs = xs
merge ys [] = ys
merge xs@(x:xt) ys@(y:yt) | x <= y = x : xt `merge` ys
                          | otherwise = y : xs `merge` yt

merge' :: (a -> a -> Bool) -> [a] -> [a] -> [a]
merge' _ xs [] = xs
merge' _ [] ys = ys
merge' p xs@(x:xt) ys@(y:yt) | p x y = x : merge' p xt ys
                             | otherwise = y : merge' p xs yt

split :: [a] -> ([a], [a])
split xs = splitAt (length xs `quot` 2) xs

-- split (x:y:zs) = let (xs, ys) = split zs in (x:xs, y:ys)
-- split [x] = ([x], [])
-- split [] = ([], [])

-- split xs = go xs xs where
--     go (x:xs) (_:_:zs) = (x:us,vs) where (us,vs) = go xs zs
--     go xs _ = ([], xs)

sort :: Ord a => [a] -> [a]
sort [] = []
sort [x] = [x]
sort xs = let (lft, rgt) = split xs
          in sort lft `merge` sort rgt

sort' :: (a -> a -> Bool) -> [a] -> [a]
sort' _ [] = []
sort' _ [x] = [x]
sort' p xs = let (lft, rgt) = split xs
             in merge' p (sort' p lft) (sort' p rgt)

main = do
    print $ sort ls
    print $ sort' (<=) ls
    where ls = [ 4, 3, 2, 1 ]