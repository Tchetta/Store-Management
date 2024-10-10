<?php

    class Dbh {
        private $uname = "root";
        private $pwd = '';
        private $host = 'localhost';
        private $dbName = 'camtel_stores';

        protected function connect() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
            $pdo = new PDO($dsn, $this->uname, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }

    }