<?php

namespace dto;

class GameDto extends BaseDto
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $image = null;
    private ?string $note = null;
    private ?int $minPlayer = null;
    private ?int $maxPlayer = null;

    public function __construct(?array $data = null)
    {
        if ($data) {
            $this->name = $data['name'];
            $this->id = $data['id'];
            $this->note = $data['note'];
            $this->image = $data['image'];
            $this->description = $data['description'];
            $this->minPlayer = $data['minPlayer'];
            $this->maxPlayer = $data['maxPlayer'];
        }
    }

    public function __serialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'note' => $this->note,
            'minPlayer' => $this->minPlayer,
            'maxPlayer' => $this->maxPlayer,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): GameDto
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): GameDto
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): GameDto
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): GameDto
    {
        $this->image = $image;
        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): GameDto
    {
        $this->note = $note;
        return $this;
    }

    public function getMinPlayer(): ?int
    {
        return $this->minPlayer;
    }

    public function setMinPlayer(int $minPlayer): GameDto
    {
        $this->minPlayer = $minPlayer;
        return $this;
    }

    public function getMaxPlayer(): ?int
    {
        return $this->maxPlayer;
    }

    public function setMaxPlayer(int $maxPlayer): GameDto
    {
        $this->maxPlayer = $maxPlayer;
        return $this;
    }

    public function isDataAvailable(): bool {
        return ($this->name && $this->minPlayer && $this->maxPlayer);
    }


}