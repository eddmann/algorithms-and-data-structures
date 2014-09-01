func qsort<T: Comparable>(var xs: [T]) -> [T] {
    if xs.count > 1 {
        let pivot = xs.removeAtIndex(0)
        return qsort(xs.filter { $0 <= pivot }) + [ pivot ] + qsort(xs.filter { $0 > pivot })
    }

    return xs
}

struct Point: Comparable, Printable {
    var x: Double, y: Double

    var description: String {
        return "Point(\(self.x),\(self.y))"
    }

    init(_ x: Double, _ y: Double) {
        self.x = x
        self.y = y
    }
}

func <(this: Point, that: Point) -> Bool {
    return this.x < that.x && this.y < that.y
}

func ==(this: Point, that: Point) -> Bool {
    return this.x == that.x && this.y == that.y
}

println(qsort([Point(4, 2), Point(5, 3), Point(2, 1)]))