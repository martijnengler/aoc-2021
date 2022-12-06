<?php
class Node
{
	public $name;
	public $linked = array();

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function link_to(Node $node, $also = true)
	{
		if (!$this->linked($node)) $this->linked[] = $node;
		if ($also) $node->link_to($this, false);
		return $this;
	}

	private function linked(Node $node)
	{
		foreach ($this->linked as $l) { if ($l->name === $node->name) return true; }
		return false;
	}

	public function not_visited_nodes($visited_names)
	{
		$ret = array();
		foreach ($this->linked as $l) {
			if (!in_array($l->name, $visited_names)) $ret[] = $l;
		}
		return $ret;
	}
}

/* Building Graph */
$start = new Node('start');
$node_a = new Node('A');
$node_b = new Node('b');
$node_c = new Node('c');
$node_d = new Node('d');
$end = new Node('end');

$start->link_to($node_a);
$start->link_to($node_b);
$node_a->link_to($node_b);
$node_a->link_to($node_c);
$node_b->link_to($node_d);
$node_a->link_to($end);
$node_b->link_to($end);

/* Searching Path */
function dfs(Node $node, $path = '', $visited = array())
{
	$visited[] = $node->name;
	$not_visited = $node->not_visited_nodes($visited);
	if (empty($not_visited)) {
		echo ltrim($path . ',' . $node->name . PHP_EOL, ',');
		return;
	}
	foreach ($not_visited as $n) dfs($n, $path . ',' . $node->name, $visited);
}

dfs($start);
// path : ->root->node1->node3
// path : ->root->node1->node4->node5->node2->node6
// path : ->root->node2->node5->node4->node1->node3
// path : ->root->node2->node6
