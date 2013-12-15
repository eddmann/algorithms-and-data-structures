def parse = java.lang.Double.parseDouble _

var rpn = (str: String) => {

    val ops = Map(
        "+" -> ((_: Double) + (_: Double)),
        "*" -> ((_: Double) * (_: Double)),
        "-" -> ((x: Double, y: Double) => y - x),
        "/" -> ((x: Double, y: Double) => y / x)
    )

    val stack = new scala.collection.mutable.Stack[Double]

    str.split(' ').foreach(token =>
        stack.push(
            if (ops.contains(token)) ops(token)(stack.pop, stack.pop)
            else parse(token)
        ))

    stack.pop

}

println(rpn("4 2 * 8 + 2 /"))

rpn = (str: String) => {

    str.split(' ').toList.foldLeft(List[Double]())(
        (list, token) => (list, token) match {
            case (x :: y :: zs, "*") => (y * x) :: zs
            case (x :: y :: zs, "+") => (y + x) :: zs
            case (x :: y :: zs, "-") => (y - x) :: zs
            case (x :: y :: zs, "/") => (y / x) :: zs
            case (_, _) => parse(token) :: list
        }).head

}

println(rpn("4 2 * 8 + 2 /"))