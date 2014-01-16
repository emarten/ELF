<?php

class ELF
{
  public function __construct($data)
  {
    $this->_init=$data["_init"];
  }
  public function __call($method,$args)
  {
    call($this,$method,$args);
  }
}