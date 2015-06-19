<?php
class A
{
	function foo()
	{
		if (isset($this)) {
			echo '$this foi definido (';
			echo get_class($this);
			echo ")<br>";
		} else {
			echo "<br>$this não foi definido.<br>";
		}
	}
}

class B
{
	function bar()
	{
		A::foo();
	}
}

// $a = new A();
// $a->foo();
// A::foo();
$b = new B();
$b->bar();
// B::bar();
?>