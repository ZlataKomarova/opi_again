<?php
$servername = "localhost";
$username = "root"; // По умолчанию
$password = ""; // По умолчанию
$dbname = "applications"; // Название вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Проверка на POST запрос
    // Проверьте, что данные отправлены и выполните очистку
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

    // Проверяем, что поля не пустые
    if ($name && $email && $phone) {
        // Подготовка и выполнение запроса
        $stmt = $conn->prepare("INSERT INTO applications (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);
        
        if ($stmt->execute()) {
            echo "Заявка успешно отправлена.";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка: Данные не переданы.";
    }
} else {
    echo "Форма не была отправлена."; // Сообщение при прямом обращении к скрипту
}

// Закрываем соединение
$conn->close();
?>
