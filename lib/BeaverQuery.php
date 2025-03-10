<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/dbtool/blob/master/LICENSE
*/
declare(strict_types=1);
namespace TRP\BeaverQuery;
use TRP\BeaverQuery\Expression\{Expression, ExpressionAnd, ExpressionOr, ExpressionList};

class BeaverQuery {
	private static string|null $default_database = null;
	/*
		IDEA: Maybe make a static configure method that returns a BeaverQuery instance.
		Static calls would use the configurations from either the first or the last instance,
		or fall back to default values.
	*/

	public static function setDefaultDatabase(string|null $database){
		self::$default_database = $database;
	}

	public static function getDefaultDatabase(): string|true|null {
		return self::$default_database;
	}

	public static function select(array $values = [], string $table = null, ?string $alias = null, ?string $database = null, bool $implicit_database = false){
		$table = new Table($table, $alias, $database, $implicit_database);
		return new SelectQuery($values, $table);
	}

	public static function table(string $name, ?string $alias = null, ?string $database = null, bool $implicit_database = false){
		return new Table($name, $alias, $database, $implicit_database);
	}

	public static function and(...$expressions): ExpressionAnd {
		return ExpressionAnd::parse(...$expressions);
	}

	public static function or(...$expressions): ExpressionOr {
		return ExpressionOr::parse(...$expressions);
	}

	public static function expr($expression): Expression {
		return Expression::parse($expression);
	}
}

abstract class TableQuery {
	protected static string $whitespace = PHP_EOL;
	protected Table $table;

	abstract public function __toString(): string;
}

class SelectQuery extends TableQuery {
	use FieldList;
	protected array $select_expr = [];
	protected ?Expression $where = null;
	protected ?array $groupby = null;
	protected ?Expression $having = null;
	protected ?array $orderby = null;
	protected ?int $limit = null;

	public function __construct(array $values = [], ?Table $table = null){
		if(isset($table)){
			$this->table = $table;
			foreach($table->get_fields() as $field){
				$this->select_expr[] = $field;
			}
		}
		foreach($values as $value){
			$this->select_expr[] = Expression::parse($value);
		}
	}

	public function from(string|array|Table $table){
		if(is_string($table)){
			$this->table = new Table($table);
		} elseif(is_array($table)){
			$this->table = new Table(...$table);
		} else {
			$this->table = $table;
		}
	}

	public function where(...$expr){
		if(!isset($this->where)){
			$this->where = ExpressionAnd::parse(...$expr);
		} else {
			$this->where->and($expr);
		}
	}

	public function order_by(...$expr){
		if(!isset($this->order_by)){
			$this->order_by = ExpressionList::parse(...$expr);
		} else {
			$this->order_by->add(...$expr);
		}
	}

	public function __toString(){
		$sql = ["SELECT\n  ".implode(",\n  ",$this->select_expr)];
		if(isset($this->table)){
			$sql[] = "FROM\n  ".$this->table->identifier_with_alias();
		}
		if(isset($this->where)){
			$sql[] = "WHERE\n  ".$this->where;
		}
		if(!empty($this->groupby)){
			$sql[] = "GROUP BY ".implode(',',$this->groupby);
		}
		if(isset($this->having)){
			$sql[] = "HAVING ".$this->having;
		}
		if(!empty($this->orderby)){
			$sql[] = "ORDER BY ".implode(',',$this->orderby);
		}
		if(isset($this->limit)){
			$sql[] = "LIMIT ".$this->limit();
		}
		return implode(self::$whitespace, $sql);
	}

	protected function add_field(string|array|Field $field){
		if(is_string($field)){
			$field = new Field($field);
		} elseif(is_array($field)){
			$field = new Field(...$field);
		}
		$this->select_expr[] = $field;
	}
}

class Table {
	use FieldList;
	protected array $field_list = [];

	public function __construct(protected string $name, protected ?string $alias = null, protected ?string $database = null, bool $implicit_database = false){
		if(!$implicit_database){
			$this->database ??= BeaverQuery::getDefaultDatabase();
		}
		if(!isset($this->database) && !$implicit_database){
			throw new BQException("Implicit database not enabled. Database missing from table `$name`");
		}
	}

	public function select(): SelectQuery {
		return new SelectQuery(table: $this);
	}

	public function get_fields(): array {
		return $this->field_list;
	}

	public function alias(){
		return '`'.($this->alias ?? $this->name).'`';
	}

	public function identifier_with_alias(){
		$identifier = "`$this->name`";
		if(isset($this->database)){
			$identifier = "`$this->database`.".$identifier;
		}
		if(isset($this->alias)){
			$identifier .= " AS `$this->alias`";
		}
		return $identifier;
	}

	public function __get(string $name): Field {
		return $this->field($name);
	}

	public function field($name, ?string $field_alias = null): Field {
		return new Field($name, alias: $field_alias, table: $this->alias ?? $this->name);
	}

	protected function add_field(string|array|Field $field){
		if(is_string($field)){
			$field = $this->field($field);
		} elseif(is_array($field)){
			$field = $this->field(...$field);
		}
		$this->field_list[] = $field;
	}
}

require_once __DIR__."/Expression.php";
class Field extends Expression {
	public function __construct(public readonly string $name, public readonly ?string $alias = null, public readonly ?string $table = null){

	}

	public function __toString(){
		return $this->identifier_with_alias();
	}

	public function identifier_with_alias(){
		$identifier = "`$this->name`";
		if(isset($this->table)){
			$identifier = "`$this->table`.".$identifier;
		}
		if(isset($this->alias)){
			$identifier .= " AS `$this->alias`";
		}
		return $identifier;
	}
}

trait FieldList {
	public function fields(string|array|Field ...$field_list){
		foreach($field_list as $field){
			$this->add_field($field);
		}
	}

	abstract protected function add_field(string|array|Field $field);
}

class BeaverQueryException extends \Exception {

}