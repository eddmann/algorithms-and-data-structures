extension String
{
    var head: String? {
        if let head = first(self) {
            return String(head)
        } else {
            return nil
        }
    }

    var tail: String? {
        let tail = dropFirst(self)

        if tail.isEmpty == false {
            return tail
        } else {
            return nil
        }
    }
}

class Node
{
    private let key: String
    var value: String? = nil
    private var children: [Node] = []

    init(_ key: String) {
        self.key = key
    }

    func getChildNode(key: String) -> Node? {
        if let idx = getChildNodeIndex(key) {
            return children[idx]
        } else {
            return nil
        }
    }

    private func getChildNodeIndex(key: String) -> Int? {
        for (idx, child) in enumerate(children) {
            if child.key == key {
                return idx
            }
        }

        return nil
    }

    func storeChildNode(child: Node) {
        if let idx = getChildNodeIndex(child.key) {
            if child.isRedundant {
                children.removeAtIndex(idx)
            } else {
                children[idx] = child
            }
        } else {
            children.append(child)
        }
    }

    private var isRedundant: Bool {
        return value == nil && children.count == 0
    }
}

class Trie
{
    private let root: Node

    init() {
        root = Node("")
    }

    func insert(key: String, _ value: String) {
        insert(key, value, root)
    }

    private func insert(key: String, _ value: String, _ parent: Node) {
        if let head = key.head {
            let child: Node = parent.getChildNode(head) ?? Node(head)

            if let tail = key.tail {
                insert(tail, value, child)
            } else {
                child.value = value
            }

            parent.storeChildNode(child)
        }
    }

    func remove(key: String) {
        remove(key, root)
    }

    private func remove(key: String, _ parent: Node) {
        if let head = key.head {
            if let child = parent.getChildNode(head) {
                if let tail = key.tail {
                    remove(tail, child)
                } else {
                    child.value = nil
                }

                parent.storeChildNode(child)
            }
        }
    }

    func get(key: String) -> String? {
        return get(key, root)
    }

    private func get(key: String, _ parent: Node) -> String? {
        if let head = key.head {
            if let child = parent.getChildNode(head) {
                if let tail = key.tail {
                    return get(tail, child)
                } else {
                    return child.value
                }
            }
        }

        return nil
    }

    var length: Int {
        return length(root)
    }

    private func length(parent: Node) -> Int {
        var total = parent.value != nil ? 1 : 0

        for child in parent.children {
            total += length(child)
        }

        return total
    }
}

let t = Trie()

t.insert("foo", "FOO")
t.insert("foobar", "FOOBAR")
t.insert("foobarbaz", "FOOBARBAZ")

dump(t)

println(t.get("foobar"))
