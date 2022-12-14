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

    /** Attachment[] $attachments */
    private array $attachments = [];

    /** CustomField[] $customFields */
    private array $customFields = [];

    /** string[] $tags */
    private array $tags = [];

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

    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;
        return $this;
    }

    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function toClientFormat(): array
    {
        $properties = null;
        if (!empty($this->customFields)) {
            $properties = [];
            array_map(function(CustomField $customField) use (&$properties) {
                $properties[$customField->getName()] = $customField->getValue();
            }, $this->customFields);
        }

        $attachments = [];

        if (!empty($this->attachments)) {
            array_map(function(Attachment $attachment) use (&$attachments) {
                $attachments[] = $attachment->toClientFormat();
            }, $this->attachments);
        }
        return [
            'object_type' => $this->type,
            'ownership' => $this->ownership,
            'title' => $this->title,
            'properties' => $properties,
            'content' => $this->content,
            'notify_email' => $this->notifyEmail,
            'notify_name' => $this->notifyName,
            'attachments' => $attachments,
            'tags' => $this->tags,
        ];
    }
}
