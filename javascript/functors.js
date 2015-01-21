var log = (x) => { console.log(x.toString()); return x; };

var curry = (fn, ...args) => {
    var _curry = (args) =>
        args.length < fn.length
            ? (..._args) => _curry([...args, ..._args])
            : fn.apply(this, args);

    return _curry(args);
};

var compose = (f) => (g) => (x) => f(g(x));

var add = (x, y) => x + y,
    toLowerCase = (s) => s.toLowerCase(),
    inc = curry(add)(1);

class Functor {
    constructor(value) { this.value = value; }
    fmap(fn) { throw new Error('fmap not implemented'); }
    toString() { return `Functor(${this.value})`; }
}

var fmap = curry((fn, functor) => functor.fmap(fn));

class Identity extends Functor {
    fmap(fn) { return Identity.of(fn(this.value)); }
    toString() { return `Identity(${this.value})`; }
    static of(value) { return new Identity(value); }
}

log(fmap(inc, Identity.of(1)));

class Maybe extends Functor {
    fmap(fn) { return Maybe.of(this.value ? fn(this.value) : null ); }
    toString() { return `Maybe(${this.value})`; }
    static of(value) { return new Maybe(value); }
}

log(fmap(inc, fmap(inc, Maybe.of(1))));
log(fmap(log, fmap(inc, Maybe.of(null))));

var get = curry((n, h) => Maybe.of(h[n])),
    splitAt = curry((t, s) => s.split(t)),
    head = (xs) => xs[0],
    getFirstName = compose(fmap(head))(compose(fmap(splitAt(' ')))(get('name')));

log(getFirstName({name: 'Joe Bloggs'}));
log(getFirstName({}));

class Either extends Functor {
    static Left(value) { return new _Left(value); }
    static Right(value) { return new _Right(value); }
}

class _Left extends Either {
    fmap(fn) { return this; }
    toString() { return `Either.Left(${this.value})`; }
}

class _Right extends Either {
    fmap(fn) { return Either.Right(fn(this.value)); }
    toString() { return `Either.Right(${this.value})`; }
}

var usernameLength = (s) => s.length > 5 ? Either.Left('Too long') : Either.Right(s),
    usernameFormat = (s) => ! s.match('^\w+$') ? Either.Left('Invalid format') : Either.Right(s);

log(compose(fmap(toLowerCase))(usernameLength)('foobar'));