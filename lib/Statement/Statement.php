<?php
/*
BeaverQuery is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/beaver-query/blob/main/LICENSE.txt
*/
declare(strict_types=1);
namespace TRP\BeaverQuery\Statement;
use TRP\BeaverQuery\Expression\{Expression, Identifier, ExpressionAlias, ExpressionList, Operation, FunctionCall};
use TRP\BeaverQuery\{BeaverQuery,Table,Parser,BeaverQueryException};

abstract class Statement {
	protected static string $whitespace = PHP_EOL;
	public function __toString(): string {
		return $this->print().';';
	}

	abstract public function print(): string;
}

#[\Property('table', '\TRP\BeaverQuery\Table', set: false)]
abstract class TableStatement extends Statement {
	protected Table $table;

	public function __isset($key){
		if($key === 'table'){
			return isset($this->table);
		} else {
			$proxy_func = $key.'_proxy';
			return is_callable([$this,$proxy_func]);
		}
	}

	public function __get($key){
		if($key === 'table'){
			return $this->table;
		}
		$proxy_func = $key.'_proxy';
		if(is_callable([$this,$proxy_func])){
			return $this->$proxy_func();
		}
	}
}

class Insert extends TableStatement {
	use ColumnAssignment;
	protected ?ExpressionList $duplicate_update_list = null;
	protected ?Select $select = null;
	protected ?array $columns = null;
	protected ?int $column_count = null;
	protected ?array $values_list = null;

	public function __construct(
		protected Table $table,
		protected bool $low_priority = false,
		protected bool $delayed = false,
		protected bool $high_priority = false,
		protected bool $ignore = false
	){

	}

	public function columns(...$columns): static {
		$this->columns = array_map(fn($column) => Identifier::parse_strict($column), Parser::list($columns));
		return $this;
	}

	public function values(...$values): static {
		$values = Parser::list($values);
		$value_count = count($values);
		if(isset($this->column_count) && $this->column_count !== $value_count){
			throw new BeaverQueryException("Failed matching $value_count value(s) with $this->column_count column(s)");
		} else {
			if(!isset($this->values_list)){
				$this->values_list = [];
			}
			$this->values_list[] = ExpressionList::parse(...$values);
			$this->column_count ??= $value_count;
		}
		return $this;
	}

	public function select($select, $values = []): Select {
		if($select instanceof Select){
			$this->select = $select;
		} else {
			$this->select = BeaverQuery::select($select, $values);
		}
		return $this->select;
	}

	public function dupl_values(...$columns): static {
		$assignment = [];
		foreach($columns as $column_name){
			$column = Identifier::parse_strict($column_name);
			$assignment[] = Operation::assignment($column, FunctionCall::parse('VALUES',$column));
		}
		$this->add_assignment_list('duplicate_update_list', ...$assignment);
		return $this;
	}

	public function dupl(...$values): static {
		$this->parse_assignment_list($values, 'duplicate_update_list');
		return $this;
	}

	public function print(): string {
		$sql = ["INSERT"];
		if($this->high_priority){
			$sql[] = 'HIGH_PRIORITY';
		} elseif($this->delayed){
			$sql[] = 'DELAYED';
		} elseif($this->low_priority){
			$sql[] = 'LOW_PRIORITY';
		}
		if($this->ignore){
			$sql[] = 'IGNORE';
		}
		$sql[] = 'INTO '.$this->table->get_name()->identifier_with_alias();
		$sql = [implode(' ',$sql)];

		if(isset($this->column_assignment)){
			$sql[] = "SET ".$this->column_assignment;
		} elseif(isset($this->values_list)) {
			if(isset($this->columns)){
				$sql[] = '('.implode(',',array_map(fn($col)=>$col->identifier_unqualified(),$this->columns)).')';
			}
			$sql[] = 'VALUES';
			$sql[] = "(".implode("),".self::$whitespace."(",$this->values_list).')';
		} elseif(isset($this->select)){
			$sql[] = $this->select->print();
		} else {
			throw new BeaverQueryException('No values in insert statement');
		}
		if(isset($this->duplicate_update_list)){
			$sql[] = "ON DUPLICATE KEY UPDATE ".$this->duplicate_update_list;
		}
		
		return implode(self::$whitespace, $sql);
	}
}

