<?php
namespace YesPHP\Aware;

interface CanInterface {
    public function canRead($id);
    public function canWrite($id,$data = null);
}