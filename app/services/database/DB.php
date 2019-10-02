<?php

namespace App\services\database;

use App\services\core\Validate;

/**
 * Class DB
 *
 * TODO: Find out how these functions works
 * 1. Case
 * 2. Select into
 * 3. Insert into select
 *
 * @package App\services\database
 */
class DB
{
    /**
     * @var \PDO|null
     */
    private $pdo = null;

    /**
     * @var string
     */
    private static $table = null;

    /**
     * @var int
     */
    private static $quantityInnerJoins = 0;

    /**
     * @var string
     */
    private $query = null;

    /**
     * @var array
     */
    private $values = [];

    private function __construct()
    {
        $this->pdo = ConnectDB::getInstance()->getConnection();
    }

    /**
     * Set the table to use in the queries.
     *
     * @param string $table
     * @param int $quantityInnerJoins
     * @return bool|DB
     */
    public static function table(string $table, int $quantityInnerJoins = 0)
    {
        if (Validate::variable($table, Validate::IS_STRING)) {
            self::$table = $table;
            self::$quantityInnerJoins = $quantityInnerJoins;

            return new self;
        }

        return false;
    }

    /**
     * The SELECT statement is used to select data from a database.
     * The data returned is stored in a result table, called the result-set.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function select(...$columns)
    {
        if (
            Validate::variable($columns, Validate::IS_ARRAY) ||
            Validate::variable($columns, Validate::IS_STRING)
        ) {
            $columns = implode(', ', $columns);
            $hooks = '';
            for ($x = 0; $x < self::$quantityInnerJoins; $x++) {
                $hooks .= '(';
            }

            $this->query .= "SELECT {$columns} FROM {$hooks}" . self::$table . ' ';

            return $this;
        }

        return false;
    }

    /**
     * The SELECT INTO statement copies data from one table into a new table.
     * TODO: find out how this query works.
     *
     * @param string $newTable
     * @param string $externalDB
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectInto(string $newTable, string $externalDB, ...$columns)
    {
        if (
            Validate::variable($columns, Validate::IS_ARRAY) ||
            Validate::variable($columns, Validate::IS_STRING) &&
            Validate::variable($newTable, Validate::IS_STRING)
        ) {
            $columns = implode(', ', $columns);
            if (!empty($externalDB)) {
                $this->query .= "SELECT {$columns} INTO {$newTable} IN {$externalDB} FROM " . self::$table . ' ';
            } else {
                $this->query .= "SELECT {$columns} INTO {$newTable} FROM " . self::$table . ' ';
            }

            return $this;
        }

        return false;
    }

    /**
     * The UNION operator is used to combine the result-set of two or more SELECT statements.
     *  - Each SELECT statement within UNION must have the same number of columns
     *  - The columns must also have similar data types
     *  - The columns in each SELECT statement must also be in the same order
     *
     * The UNION operator selects only distinct values by default. To allow duplicate values, use UNION ALL:
     *
     * @param string $table
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectUnion(string $table, ...$columns)
    {
        if (
            Validate::variable($columns, Validate::IS_ARRAY) ||
            Validate::variable($columns, Validate::IS_STRING)
        ) {
            $columns = implode(', ', $columns);
            $this->query .= "UNION SELECT {$columns} FROM {$table} ";

            return $this;
        }

        return false;
    }

    /**
     * The UNION operator is used to combine the result-set of two or more SELECT statements.
     *  - Each SELECT statement within UNION must have the same number of columns
     *  - The columns must also have similar data types
     *  - The columns in each SELECT statement must also be in the same order
     *
     * The UNION operator selects only distinct values by default. To allow duplicate values, use UNION ALL:
     *
     * @param string $table
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectUnionAll(string $table, ...$columns)
    {
        if (
            Validate::variable($columns, Validate::IS_ARRAY) ||
            Validate::variable($columns, Validate::IS_STRING)
        ) {
            $columns = implode(', ', $columns);
            $this->query .= "UNION ALL SELECT {$columns} FROM {$table} ";

            return $this;
        }

        return false;
    }

    /**
     * The SELECT DISTINCT statement is used to return only distinct (different) values.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectDistinct(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT DISTINCT {$columns} FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The MIN() function returns the smallest value of the selected column.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectMin(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT MIN({$columns}) FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The MAX() function returns the largest value of the selected column.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectMax(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT MAX({$columns}) FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The COUNT() function returns the number of rows that matches a specified criteria.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectCount(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT COUNT({$columns}) FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The AVG() function returns the average value of a numeric column.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectAvg(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT AVG({$columns}) FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The SUM() function returns the total sum of a numeric column.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function selectSum(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "SELECT SUM({$columns}) FROM " . self::$table;

            return $this;
        }

        return false;
    }

    /**
     * The INNER JOIN keyword selects records that have matching values in both tables.
     *
     * @param string $table
     * @param string $tableOneColumn
     * @param string $tableTwoColumn
     * @return $this|bool
     */
    public function innerJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        if (
            Validate::variable($table, Validate::IS_STRING) &&
            Validate::variable($tableOneColumn, Validate::IS_STRING) &&
            Validate::variable($tableTwoColumn, Validate::IS_STRING)
        ) {
            $hook = '';
            if (!empty(self::$quantityInnerJoins)) {
                $hook = ')';
            }

            $this->query .= "INNER JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

            return $this;
        }

