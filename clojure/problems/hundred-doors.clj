(defn- toggle-door [doors door]
  (update-in doors [door] not))

(defn- door-visits [num]
  (for [pass (range 1 (inc num))
        door (range (dec pass) num pass)] door))

(defn- toggle-doors [num]
  (reduce toggle-door (vec (repeat num false)) (door-visits num)))

(defn open-doors [num]
  (filter some? (map-indexed #(if %2 (inc %1)) (toggle-doors num))))

(println (open-doors 100))
