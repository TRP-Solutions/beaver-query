<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/dbtool/blob/master/LICENSE
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Expression;
require_once __DIR__.'/BindingStrength.php';
use TRP\BeaverQuery\BeaverQueryException;

class Expression {
	public static function parse($input){
		// TODO: implement this with validation
		if($input instanceof Expression){
			return $input;
		} elseif(is_bool($input) || is_int($input)){
			return static::constant($input);
		} elseif(is_string($input)) {
			return new Expression($input);
		}
	}

	public static function constant($value){
		if($value instanceof Expression){
			return $input;
		} elseif(is_bool($value)){
			return new Expression($value === true ? 'TRUE' : 'FALSE', BindingStrength::Constant);
		} elseif(is_int($value)){
			return new Expression((string)$value, BindingStrength::Constant);
		} elseif(is_string($value)){
			$value = Expression::escape($value);
			return new Expression("'$value'", BindingStrength::Constant);
		}
	}

	public static function escape(string $value): string {
		// TODO: implement escaping
		return $value;
	}

	protected function __construct(private string $expr, protected BindingStrength $inner_strength = BindingStrength::Undefined){

	}

	public function is($expr, $allow_null = false, $constant = true){
		if(!isset($expr)){
			return $allow_null ? self::is_null() : throw new BeaverQueryException('Attempting to compare with null without explicit permission.');
		} else {
			$expr = $constant ? Expression::constant($expr) : Expression::parse($expr);
			return new Expression($this.' = '.$expr, BindingStrength::Comparison);
		}
	}

	public function is_null(){
		return new Expression($this.' IS NULL', BindingStrength::Comparison);
	}

	public function is_not_null(){
		return new Expression($this.' IS NOT NULL', BindingStrength::Comparison);
	}

	public function in_range($from, $to, $start_inclusive = true, $end_inclusive = true){
		$from = self::parse($from);
		$to = self::parse($to);
		$after = $start_inclusive ? '>=' : '>';
		$before = $end_inclusive ? '<=' : '<';
		return ExpressionAnd::parse(
			new Expression("$this $after $from", BindingStrength::Comparison),
			new Expression("$this $before $to", BindingStrength::Comparison)
		);
	}

	public function if_then($then, $else){
		$then = Expression::parse($then);
		$else = Expression::parse($else);
		return new Expression("IF($this, $then, $else)", BindingStrength::Constant);
	}

	public function date(){
		return new Expression("DATE($this)", BindingStrength::Constant);
	}

	public function and($expr): ExpressionAnd {
		return new ExpressionAnd($this, $expr);
	}

	public function or($expr): ExpressionOr {
		return new ExpressionOr($this, $expr);
	}

	public function __toString(): string {
		return $this->expr;
	}

	public function print(BindingStrength $outer_strength): string {
		return $outer_strength->stronger_than($this->inner_strength) ? "($this)" : (string) $this;
	}
}

class ExpressionList {
	protected array $expressions;

	public function __construct(protected string $delimiter, Expression ...$expressions){
		$this->expressions = $expressions;
	}

	public static function parse(...$expressions){
		$list = new static(',');
		$list->add(...$expressions);
		return $list;
	}

	public function __toString(): string {
		return implode($this->delimiter, $this->expressions);
	}

	public function print(BindingStrength $outer_strength): string {
		return implode($this->delimiter, array_map(fn($e)=>$e->print($outer_strength), $this->expressions));
	}

	public function add(...$expressions){
		foreach($expressions as $expr){
			$this->expressions[] = Expression::parse($expr);
		}
	}
}

class ExpressionOrder extends ExpressionList {
	public function add(...$expressions){
		foreach($expressions as $expr){
			$list->expressions[] = match($expr){
				[$e, 'ASC'] => Expression::parse($e).' ASC',
				[$e, 'DESC'] => Expression::parse($e).' DESC',
				default => Expression::parse($expr)
			};
		}
	}
}

abstract class ExpressionBoolean extends Expression {
	public static function parse(...$expr): ExpressionBoolean {
		$expression_list = new ExpressionList(static::$delimiter);
		$expression_list->add(...$expr);
		return new static($expression_list);
	}

	public function print(BindingStrength $outer_strength): string {
		return $outer_strength->stronger_than(static::$static_inner_strength) ? "($this)" : (string) $this;
	}

	protected function __construct(protected ExpressionList $expressions){

	}

	public function __toString(): string {
		return $this->expressions->print(static::$static_inner_strength);
	}
}

class ExpressionAnd extends ExpressionBoolean {
	protected static $delimiter = "\n  AND ";
	protected static $static_inner_strength = BindingStrength::And;

	public function and(...$expr): ExpressionAnd {
		$this->expressions->add(...$expressions);
		return $this;
	}

}

class ExpressionOr extends ExpressionBoolean {
	protected static $delimiter = "\n  OR ";
	protected static $static_inner_strength = BindingStrength::Or;

	public function or($expr): ExpressionOr {
		$this->expressions->add(...$expressions);
		return $this;
	}
}
