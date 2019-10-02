<?php

namespace App\services\database;

use \PDO;
use App\services\exceptions\customException;

class DBProcessor
{
    /**
     * @var PDO|null
     */
    private $pdo = null;

    /**
     * @var bool|\PDOStatement|null
     */
    private $statement = null;

    /**
     * @var int
     */
    private $lastInsertedId = 0;

    /**
     * @var string
     */
    private $message = null;

    /**
     * @var bool
     */
    private $successful = false;

    /**
     * DBProcessor constructor.
     *
     * @param \PDO $pdo
     * @param string $query
     * @param array $bindValues
     * @param string $message
     * @void
     * @throws \PDOException
     */
    public function __construct(\PDO $pdo, string $query, array $bindValues, string $message)
    {
        try {
            // set the pdo object
            $this->pdo = $pdo;
            $this->statement = $this->pdo->prepare($query);

            // if specified, bind the values with the specified column
            if (!empty($bindValues)) {
                $this->bindValues($bindValues);
            }

            // if specified, set the message
            if (!empty($message)) {
                $this->setMessage($message);
            }

            // execute the statement
            $this->statement->execute();

            // if specified, set the last inserted id
            $this->setLastInsertedId();

            $this->setSuccessful();
        } catch (\PDOException $PDOException) {
            var_dump('Used query: "' . $query . '" The values to bind to the query: ', $bindValues);
            customException::handle($PDOException);
        }
    }

    /**
     * Bind each value with the specified column.
     *
     * @param array $bindValues
     * @return bool|/PDOStatement
     */
    private function bindValues(array $bindValues)
    {
        try {
            foreach ($bindValues as $bindColumn => $bindValue) {
                switch (gettype($bindValue)) {
                    case 'boolean':
                        $this->statement->bindValue(":{$bindColumn}", sanitize_data($bindValue, gettype($bindValue)),
                            PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $this->statement->bindValue(":{$bindColumn}", null, PDO::PARAM_NULL);
                        break;
                    case 'integer':
                        $this->statement->bindValue(":{$bindColumn}", sanitize_data($bindValue, gettype($bindValue)),
                            PDO::PARAM_INT);
                        break;
                    case 'double':
                        $this->statement->bindValue(":{$bindColumn}", sanitize_data($bindValue, gettype($bindValue)),
                            PDO::PARAM_STR);
                        break;
                    case 'float':
                        $this->statement->bindValue(":{$bindColumn}", sanitize_data($bindValue, gettype($bindValue)),
                            PDO::PARAM_STR);
                        break;
                    case 'string':
                        $this->statement->bindValue(":{$bindColumn}", sanitize_data($bindValue, gettype($bindValue)),
                            PDO::PARAM_STR);
                        break;
                    default:
                        throw new customException(
                            gettype($bindValue) . ' given to execute against the database. 
                            Only variables with the type of a boolean, integer, null or a string are allowed. Query: ' .
                            $this->statement . ' and values ' . implode(',', $bindValues)
                        );
                }
            }

            return $this->statement;
        } catch (customException $customException) {
            customException::handle($customException);
            return false;
        }
    }

    /**
     * Fetch all records from the database with the given fetch method.
     *
     * @param int $fetchMethod
     * @return mixed
     */
    public function fetchAll(int $fetchMethod)
    {
        return $this->statement->fetchAll($fetchMethod);
    }

    /**
     * Fetch one record from the database with the given fetch method.
     *
     * @param int $fetchMethod
     * @return mixed
     */
    public function fetch(int $fetchMethod)
    {
        return $this->statement->fetch($fetchMethod);
    }

    /**
     * Fetch all the records from the database to an object.
     */
    public function all()
    {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetch all the records from the database to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->statement->fetchAll(PDO::FETCH_NAMED);
    }

    /**
     * Fetch the first record found in the database to an object.
     */
    public function first()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Set the last inserted ID.
     *
     * @void int
     */
    private function setLastInsertedId()
    {
        $this->lastInsertedId = $this->pdo->lastInsertId();
    }

    /**
     * Get the last inserted ID.
     *
     * @return int
     */
    public function getLastInsertedId()
    {
        return $this->lastInsertedId;
    }

    /**
     * Count all records that are selected from the database.
     *
     * @return int
     */
    public function getNumberOfItems()
    {
        $items = $this->statement->fetchAll(PDO::FETCH_NAMED);

        if (!empty($items) && is_array($items)) {
            $numberOfItems = count($items);

            return $numberOfItems;
        }

        return 0;
    }

    /**
     * Set the message.
     *
     * @param string $message
     * @void
     */
    private function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the successful state.
     * @void
     */
    private function setSuccessful()
    {
        $this->successful = true;
    }

    /**
     * Get the successful state.
     *
     * @return bool
     */
    public function getSuccessful()
    {
        return $this->successful;
    }
}
