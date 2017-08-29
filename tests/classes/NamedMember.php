<?php
namespace Test;

class NamedMember implements \KS\JsonApi\NamedMemberInterface {
    protected $memberName;
    protected $data;

    public function getMemberName() {
        return $this->memberName;
    }

    public function setMemberName($name) {
        $this->memberName = $name;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function jsonSerialize() {
        return $this->data;
    }
}

