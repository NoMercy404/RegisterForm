<?php

namespace App\Service\Factory;

use App\Entity\Candidate;


class CandidateFactory
{
    public function create(): Candidate
    {
        return new Candidate();
    }
}

