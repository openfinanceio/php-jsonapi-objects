<?php
namespace KS\JsonApi;

class Relationship implements RelationshipInterface {
    protected $name;
    protected $links;
    protected $meta;
    protected $data;

    public function __construct(array $data) {
        if (!array_key_exists('name', $data)) throw new \InvalidArgumentException("To construct a Relationship, you must pass a `name` key containing the name of the resource.");
        $this->name = $data['name'];

        if (!array_key_exists('data', $data)) throw new \InvalidArgumentException("To construct a Relationship, you must pass a `data` key containing a Resource or a ResourceCollection.");

        if ($data['data'] === null) $this->data = null;
        elseif (array_key_exists('id', $data['data'])) $this->data = new Resource($data['data']);
        else {
            $rc = $this->data = new ResourceCollection();
            foreach($data['data'] as $r) $rc[] = new Resource($r);
        }

        if (array_key_exists('links', $data)) $this->links = $data['links'];
        if (array_key_exists('meta', $data)) $this->meta = $data['meta'];
    }

    public function getName() { return $this->name; }
    public function getLinks() { return $this->links; }
    public function getMeta() { return $this->meta; }
    public function getData() { return $this->data; }

    public function jsonSerialize() {
        $data = [
            'data' => $this->data ? $this->data->jsonSerialize(false) : null
        ];
        if ($this->links) $data['links'] = $this->links;
        if ($this->meta) $data['meta'] = $this->meta;
        return $data;
    }
}

