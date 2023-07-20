<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AtticInsulationController extends Controller
{
    public function calculate(Request $request)
    {
        $length = $request->input('length');
        $width = $request->input('width');
        $height = $request->input('height');
        $roofSlope = $request->input('roofSlope', 0); // Default to 0 if not provided
        $selectedRValue = $request->input('selectedRValue');

        // Perform the insulation volume calculation (Replace this with your actual calculation logic)
        $insulationVolume = $this->calculateInsulationVolume($length, $width, $height, $roofSlope, $selectedRValue);

        return response()->json(['insulation_volume' => $insulationVolume]);
    }

    private function calculateInsulationVolume($length, $width, $height, $roofSlope, $rValue)
    {
        // Convert roofSlope to radians
        $roofSlopeRad = ($roofSlope * M_PI) / 180;

        // Calculate the triangular end walls' area
        $triangleBase = $width;
        $triangleHeight = (tan($roofSlopeRad) * $width) / 2;
        $triangularArea = 0.5 * $triangleBase * $triangleHeight;

        // Calculate the rectangular area of the attic
        $rectangularArea = $length * $width;

        // Calculate the total area of the attic
        $totalArea = $triangularArea * 2 + $rectangularArea;

        // Calculate the volume of the attic
        $atticVolume = $totalArea * $height;

        // Calculate the insulation volume needed
        $insulationVolume = $atticVolume / $rValue;

        return $insulationVolume;
    }
}
