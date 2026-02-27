<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/beaver-query/blob/main/LICENSE.txt
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Expression;
use TRP\BeaverQuery\{Parser,BeaverQueryException};

class Atom extends Expression {
	public static function literal(mixed $value): Atom {
		if(is_bool($value)){
			return $value ? AtomTrue::get() : AtomFalse::get();
		} elseif(is_int($value)){
			return new self((string) $value);
		} elseif(is_float($value)){
			return new self(sprintf('%F', $value));
		} elseif(is_string($value)){
			return new self(Parser::string_literal($value));
		} elseif(!isset($value)){
			return AtomNull::get();
		} elseif($value instanceof IntervalUnit){
			return new self($value->value);
		} else {
			throw new BeaverQueryException("Can't convert value to literal");
		}
	}

	protected function __construct(private string $term){

	}

	public function __toString(): string {
		return $this->term;
	}

	public function print(BindingStrength $outer_strength): string {
		return (string) $this;
	}
}

abstract class AtomSingleton extends Atom {
	public static function get(){
		if(!isset(static::$instance)){
			static::$instance = new static();
		}
		return static::$instance;
	}

	protected function __construct(){

	}
}

class AtomTrue extends AtomSingleton {
	protected static $instance;
	public function __toString(): string {
		return 'TRUE';
	}
}

class AtomFalse extends AtomSingleton {
	protected static $instance;
	public function __toString(): string {
		return 'FALSE';
	}
}

class AtomNull extends AtomSingleton {
	protected static $instance;
	public function __toString(): string {
		return 'NULL';
	}
}
