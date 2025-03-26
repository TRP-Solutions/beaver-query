<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/dbtool/blob/master/LICENSE
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Expression;

class FunctionCall extends Atom {
	protected array $arguments;

	public static function parse($name, ...$expr): static {
		return new static($name, ...Expression::map_parse($expr));
	}

	public function __construct(protected string $name, Expression ...$arguments){
		// TODO: parse $name as a valid function identifier
		$this->arguments = $arguments;
	}

	public function __toString(): string {
		return $this->name.'('.implode(',',$this->arguments).')';
	}
}
