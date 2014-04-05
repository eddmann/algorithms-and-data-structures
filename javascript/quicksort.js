Array.prototype.partition = function(fn) {
    var xs = [], ys = [], len = this.length, i, e;

    for (i = 0; i < len; i++) {
        e = this[i];
        (fn(e) ? xs : ys).push(e);
    }

    return [xs, ys];
};

function unpack(fn, el)
{
    return fn.apply(null, el);
}

Array.prototype.qsort = function()
{
    if (this.length < 2)
        return this;

    var head = this.shift();

    return unpack(function(low, high) {
        return [].concat(low.qsort(), head, high.qsort());
    }, this.partition(function(_) { return _ < head; }));
};

console.log([ 5, 4, 3, 2, 1].qsort());