(defn open-doors [num]
  (->>
    (iterate inc 1)
    (map #(* % %))
    (take-while #(<= % num))))

(println (open-doors 100))
