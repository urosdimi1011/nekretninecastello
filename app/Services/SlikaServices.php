<?php

namespace App\Services;
use App\Models\Slike;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SlikaServices
{
    public function sacuvajSliku($slika,$kljucSlike = 'slika',$alt="")
    {

        $slikaData = [
            $kljucSlike => $slika
        ];
//        dd($slikaData['slika'],$kljucSlike);
        if($alt == ""){
            $altNaOsnovuNazivaUneteSlike = pathinfo($slikaData[$kljucSlike]->getClientOriginalName(), PATHINFO_FILENAME);
        }
        else{
            $altNaOsnovuNazivaUneteSlike = $slikaData[$kljucSlike] = $alt;
        }

        if (!$this->validirajSliku($slikaData,$kljucSlike)) {
            throw new \Exception("Nevažeći format slike.");
        }

        $putanja = $this->sacuvajSlikuNaDiskuIVratiPutanju($slika,$kljucSlike);

        $novaSlika = new Slike;
        $novaSlika->putanja = $putanja;
        $novaSlika->alt = $altNaOsnovuNazivaUneteSlike;
        $novaSlika->save();

        return $novaSlika->id;
    }


    private function validirajSliku($slika,$kljucSlike)
    {
        $validator = Validator::make($slika, [
            $kljucSlike => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($validator->fails()){
            $errors = $validator->errors();

            return $errors->all();
        }

        return true;

    }

    private function sacuvajSlikuNaDiskuIVratiPutanju($request,$kljucSlike)
    {

        $imageName = pathinfo($request->getClientOriginalName(), PATHINFO_FILENAME).uniqid() . '.' . $request->getClientOriginalExtension();


        if(strpos($kljucSlike, "podSlike") !== false){
            $zig = public_path('assets/img/zig2.png');
            $slika = Image::make($request);
            $watermark = Image::make($zig);

            $originalWidth = $slika->width();
            $originalHeight = $slika->height();
            $originalAspectRatio = $originalWidth / $originalHeight;

            $watermarkWidth = $originalWidth * 0.3;
            $watermarkHeight = $watermarkWidth / $watermark->width() * $watermark->height();

            $watermarkAspectRatio = $watermarkWidth / $watermarkHeight;

            if ($watermarkAspectRatio > $originalAspectRatio) {
                $watermarkWidth = $originalWidth * 0.3;
                $watermarkHeight = $watermarkWidth / $watermark->width() * $watermark->height();
            } else {
                $watermarkHeight = $originalHeight * 0.3;
                $watermarkWidth = $watermarkHeight * $watermark->width() / $watermark->height();
            }

            $watermark->resize($watermarkWidth, $watermarkHeight);

            $topPosition = intval(($originalHeight - $watermarkHeight) / 2);
            $leftPosition = intval(($originalWidth - $watermarkWidth) / 2);

            $slika->insert($watermark, 'top-left', $leftPosition, $topPosition);

            $slika->save(public_path('/assets/img/' . $imageName));
        }
        else{
            $request->move(public_path('assets/img'),$imageName);
        }
        return $imageName;
    }

    public function sacuvajViseSlikaIVratiIDjeve($slike,$kljucSlike = "slike"){
        $slikeIds = [];
        foreach ($slike as $index => $slika) {
            //TACKA PRAVILA PROBLEM!!
                $kljucMojeSlike = $kljucSlike.$index;


            $slikeIds[] = $this->sacuvajSliku($slika, $kljucMojeSlike);
        }

        return $slikeIds;
    }

    public function obrisiSlike($ids){
        foreach ($ids as $i){
            $this->obrisiSliku($i);
        }
    }

    public function obrisiSlikeIzBaze($ids){
        foreach ($ids as $i){
            $slika = Slike::find($i);

            if (!$slika) {
                throw new \Exception("Slika sa ID-jem $i ne postoji.");
            }
            $slika->delete();
        }
    }
    public function obrisiSliku($slikaId)
    {
        $slika = Slike::find($slikaId);

        if (!$slika) {
            throw new \Exception("Slika sa ID-jem $slikaId ne postoji.");
        }

        $putanja = $slika->putanja;

        if ($putanja) {
            $putanjaDoSlike = public_path("assets/img/".$putanja);
            if (file_exists($putanjaDoSlike)) {
                unlink($putanjaDoSlike);
            }
        }

//        $slika->delete();

        return true;
    }

}
