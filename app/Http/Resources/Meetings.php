<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Fields\{Card, Text, BelongsTo, Url};
use marcusvbda\vstack\Resource;

class Meetings extends Resource
{
    public $model = \App\Http\Models\Meeting::class;

    public function label()
    {
        return "Reuniões";
    }

    public function menu()
    {
        return "Agendamentos";
    }

    public function menuIcon()
    {
        return "el-icon-notebook-1";
    }

    public function icon()
    {
        return "el-icon-data-line";
    }

    public function fields()
    {
        return [new Card("Informações", [
            new Text([
                "label" => "Assunto da Reunião",
                "field" => "subject",
                "required" => true,
                "placeholder" => "Assunto",
                "rules" => "required|max:255"
            ]),
            new Text([
                "label" => "Tipo de Reunião",
                "field" => "type",
                "required" => true,
                "placeholder" => "Ex: orçamento, investimento etc",
                "rules" => "required|max:255"
            ]),
            new Url([
                "label" => "Url de feedback",
                "field" => "feedback_url",
                "required" => true,
                "placeholder" => "Url do Google Forms",
                "rules" => "required|url|max:255"
            ]),
            new Text([
                "label" => "Tipo de Reunião",
                "field" => "type",
                "required" => true,
                "placeholder" => "Ex: orçamento, investimento etc",
                "rules" => "required|max:255"
            ]),
            new BelongsTo([
                "label" => "Local da Reunião",
                "field" => "meeting_room_id",
                "required" => true,
                "placeholder" => "Selecione o local da Reunião",
                "model" => \App\Http\Models\MeetingRoom::class,
                "rules" => "required|min:1"
            ])
        ])];
    }
}