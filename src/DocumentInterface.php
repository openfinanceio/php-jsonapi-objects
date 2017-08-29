<?php
namespace KS\JsonApi;

interface DocumentInterface extends \JsonSerializable {
    function getData();
    function getErrors();
    function getLinks();
    function getLink($name);
    function getMeta();
    function getJsonApi();
    function setData($data);
    function addError(ErrorInterface $e);
    function addLink(LinkInterface $l);
    function setMeta(MetaInterface $m);
    function setJsonApi($jsonapi);
}

