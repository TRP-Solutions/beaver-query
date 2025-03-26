# BeaverQuery
A standalone SQL builder library.

## Usage
Simple select statements can be generated directly using static methods on the [BeaverQuery](reference.md#class-beaverquery) class.
```PHP
use \TRP\BeaverQuery\BeaverQuery as BQ;
$sql = BQ::select('staff',['id','name','username','birthday']);
```
Output when `$sql` is converted to a string:
```SQL
SELECT
  `staff`.`id`,
  `staff`.`name`,
  `staff`.`username`,
  `staff`.`birthday`
FROM
  `test`.`staff`;
```

```PHP
use \TRP\BeaverQuery\BeaverQuery as BQ;
$sql = BQ::insert(
	'staff',
	['id','name','username','birthday'],
	[1, 'John', 'john', '2000-12-31'],
	[2, 'Jane', 'jane', '2000-06-15']
);
```
Output when `$sql` is converted to a string:
```SQL
INSERT INTO `test`.`staff`
(`id`,`name`,`username`,`birthday`)
VALUES
(1,'John','john','2000-12-31'),
(2,'Jane','jane','2000-06-15');
```

Expressions can be build by starting from a table ([Table](reference.md#class-table)) or a name ([Identifier](reference.md#class-identifier)).
```PHP
use \TRP\BeaverQuery\BeaverQuery as BQ;
$staff = BQ::table('staff',['id','name','username','birthday']);
$has_birthday = $staff->birthday->eq(BQ::func('TODAY'));
$sql = $staff->select()->where($has_birthday);
```
Output when `$sql` is converted to a string:
```SQL
SELECT
  `staff`.`id`,
  `staff`.`name`,
  `staff`.`username`,
  `staff`.`birthday`
FROM
  `test`.`staff`
WHERE
  `staff`.`birthday` = TODAY();
```

```PHP
use \TRP\BeaverQuery\BeaverQuery as BQ;
$january_birthday = BQ::func('MONTH', BQ::name('staff','birthday'))->eq(1);
$sql = BQ::select('staff',['id','name','username','birthday'])->where($january_birthday);
```
Output when `$sql` is converted to a string:
```SQL
SELECT
  `staff`.`id`,
  `staff`.`name`,
  `staff`.`username`,
  `staff`.`birthday`
FROM
  `test`.`staff`
WHERE
  MONTH(`staff`.`birthday`) = 1;
```

Strings passed into expression building methods are automatically escaped.

> [!NOTE]
> Any character that isn't valid UTF-8 is replaced with the substitute character specified by `mb_substitute_character`.

```PHP
use \TRP\BeaverQuery\BeaverQuery as BQ;
$client_supplied_string = "Robert'); DROP TABLE Students;-- \x00 \x0A \x0D \x1A \x22 \x27 \x5C \x60";
$name_match = BQ::func('MONTH', BQ::name('staff','name'))->eq($client_supplied_string);
$sql = BQ::select('staff',['id','name','username','birthday'])->where($name_match);
```
Output when `$sql` is converted to a string:
```SQL
SELECT
  `staff`.`id`,
  `staff`.`name`,
  `staff`.`username`,
  `staff`.`birthday`
FROM
  `test`.`staff`
WHERE
  MONTH(`staff`.`name`) = 'Robert\'); DROP TABLE Students;-- \0 \n \r \Z " \' \\ `';
```

## Reference

See [reference.md](reference.md) for reference of namespaces, classes, and methods.