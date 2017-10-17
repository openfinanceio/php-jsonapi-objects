<?php
namespace KS\JsonApi\Test;

class Context extends \KS\JsonApi\Context {
    /**
     * Stub this out so that we return a GenericResource for any requested type
     */
    public function newJsonApiResource($data=null, $type=null) {
        if ($type == 'test-users') return new User($this, $data);
        return new \KS\JsonApi\GenericResource($this, $data);
    }
}
