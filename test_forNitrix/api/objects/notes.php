<?php
class Product {

    // подключение к базе данных и таблице 'products' 
    private $conn;
    private $table_name = "test";

    // свойства объекта 
    public $id;
    public $name;
    public $description;
    public $modified;


    // конструктор для соединения с базой данных 
    public function __construct($db){
        $this->conn = $db;
    }

    // здесь будет метод read() 
    function read(){

        // выбираем все записи 
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description,   p.modified
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.notes_id = c.id
                ORDER BY
                    p.modified DESC";
    
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // выполняем запрос 
        $stmt->execute();
    
        return $stmt;
    }

 
function create(){

// запрос для вставки (создания) записей 
$query = "INSERT INTO
            " . $this->table_name . "
        SET
            name=:name, description=:description, category_id=:category_id, modified=:modified";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->name=htmlspecialchars(strip_tags($this->name));
$this->description=htmlspecialchars(strip_tags($this->description));
$this->notes_id=htmlspecialchars(strip_tags($this->notes_id));
$this->modified=htmlspecialchars(strip_tags($this->modified));

// привязка значений 
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":description", $this->description);
$stmt->bindParam(":notes_id", $this->notes_id);
$stmt->bindParam(":modified", $this->modified);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}

function update(){

    // запрос для обновления записи (товара) 
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                description = :description,
                notes_id = :notes_id
            WHERE
                id = :id";

    // подготовка запроса 
    $stmt = $this->conn->prepare($query);

    // очистка 
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->modified=htmlspecialchars(strip_tags($this->modified));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // привязываем значения 
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':modified', $this->modified);
    $stmt->bindParam(':id', $this->id);

    // выполняем запрос 
    if ($stmt->execute()) {
        return true;
    }

    return false;
}

function delete(){

    // запрос для удаления записи (товара) 
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    // подготовка запроса 
    $stmt = $this->conn->prepare($query);

    // очистка 
    $this->id=htmlspecialchars(strip_tags($this->id));

    // привязываем id записи для удаления 
    $stmt->bindParam(1, $this->id);

    // выполняем запрос 
    if ($stmt->execute()) {
        return true;
    }

    return false;
}


}
?>