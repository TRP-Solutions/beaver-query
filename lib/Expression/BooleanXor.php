<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/beaver-query/blob/main/LICENSE.txt
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Expression;

class BooleanXor extends BooleanOperation {
	protected const OPERATOR = "\n  XOR ";
	protected const INNER_STRENGTH = BindingStrength::Xor;

	protected static function filter(Expression $expression): bool {
		return true;
	}

	public function xor(...$expr): Expression {
		$this->expressions = array_merge($this->expressions, self::parse_and_filter($expr));
		return $this;
	}
}
