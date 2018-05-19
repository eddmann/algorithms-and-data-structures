(defn count-change [denominations amount]
  (letfn [(count-coins [den amt]
            (cond (zero? amt) 1
                  (neg? amt) 0
                  (empty? den) 0
                  :else (+ (count-coins (rest den) amt)
                           (count-coins den (- amt (first den))))))]
    (count-coins denominations amount)))

(println (count-change [1 5 10 25] 100))
