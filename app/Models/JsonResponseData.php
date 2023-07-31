<?php
    namespace App\Models;


    class JsonResponseData
    {
        public bool $success = false;
        public int $total = 0;
        public int $current = 0;
        public mixed $data;
        public int $page = 1;
    }
