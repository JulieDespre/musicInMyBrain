<?php

namespace geoquizz\service\domain\DTO;

class SerieDTO extends DTO
{
    public int $id;
    public string $nom;

    /**
     * @param int $id
     * @param string $nom
     */
    public function __construct(int $id, string $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }


}