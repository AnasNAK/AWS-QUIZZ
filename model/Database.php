<?php

session_start();
class Database {
  private static $HOST = "localhost";
  private static $username = "root";
  private static $password = "";
  private static $database = "aws_cloud";
  private static $connection;

  public static function getconnection() {
      if (!isset(self::$connection)) {
          try {
              self::$connection = new PDO("mysql:host=" . self::$HOST . ";dbname=" . self::$database, self::$username, self::$password);
              self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
          }
      }
      return self::$connection;
  }
}

?>