<?php

namespace UseresponseClient\Objects;

abstract class UseResponseObject
{
    private string $type;

    private string $ownership;

    private string $title;

    private string $content;

    private string $notifyEmail;

    private string $notifyName;

    /** CustomField[] $customFields */
    private array $customFields = [];

    public function __construct(string $type, string $ownership, string $title, string $notifyEmail, string $notifyName, string $content)
    {
        $this->type = $type;
        $this->ownership = $ownership;
        $this->title = $title;
        $this->notifyEmail = $notifyEmail;
        $this->notifyName = $notifyName;
        $this->content = $content;
    }

    public function addCustomField(CustomField $customField): self
    {
        $this->customFields[] = $customField;
        return $this;
    }

    public function toClientFormat(): array
    {
        $properties = null;
        if (!empty($this->customFields)) {
            $properties = [];
            array_map(function(CustomField $customField) use (&$properties) { $properties[$customField->getName()] = $customField->getValue();}, $this->customFields);
        }
        return [
            'object_type' => $this->type,
            'ownership' => $this->ownership,
            'title' => $this->title,
            'properties' => $properties,
            'content' => $this->content,
            'notify_email' => $this->notifyEmail,
            'notify_name' => $this->notifyName,
        ];
    }
}
