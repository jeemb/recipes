<?php
    class Recipe
    {
        private $id;
        private $name;
        private $rating;

        function __construct($name, $rating, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
            $this->rating = $rating;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setRating($new_rating)
        {
            $this->rating = $new_rating;
        }

        function getRating()
        {
            return $this->rating;
        }


        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO recipe (name, rating) VALUES ('{$this->getName()}', '{$this->getRating()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_recipes = $GLOBALS['DB']->query("SELECT * FROM recipe;");
            $recipes = array();
            foreach($returned_recipes as $recipe) {
                $name = $recipe['name'];
                $id = $recipe['id'];
                $rating = $recipe['rating'];
                $new_recipe = new Recipe($name, $rating, $id);
                array_push($recipes, $new_recipe);
            }
            return $recipes;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM recipe;");
        }

        static function find($search_id)
        {
            $found_recipe = null;
            $recipes = Recipe::getAll();
            foreach($recipes as $recipe) {
                $recipe_id = $recipe->getId();
                if ($recipe_id == $search_id) {
                  $found_recipe = $recipe;
                }
            }
            return $found_recipe;
        }
    }
?>
