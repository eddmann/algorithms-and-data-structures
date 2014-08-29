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

extension Array {
    func slice(min: Int, _ max: Int) -> [T] {
        return Array(self[min ..< max])
    }
    
    var head: T {
        return self[0]
    }

    var tail: [T] {
        return self.slice(1, self.count)
    }

    func split() -> ([T], [T]) {
        let mid = self.count / 2
        return (slice(0, mid), slice(mid, self.count))
    }
}

func merge_<T>(lft: [T], rgt: [T], pred: (T, T) -> Bool) -> [T] {
    if lft.isEmpty {
        return rgt
    } else if rgt.isEmpty {
        return lft
    } else if pred(lft.head, rgt.head) {
        return [ lft.head ] + merge_(lft.tail, rgt, pred)
    } else {
        return [ rgt.head ] + merge_(lft, rgt.tail, pred)
    }
}

func sort_<T>(arr: [T], pred: (T, T) -> Bool) -> [T] {
    if (arr.count > 1) {
        let (lft, rgt) = arr.split()
        return merge_(sort_(lft, pred), sort_(rgt, pred), pred)
    }

    return arr
}

println(sort_([1, 2, 3, 4, 5], { $0 > $1 }))