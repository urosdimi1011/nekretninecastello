<?php

namespace App\Http\Requests;

class NekretnineRequest extends ownRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            "naziv" => "required|string",
            "istaknuto" => "nullable",
            "link_ka_videu" => "nullable",
            "link_ka_videu_virtual" => "nullable",
            "cena_metar" => "nullable",
            "video_fajl" => "nullable|file|mimes:mp4,mov,ogg,qt|max:51200",
            "sifra_nekretnine" => "required|string",
            "id_tip_nekretnine" => "required",
            "opis" => "required",
            "cena" => "required|numeric",
            "mesto_id" => "required|exists:mesta,id",
        ];

        if ($this->isMethod('post')) {
            $rules['glavnaSlika'] = 'required|image|mimes:jpeg,png,jpg|max:10000';
            $rules['podSlike'] = 'required|array';
            $rules['podSlike.*'] = 'required|image|mimes:jpeg,png,jpg|max:10000';
        } else {
            $rules['glavnaSlika'] = 'nullable|image|mimes:jpeg,png,jpg|max:10000';
            $rules['podSlike'] = 'nullable|array';
            $rules['podSlike.*'] = 'nullable|image|mimes:jpeg,png,jpg|max:10000';
        }

        return $rules;
    }



    public function messages()
    {
        return [
            'naziv.required' => "Naziv je obavezno polje.",
            'opis.required' => "Opis je obavezno polje.",
            'cena.required' => "Cena je obavezno polje.",
            'mesto_id.required' => "Lokacija je obavezno polje.",
            'mesto_id.exists' => "Izabrana lokacija nije ispravna.",
            'id_tip_nekretnine.required' => "Tip nekretnine je obavezno polje.",
            "sifra_nekretnine.required" => "Šifra nekretnine je obavezno polje",
            'glavnaSlika.required' => "Glavna slika je obavezno polje.",
            'podSlike.required' => "Podslike su obavezno polje.",
            'video_fajl.mimes' => "Video mora biti u formatu: mp4, mov, ogg.",
            'video_fajl.max' => "Video ne sme biti veći od 50MB.",
        ];
    }
}
