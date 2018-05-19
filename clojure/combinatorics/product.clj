(defn product [col]
  (if (empty? col)
    '(())
    (for [head (first col)
          tail (product (rest col))]
      (cons head tail))))

(println (product '((a b) (1 2))))
