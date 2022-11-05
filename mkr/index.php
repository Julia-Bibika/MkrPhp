<?php
//8 Варіант
//(10 балів) Функції для роботи з масивами в РНР
//2. (20 балів) На сервері зберігається список Товарів (Id, Назва, Країна
//виробника, Ціна). Розробити Web сторінку, для редагування даних товару
//із вказаним Id та сторінку для перегляду всього списку товарів.
//3. (10 балів) Реалізувати завдання 2 з використанням бази даних.
echo "<br>Функції для роботи з масивами в РНР<br>";
echo "<br>array_search() - шукає значення в масиві і повертає ключ першого знайденого елемента,якщо такий існує.Інакше - FALSE<br>";
echo "<br>array_key_exists() - перевірка на існування ключів в масиві<br>";
echo "<br>in_array() - перевірка на існування значення в масиві<br>";
echo "<br>sort() - сортування по зростанню<br>";
echo "<br>rsort() - сортування по спаданню<br>";
echo "<br>ksort() - сортування по зростанню(по ключах)<br>";
echo "<br>krsort() - сортування по спаданню(по ключах)<br>";
echo "<br>array_filter() - повертає профільтрований ітерований об'єкт за заданою функцією користувача<br>";
echo "<br>array_push() - додає елемент в масив<br>";
echo "<br>array_splice() - видалення елемента з масиву<br>";
echo "<br>-------------------------------<br>";

function defaultDataProduct() {
    return [
        [
            "id" => 1,
            "name"=>"Lay`s",
            "country" =>"USA",
            "price" => "46 грн",
        ],
        [
            "id" => 2,
            "name"=>"Pringles",
            "country" =>"USA",
            "price" => "99 грн",
        ],
        [
            "id" => 3,
            "name"=>"Oreo",
            "country" =>"USA",
            "price" => "120 грн",
        ],
        [
            "id" => 4,
            "name"=>"Слов`яночка",
            "country" =>"Ukraine",
            "price" => "37 грн",
        ]
    ];
}
function addProductDB(string $otherName, string $otherCountry, string $otherPrice,$dbh){
    $dbh->query('INSERT INTO products(name,country,price) VALUES (' .
    "'" . $otherName . "', " .
    "'" . $otherCountry . "', " .
    "'" . $otherPrice . "')"
    );
}
function updateProductDB(int $otherId,string $otherName, string $otherCountry, string $otherPrice,$dbh){
    $dbh->query('UPDATE products SET ' .
        'name = ' . $otherName . ', ' .
        'country = ' . $otherCountry . ', ' .
        'price = ' . $otherPrice . ', ' .
        'WHERE id = ' . $otherId);
}
function CreateNewProduct($array, $id) {
    return [
        'id' => $id,
        'name' => $array['name'],
        'country' => $array['country'],
        'price' => $array['price'],
    ];
}

function validationDataProducts($array) {
    return !(
        empty($array['name']) ||
        empty($array['country']) ||
        empty($array['price']) ||
        !isset($array)
    );
}
function displayTableProducts($array)
{
    $table = '<table>';
    $table .= '<tr> <th>id</th> <th>name</th> <th>country</th> <th>price</th></tr>';

    foreach ($array as $item) {
        $table .= "<tr>" .
            "<td>$item[id]</td><td>$item[name]</td><td>$item[country]</td>" .
            "<td>$item[price]</td>" .
            "</tr>";
    }

    $table .= '</table>';
    echo $table;
}

session_start();
$dbh = new PDO('mysql:host=127.0.0.1;dbname=products_db', 'root', '');
$sql = "SELECT * FROM products;";
if (empty($_SESSION)) {
    $_SESSION['Products'] = defaultDataProduct();
}
$action = $_POST['action'];

// edit Product
if ($action == 'edit'){
    if (validationDataProducts($_POST)) {
        $idToEdit = $_POST['id'];
        foreach ($_SESSION['Products'] as $key => $value) {
            if ($value['id'] == $idToEdit) {
                $_SESSION['Products'][$key] = CreateNewProduct($_POST, $idToEdit);
                break;
            }
        }
    }
}
?>
<br>
<button onclick="ShowEditForm()"> EDIT </button>
<br>
<form action='<?= $_SERVER['PHP_SELF']?>' method='post' id='editForm'>
    EDIT <br>
    <label> id:
        <input type='number' name='id'>
    </label><br>
    <label> name:
        <input type='text' name='name'>
    </label><br>
    <label> country:
        <input type='text' name='country'>
    </label><br>
    <label> price:
        <input type='text' name='price'>
    </label><br>
    <input type='hidden' name='action' value='edit'>
    <input type='submit'>
</form>

<a href="view.php">Переглянути список товарів</a>
<script>
    function ShowEditForm() {
        document.querySelector('#editForm').style.display = 'inline';
    }
</script>