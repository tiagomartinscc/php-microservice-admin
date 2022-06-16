<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\ValueObject\Uuid;
use Core\Domain\Validation\DomainValidation;
use DateTime;

class Category {
    use MethodsMagicsTrait;
    
    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
    ) {
        $this->id = !empty($this->id) ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = !empty($this->createdAt) ? new DateTime($this->createdAt) : new DateTime();
        $this->validate();
    }

    public function activate():void {
        $this->isActive = true;
    }

    public function disabled():void {
        $this->isActive = false;
    }

    public function update(string $name, string $description = ''):void {
        $this->name = $name;
        $this->description = $description;
        $this->validate();
    }
    
    private function validate() {
        DomainValidation::strMinLength($this->name);
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMCanNullAndMaxLength($this->description);
    }
}