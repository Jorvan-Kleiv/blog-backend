<?php

namespace App;

enum Status: string
{
    case PUBLISHED = "Published";
    case DRAFT = "Draft";
    case TRASHED = "Trashed";

}

