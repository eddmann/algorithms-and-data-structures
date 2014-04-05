def qsort(xs: List[Int]): List[Int] = xs match {
    case Nil => Nil
    case head :: tail => {
        val (low, high) = tail.partition(_ < head)
        qsort(low) ::: head :: qsort(high)
    }
}

println(qsort(List(5, 4, 3, 2, 1)))