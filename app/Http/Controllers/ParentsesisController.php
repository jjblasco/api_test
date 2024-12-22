<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentsesisController extends Controller
{
    public function checkOrder(Request $request)
    {
        $text = $request->input('order');

        if ($this->isValid($text)) {
            return response()->json(['message' => 'La cadena es válida'], 200);
        } else {
            return response()->json(['message' => 'La cadena es inválida'], 400);
        }

    }

    private function isValid($text)
    {
        $stack = [];
        $map = [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ];

        foreach (str_split($text) as $char) {
            if (isset($map[$char])) {
                if (empty($stack) || array_pop($stack) != $map[$char]) {
                    return false;
                }
            } else {
                $stack[] = $char;
            }
        }

        return empty($stack);
    }

}
