<?php

namespace geoquizz\service\domain\DTO;

class SerieDTO extends DTO
{
    public int $id;
    public string $nom;
    public string $photo;

    /**
     * @param int $id
     * @param string $nom
     * @param string $photo
     */
    public function __construct(int $id, string $nom, string $photo)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->photo = $photo;
    }


}