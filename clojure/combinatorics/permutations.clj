(defn permutations [col]
  (letfn [(remove-first [el col]
            (let [[before after] (split-with (partial not= el) col)]
              (concat before (rest after))))
          (permutate [col]
            (if (empty? col)
              '(())
              (for [head col
                    tail (permutate (remove-first head col))]
                (cons head tail))))]
    (distinct (permutate col))))

(println (permutations [1 2 3]))
(println (permutations [1 1 2]))