class Select extends TableStatement {
	use Join, Where, OrderBy, GroupBy, Limit, Offset;
	protected array $select_expr = [];

	public function __construct(?Table $table = null, array $values = []){
		if(isset($table)){
			$this->table = $table;
		}
		$this->columns(...$values);
	}

	public function from(string|array|Table $table): Table {
		$this->table = Table::parse($table);
		return $this->table;
	}

	public function columns(...$columns): static {
		foreach(Parser::list($columns) as $column){
			if(is_string($column)){
				$identifier = Parser::dotted_name_with_alias($column);
				if(isset($identifier) && !isset($identifier[2])){
					$table_name ??= $this->table->get_name();
					$this->select_expr[] = Identifier::parse_strict($identifier, $table_name);
					continue;
				}
			}
			$this->select_expr[] = ExpressionAlias::parse($column);
		}
		return $this;
	}

	public function print(): string {
		$sql = ["SELECT\n  ".$this->select_expr()];
		if(isset($this->table)){
			$sql[] = "FROM\n  ".$this->table->get_name()->identifier_with_alias();
		}
		foreach($this->joins as $join){
			$sql[] = (string) $join;
		}
		if(isset($this->where)){
			$sql[] = "WHERE\n  ".$this->where;
		}
		if(!empty($this->groupby)){
			$sql[] = "GROUP BY ".$this->groupby;
		}
		if(isset($this->having)){
			$sql[] = "HAVING ".$this->having;
		}
		if(!empty($this->orderby)){
			$sql[] = "ORDER BY ".$this->orderby;
		}
		if(isset($this->limit)){
			$sql[] = "LIMIT ".$this->limit;
			if(isset($this->offset)){
				$sql[] = "OFFSET ".$this->offset;
			}
		}
		return implode(self::$whitespace, $sql);
	}

	protected function select_expr(): string {
		$expr = $this->select_expr;
		if(isset($this->table)){
			$expr = array_merge($this->table->get_column_list(), $expr);
		}
		if(!empty($this->joins)){
			$expr = array_merge($expr, ...array_map(fn($join)=>$join->table->get_column_list(), $this->joins));
		}
		return implode(",\n  ",$expr);
	}
}

class Update extends TableStatement {
	use ColumnAssignment, Join, Where, OrderBy, Limit;

	public function __construct(
		?Table $table = null,
		protected bool $low_priority = false,
		protected bool $ignore = false
	){
		if(isset($table)){
			$this->table = $table;
		}
	}

	public function print(): string {
		$sql = ["UPDATE"];
		if($this->low_priority){
			$sql[] = 'LOW_PRIORITY';
		}
		if($this->ignore){
			$sql[] = 'IGNORE';
		}
		$sql[] = $this->table->get_name()->identifier_with_alias();
		foreach($this->joins as $join){
			$sql[] = (string) $join;
		}
		$sql[] = "SET\n  ".$this->column_assignment;
		if(isset($this->where)){
			$sql[] = "WHERE\n  ".$this->where;
		}
		if(!empty($this->orderby)){
			$sql[] = "ORDER BY ".$this->orderby;
		}
		if(isset($this->limit)){
			$sql[] = "LIMIT ".$this->limit();
		}
		return implode(self::$whitespace, $sql);
	}
}

class Delete extends TableStatement {
	use Where, OrderBy, Limit;

	public function __construct(
		?Table $table = null,
		protected bool $low_priority = false,
		protected bool $quick = false,
		protected bool $ignore = false
	){
		if(isset($table)){
			$this->table = $table;
		}
	}

	public function print(): string {
		$sql = ["DELETE"];
		if($this->low_priority){
			$sql[] = 'LOW_PRIORITY';
		}
		if($this->quick){
			$sql[] = 'QUICK';
		}
		if($this->ignore){
			$sql[] = 'IGNORE';
		}
		$sql[] = 'FROM';
		$sql[] = $this->table->get_name()->identifier_with_alias();
		if(isset($this->where)){
			$sql[] = "WHERE\n  ".$this->where;
		}
		if(!empty($this->orderby)){
			$sql[] = "ORDER BY ".$this->orderby;
		}
		if(isset($this->limit)){
			$sql[] = "LIMIT ".$this->limit();
		}
		return implode(self::$whitespace, $sql);
	}
}
