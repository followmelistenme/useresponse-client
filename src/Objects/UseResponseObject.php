<?php

namespace UseresponseClient\Objects;

abstract class UseResponseObject
{
    private string $type;

    private string $ownership;

    private string $title;

    /** CustomField[] $customFields */
    private array $customFields;

    public function __construct(string $type, string $ownership, string $title)
    {
        $this->type = $type;
        $this->ownership = $ownership;
        $this->title = $title;
    }

    public function addCustomField(CustomField $customField): self
    {
        $this->customFields[] = $customField;
        return $this;
    }

    public function toClientFormat(): array
    {
        $properties = [];
        array_map(function(CustomField $customField) use (&$properties) { $properties[$customField->getName()] = $customField->getValue();}, $this->customFields);
        return [
            'object_type' => $this->type,
            'ownership' => $this->ownership,
            'title' => $this->title,
            'properties' => $properties,
        ];
    }
}
