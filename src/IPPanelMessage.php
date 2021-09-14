<?php

namespace Mirvan\IPPanel;

use Mirvan\IPPanel\Exceptions\InvalidMessage;

class IPPanelMessage
{
    /** @var string */
    protected $body;

    /** @var string */
    protected $originator;

    /** @var string */
    protected $reference = [];

    /** @var string */
    protected $pattern;

    /** @var array */
    protected $variables = [];
    /**
     * @param  string  $body
     */
    public function __construct(string $body = '')
    {
        $this->body($body);
    }

    /**
     * @param  string  $body
     * @return static
     */
    public static function create($body = ''): self
    {
        return new static($body);
    }

    public function type(): string
    {
        return isset($this->pattern) ? 'pattern' :'message';
    }

    /**
     * @param  string  $body
     * @return $this
     */
    public function body(string $body)
    {
        $this->body = trim($body);

        return $this;
    }

    /**
     * @param  string|int  $originator
     * @return $this
     *
     * @throws InvalidMessage
     */
    public function originator($originator)
    {
        if (empty($originator) || strlen($originator) > 11) {
            throw InvalidMessage::invalidOriginator($originator);
        }

        $this->originator = (string) $originator;

        return $this;
    }

    /**
     * @param  string|array  $reference
     * @return $this
     *
     * @throws InvalidMessage
     */
    public function reference($reference)
    {
        if (empty($reference) || strlen($reference) > 32 ) {
            throw InvalidMessage::invalidReference($reference);
        }

        $this->reference = is_array($reference) ?
            array_push($this->reference, $reference) : [(string) $reference];

        return $this;
    }

    /**
     * @param  string  $pattern
     * @return $this
     *
     * @throws InvalidMessage
     */
    public function pattern(string $pattern)
    {
        if (empty($pattern)) {
            throw InvalidMessage::invalidOriginator($pattern);
        }

        $this->pattern = (string) $pattern;

        return $this;
    }

    /**
     * @param  string  $name
     * @param  $value
     * @return $this
     *
     * @throws InvalidMessage
     */
    public function variable(string $name, $value = '')
    {
        if (empty($name)) {
            throw InvalidMessage::invalidOriginator($name);
        }

        $this->variables[$name] = (string) $value;

        return $this;
    }

    /**
     * @param  array  $variables
     * @return $this
     *
     * @throws InvalidMessage
     */
    public function variables(array $variables)
    {
        foreach ($variables as $name => $value) {
            $this->variable($name, $value);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getOriginator()
    {
        return $this->originator;
    }

    /**
     * @return array
     */
    public function getReference() :array
    {
        return $this->reference;
    }
}
