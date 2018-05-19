(defn selections [col num]
  (letfn [(product [col]
            (if (empty? col)
              '(())
              (for [head (first col)
                    tail (product (rest col))]
                (cons head tail))))]
    (product (take num (repeat col)))))

(println (selections '(a b c) 2))
