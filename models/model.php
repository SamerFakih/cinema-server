<?php

abstract class Model {
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected static array $fillable = []; // define in child class
    protected static mysqli $conn;

    // ========== CONSTRUCTOR ==========
    public function __construct(array $data = []) {
    foreach ($data as $key => $value) {
        $this->$key = $value;
    }
    }
    // ========== SAVE ==========
    public function save(): bool|int {
    $data = [];

    foreach (static::$fillable as $field) {
        $data[$field] = $this->$field ?? null;
    }

    if (isset($this->{static::$primaryKey})) {
        $data[static::$primaryKey] = $this->{static::$primaryKey};
        return static::update($data);
    }

    return static::create($data);
    }

    // ========== SET CONNECTION ==========
    public static function setConnection(mysqli $conn) {
        static::$conn = $conn;
    }

    // ========== FIND BY ID ==========
    public static function find($id) {
        $sql = sprintf("SELECT * FROM %s WHERE %s = ?", static::$table, static::$primaryKey);
        $stmt = static::$conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new static($result) : null;
    }

    // ========== GET ALL ==========
    public static function all(): array {
        $sql = sprintf("SELECT * FROM %s", static::$table);
        $result = static::$conn->query($sql);

        $objects = [];

        while ($row = $result->fetch_assoc()) {
            $objects[] = new static($row);
        }
        
        return $objects;
    }

        // ========== CREATE ==========
    public static function create(array $data) {
        // Only insert fillable fields
        $data = array_intersect_key($data, array_flip(static::$fillable));

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $types = self::detectTypes($data);

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, $columns, $placeholders);
        $stmt = static::$conn->prepare($sql);
        $stmt->bind_param($types, ...array_values($data));

        if ($stmt->execute()) {
            return static::$conn->insert_id; // return inserted ID
        }

        return false;
    }

    // ========== UPDATE ==========
    public static function update(array $data) {
        if (!isset($data[static::$primaryKey])) return false;

        $set = [];
        $params = [];

        foreach ($data as $key => $value) {
            if ($key !== static::$primaryKey && in_array($key, static::$fillable)) {
                $set[] = "$key = ?";
                $params[] = $value;
            }
        }

        $params[] = $data[static::$primaryKey];
        $types = self::detectTypes($params);

        $sql = sprintf("UPDATE %s SET %s WHERE %s = ?", static::$table, implode(', ', $set), static::$primaryKey);
        $stmt = static::$conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    // ========== DELETE ==========
    public static function delete($id): bool {
        $sql = sprintf("DELETE FROM %s WHERE %s = ?", static::$table, static::$primaryKey);
        $stmt = static::$conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // ========== TYPE DETECTION ==========
    private static function detectTypes(array $params): string {
        $types = '';
        foreach ($params as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_double($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }
    // ==========FINDBYVALUE ==========
    public static function findByValue(string $column, $value) {
        if (!in_array($column, static::$fillable)) {
            throw new InvalidArgumentException("Column '$column' is not fillable.");
        }

        $sql = sprintf("SELECT * FROM %s WHERE %s = ?", static::$table, $column);
        $stmt = static::$conn->prepare($sql);
        $stmt->bind_param(self::detectTypes([$value]), $value);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new static($result) : null;
    }
    // ========== TO ARRAY ==========
    public function toArray(): array {
    $array = [];
    foreach (static::$fillable as $key) {
        $array[$key] = $this->$key ?? null;
    }
    $array[static::$primaryKey] = $this->{static::$primaryKey} ?? null;
    return $array;
}

}
