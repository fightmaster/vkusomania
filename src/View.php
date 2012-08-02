<?php

class View {
 
static function displayDefault() {
 
echo "<form method='POST' action='index.php' > ";
 
echo "Введите адрес DOC файла: ";
 
echo "<input type='text' name='filepath' value='' > ";
 
echo "<input type='submit' name='send' value='Отправить'>";
 
echo "</form>";
 
}
 
static function displayError($error) {
 
echo "<b>Ошибка:</b> {$error}";
 
View::displayDefault();
 
}
 
static function displayResults($results) {

echo $results;

}
 
} // class VIEW

?>
