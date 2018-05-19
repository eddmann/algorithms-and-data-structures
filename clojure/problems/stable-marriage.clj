(defn remove-matched [xs matches]
  (apply dissoc xs (vals matches)))

(defn drop-first-pref [prefs]
  (reduce-kv #(assoc %1 %2 (rest %3)) {} prefs))

(defn better-match? [y-prefs prev-x x]
  (or (nil? prev-x) (< (.indexOf y-prefs x) (.indexOf y-prefs prev-x))))

(defn make-proposal [ys matches x x-prefs]
  (let [ideal-y (first x-prefs)
        y-prefs (ys ideal-y)
        prev-x (matches ideal-y)]
    (if (better-match? y-prefs prev-x x)
      (assoc matches ideal-y x)
      matches)))

(defn match
  ([xs ys] (match xs ys {}))
  ([xs ys matches]
    (if (= (count matches) (count ys))
      matches
      (let [available-xs (remove-matched xs matches)]
        (recur (merge xs (drop-first-pref available-xs))
               ys
               (reduce-kv (partial make-proposal ys) matches available-xs))))))

(def women {:abi  [:bob :fred :jon :gav :ian :abe :dan :ed :col :hal]
            :bea  [:bob :abe :col :fred :gav :dan :ian :ed :jon :hal]
            :cath [:fred :bob :ed :gav :hal :col :ian :abe :dan :jon]
            :dee  [:fred :jon :col :abe :ian :hal :gav :dan :bob :ed]
            :eve  [:jon :hal :fred :dan :abe :gav :col :ed :ian :bob]
            :fay  [:bob :abe :ed :ian :jon :dan :fred :gav :col :hal]
            :gay  [:jon :gav :hal :fred :bob :abe :col :ed :dan :ian]
            :hope [:gav :jon :bob :abe :ian :dan :hal :ed :col :fred]
            :ivy  [:ian :col :hal :gav :fred :bob :abe :ed :jon :dan]
            :jan  [:ed :hal :gav :abe :bob :jon :col :ian :fred :dan]})

(def men {:abe  [:abi :eve :cath :ivy :jan :dee :fay :bea :hope :gay]
          :bob  [:cath :hope :abi :dee :eve :fay :bea :jan :ivy :gay]
          :col  [:hope :eve :abi :dee :bea :fay :ivy :gay :cath :jan]
          :dan  [:ivy :fay :dee :gay :hope :eve :jan :bea :cath :abi]
          :ed   [:jan :dee :bea :cath :fay :eve :abi :ivy :hope :gay]
          :fred [:bea :abi :dee :gay :eve :ivy :cath :jan :hope :fay]
          :gav  [:gay :eve :ivy :bea :cath :abi :dee :hope :jan :fay]
          :hal  [:abi :eve :hope :fay :ivy :cath :jan :bea :gay :dee]
          :ian  [:hope :cath :dee :gay :bea :abi :fay :ivy :jan :eve]
          :jon  [:abi :fay :jan :gay :eve :bea :dee :cath :ivy :hope]})

(println (match men women))
