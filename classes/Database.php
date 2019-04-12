<?php
  class Database
  {
      private $db;

      private $host;
      private $user;
      private $password;
      private $database;

      private $types = [
          'string' => 's',
          'integer' => 'i'
      ];

      public function __construct($host, $user, $password, $database) {
          $this->host = $host;
          $this->user = $user;
          $this->password = $password;
          $this->database = $database;

          $this->db = new MySQLi($host, $user, $password, $database);

          if ($this->db->connect_errno)
              throw new Exception('Failed to connect to the MySQL database: ' . $this->db->connect_error);
      }

      public function query($query, $params = []) {
          $statement = $this->db->prepare($query);
          if (!$statement)
            throw new Exception('Preparing statement faile: ' . $this->db->error);

          $typeStr = '';
          foreach ($params as $param) {
              $type = gettype($param);

              if (!array_key_exists($type, $this->types))
                  throw new Exception('Variable has no known type: ' . $param);

              $typeStr .= $this->types[$type];
          }

          if (count($params) > 0) {
            $bind = $statement->bind_param($typeStr, ...$params);
            if (!$bind)
              throw new Exception('Binding parameters failed: ' . $statement->error);
          }

          $exec = $statement->execute();
          if (!$exec)
            throw new Exception('Binding parameters failed: ' . $statement->error);

          $result = $statement->get_result();

          $statement->close();

          return $result;
      }
  }
