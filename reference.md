# Namespace: `\TRP\BeaverQuery`

## Class: BeaverQuery
Namespaced name: `\TRP\BeaverQuery\BeaverQuery`

| BeaverQuery Factories | Return Type                         | Method signature                                                                  |
| --------------------- | ----------------------------------- | --------------------------------------------------------------------------------- |
| insert                | [Insert](#class-insert)             | `static BeaverQuery::insert(​$table, array $columns = [], array ...$rows): Insert` |
| select                | [Select](#class-select)             | `static BeaverQuery::select(​$table = null, array $values = []): Select`           |
| update                | [Update](#class-update)             | `static BeaverQuery::update(​$table, ...$values): Update`                          |
| delete                | [Delete](#class-delete)             | `static BeaverQuery::delete(​$table, $where = null): Delete`                       |
| join                  | [Join](#class-join)                 | `static BeaverQuery::join(​$table, $type = 'JOIN'): Join`                          |
| table                 | [Table](#class-table)               | `static BeaverQuery::table(​$table, array $columns = []): Table`                   |
| name                  | [Identifier](#class-identifier)     | `static BeaverQuery::name(​string $name, ?string $subname = null): Identifier`     |
| func                  | [FunctionCall](#class-functioncall) | `static BeaverQuery::func(​string $name, ...$expressions): FunctionCall`           |
| and                   | [Expression](#class-expression)     | `static BeaverQuery::and(​...$expressions): Expression`                            |
| or                    | [Expression](#class-expression)     | `static BeaverQuery::or(​...$expressions): Expression`                             |
| xor                   | [Expression](#class-expression)     | `static BeaverQuery::xor(​...$expressions): Expression`                            |
| unsafe                | [Unsafe](#class-unsafe)             | `static BeaverQuery::unsafe(​string $raw_sql): Unsafe`                             |

| BeaverQuery Configuration | Method signature                                                      |
| ------------------------- | --------------------------------------------------------------------- |
| setDefaultDatabase        | `static BeaverQuery::setDefaultDatabase(​?string $database): void`     |
| getDefaultDatabase        | `static BeaverQuery::getDefaultDatabase(): ?string`                   |
| allowImplicitDatabase     | `static BeaverQuery::allowImplicitDatabase(​bool $allow = true): void` |

## Class: BeaverQueryException
Namespaced name: `\TRP\BeaverQuery\BeaverQueryException`
Extends: `\Exception`

---

# Namespace: `\TRP\BeaverQuery\Statement`

## Class: Insert
Namespaced name: `\TRP\BeaverQuery\Statement\Insert`

| Property | Type                  | Writable |
| -------- | --------------------- | -------- |
| `table`  | [Table](#class-table) | No       |

| Insert Methods | Method signature                                                                                                                  |
| -------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| __construct    | `__construct(​Table $table, bool $low_priority = false, bool $delayed = false, bool $high_priority = false, bool $ignore = false)` |
| columns        | `columns(​...$columns): Insert`                                                                                                    |
| values         | `values(​...$values): Insert`                                                                                                      |
| select         | `select(​$select, $values = []): Select`                                                                                           |
| dupl_values    | `dupl_values(​...$columns): Insert`                                                                                                |
| dupl           | `dupl(​...$values): Insert`                                                                                                        |
| print          | `print(): string`                                                                                                                 |
| set            | `set(​...$values): Insert`                                                                                                         |

## Class: Select
Namespaced name: `\TRP\BeaverQuery\Statement\Select`

| Property   | Type                                      | Writable |
| ---------- | ----------------------------------------- | -------- |
| `table`    | [Table](#class-table)                     | No       |
| `where`    | [ExpressionProxy](#class-expressionproxy) | No       |
| `order_by` | [ExpressionProxy](#class-expressionproxy) | No       |
| `group_by` | [ExpressionProxy](#class-expressionproxy) | No       |
| `having`   | [ExpressionProxy](#class-expressionproxy) | No       |

| Select Methods | Method signature                                        |
| -------------- | ------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, array $values = [])` |
| from           | `from(​Table\|array\|string $table): Table`              |
| columns        | `columns(​...$columns): Select`                          |
| print          | `print(): string`                                       |
| join           | `join(​Join $join): Join`                                |
| left_join      | `left_join(​$table, $condition): Join`                   |
| right_join     | `right_join(​$table, $condition): Join`                  |
| inner_join     | `inner_join(​$table, $condition = null): Join`           |
| where          | `where(​...$expr): Select`                               |
| where_proxy    | `where_proxy(): ExpressionProxy`                        |
| order_by       | `order_by(​...$expr): Select`                            |
| order_by_proxy | `order_by_proxy(): ExpressionProxy`                     |
| group_by       | `group_by(​...$expr): Select`                            |
| group_by_proxy | `group_by_proxy(): ExpressionProxy`                     |
| having         | `having(​...$expr): Select`                              |
| having_proxy   | `having_proxy(): ExpressionProxy`                       |
| limit          | `limit(​?int $limit): Select`                            |
| offset         | `offset(​?int $offset): Select`                          |

## Class: Update
Namespaced name: `\TRP\BeaverQuery\Statement\Update`

| Property   | Type                                      | Writable |
| ---------- | ----------------------------------------- | -------- |
| `table`    | [Table](#class-table)                     | No       |
| `where`    | [ExpressionProxy](#class-expressionproxy) | No       |
| `order_by` | [ExpressionProxy](#class-expressionproxy) | No       |

| Update Methods | Method signature                                                                      |
| -------------- | ------------------------------------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, bool $low_priority = false, bool $ignore = false)` |
| print          | `print(): string`                                                                     |
| set            | `set(​...$values): Update`                                                             |
| join           | `join(​Join $join): Join`                                                              |
| left_join      | `left_join(​$table, $condition): Join`                                                 |
| right_join     | `right_join(​$table, $condition): Join`                                                |
| inner_join     | `inner_join(​$table, $condition = null): Join`                                         |
| where          | `where(​...$expr): Update`                                                             |
| where_proxy    | `where_proxy(): ExpressionProxy`                                                      |
| order_by       | `order_by(​...$expr): Update`                                                          |
| order_by_proxy | `order_by_proxy(): ExpressionProxy`                                                   |
| limit          | `limit(​?int $limit): Update`                                                          |

## Class: Delete
Namespaced name: `\TRP\BeaverQuery\Statement\Delete`

| Property   | Type                                      | Writable |
| ---------- | ----------------------------------------- | -------- |
| `table`    | [Table](#class-table)                     | No       |
| `where`    | [ExpressionProxy](#class-expressionproxy) | No       |
| `order_by` | [ExpressionProxy](#class-expressionproxy) | No       |

| Delete Methods | Method signature                                                                                           |
| -------------- | ---------------------------------------------------------------------------------------------------------- |
| __construct    | `__construct(​?Table $table = null, bool $low_priority = false, bool $quick = false, bool $ignore = false)` |
| print          | `print(): string`                                                                                          |
| where          | `where(​...$expr): Delete`                                                                                  |
| where_proxy    | `where_proxy(): ExpressionProxy`                                                                           |
| order_by       | `order_by(​...$expr): Delete`                                                                               |
| order_by_proxy | `order_by_proxy(): ExpressionProxy`                                                                        |
| limit          | `limit(​?int $limit): Delete`                                                                               |

## Class: Table
Namespaced name: `\TRP\BeaverQuery\Table`

| Table Factories | Return Type | Method signature                                                                    |
| --------------- | ----------- | ----------------------------------------------------------------------------------- |
| parse           | Table       | `static parse(​Table\|array\|string $table, bool $implicit_database = false): Table` |

| Table Methods   | Method signature                                                                                              |
| --------------- | ------------------------------------------------------------------------------------------------------------- |
| __construct     | `__construct(​string $name, ?string $alias = null, ?string $database = null, bool $implicit_database = false)` |
| columns         | `columns(​Column\|array\|string ...$column_list): Table`                                                       |
| select          | `select(): Select`                                                                                            |
| insert          | `insert(): Insert`                                                                                            |
| update          | `update(): Update`                                                                                            |
| delete          | `delete(): Delete`                                                                                            |
| get_name        | `get_name(): Identifier`                                                                                      |
| set_alias       | `set_alias(​string $name)`                                                                                     |
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

| Join Factories | Return Type | Method signature                                                                                  |
| -------------- | ----------- | ------------------------------------------------------------------------------------------------- |
| left_join      | Join        | `static left_join(​Table\|array\|string $table, $on = null, $using = null): Join`                  |
| right_join     | Join        | `static right_join(​Table\|array\|string $table, $on = null, $using = null): Join`                 |
| inner_join     | Join        | `static inner_join(​Table\|array\|string $table, $on = null, $using = null): Join`                 |
| specified_join | Join        | `static specified_join(​Type $type, Table\|array\|string $table, $on = null, $using = null): Join` |

| Join Methods | Method signature                                       |
| ------------ | ------------------------------------------------------ |
| __construct  | `__construct(​Type $type, Table\|array\|string $table)` |
| on           | `on(​...$expr): Expression`                             |
| using        | `using(​...$columns): IdentifierList`                   |

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

| Type Factories | Return Type | Method signature                                  |
| -------------- | ----------- | ------------------------------------------------- |
| parse          | Type        | `static parse(​self\|string $type): Type`          |
| cases          | array       | `static cases(): array`                           |
| from           | Type        | `static from(​string\|int $value): Type`           |
| tryFrom        | Type        | `static Type::tryFrom(​string\|int $value): ?Type` |

| Type Methods           | Method signature                 |
| ---------------------- | -------------------------------- |
| requires_specification | `requires_specification(): bool` |
| allows_specification   | `allows_specification(): bool`   |

---

# Namespace: `\TRP\BeaverQuery\Expression`

## Class: Expression
Namespaced name: `\TRP\BeaverQuery\Expression\Expression`

| Expression Factories | Return Type | Method signature                       |
| -------------------- | ----------- | -------------------------------------- |
| parse                | Expression  | `static parse(​$expr): Expression`      |
| map_parse            | array       | `static map_parse(​array $expr): array` |

| Expression Methods | Method signature                                                                   |
| ------------------ | ---------------------------------------------------------------------------------- |
| as                 | `as(​string $alias): ExpressionAlias`                                               |
| is                 | `is(​$expr, $allow_null = false): Expression`                                       |
| is_not             | `is_not(​$expr, $allow_null = false): Expression`                                   |
| is_null            | `is_null(): Expression`                                                            |
| is_not_null        | `is_not_null(): Expression`                                                        |
| in_range           | `in_range(​$from, $to, $start_inclusive = true, $end_inclusive = true): Expression` |
| between            | `between(​$from, $to): Expression`                                                  |
| lt                 | `lt(​$expr): Expression`                                                            |
| lteq               | `lteq(​$expr): Expression`                                                          |
| gt                 | `gt(​$expr): Expression`                                                            |
| gteq               | `gteq(​$expr): Expression`                                                          |
| eq                 | `eq(​$expr): Expression`                                                            |
| not_eq             | `not_eq(​$expr): Expression`                                                        |
| eq_nullsafe        | `eq_nullsafe(​$expr): Expression`                                                   |
| in                 | `in(​array $list): Expression`                                                      |
| not_in             | `not_in(​array $list): Expression`                                                  |
| func               | `func(​string $function, ...$additional_arguments): Expression`                     |
| and                | `and(​...$expr): Expression`                                                        |
| or                 | `or(​...$expr): Expression`                                                         |
| xor                | `xor(​...$expr): Expression`                                                        |
| print              | `print(​BindingStrength $outer_strength): string`                                   |

## Class: Atom
Namespaced name: `\TRP\BeaverQuery\Expression\Atom`
Extends: [Expression](#class-expression)

| Atom Factories | Return Type | Method signature                     |
| -------------- | ----------- | ------------------------------------ |
| literal        | Atom        | `static literal(​mixed $value): Atom` |

| Atom Methods | Method signature                                 |
| ------------ | ------------------------------------------------ |
| print        | `print(​BindingStrength $outer_strength): string` |

## Class: Identifier
Namespaced name: `\TRP\BeaverQuery\Expression\Identifier`
Extends: [Atom](#class-atom)

| Identifier Factories | Return Type                     | Method signature                                               |
| -------------------- | ------------------------------- | -------------------------------------------------------------- |
| parse                | [Expression](#class-expression) | `static Identifier::parse(​$expr, $context = null): Expression` |
| parse_strict         | Identifier                      | `static parse_strict(​$expr, $context = null): Identifier`      |

| Identifier Methods     | Method signature                                                                             |
| ---------------------- | -------------------------------------------------------------------------------------------- |
| __construct            | `__construct(​string $name, ?string $alias = null, Identifier\|string\|null $context = null)` |
| set_alias              | `set_alias(​string $alias)`                                                                   |
| print                  | `print(​BindingStrength $outer_strength): string`                                             |
| identifier             | `identifier(): string`                                                                       |
| identifier_with_alias  | `identifier_with_alias(): string`                                                            |
| identifier_unqualified | `identifier_unqualified(): string`                                                           |
| alias                  | `alias(​array $used_names = []): string`                                                      |

## Class: FunctionCall
Namespaced name: `\TRP\BeaverQuery\Expression\FunctionCall`
Extends: [Atom](#class-atom)

| FunctionCall Factories | Return Type  | Method signature                              |
| ---------------------- | ------------ | --------------------------------------------- |
| parse                  | FunctionCall | `static parse(​$name, ...$expr): FunctionCall` |

| FunctionCall Methods | Method signature                                      |
| -------------------- | ----------------------------------------------------- |
| __construct          | `__construct(​string $name, Expression ...$arguments)` |

## Class: Operation
Namespaced name: `\TRP\BeaverQuery\Expression\Operation`
Extends: [Expression](#class-expression)

| Operation Factories | Return Type | Method signature                                                                          |
| ------------------- | ----------- | ----------------------------------------------------------------------------------------- |
| is_op               | Operation   | `static is_op(​Expression $left, Expression $right): Operation`                            |
| is_not_op           | Operation   | `static is_not_op(​Expression $left, Expression $right): Operation`                        |
| between_op          | Operation   | `static between_op(​Expression $expr, Expression $left, Expression $right): Operation`     |
| not_between_op      | Operation   | `static not_between_op(​Expression $expr, Expression $left, Expression $right): Operation` |
| like_op             | Operation   | `static like_op(​Expression $left, Expression $right): Operation`                          |
| not_like_op         | Operation   | `static not_like_op(​Expression $left, Expression $right): Operation`                      |
| compare_op          | Operation   | `static compare_op(​Expression $left, string $infix, Expression $right): Operation`        |
| in_op               | Operation   | `static in_op(​Expression $left, ArgumentList $list): Operation`                           |
| asc_order           | Operation   | `static asc_order(​Expression $expr): Operation`                                           |
| desc_order          | Operation   | `static desc_order(​Expression $expr): Operation`                                          |
| assignment          | Operation   | `static assignment(​Expression $left, Expression $right): Operation`                       |

## Class: BooleanAnd
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanAnd`
Extends: [Expression](#class-expression)

| BooleanAnd Factories | Return Type                     | Method signature                                 |
| -------------------- | ------------------------------- | ------------------------------------------------ |
| parse                | [Expression](#class-expression) | `static BooleanAnd::parse(​...$expr): Expression` |

| BooleanAnd Methods | Method signature            |
| ------------------ | --------------------------- |
| and                | `and(​...$expr): Expression` |

## Class: BooleanOr
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanOr`
Extends: [Expression](#class-expression)

| BooleanOr Factories | Return Type                     | Method signature                                |
| ------------------- | ------------------------------- | ----------------------------------------------- |
| parse               | [Expression](#class-expression) | `static BooleanOr::parse(​...$expr): Expression` |

| BooleanOr Methods | Method signature           |
| ----------------- | -------------------------- |
| or                | `or(​...$expr): Expression` |

## Class: BooleanXor
Namespaced name: `\TRP\BeaverQuery\Expression\BooleanXor`
Extends: [Expression](#class-expression)

| BooleanXor Factories | Return Type                     | Method signature                                 |
| -------------------- | ------------------------------- | ------------------------------------------------ |
| parse                | [Expression](#class-expression) | `static BooleanXor::parse(​...$expr): Expression` |

| BooleanXor Methods | Method signature            |
| ------------------ | --------------------------- |
| xor                | `xor(​...$expr): Expression` |

## Class: Unsafe
Namespaced name: `\TRP\BeaverQuery\Expression\Unsafe`

> [!CAUTION]
> **Using `Unsafe` expressions circumvent all safety precautions and escaping.**\
> To prevent construction of `Unsafe` expressions call this method as early as possible in your execution:
> ```PHP
> \TRP\BeaverQuery\Expression\Unsafe::disable();
> ```

| Unsafe Factories | Return Type                     | Method signature                          |                                                                                        |
| ---------------- | ------------------------------- | ----------------------------------------- | -------------------------------------------------------------------------------------- |
| unsafe           | Unsafe                          | `static unsafe(​string $raw_sql): Unsafe`  | Use any string as an Expression object. No escaping or safety precautions are applied. |
| parse            | [Expression](#class-expression) | `static Unsafe::parse(​$expr): Expression` |                                                                                        |
| map_parse        | array                           | `static map_parse(​array $expr): array`    |                                                                                        |

| Unsafe Configuration | Method signature           |                                                                                                                                                                    |
| -------------------- | -------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| enable               | `static Unsafe::enable()`  | Permanently enables using Unsafe expression objects for the duration of the script. Calling Unsafe::disable() later in execution will throw a BeaverQueryException |
| disable              | `static Unsafe::disable()` | Permanently disabled using Unsafe expression objects for the duration of the script. Calling Unsafe::enable() later in execution will throw a BeaverQueryException |

| Unsafe Methods | Method signature                                                                   |
| -------------- | ---------------------------------------------------------------------------------- |
| as             | `as(​string $alias): ExpressionAlias`                                               |
| is             | `is(​$expr, $allow_null = false): Expression`                                       |
| is_not         | `is_not(​$expr, $allow_null = false): Expression`                                   |
| is_null        | `is_null(): Expression`                                                            |
| is_not_null    | `is_not_null(): Expression`                                                        |
| in_range       | `in_range(​$from, $to, $start_inclusive = true, $end_inclusive = true): Expression` |
| between        | `between(​$from, $to): Expression`                                                  |
| lt             | `lt(​$expr): Expression`                                                            |
| lteq           | `lteq(​$expr): Expression`                                                          |
| gt             | `gt(​$expr): Expression`                                                            |
| gteq           | `gteq(​$expr): Expression`                                                          |
| eq             | `eq(​$expr): Expression`                                                            |
| not_eq         | `not_eq(​$expr): Expression`                                                        |
| eq_nullsafe    | `eq_nullsafe(​$expr): Expression`                                                   |
| in             | `in(​array $list): Expression`                                                      |
| not_in         | `not_in(​array $list): Expression`                                                  |
| func           | `func(​string $function, ...$additional_arguments): Expression`                     |
| and            | `and(​...$expr): Expression`                                                        |
| or             | `or(​...$expr): Expression`                                                         |
| xor            | `xor(​...$expr): Expression`                                                        |
| print          | `print(​BindingStrength $outer_strength): string`                                   |

