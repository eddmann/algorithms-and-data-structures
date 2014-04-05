Array::partition = (fn) ->
    [xs, ys] = [[], []]
    for ele in @
        (if fn ele then xs else ys).push ele
    [xs, ys]

Array::qsort = () ->
    if @.length < 2 then return @
    head = @.shift()
    [low, high] = @.partition((_) -> _ < head)
    [].concat low.qsort(), head, high.qsort()

console.log([3, 2, 1].qsort())