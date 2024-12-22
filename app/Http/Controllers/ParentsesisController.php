<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentsesisController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/validate-parentheses",
     *     tags={"Validación de Paréntesis"},
     *     summary="Valida una cadena de paréntesis, corchetes y llaves",
     *     description="Este endpoint valida que una cadena de paréntesis, corchetes y llaves esté correctamente balanceada.",
     *     operationId="validateParentheses",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Cadena de paréntesis a validar",
     *         @OA\JsonContent(
     *             required={"expression"},
     *             @OA\Property(property="expression", type="string", example="{[()()]}")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La cadena de paréntesis es válida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La cadena es válida.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="La cadena no es válida",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="La cadena de paréntesis no es válida.")
     *         )
     *     ),
     * )
     */

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
