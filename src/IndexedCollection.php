<?php
namespace KS\JsonApi;

abstract class IndexedCollection extends Collection implements IndexedCollectionInterface  {
    public function offsetSet($offset, $value) {
        if ($value !== null && !($value instanceof NamedMemberInterface)) throw new \InvalidArgumentException("All members of IndexedCollections must implement the \KS\JsonApi\NamedMemberInterface");

        // If value is not null and has a name...
        if ($value !== null && $value->getMemberName()) {
            // If we've used a string offset that doesn't match the given name, throw exception
            if (!is_int($offset) && $offset != $value->getMemberName()) throw new \InvalidArgumentException("You've attempted to add a named member, `{$value->getMemberName()}`, to this collection at an index that doesn't match its name (`{$offset}`). Indices must match the names of the objects they contain. (Remember, you can always add a named member using an empty pair of brackets, `[]`.)");

            // Set offset to member name
            $offset = $value->getMemberName();

            // Now, check for duplicates in the collection
            foreach($this->elements as $k => $e) {
                if ($e && $k != $offset && $e->getMemberName() == $value->getMemberName()) throw new CollectionConflictingMemberException("There is already a member in this collection at index `$k` with the same name as the one you're trying to add (`".$value->getMemberName()."`). You cannot add members with duplicate names to an indexed collection.");
            }
        }

        // If it's not null but DOESN'T have a name, set its name to the offset
        if ($value && !$value->getMemberName()) $value->setMemberName($offset);

        // Now use the parent method to do the setting
        parent::offsetSet($offset, $value);
    }

    public function jsonSerialize($fullResource=true) {
        $data = [];
        foreach($this->elements as $k => $e) {
            if (!$e->getMemberName()) throw new UnserializableObjectStateException("Trying to serialize an indexed collection, but some members are unnamed at the time of serialization. (Unnamed member found at index `$k`.)");
            if (array_key_exists($e->getMemberName(), $data)) throw new CollectionConflictingMemberException("Trying to serialize a collection with conflicting members. There are at least two members named `".$e->getMemberName()."` in this collection.");
            $data[$e->getMemberName()] = $e->jsonSerialize($fullResource);
        }
        return $data;
    }
}


