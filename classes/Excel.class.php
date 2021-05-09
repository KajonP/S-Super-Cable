<?php
/** PHPExcel */
require_once Router::getSourcePath() . 'library/PHPExcel-1.8/Classes/PHPExcel.php';
 
/** PHPExcel_IOFactory - Reader */
include Router::getSourcePath() .'library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
 
class Excel extends PHPExcel {
    public function __construct() {
       
    }
}