<?php

class HuffmanMinHeap extends SplHeap {

	public function compare($a, $b)
	{
		return $b->freq - $a->freq;
	}

}

class HuffmanNode {

	public $char, $freq, $left, $right;

	public function __construct($char, $freq, $left = null, $right = null)
	{
		$this->char  = $char;
		$this->freq  = $freq;
		$this->left  = $left;
		$this->right = $right;
	}

	public function isLeaf()
	{
		return $this->left === null && $this->right === null;
	}

	public function __toString()
	{
		return sprintf("Char: '%s', Freq: '%s'", $this->char, $this->freq);
	}

}

class Huffman {

	public static $codeTable;

	public static function compress($str)
	{
		$chars       = str_split($str);			   // split the string into char array.
		$frequencies = array_count_values($chars); // tally up the counts of each char.
		$length      = strlen($str);			   // store the orginal length of the string.

		// build the huffman trie based on char frequencies.
		$root = static::buildTrie($frequencies);

		// build code based on huffman trie.
		static::$codeTable = array();
		static::buildCode(static::$codeTable, $root);

		// write trie to output var.
		static::writeTrie($root, $output);

		// convert all chars to their code table equivelant.
		foreach ($chars as $char) {
			$output .= static::$codeTable[$char];
		}

		return $output;
	}

	public static function expand($str)
	{
		// read the trie structure from the passed in string.
		$root = static::readTrie($str);
		
		// declare empty output string.
		$output = '';

		while ( ! empty($str)) {
			$x = $root;

			// while the current node is not a leaf proceed with traversal.
			while ( ! $x->isLeaf()) {
				// pop next char off string.
				$bit = substr($str, 0, 1); $str = substr($str, 1);

				// traverse either left or right depending on bit value.
				$x = ($bit === '1') ?
					$x->right :
					$x->left;
			}

			// append the leaf's char to the output.
			$output .= $x->char;
		}

		return $output;
	}

	private static function buildTrie(array $frequencies)
	{
		$heap = new HuffmanMinHeap();

		foreach ($frequencies as $char => $freq) {
			// insert each char/freq into heap as a huffman node instance.
			$heap->insert(new HuffmanNode($char, $freq));
		}

		// loop through extracting nodes until we reach the root.
		while ($heap->count() > 1) {
			$left  = $heap->extract();
			$right = $heap->extract();

			// insert parent node into heap with the left and right nodes as children,
			// freqency being the sum of the two childrens.
			$heap->insert(new HuffmanNode('', $left->freq + $right->freq, $left, $right));
		}

		// return the root node
		return $heap->extract();
	}

	private static function buildCode(&$codeTable, $node, $code = '')
	{
		if ( ! $node->isLeaf()) {
			// if node is not a leaf then traverse its children.
			static::buildCode($codeTable, $node->left,  $code . '0');
			static::buildCode($codeTable, $node->right, $code . '1');
		} else {
			// add node char to table along with its code.
			$codeTable[$node->char] = $code;
		}
	}

	private static function writeTrie($node, &$serialisedTrie)
	{
		if ($node->isLeaf()) {
			// if node is a leaf add 1 bit, followed by char.
			$serialisedTrie .= '1' . $node->char;
			return;
		}

		$serialisedTrie .= '0';
	
		static::writeTrie($node->left,  $serialisedTrie);
		static::writeTrie($node->right, $serialisedTrie);
	}

	private static function readTrie(&$serialisedTrie)
	{
		// pop next char off serialised trie.
		$isLeaf = substr($serialisedTrie, 0, 1); $serialisedTrie = substr($serialisedTrie, 1);

		if ($isLeaf === '1') {
			// pop next char off serialised trie.
			$char = substr($serialisedTrie, 0, 1); $serialisedTrie = substr($serialisedTrie, 1);

			return new HuffmanNode($char, -1, null, null);
		} else {
			return new HuffmanNode('', -1, static::readTrie($serialisedTrie), static::readTrie($serialisedTrie));
		}
	}

}

/**********************************************/

$opts = getopt('i:d');

$input = (isset($opts['i'])) ?
	$opts['i'] :
	'Hello, world!';

$dump = isset($opts['d']);

/**********************************************/

echo "\n\n";

echo "Input: $input\n----------\n";

$compressed = Huffman::compress($input);

if ($dump) {
	// dump out code table.
	echo "Char\tHuffman Code\n";
	foreach (Huffman::$codeTable as $char => $code) {
		echo "$char\t$code\n";
    }
} else {
	// print out compressed and expanded output.
	echo "Compressed: $compressed\n----------\n";

	$expanded = Huffman::expand($compressed);

	echo "Expanded: $expanded\n----------\n";

	echo ($input === $expanded) ?
		"[SUCCESS]" :
		"[FAIL]";
}

echo "\n\n";