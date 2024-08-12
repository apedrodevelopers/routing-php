<?php
    namespace App\Controllers;

    class ProductController {

        public function create () {
            echo "<h1> Create a new product </h1>";

            echo "
                <form action='/product/store' method='POST'>
                    <label>Product name</label>
                    <input type='text' name='product_name'>
                    <button type='submit'>Create</button>
                </form>
            ";
        }

    }