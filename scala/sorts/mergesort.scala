def sort1(xs: List[Int]): List[Int] = {
  val m = xs.length / 2
  if (m == 0) xs
  else {
    def merge(xs: List[Int], ys: List[Int]): List[Int] = (xs, ys) match {
      case (Nil, ys) => ys
      case (xs, Nil) => xs
      case (x :: xs1, y :: ys1) =>
        if (x < y) x :: merge(xs1, ys)
        else y :: merge(xs, ys1)
    }
    val (left, right) = xs splitAt m
    merge(sort1(left), sort1(right))
  }
}

println(sort1(List(4, 1, 3, 2)))

implicit def lt(x: Int, y: Int) = x < y

def sort2[T](pred: (T, T) => Boolean)(xs: List[T]): List[T] = {
  val m = xs.length / 2
  if (m == 0) xs
  else {
    def merge(xs: List[T], ys: List[T]): List[T] = (xs, ys) match {
      case (Nil, ys) => ys
      case (xs, Nil) => xs
      case (x :: xs1, y :: ys1) =>
        if (pred(x, y)) x :: merge(xs1, ys)
        else y :: merge(xs, ys1)
    }
    val (left, right) = xs splitAt m
    merge(sort2(pred)(left), sort2(pred)(right))
  }
}

println(sort2(lt)(List(4, 1, 3, 2)))

object Sort3 {
  def apply[T](xs: List[T])(implicit pred: (T, T) => Boolean): List[T] = {
    val m = xs.length / 2
    if (m == 0) xs
    else {
      def merge(xs: List[T], ys: List[T]): List[T] = (xs, ys) match {
        case (Nil, ys) => ys
        case (xs, Nil) => xs
        case (x :: xs1, y :: ys1) =>
          if (pred(x, y)) x :: merge(xs1, ys)
          else y :: merge(xs, ys1)
      }
      val (left, right) = xs splitAt m
      merge(apply(left), apply(right))
    }
  }
}

println(Sort3(List(4, 1, 3, 2)))

def sort4[T](pred: (T, T) => Boolean)(xs: Stream[T]): Stream[T] = {
  val m = xs.length / 2
  if (m == 0) xs
  else {
    def merge(xs: Stream[T], ys: Stream[T]): Stream[T] = (xs, ys) match {
      case (Stream.Empty, ys) => ys
      case (xs, Stream.Empty) => xs
      case (x #:: xs1, y #:: ys1) =>
        if (pred(x, y)) x #:: merge(xs1, ys)
        else y #:: merge(xs, ys1)
    }
    val (left, right) = xs splitAt m
    merge(sort4(pred)(left), sort4(pred)(right))
  }
}

def numbers(remain: Int): Stream[Int] =
  if (remain == 0) Stream.Empty
  else Stream.cons(util.Random.nextInt(100), numbers(remain - 1))

println(sort4(lt)(numbers(4)).toList)

def sort5[T](pred: (T, T) => Boolean)(xs: List[T]): List[T] = {
  val m = xs.length / 2
  if (m == 0) xs
  else {
    @scala.annotation.tailrec
    def merge(xs: List[T], ys: List[T], acc: List[T]): List[T] = (xs, ys) match {
      case (Nil, ys) => acc ++ ys
      case (xs, Nil) => acc ++ xs
      case (x :: xs1, y :: ys1) =>
        if (pred(x, y)) merge(xs1, ys, acc :+ x)
        else merge(xs, ys1, acc :+ y)
    }
    val (left, right) = xs splitAt m
    merge(sort5(pred)(left), sort5(pred)(right), List());
  }
}

println(sort5(lt)(numbers(4).toList))