        return false;
    }

    /**
     * The LEFT JOIN keyword returns all records from the left table (table1),
     * and the matched records from the right table (table2).
     * The result is NULL from the right side, if there is no match.
     *
     * @param string $table
     * @param string $tableOneColumn
     * @param string $tableTwoColumn
     * @return $this|bool
     */
    public function leftJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        if (
            Validate::variable($table, Validate::IS_STRING) &&
            Validate::variable($tableOneColumn, Validate::IS_STRING) &&
            Validate::variable($tableTwoColumn, Validate::IS_STRING)
        ) {
            $hook = '';
            if (!empty(self::$quantityInnerJoins)) {
                $hook = ')';
            }

            $this->query .= "LEFT JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

            return $this;
        }

        return false;
    }

    /**
     * The RIGHT JOIN keyword returns all records from the right table (table2),
     * and the matched records from the left table (table1).
     * The result is NULL from the left side, when there is no match.
     *
     * @param string $table
     * @param string $tableOneColumn
     * @param string $tableTwoColumn
     * @return $this|bool
     */
    public function rightJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        if (
            Validate::variable($table, Validate::IS_STRING) &&
            Validate::variable($tableOneColumn, Validate::IS_STRING) &&
            Validate::variable($tableTwoColumn, Validate::IS_STRING)
        ) {
            $hook = '';
            if (!empty(self::$quantityInnerJoins)) {
                $hook = ')';
            }

            $this->query .= "RIGHT JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

            return $this;
        }

        return false;
    }

    /**
     * The FULL OUTER JOIN keyword return all records when
     * there is a match in either left (table1) or right (table2) table records.
     *
     * @param string $table
     * @param string $tableOneColumn
     * @param string $tableTwoColumn
     * @return $this|bool
     */
    public function fullOuterJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        if (
            Validate::variable($table, Validate::IS_STRING) &&
            Validate::variable($tableOneColumn, Validate::IS_STRING) &&
            Validate::variable($tableTwoColumn, Validate::IS_STRING)
        ) {
            $hook = '';
            if (!empty(self::$quantityInnerJoins)) {
                $hook = ')';
            }

            $this->query .= "FULL OUTER JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

            return $this;
        }

        return false;
    }

    /**
     * The WHERE clause is used to filter records.
     * The WHERE clause is used to extract only those records that fulfill a specified condition.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $condition
     * @return $this|bool
     */
    public function where(string $column, string $operator, $condition)
    {
        if (
            Validate::variable($column, Validate::IS_STRING) &&
            Validate::variable($operator, Validate::IS_STRING)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} {$operator} :{$column} ";
            } else {
                $this->query .= "AND {$column} {$operator} :{$column} ";
            }

            // set the values
            $this->values += [$column => $condition];

            return $this;
        }

        return false;
    }

    /**
     * The EXISTS operator is used to test for the existence of any record in a sub query.
     * The EXISTS operator returns true if the sub query returns one or more records.
     *
     * @param string $query
     * @param array $values
     * @return $this|bool
     */
    public function whereExists(string $query, array $values)
    {
        if (
            Validate::variable($query, Validate::IS_STRING) &&
            Validate::variable($values, Validate::IS_ARRAY)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE EXISTS ({$query}) ";
            } else {
                $this->query .= "AND EXISTS ({$query}) ";
            }

            foreach ($values as $column => $value) {
                $this->values += [$column => $value];
            }

            return $this;
        }

        return false;
    }

    /**
     * The ANY and ALL operators are used with a WHERE or HAVING clause.
     * The ANY operator returns true if any of the sub query values meet the condition.
     * The ALL operator returns true if all of the sub query values meet the condition.
     *
     * @param string $column
     * @param string $operator
     * @param string $query
     * @param array $values
     * @return $this|bool
     */
    public function whereAny(string $column, string $operator, string $query, array $values)
    {
        if (
            Validate::variable($query, Validate::IS_STRING) &&
            Validate::variable($values, Validate::IS_ARRAY)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} {$operator} ANY ({$query}) ";
            } else {
                $this->query .= "AND {$column} {$operator} ANY ({$query}) ";
            }

            foreach ($values as $column => $value) {
                $this->values += [$column => $value];
            }

            return $this;
        }

        return false;
    }

    /**
     * The ANY and ALL operators are used with a WHERE or HAVING clause.
     * The ANY operator returns true if any of the sub query values meet the condition.
     * The ALL operator returns true if all of the sub query values meet the condition.
     *
     * @param string $column
     * @param string $operator
     * @param string $query
     * @param array $values
     * @return $this|bool
     */
    public function whereAll(string $column, string $operator, string $query, array $values)
    {
        if (
            Validate::variable($query, Validate::IS_STRING) &&
            Validate::variable($values, Validate::IS_ARRAY)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} {$operator} ALL ({$query}) ";
            } else {
                $this->query .= "AND {$column} {$operator} ALL ({$query}) ";
            }

            foreach ($values as $column => $value) {
                $this->values += [$column => $value];
            }

            return $this;
        }

        return false;
    }

    /**
     * Add where not statement to the query.
     *
     * @param string $column
     * @param string $operator
     * @param $condition
     * @return $this|bool
     */
    public function whereNot(string $column, string $operator, $condition)
    {
        if (
            Validate::variable($column, Validate::IS_STRING) &&
            Validate::variable($operator, Validate::IS_STRING)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE NOT {$column} {$operator} :{$column} ";
            } else {
                $this->query .= "AND NOT {$column} {$operator} :{$column} ";
            }

            // set the values
            $this->values += [$column => $condition];

            return $this;
        }

        return false;
    }

    /**
     * The IS NULL operator is used to test for empty values (NULL values).
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function whereIsNull(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$columns} IS NULL ";
            } else {
                $this->query .= "AND {$columns} IS NULL";
            }

            return $this;
        }

        return false;
    }

    /**
     * The IS NOT NULL operator is used to test for empty values (NULL values).
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function whereIsNotNull(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$columns} IS NOT NULL ";
            } else {
                $this->query .= "AND {$columns} IS NOT NULL";
            }

            return $this;
        }

        return false;
    }

    /**
     * The IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column
     * @param mixed ...$condition
     * @return $this|bool
     */
    public function whereInValue(string $column, ...$condition)
    {
        if (
        Validate::variable($column, Validate::IS_STRING)
        ) {
            // set the query
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} IN (:{$column}) ";
            } else {
                $this->query .= "AND {$column} IN (:{$column}) ";
            }

            // set the values
            $this->values += [$column => $condition];

            return $this;
        }

        return false;
    }

    /**
     * The NOT IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column
     * @param mixed ...$condition
     * @return $this|bool
     */
    public function whereNotInValue(string $column, ...$condition)
    {
        if (
        Validate::variable($column, Validate::IS_STRING)
        ) {
            // set the query
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} NOT IN (:{$column}) ";
            } else {
                $this->query .= "AND {$column} NOT IN (:{$column}) ";
            }

            // set the values
            $this->values += [$column => $condition];

            return $this;
        }

        return false;
    }

    /**
     * Add where or statement to the query.
     *
     * @param string $column
     * @param mixed ...$values
     * @return $this|bool
     */
    public function whereOr(string $column, ...$values)
    {
        if (
            Validate::variable($column, Validate::IS_STRING) &&
            Validate::variable($values, Validate::IS_ARRAY)
        ) {
            $query = '';
            foreach ($values as $key => $value) {
                // set the query
                if (strpos($this->query, 'WHERE') === false) {
                    if (strpos($query, 'OR') === false) {
                        $query .= "WHERE ({$column} = :" . $column . $key . " ";
                    } else {
                        $query .= " OR {$column} = :" . $column . $key . " ";
                    }
                } else {
                    if (strpos($query, 'OR') === false) {
                        $query .= "AND ({$column} = :" . $column . $key . " OR ";
                    } else {
                        $query .= "{$column} = :" . $column . $key . " ";
                    }
                }

                // set the values
                $this->values += [$column . $key => "{$value}"];
            }
            $query .= ') ';
            $this->query .= $query;

            return $this;
        }

        return false;
    }

    /**
     * The IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column
     * @param string $query
     * @param array $values
     * @return $this|bool
     */
    public function whereInQuery(string $column, string $query, array $values)
    {
        if (
            Validate::variable($column, Validate::IS_STRING) &&
            Validate::variable($query, Validate::IS_STRING)
        ) {
            // set the query
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} IN ({$query}) ";
            } else {
                $this->query .= "AND {$column} IN ({$query}) ";
            }

            // set the values
            if (is_array($values)) {
                foreach ($values as $key => $value) {
                    $this->values[$key] = $value;
                }
            }

            return $this;
        }

        return false;
    }

    /**
     * The BETWEEN operator selects values within a given range. The values can be numbers, text, or dates.
     * The BETWEEN operator is inclusive: begin and end values are included.
     *
     * @param string $column
     * @param $value1
     * @param $value2
     * @return $this|bool
     */
    public function whereBetween(string $column, $value1, $value2)
    {
        if (
        Validate::variable($column, Validate::IS_STRING)
        ) {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= "WHERE {$column} BETWEEN :{$column}1 AND :{$column}2 ";
            } else {
                $this->query .= "AND {$column} BETWEEN :{$column}1 AND :{$column}2 ";
            }

            // set the values
            $this->values += [
                $column . '1' => $value1,
                $column . '2' => $value2
            ];

            return $this;
        }

        return false;
    }

    /**
     * The HAVING clause was added to SQL because the WHERE keyword could not be used with aggregate functions.
     *
     * @param mixed ...$conditions
     * @return $this|bool
     */
    public function having(...$conditions)
    {
        if (Validate::variable($conditions, Validate::IS_ARRAY)) {
            $conditions = implode(', ', $conditions);
            $this->query .= "HAVING {$conditions} ";

            return $this;
        }

        return false;
    }

    /**
     * The CASE statement goes through conditions and return a value when the first condition is met
     * (like an IF-THEN-ELSE statement). So, once a condition is true, it will stop reading and return the result.
     * If no conditions are true, it returns the value in the ELSE clause.
     * If there is no ELSE part and no conditions are true, it returns NULL.
     *
     * @param string $condition
     * @param string $then
     * @return $this|bool
     */
    public function caseWhen(string $condition, string $then)
    {
        if (
            Validate::variable($condition, Validate::IS_STRING) &&
            Validate::variable($then, Validate::IS_STRING)
        ) {
            if (strpos($this->query, 'CASE') === false) {
                $this->query .= " CASE WHEN {$condition} THEN '{$then}' ";
            } else {
                $this->query .= " WHEN {$condition} THEN '{$then}' ";
            }

            return $this;
        }

        return false;
    }

    /**
     * The CASE statement goes through conditions and return a value when the first condition is met
     * (like an IF-THEN-ELSE statement). So, once a condition is true, it will stop reading and return the result.
     * If no conditions are true, it returns the value in the ELSE clause.
     * If there is no ELSE part and no conditions are true, it returns NULL.
     *
     * @param string $else
     * @return $this|bool
     */
    public function caseElse(string $else)
    {
        if (Validate::variable($else, Validate::IS_STRING)) {
            $this->query .= " ELSE '{$else}' ";

            return $this;
        }

        return false;
    }

    /**
     * The CASE statement goes through conditions and return a value when the first condition is met
     * (like an IF-THEN-ELSE statement). So, once a condition is true, it will stop reading and return the result.
     * If no conditions are true, it returns the value in the ELSE clause.
     * If there is no ELSE part and no conditions are true, it returns NULL.
     *
     * @param string $asColumn
     * @return $this
     */
    public function caseEnd(string $asColumn)
    {
        $this->query .= " END AS {$asColumn}";

        return $this;
    }

    /**
     * The INSERT INTO statement is used to insert new records in a table.
     *
     * @param array $values
     * @return $this|bool
     */
    public function insert(array $values)
    {
        if (Validate::variable($values, Validate::IS_ARRAY)) {
            // separate the keys => columns from the array
            $columns = array_keys($values);

            // set the query
            $this->query .= "INSERT INTO " . self::$table;
            $this->query .= " (" . implode(', ', $columns) . ")";
            $this->query .= " VALUES (:" . implode(', :', $columns) . ") ";

            // set the values
            $this->values += $values;

            return $this;
        }

        return false;
    }

    /**
     * The INSERT INTO SELECT statement copies data from one table and inserts it into another table.
     * 1. INSERT INTO SELECT requires that data types in source and target tables match
     * 2. The existing records in the target table are unaffected
     *
     * TODO: find out how this query works.
     *
     * @param string $newTable
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function insertSelectInto(string $newTable, ...$columns)
    {
        if (
            Validate::variable($columns, Validate::IS_ARRAY) ||
            Validate::variable($columns, Validate::IS_STRING) &&
            Validate::variable($newTable, Validate::IS_STRING)
        ) {
            $columns = implode(', ', $columns);
            $this->query .= "INSERT INTO {$newTable} SELECT {$columns} INTO {$newTable} FROM " . self::$table . ' ';

            return $this;
        }

        return false;
    }

    /**
     * The UPDATE statement is used to modify the existing records in a table.
     *
     * @param array $values
     * @return $this|bool
     */
    public function update(array $values)
    {
        if (Validate::variable($values, Validate::IS_ARRAY)) {
            // separate the keys => columns from the array
            $columns = array_keys($values);
            $lastColumn = array_key_last($values);

            // set the query
            $this->query .= "UPDATE " . self::$table . " SET ";
            foreach ($columns as $column) {
                if ($lastColumn !== $column) {
                    $this->query .= "{$column} = :{$column}, ";
                } else {
                    $this->query .= "{$column} = :{$column} ";
                }
            }

            // set the values
            $this->values += $values;

            return $this;
        }

        return false;
    }

    /**
     * Soft delete records from the database.
     *
     * @param string $column
     * @param int $value
     * @return $this|bool
     */
    public function softDelete(string $column, int $value)
    {
        if (
            Validate::variable($column, Validate::IS_STRING) &&
            Validate::variable($value, Validate::IS_INT)
        ) {
            $this->update([$column => $value]);

            return $this;
        }

        return false;
    }

    /**
     * The DELETE statement is used to delete existing records in a table.
     *
     * @return $this
     */
    public function delete()
    {
        $this->query .= "DELETE FROM " . self::$table . " ";

        return $this;
    }

    /**
     * Order all selected records by specified columns with a specified filter.
     *
     * @param string $filter
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function orderBy(string $filter, ...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "ORDER BY {$columns} {$filter} ";

            return $this;
        }

        return false;
    }

    /**
     * The GROUP BY statement is used to group the result-set by one or more columns.
     *
     * @param mixed ...$columns
     * @return $this|bool
     */
    public function groupBy(...$columns)
    {
        if (Validate::variable($columns, Validate::IS_ARRAY)) {
            $columns = implode(', ', $columns);
            $this->query .= "GROUP BY {$columns} ";

            return $this;
        }

        return false;
    }

    /**
     * Limit the number of records that are selected from the database.
     *
     * @param int $number
     * @return $this|bool
     */
    public function limit(int $number = 1)
    {
        if (Validate::variable($number, Validate::IS_INT)) {
            $this->query .= "LIMIT {$number}";

            return $this;
        }

        return false;
    }

    /**
     * Execute self written queries.
     *
     * @param string $query
     * @param array $values
     * @return $this|bool
     */
    public function query(string $query, array $values = null)
    {
        if (Validate::variable($query, Validate::IS_STRING)) {
            $this->query = $query;

            if (!empty($this->values)) {
                $this->values += $values;
            }

            return $this;
        }

        return false;
    }

    /**
     * Get the prepared query.
     *
     * @return bool|string
     */
    public function getQuery()
    {
        if (!empty($this->query)) {
            $query = sanitize_data($this->query, gettype($this->query));

            return $query;
        }

        return false;
    }

    /**
     * Get the prepared values.
     *
     * @return array|bool
     */
    public function getValues()
    {
        if (!empty($this->values)) {
            return $this->values;
        }

        return false;
    }

    /**
     * Execute the query if the query is prepared.
     *
     * @param string $message
     * @return bool|DBProcessor
     */
    public function execute(string $message = '')
    {
        if (Validate::variable($this->query, Validate::IS_STRING)) {
            // sanitize the data
            $query = sanitize_data($this->query, gettype($this->query));
            $values = $this->values;
            $message = sanitize_data($message, gettype($message));

            // prepare the processor and return it
            return new DBProcessor($this->pdo, $query, $values, $message);
        }

        return false;
    }
}
