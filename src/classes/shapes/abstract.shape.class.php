<?php

require_once __DIR__ . "/shape.interface.php";

abstract class AbstractShape implements Shape{

    public static function resolveShape($value,Shape &$shapeObject){
      if($value == "circle")
          $shapeObject = new Circle();
      else
          $shapeObject = new Square();
    }
}