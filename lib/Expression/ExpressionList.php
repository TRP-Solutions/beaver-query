<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/beaver-query/blob/main/LICENSE.txt
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Expression;

class ExpressionList {
	protected array $expressions;

	public function __construct(Expression ...$expressions){
		$this->expressions = $expressions;
	}

	public static function parse(...$expressions): static {
		$list = new static();
		return $list->add(...$expressions);
	}

	public function __toString(): string {
		return implode(',', $this->expressions);
	}

	public function add(...$expressions): static {
		foreach($expressions as $expr){
			$this->expressions[] = Expression::parse($expr);
		}
		return $this;
	}
}

class IdentifierList extends ExpressionList {
	public function add(...$expressions): static {
		foreach($expressions as $expr){
			$this->expressions[] = Identifier::parse($expr);
		}
		return $this;
	}
}

class OrderingList extends ExpressionList {
	public function add(...$expressions): static {
		foreach($expressions as $expr){
			$this->expressions[] = Ordering::parse($expr);
		}
		return $this;
	}
}

class ArgumentList extends ExpressionList {
	public function __toString(): string {
		return '('.implode(',', $this->expressions).')';
	}
}
