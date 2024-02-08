<?php

namespace geoquizz\service\domain\DTO;

class SerieDTO extends DTO
{
    public int $id;
    public string $nom;
    public string $photo;
    public array $startmap;

    /**
     * @param int $id
     * @param string $nom
     * @param string $photo
     * @param array $startmap
     */
    public function __construct(int $id, string $nom, string $photo, array $startmap)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->photo = $photo;
        $this->startmap = $startmap;
    }


}