# Namespace: `\TRP\BeaverQuery`

## Class: BeaverQuery
Namespaced name: `\TRP\BeaverQuery\BeaverQuery`

| BeaverQuery Factories | Return Type                         | Method signature                                                                  |
| ----------------------| ----------------------------------- | --------------------------------------------------------------------------------- |
| insert                | [Insert](#class-insert)             | `static BeaverQuery::insert(​$table, array $columns = [], array ...$rows): Insert` |
| select                | [Select](#class-select)             | `static BeaverQuery::select(​$table = null, array $values = []): Select`           |
| update                | [Update](#class-update)             | `static BeaverQuery::update(​$table, ...$values): Update`                          |
| delete                | [Delete](#class-delete)             | `static BeaverQuery::delete(​$table, $where = null): Delete `                      |
| table                 | [Table](#class-table)               | `static BeaverQuery::table(​$table, array $columns = []): Table`                   |
| name                  | [Identifier](#class-identifier)     | `static BeaverQuery::name(​string $name, ?string $subname = null): Identifier`     |
| func                  | [FunctionCall](#class-functioncall) | `static BeaverQuery::func(​string $name, ...$expressions): FunctionCall`           |
| and                   | [Expression](#class-expression)     | `static BeaverQuery::and(​...$expressions): Expression`                            |
| or                    | [Expression](#class-expression)     | `static BeaverQuery::or(​...$expressions): Expression`                             |
| xor                   | [Expression](#class-expression)     | `static BeaverQuery::xor(​...$expressions): Expression`                            |
| unsafe                | [Unsafe](#class-unsafe)             | `static BeaverQuery::unsafe(​string $raw_sql): Unsafe`                             |

| BeaverQuery Configuration | Method signature                                                      |
| --------------------------| --------------------------------------------------------------------- |
| setDefaultDatabase        | `static BeaverQuery::setDefaultDatabase(​?string $database): void`     |
| getDefaultDatabase        | `static BeaverQuery::getDefaultDatabase(): ?string`                   |
| allowImplicitDatabase     | `static BeaverQuery::allowImplicitDatabase(​bool $allow = true): void` |

## Class: BeaverQueryException
Namespaced name: `\TRP\BeaverQuery\BeaverQueryException`
```PHP
class BeaverQueryException extends \Exception
```

---

# Namespace: `\TRP\BeaverQuery\Statement`

## Class: Insert
Namespaced name: `\TRP\BeaverQuery\Statement\Insert`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Insert methods | Method signature                                                                                                                  |
| -------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| __construct    | `__construct(​Table $table, bool $low_priority = false, bool $delayed = false, bool $high_priority = false, bool $ignore = false)` |
| columns        | `columns(​...$columns): Insert`                                                                                                    |
| values         | `values(​...$values): Insert`                                                                                                      |
| set            | `set(​...$values): Insert`                                                                                                         |
| select         | `function select(​$select, $values = []): Select`                                                                                  |
| dupl_values    | `dupl_values(​...$columns): Insert`                                                                                                |
| dupl           | `dupl(​...$values): Insert`                                                                                                        |
| print          | `print(): string`                                                                                                                 |

## Class: Select
Namespaced name: `\TRP\BeaverQuery\Statement\Select`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Select methods | Method signature |
| -------------- | ------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, array $values = [])` |
| from           | `from(​string\|array\|Table $table): Table`              |
| columns        | `columns(​...$columns): Select`                          |
| join           | `join(​Join $join): Join`                                |
| left_join      | `left_join(​$table, $condition): Join`                   |
| right_join     | `right_join(​$table, $condition): Join`                  |
| inner_join     | `inner_join(​$table, $condition = null): Join`           |
| where          | `where(​...$expr): Select`                               |
| order_by       | `order_by(​...$expr): Select`                            |
| limit          | `limit(​?int $limit): Select`                            |
| group_by       | `group_by(​...$expr): Select`                            |
| having         | `having(​...$expr): Select`                              |
| print          | `print(): string`                                       |

## Class: Update
Namespaced name: `\TRP\BeaverQuery\Statement\Update`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Update methods | Method signature                                                                      |
| -------------- | ------------------------------------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, bool $low_priority = false, bool $ignore = false)` |
| values         | `values(​...$values): Update`                                                          |
| set            | `set(​...$values): Update`                                                             |
| join           | `join(​Join $join): Join`                                                              |
| left_join      | `left_join(​$table, $condition): Join`                                                 |
| right_join     | `right_join(​$table, $condition): Join`                                                |
| inner_join     | `inner_join(​$table, $condition = null): Join`                                         |
| where          | `where(​...$expr): Update`                                                             |
| order_by       | `order_by(​...$expr): Update`                                                          |
| limit          | `limit(​?int $limit): Update`                                                          |
| print          | `print(): string`                                                                     |


## Class: Delete
Namespaced name: `\TRP\BeaverQuery\Statement\Delete`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Delete methods | Method signature                                                                                           |
| -------------- | ---------------------------------------------------------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, bool $low_priority = false, bool $quick = false, bool $ignore = false)` |
| where          | `where(​...$expr): Update`                                                                                  |
| order_by       | `order_by(​...$expr): Update`                                                                               |
| limit          | `limit(​?int $limit): Update`                                                                               |
| print          | `print(): string`                                                                                          |

## Class: Table
Namespaced name: `\TRP\BeaverQuery\Table`

| Table methods   | Method signature                                                                                              |
| --------------- | ------------------------------------------------------------------------------------------------------------- |
| parse           | `static parse(​string\|array\|Table $table, bool $implicit_database = false): Table`                           |
| __construct     | `__construct(​string $name, ?string $alias = null, ?string $database = null, bool $implicit_database = false)` |
| columns         | `columns(​string\|array\|Column ...$column_list): static`                                                      |
| select          | `select(): Select`                                                                                            |
| insert          | `insert(): Inser`                                                                                             |
| update          | `update(): Update`                                                                                            |
| delete          | `delete(): Delete`                                                                                            |
| get_name        | `get_name(): Identifier`                                                                                      |
| get_column_list | `get_column_list(): array`                                                                                    |
| get_column      | `get_column(​string $name, ?string $column_alias = null): Identifier`                                          |
| __get           | `__get(​string $name): Identifier`                                                                             |

---

# Namespace: `\TRP\BeaverQuery\Join`

## Class: Join
Namespaced name: `\TRP\BeaverQuery\Join\Join`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Join methods   | Method signature                                                                                 |
| -------------- | ------------------------------------------------------------------------------------------------ |
| left_join      | `static left_join(​string\|array\|Table $table, $on = null, $using = null): Join`                 |
| right_join     | `static right_join(​string\|array\|Table $table, $on = null, $using = null): Join`                |
| inner_join     | `static inner_join(​string\|array\|Table $table, $on = null, $using = null): Join`                |
| specified_join | `static specified_join(​Type $type, string\|array\Table $table, $on = null, $using = null): Join` |
| __construct    | `__construct(​protected Type $type, string\|array\|Table $table)`                                 |
| on             | `on(​...$expr): Expression`                                                                       |
| using          | `using(​...$columns): IdentifierList`                                                             |

## Enum: Type
Namespaced name: `\TRP\BeaverQuery\Join\Type`

| Enum                    | SQL Keyword                |
| ----------------------- | -------------------------- |
| Type::Join              | `JOIN`                     |
| Type::Inner             | `INNER JOIN`               |
| Type::Cross             | `CROSS JOIN`               |
| Type::Straight          | `STRAIGHT_JOIN`            |
| Type::Left              | `LEFT JOIN`                |
| Type::LeftOuter         | `LEFT OUTER JOIN`          |
| Type::Right             | `RIGHT JOIN`               |
| Type::RightOuter        | `RIGHT OUTER JOIN`         |
| Type::Natural           | `NATURAL JOIN`             |
| Type::NaturalInner      | `NATURAL INNER JOIN`       |
| Type::NaturalLeft       | `NATURAL LEFT JOIN`        |
| Type::NaturalLeftOuter  | `NATURAL LEFT OUTER JOIN`  |
| Type::NaturalRight      | `NATURAL RIGHT JOIN`       |
| Type::NaturalRightOuter | `NATURAL RIGHT OUTER JOIN` |

---

# Namespace: `\TRP\BeaverQuery\Expression`

## Class: Expression
Namespaced name: `\TRP\BeaverQuery\Expression\Expression`

| Expression methods | Method signature                                                                   |
| ------------------ | ---------------------------------------------------------------------------------- |
| parse              | `static parse(​$expr): Expression`                                                  |
| map_parse          | `static map_parse(​array $expr): array`                                             |
| is                 | `is(​$expr, $allow_null = false): Expression`                                       |
| is_not             | `is_not(​$expr, $allow_null = false): Expression`                                   |
| is_null            | `is_null(): Expression`                                                            |
| is_not_null        | `is_not_null(): Expression`                                                        |
| in_range           | `in_range(​$from, $to, $start_inclusive = true, $end_inclusive = true): Expression` |
| between            | `between(​$from, $to): Expression`                                                  |
| lt                 | `lt(​$expr): Expression`                                                            |
| lteq               | `lteq(​$expr): Expression`                                                          |
| gt                 | `gt(​$expr): Expression`                                                            |
| gteq               | `gteq(​$expr): Expression`                                                          |
| eq                 | `eq(​$expr): Expression`                                                            |
| func               | `func(​string $function, ...$additional_arguments): Expression`                     |
| and                | `and(​$expr): Expression`                                                           |
| or                 | `or(​$expr): Expression`                                                            |
| xor                | `xor(​$expr): Expression`                                                           |
| print              | `print(​BindingStrength $outer_strength): string`                                   |

## Class: Identifier
Namespaced name: `\TRP\BeaverQuery\Expression\Identifier`
Extends: [Expression](#class-expression)

| Identifier methods     | Method signature                                                                             |
| ---------------------- | -------------------------------------------------------------------------------------------- |
| parse                  | `static parse(​$expr): Expression`                                                            |
| parse_strict           | `static parse_strict(​$expr, $context = null): Identifier`                                    |
| __construct            | `__construct(​string $name, ?string $alias = null, string\|Identifier\|null $context = null)` |
| print                  | `print(​BindingStrength $outer_strength): string`                                             |
| identifier             | `identifier(): string`                                                                       |
| identifier_with_alias  | `identifier_with_alias(): string`                                                            |
| identifier_unqualified | `identifier_unqualified(): string`                                                           |
| alias                  | `alias(​array $used_names): string`                                                           |

## Class: FunctionCall
Namespaced name: `\TRP\BeaverQuery\Expression\FunctionCall`
Extends: [Expression](#class-expression)

| FunctionCall methods | Method signature                                      |
| -------------------- | ----------------------------------------------------- |
| parse                | `static parse(​$name, ...$expr): FunctionCall`         |
| __construct          | `__construct(​string $name, Expression ...$arguments)` |


## Class: Operation
Namespaced name: `\TRP\BeaverQuery\Expression\Operation`
Extends: [Expression](#class-expression)

| Operation Factories           | Method signature                                                                          |
| ----------------------------- | ----------------------------------------------------------------------------------------- |
| is_op                         | `static is_op(​Expression $left, Expression $right): Operation`                            |
| is_not_op                     | `static is_not_op(​Expression $left, Expression $right): Operation`                        |
| between_op                    | `static between_op(​Expression $expr, Expression $left, Expression $right): Operation`     |
| not_between_op                | `static not_between_op(​Expression $expr, Expression $left, Expression $right): Operation` |
| like_op                       | `static like_op(​Expression $left, Expression $right): Operation`                          |
| not_like_op                   | `static not_like_op(​Expression $left, Expression $right): Operation`                      |
| compare_op                    | `static compare_op(​Expression $left, string $infix, Expression $right): Operation`        |
| asc_order                     | `static asc_order(​Expression $expr): Operation`                                           |
| desc_order                    | `static desc_order(​Expression $expr): Operation`                                          |
| assignment                    | `static assignment(​Expression $left, Expression $right): Operation`                       |

## Class: BooleanAnd
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanAnd`
Extends: [Expression](#class-expression)

| BooleanAnd methods    | Method signature                            |
| --------------------- | ------------------------------------------- |
| parse                 | `static parse(​...$expressions): Expression` |

## Class: BooleanOr
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanOr`
Extends: [Expression](#class-expression)

| BooleanOr methods | Method signature                            |
| ----------------- | ------------------------------------------- |
| parse             | `static parse(​...$expressions): Expression` |

## Class: BooleanXor
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanXor`
Extends: [Expression](#class-expression)

| BooleanXor methods | Method signature                            |
| ------------------ | ------------------------------------------- |
| parse              | `static parse(​...$expressions): Expression` |

## Class: Unsafe
Namespaced name: `\TRP\BeaverQuery\Expression\Unsafe`
Extends: [Expression](#class-expression)

> [!CAUTION]
> **Using `Unsafe` expressions circumvent all safety precautions and escaping.**\
> To prevent construction of `Unsafe` expressions call this method as early as possible in your execution:
> ```PHP
> \TRP\BeaverQuery\Expression\Unsafe::disable();
> ```

| Unsafe methods | Method signature                         |     |
| -------------- | ---------------------------------------- | --- |
| enable         | `static enable()`                        | Permanently enables using Unsafe expression objects for the duration of the script. Calling Unsafe::disable() later in execution will throw a BeaverQueryException |
| disable        | `static disable()`                       | Permanently disabled using Unsafe expression objects for the duration of the script. Calling Unsafe::enable() later in execution will throw a BeaverQueryException |
| unsafe         | `static unsafe(​string $raw_sql): Unsafe` | Use any string as an Expression object. No escaping or safety precautions are applied. |
