<?php
class MasterkeyVO
{
    // FOREIGNKEYS
    protected $id_key;

    // FOREIGNKEYS
    public function setIdKey($id) {
        $this->id_key = $id;
    }
    public function getIdKey() {
        return $this->id_key;
    }
}
