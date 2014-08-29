func merge<T: Comparable>(lft: [T], rgt: [T]) -> [T] {
    func head(arr: [T]) -> T {
        return arr[0]
    }

    func tail(arr: [T]) -> [T] {
        return Array(arr[1 ..< arr.count])
    }

    if lft.isEmpty {
        return rgt
    } else if rgt.isEmpty {
        return lft
    } else if head(lft) < head(rgt) {
        return [ head(lft) ] + merge(tail(lft), rgt)
    } else {
        return [ head(rgt) ] + merge(lft, tail(rgt))
    }
}

func sort<T: Comparable>(arr: [T]) -> [T] {
    func from(lo: Int, hi: Int) -> [T] {
        return Array(arr[lo ..< hi])
    }

    if arr.count > 1 {
        let mid = arr.count / 2
        return merge(sort(from(0, mid)), sort(from(mid, arr.count)))
    }

    return arr
}

println(sort([5, 4, 3, 2, 1]))

func merge<T>(lft: [T], rgt: [T], pred: (T, T) -> Bool) -> [T] {
    func head(arr: [T]) -> T {
        return arr[0]
    }

    func tail(arr: [T]) -> [T] {
        return Array(arr[1 ..< arr.count])
    }

    if lft.isEmpty {
        return rgt
    } else if rgt.isEmpty {
        return lft
    } else if pred(head(lft), head(rgt)) {
        return [ head(lft) ] + merge(tail(lft), rgt, pred)
    } else {
        return [ head(rgt) ] + merge(lft, tail(rgt), pred)
    }    
}

func sort<T>(arr: [T], pred: (T, T) -> Bool) -> [T] {
    func from(lo: Int, hi: Int) -> [T] {
        return Array(arr[lo ..< hi])
    }

    if arr.count > 1 {
        let mid = arr.count / 2
        return merge(sort(from(0, mid), pred), sort(from(mid, arr.count), pred), pred)
    }       

    return arr
}

println(sort([1, 2, 3, 4, 5], { $0 > $1 }))