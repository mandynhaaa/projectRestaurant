<?php

namespace Connection;

class SQLGenerator {
    
    public static function formatTableName(string $class): string
    {
        $className = explode('\\', $class);
        $className = end($className);

        $classNameWithoutNamespace = explode('::', $className)[0];
        $value = strtolower($classNameWithoutNamespace);
    
        $formattedName = str_replace('_', '', ucwords(strtolower($value), '_'));
        return lcfirst($formattedName);
    }
    
    public static function createQueryLog(string $class, string $query, array $values) : void {
        foreach ($values as $index => $value) {
            $query = preg_replace('/\?/', '"' . addslashes($value) . '"', $query, 1);
        }
        Log::addLog($class . ": " . $query);
    }

    public static function insertSQL(string $method, array $data)
    {
        $table = self::formatTableName($method);

        if (empty($table)) {
            throw new \InvalidArgumentException('The table cannot be empty.');
        }
        if (empty($data) or count(array_keys($data)) !== count(array_values($data))) {
            throw new \InvalidArgumentException('The data array cannot be empty.');
        }

        $conn = null;
        $lastId = 0;

        try {
            $conn = Connection::getConnection();

            $columns = array_keys($data);
            $values = array_values($data);

            $columnsStr = implode(', ', $columns);
            $placeholders = implode(', ', array_fill(0, count($values), '?'));
            $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $columnsStr, $placeholders);

            $stmt = $conn->prepare($query);

            foreach ($values as $index => $value) {
                $stmt->bindValue($index + 1, $value);
            }

            self::createQueryLog($method, $query, $values);
            $stmt->execute();
            $lastId = $conn->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return $lastId;
    }

    public static function updateSQL(string $table, int $id, array $data)
    {
        if (empty($table)) {
            throw new \InvalidArgumentException('The table cannot be empty.');
        }
        if (empty($data) || count(array_keys($data)) !== count(array_values($data))) {
            throw new \InvalidArgumentException('The data array cannot be empty.');
        }
    
        $conn = null;
        $idColumn = "id" . ucfirst(strtolower($table));
    
        try {
            $conn = Connection::getConnection();
    
            $set = "";
            $values = [];
    
            foreach ($data as $column => $value) {
                if ($set !== "") {
                    $set .= ", ";
                }
                $set .= trim($column) . " = ?";
                $values[] = $value;
            }
    
            $values[] = $id;
    
            $query = sprintf("UPDATE %s SET %s WHERE %s = ?", $table, $set, $idColumn);
    
            $stmt = $conn->prepare($query);
    
            foreach ($values as $index => $value) {
                $stmt->bindValue($index + 1, $value);
            }
    
            Log::addLog(__FUNCTION__ . ": " . $query);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    public static function deleteSQL(string $table, int $id)
    {
        if (empty($table)) {
            throw new \InvalidArgumentException('The table cannot be empty.');
        }
        if (empty($id)) {
            throw new \InvalidArgumentException('The id cannot be empty.');
        }
        $conn = null;
        $idColumn = "id" . ucfirst(strtolower($table));

        try {
            $conn = Connection::getConnection();
            
            $query = sprintf("DELETE FROM %s WHERE %s = ?", $table, $idColumn);
            $stmt = $conn->prepare($query);
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);

            Log::addLog(__FUNCTION__ . ": " . $query);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public static function selectSQL(string|null $columns, string $method, string|null $join = "", array $where = [])
    {
        $table = self::formatTableName($method);
    
        if (empty($table)) {
            throw new \InvalidArgumentException('The table cannot be empty.');
        }

        $whereClause = "";
        $bindings = [];
        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $param => $value) {
                $field = ltrim($param, ':');
                $conditions[] = "$field = :$param";
                $bindings[":$param"] = $value;
            }
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }
    
        if (empty($columns)) {
            $columns = "*";
        }
    
        $conn = null;
        $resultList = [];
        $columnNames = [];
    
        try {
            $conn = Connection::getConnection();
            $query = sprintf("SELECT %s FROM %s %s %s", $columns, $table, $join, $whereClause);
    
            Log::addLog(__FUNCTION__ . ": " . $query);
            $stmt = $conn->prepare($query);
    
            foreach ($bindings as $param => $value) {
                $stmt->bindValue($param, $value);
            }
    
            $stmt->execute();
    
            $columnCount = $stmt->columnCount();
            for ($i = 0; $i < $columnCount; $i++) {
                $meta = $stmt->getColumnMeta($i);
                $columnNames[] = $meta['name'];
            }
    
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $resultList[] = $row;
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return empty($resultList) ? null : $resultList;
    }

    public static function getLastId(string $table)
    {
        if (empty($table)) {
            throw new \InvalidArgumentException('The table cannot be empty.');
        }
        $conn = null;
        $lastId = 0;
        $idColumn = "id" . ucfirst(strtolower($table));
    
        try {
            $conn = Connection::getConnection();
            $query = sprintf("SELECT MAX(%s) AS lastId FROM %s", $idColumn, $table);
    
            Log::addLog(__FUNCTION__ . ": " . $query);
            $stmt = $conn->query($query);
    
            $lastId = $stmt->fetchColumn();
            $lastId = $lastId === false ? 0 : (int)$lastId;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    
        return $lastId;
    }    
}

?>