from string import ascii_lowercase, ascii_uppercase

def rot13(s):
    from codecs import encode
    return encode(s, 'rot13')

print(rot13('Hello World'))

def rot13_alpha(s):
    def lookup(v):
        o, c = ord(v), v.lower()
        if 'a' <= c <= 'm':
            return chr(o + 13)
        if 'n' <= c <= 'z':
            return chr(o - 13)
        return v
    return ''.join(map(lookup, s))

print(rot13_alpha('Hello World'))

def rot_alpha(n):
    from string import ascii_lowercase as lc, ascii_uppercase as uc
    lookup = str.maketrans(lc + uc, lc[n:] + lc[:n] + uc[n:] + uc[:n])
    return lambda s: s.translate(lookup)

print(rot_alpha(13)('Hello World'))

def rot(*symbols):
    def _rot(n):
        encoded = ''.join(sy[n:] + sy[:n] for sy in symbols)
        lookup = str.maketrans(''.join(symbols), encoded)
        return lambda s: s.translate(lookup)
    return _rot

rot5_num = rot('0123456789')(5)
print(rot5_num('1234'))

rot_alpha = rot(ascii_lowercase, ascii_uppercase)
rot5_alpha_enc = rot_alpha(5)
rot5_alpha_dec = rot_alpha(-5)

enc = rot5_alpha_enc('Hello World')
print(enc)
print(rot5_alpha_dec(enc))