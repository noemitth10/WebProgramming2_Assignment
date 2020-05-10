<?php
function url($page='home')
{
    return DOMAIN."?p={$page}";
}

function asset($asset) {
    return DOMAIN . $asset;
}

function url2($page = 'home', $params = []) {
    $url = DOMAIN . "?p={$page}";
    if (is_array($params)) {
        foreach ($params as $key => $value) {
            $url .= "&$key=$value";
        }
    }
    return $url;
}

function redirect($page = 'home', $params = []) {
    $url = url2($page, $params);
    header("Location: $url");
    die();
}

function GenerateID($digits = 5)
{
    $chars="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ";
    $result = "";
    for ($i = 0; $i < $digits; $i++){
        $result .= $chars[rand(0,strlen($chars)-1)];
    }
    return $result; 
}

function db_connect() 
{
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if($conn->connect_error)
    {
        die("Connection failed {$conn->connect_error}");
    }
    return $conn;
}

function validate_email($e){
    return (bool)preg_match("`^[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$`i", trim($e));
}

function get_comic_list()
{
    global $db;

    $sql = $db->prepare("SELECT * FROM comicbooks");
    $sql->execute();


    $result = $sql->get_result();

    $sql->close();

    return $result;
}

function get_comic_by_id($id)
{
    global $db;

    $sql = $db->prepare("SELECT * FROM comicbooks WHERE `id` = ?");
    $sql->bind_param('i', $id);
    $sql->execute();

    $result = $sql->get_result();
    $sql->close();

    if ($result->num_rows != 1) {
        return null;
    }

    return $result->fetch_assoc();
}